<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/app.php';

ensureSeedSessionData();
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$receiverName = trim($_POST['receiver_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$paymentMethod = trim($_POST['payment_method'] ?? '');
$note = trim($_POST['note'] ?? '');
$bankCode = trim($_POST['bank_code'] ?? '');

$items = cartItems();
$totals = cartTotals();

if ($receiverName === '' || $phone === '' || $address === '') {
    setFlash('error', 'Vui lòng nhập đầy đủ thông tin người nhận, số điện thoại và địa chỉ.');
    redirect('index.php');
}

if (!$items) {
    setFlash('error', 'Giỏ hàng trống, không thể tạo đơn.');
    redirect('index.php');
}

if (!array_key_exists($paymentMethod, paymentMethods())) {
    setFlash('error', 'Phương thức thanh toán không hợp lệ.');
    redirect('index.php');
}

if ($paymentMethod === 'VNPAY') {
    if (
        trim(VNPAY_TMN_CODE) === '' ||
        trim(VNPAY_HASH_SECRET) === '' ||
        VNPAY_TMN_CODE === 'YOUR_TMN_CODE' ||
        VNPAY_HASH_SECRET === 'YOUR_HASH_SECRET'
    ) {
        setFlash('error', 'Chưa cấu hình tài khoản VNPAY sandbox trong app.local.php');
        redirect('index.php');
    }
}

$pdo = db();
$pdo->beginTransaction();

try {
    $orderStatus = $paymentMethod === 'VNPAY' ? 'pending' : 'confirmed';
    $paymentStatus = $paymentMethod === 'VNPAY' ? 'pending' : 'unpaid';

    $insertOrder = $pdo->prepare(
        'INSERT INTO orders (
            user_id,
            receiver_name,
            phone,
            address,
            note,
            total_amount,
            status,
            payment_method,
            payment_status
        ) VALUES (
            :user_id,
            :receiver_name,
            :phone,
            :address,
            :note,
            :total_amount,
            :status,
            :payment_method,
            :payment_status
        )'
    );

    $insertOrder->execute([
        'user_id' => currentUserId(),
        'receiver_name' => $receiverName,
        'phone' => $phone,
        'address' => $address,
        'note' => $note,
        'total_amount' => $totals['total'],
        'status' => $orderStatus,
        'payment_method' => $paymentMethod,
        'payment_status' => $paymentStatus,
    ]);

    $orderId = (int) $pdo->lastInsertId();

    $insertItem = $pdo->prepare(
        'INSERT INTO order_items (
            order_id,
            comic_id,
            comic_name,
            price,
            quantity,
            subtotal
        ) VALUES (
            :order_id,
            :comic_id,
            :comic_name,
            :price,
            :quantity,
            :subtotal
        )'
    );

    foreach ($items as $item) {
        $quantity = (int) $item['quantity'];
        $price = (float) $item['price'];

        $insertItem->execute([
            'order_id' => $orderId,
            'comic_id' => (int) $item['comic_id'],
            'comic_name' => $item['name'],
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $price * $quantity,
        ]);
    }

    $rawTxnRef = createTxnRef($orderId);
    $txnRef = preg_replace('/[^A-Za-z0-9]/', '', (string) $rawTxnRef);

    if ($txnRef === null || $txnRef === '') {
        $txnRef = 'ORD' . $orderId . date('YmdHis');
    }

    $vnpCreateDate = date('YmdHis');

    $insertPayment = $pdo->prepare(
        'INSERT INTO payments (
            order_id,
            method,
            amount,
            status,
            transaction_code,
            vnp_create_date,
            admin_note
        ) VALUES (
            :order_id,
            :method,
            :amount,
            :status,
            :transaction_code,
            :vnp_create_date,
            :admin_note
        )'
    );

    $insertPayment->execute([
        'order_id' => $orderId,
        'method' => $paymentMethod,
        'amount' => $totals['total'],
        'status' => $paymentMethod === 'VNPAY' ? 'pending' : 'unpaid',
        'transaction_code' => $txnRef,
        'vnp_create_date' => $vnpCreateDate,
        'admin_note' => 'Tạo tự động từ checkout.',
    ]);

    $paymentId = (int) $pdo->lastInsertId();

    $insertLog = $pdo->prepare(
        'INSERT INTO order_logs (
            order_id,
            old_status,
            new_status,
            note,
            changed_by,
            changed_by_name
        ) VALUES (
            :order_id,
            :old_status,
            :new_status,
            :note,
            :changed_by,
            :changed_by_name
        )'
    );

    $insertLog->execute([
        'order_id' => $orderId,
        'old_status' => 'new',
        'new_status' => $orderStatus,
        'note' => 'Tạo đơn hàng từ trang checkout.',
        'changed_by' => currentUserId(),
        'changed_by_name' => currentUserName(),
    ]);

    $pdo->commit();

    if ($paymentMethod === 'VNPAY') {
        $_SESSION['last_payment_id'] = $paymentId;

        $payment = [
            'transaction_code' => $txnRef,
            'order_id' => $orderId,
            'vnp_create_date' => $vnpCreateDate,
        ];

        $order = [
            'id' => $orderId,
            'total_amount' => $totals['total'],
        ];

        $paymentUrl = createVnpayPaymentUrl($order, $payment, $bankCode);
        redirect($paymentUrl);
    }

    unset($_SESSION['cart']);
    setFlash('success', 'Đặt hàng thành công với phương thức COD.');
    redirect('../admin/orders/detail.php?id=' . $orderId);
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    setFlash('error', 'Tạo đơn thất bại: ' . $exception->getMessage());
    redirect('index.php');
}