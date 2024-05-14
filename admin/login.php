<?php
session_start();
include './model/pdo.php';

if (isset($_SESSION['username'])) {
    header('index.php?act=sanpham');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra dữ liệu biểu mẫu được gửi đi
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = new PDO('mysql:host=localhost;dbname=shopmatkinh_db', 'root', '');
        $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user && $password === $user['password']) {
            extract($user);
            if ($role_id == 3) {
                $_SESSION['error_message'] = 'Bạn không có quyền truy cập trang này';
                header('Location: login.php');
                exit;
            }

            $_SESSION['username'] = $username;
            $_SESSION['user_role'] = $role_id;
            header('Location: index.php?act=sanpham');
            exit;
        } else {
            $_SESSION['error_message'] = 'Sai tên đăng nhập hoặc mật khẩu';
            header('Location: login.php');
            exit;
        }

    } else {
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <h1>Login Admin</h1>
    <?php if (isset($_SESSION['error_message'])): ?>
        <p class="error-message"><?php echo $_SESSION['error_message']; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required="true">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required="true">
        <input type="submit" value="Login">
    </form>
</body>

</html>