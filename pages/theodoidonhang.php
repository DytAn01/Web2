<link rel="stylesheet" href="../style.css">
<?php
include "header.php";
?>
<div class="waiting-list-display">
    <div class="waiting-list-container">
        <?php
        include "../dbconnect.php";
        if ($conn) {
            $sql_hoadon = "SELECT * FROM hoadon";
            $result_hoadon = $conn->query($sql_hoadon);
            if ($result_hoadon->num_rows > 0) {
                // duyệt từng hóa đơn
                while ($rowHoaDon = mysqli_fetch_assoc($result_hoadon)) {
                    $maHD = $rowHoaDon['maHD'];
                    $thoiGianDatHang = $rowHoaDon['ngayxuatHD'];
                    $thanhTien = $rowHoaDon['thanhtien'];
                    $trangThai = $rowHoaDon['trangthai'];
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
                            $soLuongSanPham = $rowChiTietHoaDon['soluong']; //******/
                            $sqlSanPham = "SELECT * FROM sanpham WHERE maSP = '$maSanPham'";
                            $resultSanPham = $conn->query($sqlSanPham);
                            if ($resultSanPham->num_rows > 0) {
                                while ($rowSanPham = $resultSanPham->fetch_assoc()) {
                                    $tenSanPham = $rowSanPham['tenSP']; //******/
                                    $anhSanPham = $rowSanPham['img_src']; //******/
                                    $donGia = $rowSanPham['dongia']; //******/
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
                    $thongBaoTrangThai = '';
                    if ($trangThai == 0) {
                        $thongBaoTrangThai = 'Đang chờ xử lí';
                    } else if ($trangThai == 1) {
                        $thongBaoTrangThai = 'Đơn hàng đã được giao đến bạn';
                    } else {
                        $thongBaoTrangThai = 'Đơn hàng của bạn đã bị hủy';
                    }
                    echo ' </div>
                      <label class="total-payment"> Tổng thanh toán: <b>' . number_format($thanhTien, 0, '.', '.') . '₫</b> </label>
            </div>
            <label> Thời gian đặt hàng: ' .  $thoiGianDatHang . ' </label>
            <label> Trạng thái:  ' . $thongBaoTrangThai . '</label>
            
        </div>
    </div>';
                }
            }
        }


        ?>

        <!-- js xử lí đơn hàng của admin -->
        <script>
            // <div class="order-processing">
            //         <button class="approve" id="' . $maHD . '" onclick="xuLiDonHang(this)"> Duyệt đơn </button> 
            //         <button class="cancel"  id="' . $maHD . '" onclick="xuLiDonHang(this)"> Hủy đơn </button> 
            // </div>
            function xuLiDonHang(btn) {
                if (btn.className == "approve") {
                    $xuLi = 1;
                } else if (btn.className == "cancel") {
                    $xuLi = -1;
                }
                $maHD = parseInt(btn.id);
                var xhttp = new XMLHttpRequest();
                if (xhttp) {
                    xhttp.open("POST", "../xulidonhang.php", true);
                    xhttp.setRequestHeader("Content-Type", "application/json");
                    var data = JSON.stringify({
                        xuLi: $xuLi,
                        maHD: $maHD
                    });
                    xhttp.send(data);
                } else {
                    console.log("Error");
                }

            }
        </script>
        <!-- <div class="order">
            <div class="order-info">
                <label> Mã đơn hàng: 194893212 </label>
                <div class="list-order-details-container">
                    <div class="list-order-details">
                        <div class="order-detail">
                            <img src="../images/product/AF1035G-3A_11zon.png">
                            <div>
                                <label> AIR FIT AF1035G-3A </label> <br>
                                <label> 1.000.000đ</label>
                            </div>
                            <label> ×3 </label>
                            <div class="border"> </div>
                        </div>
                    </div>
                    <label> Tổng thanh toán: 3.000.000đ </label>
                </div>
                <label> Thời gian đặt hàng: 00:38 28/04/2024 </label>
                <label> Trạng thái: Đang chờ xử lí </label>
                <div class="order-processing">
                    <button class="approve"> Duyệt đơn </button> 
                    <button class="cancel"> Hủy đơn </button> 
                </div>
                 
            </div>
        </div> -->

    </div>

</div>




<?php
include "footer.php";
?>