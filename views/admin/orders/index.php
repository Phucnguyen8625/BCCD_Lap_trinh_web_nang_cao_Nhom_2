<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; font-weight: 600; }
        .btn { padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; color: #fff; font-size: 14px;}
        .btn-info { background: #17a2b8; }
        .status-pending { color: #f39c12; font-weight: bold; }
        .status-processing { color: #3498db; font-weight: bold; }
        .status-completed { color: #2ecc71; font-weight: bold; }
        .status-cancelled { color: #e74c3c; font-weight: bold; }
        .back-link { margin-bottom: 20px; display: inline-block; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin.php" class="back-link">← Quay lại Dashboard</a>
        <h1>Quản lý đơn hàng</h1>
        <?php if(isset($_GET['success'])): ?>
            <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <p style="color: red;"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $o): ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td><?= htmlspecialchars($o['customer_name']) ?></td>
                    <td><?= number_format($o['total_amount'], 0, ',', '.') ?> đ</td>
                    <td class="status-<?= strtolower($o['status']) ?>"><?= ucfirst($o['status']) ?></td>
                    <td><?= $o['created_at'] ?></td>
                    <td>
                        <a href="admin.php?controller=order&action=show&id=<?= $o['id'] ?>" class="btn btn-info">Chi tiết</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($orders)): ?>
                <tr><td colspan="6" style="text-align: center;">Chưa có đơn hàng nào</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
