<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_role = $_SESSION['user_role'];
} else {
    header('Location: login.php');
    exit;
}

include "./model/pdo.php";
include "header.php";

$requested_action = $_GET['act'];
if ($user_role == 0 && $requested_action == 'qlquyen') {
    include 'Quyen/qlquyen.php';
    exit;
} elseif ($user_role == 0 && $requested_action == 'user') {
    $sql = "SELECT * FROM users";
    $users = pdo_query($sql);

    $sql = "SELECT * FROM roles";
    $roles = pdo_query($sql);
    include 'User/danhSachUser.php';
    exit;
}

// Lấy danh sách các chức năng mà người dùng được phép thực hiện
$db = new PDO('mysql:host=localhost;dbname=shopmatkinh_db', 'root', '');
$stmt = $db->prepare('SELECT action_trim FROM permissions WHERE role_id = :role_id AND can_access = 1');
$stmt->bindParam(':role_id', $user_role);
$stmt->execute();
$allowed_actions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$has_access = false;
// Kiểm tra chức năng được yêu cầu có được phép thực hiện không
foreach ($allowed_actions as $action) {
    if (strpos(strtolower($requested_action), $action['action_trim']) !== false) {
        $has_access = true;
        switch ($requested_action) {
            // ------------------------------------------------------ add
            case 'addChatLieuSp':
                if (isset($_POST['themmoi']) && $_POST['ten']) {
                    $ten = $_POST['ten'];
                    $sql = "insert into chatlieusp (ten) values ('$ten')";
                    pdo_execute($sql);
                    $thongbao = "Thêm thành công";
                }
                include 'ChatLieuSp/addChatLieu.php';
                break;

            case 'addDoiTuongSd':
                if (isset($_POST['themmoi']) && $_POST['ten']) {
                    $ten = $_POST['ten'];
                    $sql = "insert into doituongsd (ten) values ('$ten')";
                    pdo_execute($sql);
                    $thongbao = "Thêm thành công";
                }
                include 'DoiTuongSd/addDoiTuong.php';
                break;

            case 'addKieuDang':
                if (isset($_POST['themmoi']) && $_POST['ten']) {
                    $ten = $_POST['ten'];
                    $sql = "insert into kieudang (ten) values ('$ten')";
                    pdo_execute($sql);
                    $thongbao = "Thêm thành công";
                }
                include 'KieuDang/addKieuDang.php';
                break;

            case 'addSanPham':
                if (isset($_POST['themmoi'])) {
                    $tenSP = $_POST['tenSP'];
                    $soluong = $_POST['soluong'];
                    $dongia = $_POST['dongia'];
                    $kieudang = $_POST['kieudang'];
                    $doituongsd = $_POST['doituongsd'];
                    $chatlieu = $_POST['chatlieu'];
                    $img = $_FILES['img']['name'];

                    $target_dir = "uploads/"; // Thư mục lưu trữ tệp
                    $target_file = $target_dir . basename($_FILES["img"]["name"]); // Đường dẫn đầy đủ đến tệp được tải lên
                    move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
                    // var_dump($kieudang, $doituongsd, $chatlieu);

                    $sql = "insert into sanpham (tenSP, soluong, dongia, makieudang, madoituongsd, machatlieu, img_src)
                            values ('$tenSP','$soluong', '$dongia', '$kieudang', '$doituongsd', '$chatlieu', '$img')";
                    pdo_execute($sql);
                    $thongbao = "Thêm thành công";
                }
                $sql = "select * from kieudang";
                $listkieudang = pdo_query($sql);

                $sql = "select * from doituongsd";
                $listdoituongsd = pdo_query($sql);

                $sql = "select * from chatlieusp";
                $listchatlieu = pdo_query($sql);

                include 'SanPham/addSanpham.php';
                break;

            case 'addUser':
                if (isset($_POST['themmoi'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $role_id = $_POST['vaitro'];
                    $hoten = $_POST['hoten'];
                    $sdt = $_POST['sdt'];
                    $email = $_POST['email'];
                    $diachi = $_POST['diachi'];

                    $sql = "insert into users (username, password, role_id, hovaten, sodienthoai, email, diachi)
                            values ('$username', '$password', '$role_id', '$hoten', '$sdt', '$email', '$diachi')";
                    pdo_execute($sql);
                    $thongbao = "Thêm thành công";
                }
                $sql = "SELECT * FROM `roles`";
                $listroles = pdo_query($sql);

                include 'User/addUser.php';
                break;

            // -------------------------------------------------------------------------- get danhSach

            case 'chatlieu':
                $sql = "select * from chatlieusp";
                $danhsach = pdo_query($sql);
                include 'ChatLieuSp/danhSachChatLieu.php';
                break;

            case 'doituongsudung':
                $sql = "select * from doituongsd";
                $danhsach = pdo_query($sql);
                include 'DoiTuongSd/danhSachDoiTuong.php';
                break;

            case 'kieudang':
                $sql = "select * from kieudang";
                $danhsach = pdo_query($sql);
                include 'KieuDang/danhSachKieuDang.php';
                break;

            case 'sanpham':
                $sql = "SELECT COUNT(*) FROM sanpham";
                $totalProducts = pdo_query_value($sql);
                include 'SanPham/danhSachSp.php';
                break;

            case 'user':
                $sql = "SELECT * FROM users";
                $users = pdo_query($sql);

                $sql = "SELECT * FROM roles";
                $roles = pdo_query($sql);
                include 'User/danhSachUser.php';
                break;

            case 'hoadon':
                $sql = "SELECT hoadon.*, users.username as tenKH, trangthai.trangthai as TT
                    FROM hoadon
                    INNER JOIN users ON hoadon.mataikhoan = users.userID
                    INNER JOIN trangthai ON hoadon.trangthai = trangthai.ma";
                $danhsach = pdo_query($sql);
                include 'HoaDon/danhSachHoaDon.php';
                break;

            // ----------------------------------------------------------------- delete

            case 'xoaChatLieuSp':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $sql = "delete from chatlieusp where ma=" . $_GET['id'];
                    pdo_execute($sql);
                }
                $sql = "select * from chatlieusp";
                $danhsach = pdo_query($sql);
                include 'ChatLieuSp/danhSachChatLieu.php';
                break;

            case 'xoaDoiTuongSd':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $sql = "delete from doituongsd where ma=" . $_GET['id'];
                    pdo_execute($sql);
                }
                $sql = "select * from doituongsd";
                $danhsach = pdo_query($sql);
                include 'DoiTuongSd/danhSachDoiTuong.php';
                break;

            case 'xoaKieuDang':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $sql = "delete from kieudang where ma=" . $_GET['id'];
                    pdo_execute($sql);
                }
                $sql = "select * from kieudang";
                $danhsach = pdo_query($sql);
                include 'KieuDang/danhSachKieuDang.php';
                break;

            case 'xoaSanPham':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $sql = "delete from sanpham where maSP=" . $_GET['id'];
                    pdo_execute($sql);
                }
                $sql = "SELECT COUNT(*) FROM sanpham";
                $totalProducts = pdo_query_value($sql);
                include 'SanPham/danhsachsp.php';
                break;

            case 'xoaUser':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $sql = "delete from users where userID=" . $_GET['id'];
                    pdo_execute($sql);
                }
                $sql = "SELECT users.*, roles.role as vaitro
                        FROM users
                        INNER JOIN roles ON users.role = roles.ma";
                $users = pdo_query($sql);
                include 'User/danhSachUser.php';
                break;

            // ----------------------------------------------------------- loadUpdate

            case 'loadUpdateChatLieuSp':
                if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                    $sql = "select * from chatlieusp where ma=" . $_GET['id'];
                    $chatlieu = pdo_query_one($sql);
                }
                include 'ChatLieuSp/updateChatLieu.php';
                break;

            case 'loadUpdateDoiTuongSd':
                if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                    $sql = "select * from doituongsd where ma=" . $_GET['id'];
                    $doituong = pdo_query_one($sql);
                }
                include 'DoiTuongSd/updateDoiTuong.php';
                break;

            case 'loadUpdateKieuDang':
                if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                    $sql = "select * from kieudang where ma=" . $_GET['id'];
                    $kieudang = pdo_query_one($sql);
                }
                include 'KieuDang/updateKieuDang.php';
                break;

            case 'loadUpdateSanPham':
                if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                    $sql = "select sp.*, cl.ten as chatlieu_ten, dt.ten as doituong_ten, kd.ten as kieudang_ten
                        from sanpham as sp  
                        inner join chatlieusp as cl on sp.machatlieu = cl.ma
                        inner join doituongsd as dt on sp.madoituongsd = dt.ma
                        inner join kieudang as kd on sp.makieudang = kd.ma where sp.maSP=" . $_GET['id'];
                    $sanpham = pdo_query_one($sql);

                    $sql = "select * from kieudang";
                    $listkieudang = pdo_query($sql);

                    $sql = "select * from doituongsd";
                    $listdoituongsd = pdo_query($sql);

                    $sql = "select * from chatlieusp";
                    $listchatlieu = pdo_query($sql);
                }
                include 'SanPham/updateSp.php';
                break;

            case 'CTHoaDon':
                if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                    $maHD = intval($_GET['id']);
                    $sql = "SELECT * FROM hoadon WHERE maHD = $maHD";
                    $hoadon = pdo_query($sql);

                    if (count($hoadon) > 0) {
                        $hoadon = $hoadon[0];
                        $ngayxuatHD = $hoadon['ngayxuatHD'];
                        $thanhtien = $hoadon['thanhtien'];

                        $sql = "SELECT chitiethoadon.*, sanpham.tensp 
                FROM chitiethoadon 
                JOIN sanpham ON chitiethoadon.maSP = sanpham.maSP 
                WHERE chitiethoadon.maHD = $maHD";
                        $result = pdo_query($sql);
                    }
                }
                include 'HoaDon/chiTietHoaDon.php';
                break;

            // -------------------------------------------------------------------- update

            case 'updateChatLieuSp':
                if (isset($_POST['capnhat']) && $_POST['ten']) {
                    $ma = $_POST['ma'];
                    $ten = $_POST['ten'];
                    $sql = "update chatlieusp set ten='$ten' where ma='$ma'";
                    pdo_execute($sql);
                    $thongbao = "Cập nhật thành công";
                }
                $sql = "select * from chatlieusp";
                $danhsach = pdo_query($sql);
                include 'ChatLieuSp/danhSachChatLieu.php';
                break;

            case 'updateDoiTuongSd':
                if (isset($_POST['capnhat']) && $_POST['ten']) {
                    $ma = $_POST['ma'];
                    $ten = $_POST['ten'];
                    $sql = "update doituongsd set ten='$ten' where ma='$ma'";
                    pdo_execute($sql);
                    $thongbao = "Cập nhật thành công";
                }
                $sql = "select * from doituongsd";
                $danhsach = pdo_query($sql);
                include 'DoiTuongSd/danhSachDoiTuong.php';
                break;

            case 'updateKieuDang':
                if (isset($_POST['capnhat']) && $_POST['ten']) {
                    $ma = $_POST['ma'];
                    $ten = $_POST['ten'];
                    $sql = "update kieudang set ten='$ten' where ma='$ma'";
                    pdo_execute($sql);
                    $thongbao = "Cập nhật thành công";
                }
                $sql = "select * from kieudang";
                $danhsach = pdo_query($sql);
                include 'KieuDang/danhSachKieuDang.php';
                break;

            case 'updateSanPham':
                if (isset($_POST['capnhat'])) {
                    $maSP = $_POST['maSP'];
                    $tenSP = $_POST['tenSP'];
                    $soluong = $_POST['soluong'];
                    $dongia = $_POST['dongia'];
                    $kieudang = $_POST['makieudang'];
                    $doituongsd = $_POST['madoituongsd'];
                    $chatlieu = $_POST['machatlieu'];
                    $img = $_FILES['img']['name'];

                    $target_dir = "uploads/"; // Thư mục lưu trữ tệp
                    $target_file = $target_dir . basename($_FILES["img"]["name"]); // Đường dẫn đầy đủ đến tệp được tải lên
                    move_uploaded_file($_FILES['img']['tmp_name'], $target_file);

                    if ($img == '') {
                        $sql = "update sanpham set tenSP='$tenSP', soluong='$soluong',dongia='$dongia', 
                    makieudang='$kieudang',madoituongsd='$doituongsd', machatlieu='$chatlieu' 
                    where maSP='$maSP'";
                    } else
                        $sql = "update sanpham set tenSP='$tenSP', soluong='$soluong',dongia='$dongia', 
                makieudang='$kieudang',madoituongsd='$doituongsd', machatlieu='$chatlieu', img_src='$img' 
                where maSP='$maSP'";

                    pdo_execute($sql);
                }
                $sql = "SELECT COUNT(*) FROM sanpham";
                $totalProducts = pdo_query_value($sql);
                include 'SanPham/danhsachsp.php';
                break;

            // ------------------------------------------------------------- thong ke
            case 'thongke':
                include 'ThongKe/thongke.php';
                break;


            default:
                include "home.php";
                break;
        }
    }
}

if (!$has_access) {
    $thongbao = "Bạn không có quyền truy cập trang này";
    include 'home.php';
    exit;
}

?>

</body>

</html>