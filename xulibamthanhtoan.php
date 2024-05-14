<?php
session_start();
include "dbconnect.php";

if ($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['selectedProduct'])) {
        $ngayxuatHD = date("Y-m-d");
        $maKH = $_SESSION['userID'];
        $sql = "INSERT INTO hoadon(thanhtien, ngayxuatHD, mataikhoan) VALUES (0, '$ngayxuatHD', '$maKH')";
        if ($conn->query($sql) === TRUE) {
            $maHD = $conn->insert_id;
            $thanhtien = 0;
        }
        $selectedProduct = $data['selectedProduct'];
        foreach ($selectedProduct as $product) {
            $idSanPham = $product['id'];
            $soLuong = $product['count'];
            $sql = "SELECT dongia FROM sanpham WHERE maSP = $idSanPham";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $gia = $row['dongia'];
                $tongTien = $soLuong * $gia;
                $thanhtien += $tongTien;
                $sql = "INSERT INTO chitiethoadon (maHD, maSP, soluong, tongtien) VALUES ($maHD, $idSanPham, $soLuong, $tongTien)";
                $conn->query($sql);
            }
        }
        $sql = "UPDATE hoadon SET thanhtien = $thanhtien WHERE maHD = $maHD";
        $conn->query($sql);
    }
    mysqli_close($conn);

} else {
    echo "Lỗi kết nối đến cơ sở dữ liệu.";
}
