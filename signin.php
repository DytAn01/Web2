<?php
include "pages/header.php";
include_once "dbconnect.php";
?>
<link rel="stylesheet" href="css/signin.css">
<link rel="stylesheet" href="css/style2.css">
<div class="registration-form">        
    <form action="" method="post">
            <h1>Đăng nhập</h1>
            <input type="hidden" id="action" value="login">
        <div class="login-group">
            <label for="tendangnhaptxt">Tên đăng nhập</label>
            <input id="tendangnhap" type="text" class="text-field" placeholder="Nhập tên đăng nhập" name="tendangnhap" required>
        </div>
        <div class="login-group">
            <label for="passtxt">Mật khẩu</label>
            <input id="pass" type="password" class="text-field" placeholder="Nhập mật khẩu" name="pass" required>
        </div>
        <button type="button" onclick="submitData()" class="btn">Đăng nhập</button>
        <div class="login-assist">
            <p>Bạn chưa có tài khoản? Hãy <a href="signup.php">Đăng kí ngay</a></p>
        </div>
        
</form>
</div>
<?php
include "script2.php";
include "pages/footer.php";
?> 