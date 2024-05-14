<link rel="stylesheet" href="../style.css">
<?php
include "header.php";
?>
<div class="waiting-list-display">
    <div class="waiting-list-container">

        <?php
        include "../dbconnect.php";
        if ($conn) {
            // $sql_donDaXuLi = "SELECT COUNT(*) AS count FROM hoadon WHERE trangthai = 1";
            // $result_donDaXuLi = mysqli_query($conn, $sql_donDaXuLi);
            // if ($result_donDaXuLi) {
            //     $row_donDaXuLi = mysqli_fetch_assoc($result_donDaXuLi);
            //     $soDonDaXuLi = $row_donDaXuLi['count'];
            //     if ($soDonDaXuLi > 0) {
                if(isset($_SESSION['userID'])){
                    $maKH = $_SESSION['userID'];

                    $sql_hoadon = "SELECT * FROM hoadon WHERE mataikhoan = $maKH";
                    $result_hoadon = $conn->query($sql_hoadon);
                    if ($result_hoadon->num_rows > 0) {
                        // duyệt từng hóa đơn
                        while ($rowHoaDon = mysqli_fetch_assoc($result_hoadon)) {
                            $maHD = $rowHoaDon['maHD'];
                            $thoiGianDatHang = $rowHoaDon['ngayxuatHD'];
                            $thanhTien = $rowHoaDon['thanhtien'];
                            echo '<div class="order">
                                <div class="order-info">
                                    <label> Mã đơn hàng: ' . $maHD . ' </label>
                                    <div class="list-order-details-container">
                                        <div class="list-order-details">';

                            $sql_chitiethoadon = "SELECT chitiethoadon.maSP, chitiethoadon.soluong, sanpham.tenSP, sanpham.img_src, sanpham.dongia 
                                         FROM chitiethoadon 
                                         INNER JOIN sanpham ON chitiethoadon.maSP = sanpham.maSP 
                                         WHERE chitiethoadon.maHD = '$maHD'";
                            $result_chitiethoadon = $conn->query($sql_chitiethoadon);
                            if ($result_chitiethoadon->num_rows > 0) {
                                // duyệt từng chi tiết 
                                while ($rowChiTietHoaDon = $result_chitiethoadon->fetch_assoc()) {
                                    $maSanPham = $rowChiTietHoaDon['maSP'];
                                    $soLuongSanPham = $rowChiTietHoaDon['soluong']; 
                                    $sqlSanPham = "SELECT * FROM sanpham WHERE maSP = '$maSanPham'";
                                    $resultSanPham = $conn->query($sqlSanPham);
                                    if ($resultSanPham->num_rows > 0) {
                                        while ($rowSanPham = $resultSanPham->fetch_assoc()) {
                                            $tenSanPham = $rowSanPham['tenSP']; 
                                            $anhSanPham = $rowSanPham['img_src']; 
                                            $donGia = $rowSanPham['dongia']; 
                                            echo '<div class="order-detail">
                                                        <img src="../images/product/' . $anhSanPham . '_11zon.png">
                                                <div>
                                                    <label> ' . $tenSanPham . ' </label> <br>
                                                    <label> ' . number_format($donGia, 0, '.', '.') . '₫ </label>
                                                    <label style="margin-left: 1rem;"> ×' .  $soLuongSanPham . ' </label>
                                                </div>
                                                <div class="border"> </div>
                                               </div>';
                                        }
                                    }
                                }
                            }
                            echo ' </div>
                                          <label class="total-payment"> Tổng thanh toán: <b>' . number_format($thanhTien, 0, '.', '.') . '₫</b> </label>
                                </div>
                                <label> Thời gian đặt hàng: ' .  $thoiGianDatHang . ' </label>
                                <label> Giao hàng thành công ! </label>
                            </div>
                        </div>';
                        }
                    }
            //         }
            //     } else { // trạng thái = 0 -> chưa được xử lí -> chưa vào lịch sử
            //         echo '
            //         <label> <h2> Bạn chưa có lịch sử đơn hàng nào </h2></label>
            //         ';
            //     }
            // } else {
            //     echo "error";
            // }
        }
    }
        ?>
       

    </div>

</div>
<?php
include "footer.php";
?>