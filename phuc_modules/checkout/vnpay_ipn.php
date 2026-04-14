<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/app.php';

header('Content-Type: application/json; charset=utf-8');

$input = $_GET;

if (!vnpayVerifyResponse($input)) {
    echo json_encode(['RspCode' => '97', 'Message' => 'Invalid signature'], JSON_UNESCAPED_UNICODE);
    exit;
}

$txnRef = trim($_GET['vnp_TxnRef'] ?? '');
$responseCode = trim($_GET['vnp_ResponseCode'] ?? '');
$transactionStatus = trim($_GET['vnp_TransactionStatus'] ?? '');
$payDate = trim($_GET['vnp_PayDate'] ?? '');
$transactionNo = trim($_GET['vnp_TransactionNo'] ?? '');
$bankCode = trim($_GET['vnp_BankCode'] ?? '');
$vnpAmount = (int) ($_GET['vnp_Amount'] ?? 0);

if ($txnRef === '') {
    echo json_encode(['RspCode' => '01', 'Message' => 'Order not found'], JSON_UNESCAPED_UNICODE);
    exit;
}

$isSuccess = $responseCode === '00' && ($transactionStatus === '' || $transactionStatus === '00');

$pdo = db();
$pdo->beginTransaction();

try {
    $stmt = $pdo->prepare('SELECT * FROM payments WHERE transaction_code = :transaction_code LIMIT 1 FOR UPDATE');
    $stmt->execute(['transaction_code' => $txnRef]);
    $payment = $stmt->fetch();

    if (!$payment) {
        $pdo->rollBack();
        echo json_encode(['RspCode' => '01', 'Message' => 'Order not found'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $expectedAmount = (int) round(((float) $payment['amount']) * 100);
    if ($expectedAmount !== $vnpAmount) {
        $pdo->rollBack();
        echo json_encode(['RspCode' => '04', 'Message' => 'Invalid amount'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (in_array((string) $payment['status'], ['paid', 'failed'], true)) {
        $pdo->rollBack();
        echo json_encode(['RspCode' => '02', 'Message' => 'Order already confirmed'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $newPaymentStatus = $isSuccess ? 'paid' : 'failed';
    $newOrderStatus = $isSuccess ? 'confirmed' : 'cancelled';

    $updatePayment = $pdo->prepare(
        'UPDATE payments
         SET status = :status,
             response_code = :response_code,
             bank_code = :bank_code,
             paid_at = :paid_at,
             raw_response = :raw_response,
             updated_at = NOW()
         WHERE id = :id'
    );
    $updatePayment->execute([
        'status' => $newPaymentStatus,
        'response_code' => $responseCode,
        'bank_code' => $bankCode,
        'paid_at' => $payDate,
        'raw_response' => json_encode($_GET, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        'id' => $payment['id'],
    ]);

    $updateOrder = $pdo->prepare(
        'UPDATE orders
         SET payment_status = :payment_status,
             status = :status,
             updated_at = NOW()
         WHERE id = :id'
    );
    $updateOrder->execute([
        'payment_status' => $newPaymentStatus,
        'status' => $newOrderStatus,
        'id' => $payment['order_id'],
    ]);

    $log = $pdo->prepare(
        'INSERT INTO order_logs (order_id, old_status, new_status, note, changed_by, changed_by_name)
         VALUES (:order_id, :old_status, :new_status, :note, :changed_by, :changed_by_name)'
    );
    $log->execute([
        'order_id' => $payment['order_id'],
        'old_status' => 'pending',
        'new_status' => $newOrderStatus,
        'note' => 'IPN VNPAY. TransactionNo=' . $transactionNo . ', ResponseCode=' . $responseCode,
        'changed_by' => 0,
        'changed_by_name' => 'VNPAY_IPN',
    ]);

    $pdo->commit();

    echo json_encode(['RspCode' => '00', 'Message' => 'Confirm Success'], JSON_UNESCAPED_UNICODE);
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode(['RspCode' => '99', 'Message' => $exception->getMessage()], JSON_UNESCAPED_UNICODE);
}