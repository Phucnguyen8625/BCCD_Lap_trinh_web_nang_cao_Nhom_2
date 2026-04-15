<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng #<?= $order['id'] ?></title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1, h2 { color: #333; }
        .info-group { margin-bottom: 20px; }
        .info-group p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; color: #fff; font-size: 14px; }
        .btn-update { background: #28a745; }
        select { padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
        .back-link { margin-bottom: 20px; display: inline-block; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin.php?controller=order&action=index" class="back-link">← Danh sách đơn hàng</a>
        <h1>Chi tiết đơn hàng #<?= $order['id'] ?></h1>

        <?php if(isset($_GET['success'])): ?>
            <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <p style="color: red;"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>

        <div class="info-group">
            <h2>Thông tin khách hàng</h2>
            <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['customer_phone']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['customer_email']) ?></p>
            <p><strong>Địa chỉ giao hàng:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?></p>
        </div>

        <div class="info-group">
            <h2>Sản phẩm</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tên truyện</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orderDetails as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['comic_name']) ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ</td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Tổng cộng:</strong></td>
                        <td><strong><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="info-group">
            <h2>Cập nhật trạng thái</h2>
            <form action="admin.php?controller=order&action=updateStatus" method="POST">
                <input type="hidden" name="id" value="<?= $order['id'] ?>">
                <select name="status">
                    <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Chờ xử lý (Pending)</option>
                    <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Đang xử lý (Processing)</option>
                    <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Hoàn thành (Completed)</option>
                    <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Đã hủy (Cancelled)</option>
                </select>
                <button type="submit" class="btn btn-update">Cập nhật</button>
            </form>
        </div>
    </div>
</body>
</html>
