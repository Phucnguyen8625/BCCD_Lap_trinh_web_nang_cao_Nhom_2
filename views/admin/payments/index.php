<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý thanh toán</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; font-weight: 600; }
        select, button { padding: 6px; border-radius: 4px; border: 1px solid #ccc; }
        button { background: #007bff; color: white; cursor: pointer; border: none; }
        .back-link { margin-bottom: 20px; display: inline-block; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin.php" class="back-link">← Quay lại Dashboard</a>
        <h1>Quản lý thanh toán</h1>
        <?php if(isset($_GET['success'])): ?>
            <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <p style="color: red;"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>Mã GD</th>
                    <th>Mã ĐH</th>
                    <th>Khách hàng</th>
                    <th>Phương thức</th>
                    <th>Số tiền</th>
                    <th>Cập nhật trạng thái</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($payments as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td>#<?= $p['order_id'] ?></td>
                    <td><?= htmlspecialchars($p['customer_name']) ?></td>
                    <td><strong style="text-transform: uppercase;"><?= htmlspecialchars($p['payment_method']) ?></strong></td>
                    <td><?= number_format($p['amount'], 0, ',', '.') ?> đ</td>
                    <td>
                        <form action="admin.php?controller=payment&action=updateStatus" method="POST" style="display:flex; gap: 5px;">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <select name="status">
                                <option value="pending" <?= $p['payment_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="success" <?= $p['payment_status'] == 'success' ? 'selected' : '' ?>>Success</option>
                                <option value="failed" <?= $p['payment_status'] == 'failed' ? 'selected' : '' ?>>Failed</option>
                            </select>
                            <button type="submit">Lưu</button>
                        </form>
                    </td>
                    <td><?= $p['created_at'] ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($payments)): ?>
                <tr><td colspan="7" style="text-align: center;">Chưa có giao dịch nào</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
