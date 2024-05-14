<?php
include "dbconnect.php";
    if ($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['xuLi']) && isset($data['maHD'])) {
        $xuLi = $data['xuLi'];
        $maHD = $data['maHD'];
        $sql_xuLiDonHang = "UPDATE hoadon SET trangthai = $xuLi WHERE maHD = $maHD";
        $conn->query($sql_xuLiDonHang);
    }
    mysqli_close($conn);
}
 
else {
    echo "error";
}
?>