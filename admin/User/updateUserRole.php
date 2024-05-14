<?php
include '../model/pdo.php';

// Kiểm tra nếu dữ liệu user ID và role ID không được gửi đi
if (!isset($_POST["userId"]) || !isset($_POST["roleId"])) {
    http_response_code(400); // Trả về lỗi Bad Request
    exit;
}

$userID = $_POST["userId"];
$roleID = $_POST["roleId"];

// Điều chỉnh các giá trị để tránh lỗ hổng bảo mật (ví dụ: SQL injection)
$userID = htmlspecialchars($userID);
$roleID = htmlspecialchars($roleID);

// Kết nối CSDL và thực hiện truy vấn cập nhật vai trò của người dùng
try {
    $sql = "UPDATE users SET role_id = '$roleID' WHERE userID = '$userID'";
    pdo_execute($sql);

    echo "Cập nhật vai trò thành công";
    http_response_code(200);
    exit;
} catch (PDOException $e) {
    // Trả về mã lỗi 500 - Internal Server Error nếu có lỗi xảy ra khi thực hiện truy vấn
    http_response_code(500);
    echo "Lỗi: " . $e->getMessage();
    exit;
}
?>