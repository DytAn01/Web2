<?php
include '../model/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['img'] != '')) {
    $img = $_POST['img'];
    $img = '../' . $img;
    $maSP = $_POST['maSP'];
    if (is_file($img)) {
        // unlink($img);
        $sql = "update sanpham set img_src='' where maSP='$maSP'";
        pdo_execute($sql);
        echo 'Đã xóa ảnh';
    } else {
        echo 'Không tìm thấy ' . $img . '';

    }
} else {
    echo 'Không có ảnh để xóa';
}
?>