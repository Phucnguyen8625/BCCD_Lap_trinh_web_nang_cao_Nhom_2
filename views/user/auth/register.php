<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký – MangaStore</title>
    <link rel="stylesheet" href="public/assets/css/authStyle.css">
</head>
<body>
<div class="auth-page">
    <div class="auth-box">
        <!-- LEFT PANEL -->
        <div class="auth-box__left">
            <a href="index.php" class="auth-back">← Về trang chủ</a>
            <div class="brand">MangaStore</div>
            <span class="auth-badge">Tham gia cộng đồng</span>
            <h1>Tạo tài khoản mới</h1>
            <p>Đăng ký miễn phí để bắt đầu mua sắm, theo dõi truyện mới và nhận ưu đãi dành riêng cho thành viên!</p>

            <div class="auth-features">
                <div class="auth-feature-item">
                    <div class="icon">🎁</div>
                    <span>Ưu đãi đặc biệt cho thành viên mới</span>
                </div>
                <div class="auth-feature-item">
                    <div class="icon">🚀</div>
                    <span>Giao hàng nhanh toàn quốc</span>
                </div>
                <div class="auth-feature-item">
                    <div class="icon">🔒</div>
                    <span>Bảo mật thông tin tuyệt đối</span>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="auth-box__right">
            <form method="POST" action="index.php?controller=auth&action=processRegister" class="auth-form">
                <h2>Đăng ký</h2>
                <p class="subtitle">Điền thông tin để tạo tài khoản MangaStore.</p>

                <?php if (!empty($message)): ?>
                    <div class="auth-alert auth-alert--<?php echo $messageType === 'error' ? 'error' : 'success'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="auth-alert auth-alert--error">
                        <ul>
                            <?php foreach ($errors as $err): ?>
                                <li><?php echo htmlspecialchars($err); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="auth-form__group">
                    <label for="ho_ten">Họ và Tên</label>
                    <input type="text" id="ho_ten" name="ho_ten" required
                           placeholder="Nhập họ và tên đầy đủ..."
                           value="<?php echo htmlspecialchars($oldData['ho_ten'] ?? ''); ?>">
                </div>

                <div class="auth-form__group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required
                           placeholder="Nhập địa chỉ email..."
                           value="<?php echo htmlspecialchars($oldData['email'] ?? ''); ?>">
                </div>

                <div class="auth-form__group">
                    <label for="mat_khau">Mật khẩu</label>
                    <div style="position:relative;">
                        <input type="password" id="mat_khau" name="mat_khau" required
                               placeholder="Tối thiểu 6 ký tự..." style="padding-right: 48px;">
                        <button type="button" class="toggle-password"
                                style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#6b7280;display:flex;align-items:center;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <small style="color:#9ca3af;font-size:12px;margin-top:5px;display:block;">Mật khẩu cần có ít nhất 6 ký tự.</small>
                </div>

                <div class="auth-form__group">
                    <label for="xac_nhan_mat_khau">Xác nhận Mật khẩu</label>
                    <div style="position:relative;">
                        <input type="password" id="xac_nhan_mat_khau" name="xac_nhan_mat_khau" required
                               placeholder="Nhập lại mật khẩu..." style="padding-right: 48px;">
                        <button type="button" class="toggle-password"
                                style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#6b7280;display:flex;align-items:center;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="auth-btn auth-btn--primary">Tạo tài khoản</button>

                <p class="auth-form__footer">
                    Đã có tài khoản?
                    <a href="index.php?controller=auth&action=login">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
</div>
<script src="public/assets/js/auth.js"></script>
</body>
</html>
