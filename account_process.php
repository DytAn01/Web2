<?php
session_start();

require 'dbconnect.php';
// IF
if (isset($_POST["action"])) {
  if ($_POST["action"] == "register") {
    signUp();
  } else if ($_POST["action"] == "login") {
    signIn();
  }
}
// Kiểm tra xem người dùng đã gửi thông tin đăng kí chưa
function signIn()
{
  try {
    global $conn; // Sử dụng kết nối cơ sở dữ liệu đã được thiết lập

    $tendangnhap = $_POST["tendangnhap"];
    $pass = $_POST["pass"];

    // Kiểm tra xem có trường username và password được cung cấp không
    if (empty($tendangnhap) || empty($pass)) {
      echo json_encode(array("message" => "Vui lòng nhập tên đăng nhập và mật khẩu"));
      exit;
    }

    // Truy vấn để lấy thông tin người dùng từ bảng users
    $user_query = "SELECT * FROM users WHERE username = '$tendangnhap'";
    $user_result = mysqli_query($conn, $user_query);

    // Kiểm tra xem có người dùng nào tồn tại với username đã nhập không
    if (mysqli_num_rows($user_result) > 0) {
      $row = mysqli_fetch_assoc($user_result);

        if ($row['trangthai'] == 0) {
            echo json_encode(array("message" => "Tài khoản của bạn hiện không thể đăng nhập"));
            exit;
        }
      // So sánh mật khẩu đã nhập với mật khẩu trong cơ sở dữ liệu
      if ($pass == $row['password']) {
        // Truy vấn để lấy vai trò của người dùng từ bảng roles
        // $role_query = "SELECT role FROM roles WHERE ma = '{$row['role_id']}'";
        // $role_result = mysqli_query($conn, $role_query);
        // $role_row = mysqli_fetch_assoc($role_result);
        // $role = $role_row['role_id'];

        // // Truy vấn để lấy quyền truy cập của vai trò từ bảng permissions
        // $permissions_query = "SELECT action, can_access FROM permissions WHERE role_id = '{$row['role_id']}'";
        // $permissions_result = mysqli_query($conn, $permissions_query);
        // $permissions = array();
        // while ($permission_row = mysqli_fetch_assoc($permissions_result)) {
        //   $permissions[$permission_row['action']] = $permission_row['can_access'];
        // }

        // Trả về thông tin người dùng và quyền truy cập
        // , "role" => $role, "permissions" => $permissions
        $_SESSION["login"] = true;
        $_SESSION["userID"] = $row["userID"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["role_id"] = $row["role_id"];
        echo json_encode(array("message" => "Đăng nhập thành công!"));
        // echo "<script>window.location.href = './index.php';</script>";
      } else {
        echo json_encode(array("message" => "Mật khẩu không đúng"));
        exit;
      }
    } else {
      echo json_encode(array("message" => "Tên đăng nhập hoặc mật khẩu không đúng"));
      exit;
    }
  } catch (Exception $e) {
    echo json_encode(array("message" => "Đã có lỗi xảy ra. Vui lòng thử lại sau."));
  }
}
function signUp()
{
  try {
    // Kết nối đến cơ sở dữ liệu
    global $conn;
    // Lấy dữ liệu từ biểu mẫu
    $hoten = $_POST["hoten"];
    $dienthoai = $_POST["dienthoai"];
    $diachi = $_POST["diachi"];
    $email = $_POST["email"];
    $tendangnhap = $_POST["tendangnhap"];
    $pass = $_POST["pass"];
    $repass = $_POST["repass"];

    if (empty($tendangnhap) || empty($pass) || empty($repass) || empty($hoten)) {
      echo json_encode(array("message" => "Vui lòng nhập đầy đủ thông tin"));
      exit;
    }

    // Kiểm tra mật khẩu và mật khẩu nhập lại có khớp nhau không
    if ($pass != $repass) {
      echo json_encode(array("message" => "Mật khẩu không khớp"));
      exit;
    }

    // Kiểm tra xem tên đăng nhập đã tồn tại chưa
    $user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$tendangnhap'");
    if (mysqli_num_rows($user) > 0) {
      echo json_encode(array("message" => "Tên tài khoản tồn tại"));
      exit;
    }


    // Thêm người dùng vào cơ sở dữ liệu
    $sql_insert_user = "INSERT INTO users VALUES ('', '$pass', '$dienthoai', '$email', '$tendangnhap','$hoten', '$diachi', '3','1')";
    mysqli_query($conn, $sql_insert_user);
    echo json_encode(array("message" => "Đăng ký thành công!"));
  } catch (Exception $e) {
    echo json_encode(array("message" => "Đã có lỗi xảy ra. Vui lòng thử lại sau."));
  }
}
?>
