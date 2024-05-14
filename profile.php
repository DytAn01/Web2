<?php
include "pages/header.php";
session_start(); // Bắt đầu phiên làm việc

// Include file dbconnect.php để kết nối đến cơ sở dữ liệu
include 'dbconnect.php';

// Kiểm tra xem userID có được thiết lập trong phiên không
if(isset($_SESSION['userID'])) {
    $userId = $_SESSION['userID'];

    // Tạo câu truy vấn SQL
    $query = "SELECT * FROM users  WHERE userID = $userId";

    // Thực thi câu truy vấn
    $result = mysqli_query($conn, $query);

    // Kiểm tra nếu không có kết quả trả về
    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }

    // Lấy dữ liệu
    $userData = mysqli_fetch_assoc($result);

    // Giải phóng bộ nhớ sau khi sử dụng kết quả
    mysqli_free_result($result);
} else {
    // Xử lý trường hợp userID không được thiết lập trong phiên
    // Chuyển hướng người dùng hoặc hiển thị thông báo lỗi
    echo "ID người dùng không được thiết lập trong phiên.";
    exit;
}
?>
<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/style2.css">

<div class="user-container">
    <div class="row">
        <div class="main-content">
            <div id="user-information">
                <div class="panel-heading">
                    <span>Thông tin người dùng</span>
                </div>
                <div class="panel-body">
                    <table class="user-table">
                        <tr>
                            <th>Họ và tên</th>
                            <td><input name="txthoten" type="text" class="form-control" value="<?php echo $userData['hovaten']; ?>"></td>
                        </tr>
                        <tr>
                            <th>Số điện thoại</th>
                            <td><input name="txtdienthoai" type="text" class="form-control" value="<?php echo $userData['sodienthoai']; ?>"></td>
                        </tr>
                        <tr>
                            <th>Địa chỉ</th>
                            <td><input name="txtdiachi" type="text" class="form-control" value="<?php echo $userData['diachi']; ?>"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><input name="txtemail" type="text" class="form-control" value="<?php echo $userData['email']; ?>"></td>
                        </tr>
                    </table>
                    <div class="form-group row">
                        <div class="form-button">
                            <input type="submit" name="" value="Lưu thay đổi" class="btn-info">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $hoten = $_POST['txthoten'];
    $dienthoai = $_POST['txtdienthoai'];
    $diachi = $_POST['txtdiachi'];
    $email = $_POST['txtemail'];
  
    // Chuẩn bị câu truy vấn SQL để cập nhật thông tin người dùng
    $query = "UPDATE users
              SET hovaten ='$hoten', email = '$email', sodienthoai = '$dienthoai', diachi = '$diachi'
              WHERE userID = $userId";

    // Thực thi câu truy vấn
    $result = mysqli_query($conn, $query);

    // Kiểm tra xem có lỗi xảy ra khi thực thi câu truy vấn không
    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }

    // Kiểm tra xem có bất kỳ hàng nào bị ảnh hưởng hay không
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Thay đổi thành công!'); location.reload();</script>";
    }
}
include "pages/footer.php";
?>
