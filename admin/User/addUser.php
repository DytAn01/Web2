<div class="content">
    <h1>Thêm người dùng</h1>
    <div class="row">
        <form action="index.php?act=addUser" method="post" enctype="multipart/form-data">
            <div class="row">
                Tên người dùng: <input type="text" name="username" required>
            </div>
            <div class="row">
                Mật khẩu: <input type="password" id="password" name="password" required oninput="checkPassword()">
            </div>
            <div class="row">
                Xác nhận mật khẩu: <input type="password" id="confirm_password" name="confirm_password" required
                    oninput="checkPassword()">
            </div>
            <script>
                function checkPassword() {
                    var password = document.getElementById('password');
                    var confirm_password = document.getElementById('confirm_password');

                    if (password.value != confirm_password.value) {
                        confirm_password.setCustomValidity("Mật khẩu không khớp");
                    } else {
                        confirm_password.setCustomValidity("");
                    }
                }
            </script>
            <div class="row">
                Họ tên: <input type="text" name="hoten" required>
            </div>
            <div class="row">
                SĐT: <input type="tel" name="sdt" pattern="[0-9]{10}" required>
            </div>
            <div class="row">
                Email: <input type="email" id="email" name="email"">
            </div>
            <script>
                document.getElementById('email').addEventListener('input', checkEmail);
                function checkEmail() {
                    var email = document.getElementById('email');

                    if (!isValidEmail(email.value)) {
                        email.setCustomValidity(" Email không hợp lệ");
                    } else { email.setCustomValidity(""); }
                    function isValidEmail(email) { var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; return regex.test(email); }
                }
            </script>
                <div class="row">
                    Địa chỉ: <input type="text" name="diachi" required>
                </div>
                <div class="row">
                    Quyền:
                    <select name="vaitro" id="">
                        <?php
                        foreach ($listroles as $item) {
                            extract($item);
                            echo '<option value="' . $ma . '">' . $role . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <input type="submit" name="themmoi" value="Thêm mới">
                    <a href="index.php?act=user"><input type="button" value="Danh sách"></a>
                </div>
                <?php if (isset($thongbao) && ($thongbao != ''))
                    echo $thongbao; ?>
        </form>
    </div>
</div>
</div>