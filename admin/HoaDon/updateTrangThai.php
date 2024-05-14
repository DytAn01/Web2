<?php
include '../model/pdo.php';

if (!isset($_POST['hoadonId']) || !isset($_POST['status'])) {
    echo 'alert("Dữ liệu POST không hợp lệ")';
    exit;
}

$hoadonID = $_POST['hoadonId'];
$status = $_POST['status'];

$sql = "update hoadon set trangthai='$status' where maHD='$hoadonID'";
pdo_execute($sql);
echo 'alert("Cập nhật trạng thái thành công")';
?>