
<?php
// Kết nối đến cơ sở dữ liệu
include_once "dbconnect.php";

// Kiểm tra xem người dùng đã gửi thông tin đăng nhập chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu đăng nhập
    $username = $_POST["tendangnhap"];
    $password = $_POST["password"];

    // Xử lý xác thực đăng nhập
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Đăng nhập thành công
        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;

        header("location: index.php"); // Điều hướng đến trang dashboard
    } else {
        // Đăng nhập không thành công
        echo "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}

// Đóng kết nối
mysqli_close($conn);
?>
