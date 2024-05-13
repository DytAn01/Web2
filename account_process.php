<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
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
function signIn(){
    try {
        global $conn; // Sử dụng kết nối cơ sở dữ liệu đã được thiết lập
    
        $username = $_POST["username"];
        $password = $_POST["password"];
    
        // Kiểm tra xem có trường username và password được cung cấp không
        if (empty($username) || empty($password)) {
          echo json_encode(array("message" => "Vui lòng nhập tên đăng nhập và mật khẩu"));
          exit;
        }
    
        // Truy vấn để lấy thông tin người dùng từ bảng users
        $user_query = "SELECT * FROM users WHERE username = '$username'";
        $user_result = mysqli_query($conn, $user_query);
    
        // Kiểm tra xem có người dùng nào tồn tại với username đã nhập không
        if (mysqli_num_rows($user_result) > 0) {
          $row = mysqli_fetch_assoc($user_result);
    
          // So sánh mật khẩu đã nhập với mật khẩu trong cơ sở dữ liệu
          if ($password == $row['password']) {
            // Truy vấn để lấy vai trò của người dùng từ bảng roles
            $role_query = "SELECT role FROM roles WHERE ma = '{$row['role_id']}'";
            $role_result = mysqli_query($conn, $role_query);
            $role_row = mysqli_fetch_assoc($role_result);
            $role = $role_row['role'];
    
            // Truy vấn để lấy quyền truy cập của vai trò từ bảng permissions
            $permissions_query = "SELECT action, can_access FROM permissions WHERE role_id = '{$row['role_id']}'";
            $permissions_result = mysqli_query($conn, $permissions_query);
            $permissions = array();
            while ($permission_row = mysqli_fetch_assoc($permissions_result)) {
              $permissions[$permission_row['action']] = $permission_row['can_access'];
            }
    
            // Trả về thông tin người dùng và quyền truy cập
            $dataRespone = json_encode(array("message" => "Đăng nhập thành công", "role" => $role, "permissions" => $permissions));
            $_SESSION["login"] = true;
            $_SESSION["userID"] = $row["userID"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["role_id"] = $row["role_id"];
            echo $dataRespone;
            echo "<script>window.location.href = 'index.php';</script>";
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
function signUp(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kết nối đến cơ sở dữ liệu
        include_once "dbconnect.php";
        
        // Lấy dữ liệu từ biểu mẫu
        $hoten = $_POST["hoten"];
        $dienthoai = $_POST["dienthoai"];
        $diachi = $_POST["diachi"];
        $email = $_POST["email"];
        $tendangnhap = $_POST["tendangnhap"];
        $pass = $_POST["pass"];
        $repass = $_POST["repass"];

        // Kiểm tra mật khẩu và mật khẩu nhập lại có khớp nhau không
        if ($pass != $repass) {
            echo "Mật khẩu và mật khẩu nhập lại không khớp.";
            exit;
        }

        // Kiểm tra xem tên đăng nhập đã tồn tại chưa
        $sql_check_username = "SELECT * FROM users WHERE username = '$tendangnhap'";
        $result_check_username = mysqli_query($conn, $sql_check_username);
        if (mysqli_num_rows($result_check_username) > 0) {
            echo "Tên đăng nhập đã tồn tại.";
            exit;
        }


        // Thêm người dùng vào cơ sở dữ liệu
        $sql_insert_user = "INSERT INTO users (hovaten, password, sodienthoai, email, username, diachi, role_id) VALUES ('$hoten', '$hashed_password', '$dienthoai', '$email', '$tendangnhap', '$diachi', 4)";
            echo "Đăng kí thành công.";
        } else {
            echo "Đã xảy ra lỗi: " . mysqli_error($conn);
        }

        // Đóng kết nối
        mysqli_close($conn);

}    
?>
<?php

// REGISTER

function register()
{
  global $conn;

  $fullname = $_POST["fullname"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];
  $currentDateTime = date('Y-m-d');
  $state = 1;

  if (empty($username) || empty($password) || empty($confirm_password) || empty($fullname)) {
    echo json_encode(array("message" => "Vui lòng nhập đầy đủ thông tin"));
    exit;
  }
  if ($password != $confirm_password) {
    echo json_encode(array("message" => "Mật khẩu không khớp"));
    exit;
  }

  $user = mysqli_query($conn, "SELECT * FROM taikhoan WHERE tendn = '$username'");
  if (mysqli_num_rows($user) > 0) {
    echo json_encode(array("message" => "Tên tài khoản đã tồn tại"));
    exit;
  }

  $query = "INSERT INTO taikhoan VALUES('','$currentDateTime', '$username', '$password', '$state')";
  mysqli_query($conn, $query);
  $last_id = mysqli_insert_id($conn);
  $query = "INSERT INTO khachhang VALUES('','$fullname','','','','$last_id','')";
  mysqli_query($conn, $query);
  $query = "INSERT INTO phanquyen VALUES('$last_id','5')";
  mysqli_query($conn, $query);
  echo json_encode(array("message" => "Registration Successful"));
}

// LOGIN
function login()
{
  try {
    global $conn;

    $username = $_POST["username"];
    $password = $_POST["password"];
    if (empty($username) || empty($password)) {
      echo json_encode(array("message" => "Vui lòng nhập tên đăng nhập và mật khẩu"));
      exit;
    }
    $user = mysqli_query($conn, "SELECT * FROM taikhoan WHERE tendn = '$username'");
  

    if (mysqli_num_rows($user) > 0) {

      $row = mysqli_fetch_assoc($user);


      if ($password == $row['MATKHAU']) {
        $query_permission = "SELECT * FROM phanquyen WHERE MATK = " . $row['MATK'];
        $result_permission = mysqli_query($conn, $query_permission);
        $permission = mysqli_fetch_assoc($result_permission);
        switch ($permission['MANHOMQUYEN']) {
          case 1: // Admin
            $accountTableName = 'nhanvien';
            break;
          case 2: // Quản lý
            $accountTableName = 'nhanvien';
            break;
          case 3: // Nhân viên
            $accountTableName = 'nhanvien';
            break;
          case 4: // Thủ kho
            $accountTableName = 'nhanvien';
            break;
          case 5: // Khách hàng
            $accountTableName = 'khachhang';
            break;
        }
        $userInfoSQLResult = mysqli_query($conn, "SELECT * FROM $accountTableName WHERE MATK = '{$row['MATK']}'");

        // check if user not exists
        if (mysqli_num_rows($userInfoSQLResult) <= 0) {
          echo "Tài khoản chưa được kích hoạt hoặc không tồn hoạt. Vui lòng liên hệ với quản trị viên.";
          exit;
        }

        $userInfo = mysqli_fetch_assoc($userInfoSQLResult);

        // Get user's role


        // response with userInfo and loginRoute
        $dataRespone = json_encode(array("message" => "Login Successful", "loginRoute" => $permission['MANHOMQUYEN']));
        $_SESSION["login"] = true;
        $_SESSION["id"] = $row["MATK"];
        $_SESSION["username"] = $userInfo["TEN"];
        $_SESSION["MANHOMQUYEN"] = $permission['MANHOMQUYEN'];
        echo $dataRespone;
      } else {
        echo json_encode(array("message" => "Mật khẩu sai"));
        exit;
      }

    } else {
      echo json_encode(array("message" => "Tên tài khoản hoặc mật khẩu sai"));
      exit;
    }
  } catch (Exception $e) {
    echo json_encode(array("message" => "Đã có lỗi xảy ra. Vui lòng thử lại sau."));
  }
}
?>