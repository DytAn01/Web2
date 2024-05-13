<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://kit.fontawesome.com/367278d2a4.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<script>
    //--------slider------------
    $(function() {
        $('.slide-show img:gt(0)').hide();
        setInterval(function() {
            $('.slide-show :first-child').fadeOut().next('img').fadeIn().end().appendTo('.slide-show');
        }, 3000);
    });
</script>



<body>
    <?php
    include "dbconnect.php";
    ?>
    <div class="header-contain">
        <div class="heading">
            <div class="header-logo">
                <!-- <img src="images/logo.png" alt=""> -->
            </div>
            <div class="header-content">
                <!---------------------------top menu------------------>
                <div class="header-top-menu">
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Lịch sử đơn hàng</a></li>
                        <li><a href="#">Theo dõi đơn hàng</a></li>
                        <?php
                        session_start(); // Bắt đầu hoặc tiếp tục session
                        if(isset($_SESSION["login"]) && $_SESSION["login"] === true): ?>
                            <!-- Nếu người dùng đã đăng nhập -->
                            <div class="accountlogged">
                                Xin chào, <?php echo $_SESSION["username"]; ?> <!-- Hiển thị tên người dùng -->
                            </div>
                        <?php else: ?>
                            <!-- Nếu người dùng chưa đăng nhập -->
                            <li><a href="signup.php">Đăng ký</a></li>
                            <li><a href="signin.php">Đăng nhập</a></li>
                        <?php endif; ?>
                        <i class="fa-solid fa-cart-shopping" onclick="xemGioHang()"></i>
                        <div class="cart-display">
                            <div>
                                <h2>Giỏ hàng của tôi</h2>
                                <div class="close-cart">
                                    <i class="fa-solid fa-circle-xmark" style="font-size: 1.6rem;" onclick="dongGioHang()"></i>
                                </div>
                            </div>
                            <div class="list-product-in-cart"></div>
                            <div class="pay-button" id="pay-button" onclick="thanhToanGioHang()">
                                <button>Thanh toán giỏ hàng</button>
                            </div>
                        </div>
                    </ul>
                </div>


                <div class="search-bar">
                    <input type="search" id="search-box" n value="" placeholder="Nhập từ khóa" autocomplete="off">
                    <button class="search-button" type="submit" onclick="hehehe()">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <button class="filter-search-button" onclick="hienThiKhungBoLoc()">
                        Bộ lọc
                    </button>
                    <div class="filter-search-container">
                        <div class="filter-search">
                            <div>
                                <label>Tìm kiếm cùng bộ lọc </label>
                            </div>
                            <div>
                                <button> Giá từ </button>
                                <select id="price-filter-select">
                                    <option value=""> Chọn khoảng giá </option>
                                    <option value="under-1m"> Dưới 1.000.000₫ </option>
                                    <option value="1m-to-2m"> Từ 1.000.000₫ đến 2.000.000₫ </option>
                                    <option value="2m-to-3m"> Từ 2.000.000₫ đến 3.000.000₫ </option>
                                    <option value="3m-to-4m"> Từ 3.000.000₫ đến 4.000.000₫ </option>
                                    <option value="2m-to-4m"> Từ 2.000.000₫ đến 4.000.000₫ </option>
                                    <option value="over-4m"> Trên 4.000.000₫ </option>
                                </select>

                            </div>
                            <div>
                                <button> Kiểu dáng </button> <br>
                                <?php
                                if ($conn) {
                                    $sql = "SELECT * FROM kieudang";
                                    $query = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($query)) {
                                        echo '<input type="checkbox" class="shape-filter" value="' . $row['ma'] . '">' . $row['ten'];
                                    }
                                }
                                ?>
                            </div>
                            <div>
                                <button> Chất liệu </button> <br>
                                <?php
                                if ($conn) {
                                    $sql = "SELECT * FROM chatlieusp";
                                    $query = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($query)) {
                                        echo '<input type="checkbox" class="material-filter" value="' . $row['ma'] . '">' . $row['ten'];
                                    }
                                }
                                ?>
                            </div>
                            <div>
                                <button> Giới tính </button> <br>
                                <?php
                                if ($conn) {
                                    $sql = "SELECT * FROM doituongsd";
                                    $query = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($query)) {
                                        echo '<input type="checkbox" class="sex-filter" value="' . $row['ma'] . '">' . $row['ten'];
                                    }
                                }
                                ?>
                            </div>
                            <div>
                                <button onclick="tatKhungBoLoc()"> Đóng </button>
                            </div>
                        </div>
                    </div>



                </div>
                <script>
                    // Tìm kiếm sản phẩm -----------------------------------------------------------------
                    function timKiemSanPham() {
                        var input = document.getElementById('search-box');
                        var inputValue = input.value.toLowerCase();
                        console.log(inputValue);
                        loadData('', inputValue);

                    }

                    function hienThiKhungBoLoc() {
                        document.querySelector(".filter-search-container").style.display = 'flex';
                    }

                    function tatKhungBoLoc() {
                        document.querySelector(".filter-search-container").style.display = 'none';
                    }


                    function hehehe() {
                        tatKhungBoLoc();
                        var input = document.getElementById('search-box');
                        var inputValue = input.value.toLowerCase();
                        console.log(inputValue);
                        var kieudang = [];
                        var chatlieu = [];
                        var dtsd = [];
                        var lockieudang = document.querySelectorAll('input[type="checkbox"].shape-filter');
                        lockieudang.forEach(function(checkbox) {
                            if (checkbox.checked) {
                                kieudang.push(checkbox.value);
                            }
                        });
                        console.log(kieudang);

                        var locchatlieu = document.querySelectorAll('input[type="checkbox"].material-filter');
                        locchatlieu.forEach(function(checkbox) {
                            if (checkbox.checked) {
                                chatlieu.push(checkbox.value);
                            }
                        });
                        console.log(chatlieu);

                        var locgioitinh = document.querySelectorAll('input[type="checkbox"].sex-filter');
                        locgioitinh.forEach(function(checkbox) {
                            if (checkbox.checked) {
                                dtsd.push(checkbox.value);
                            }
                        });
                        console.log(dtsd);

                        var from_price;
                        var to_price;
                        var priceSelectValue = document.getElementById("price-filter-select").value;
                        if (priceSelectValue !== "") {
                            if (priceSelectValue === "under-1m") {
                                from_price = 0;
                                to_price = 1000000;
                            } else if (priceSelectValue === "1m-to-2m") {
                                from_price = 1000000;
                                to_price = 2000000;
                            } else if (priceSelectValue === "2m-to-3m") {
                                from_price = 2000000;
                                to_price = 3000000;
                            } else if (priceSelectValue === "3m-to-4m") {
                                from_price = 3000000;
                                to_price = 4000000;
                            } else if (priceSelectValue === "2m-to-4m") {
                                from_price = 2000000;
                                to_price = 4000000;
                            } else if (priceSelectValue === "over-4m") {
                                from_price = 4000000;
                                to_price = 1000000000;
                            }

                        } else {
                            from_price = 0;
                            to_price = 1000000000000;
                        }

                        timKiemNangCao('', inputValue, kieudang, chatlieu, dtsd, from_price, to_price);
                    }

                    function timKiemNangCao($sortby, $name, $shape, $material, $sex, $from_price, $to_price) {
                        // Đổi mảng checkbox sang mảng số nguyên
                        var shape = $shape.map(function(ele) {
                            return parseInt(ele);
                        });
                        var material = $material.map(function(ele) {
                            return parseInt(ele);
                        });
                        var sex = $sex.map(function(ele) {
                            return parseInt(ele);
                        });
                        $.ajax({
                            url: 'listtimkiem.php',
                            type: 'GET',
                            data: {
                                type: $sortby,
                                name: $name,
                                shape: $shape,
                                material: $material,
                                sex: $sex,
                                from_price: $from_price,
                                to_price: $to_price
                            },
                            success: function(data) {
                                var newData = [];
                                var newData2 = [];
                                var newData3 = [];
                                var newData4 = [];

                                if (shape.length > 0) {
                                    for (var i = 0; i < data.length; i++)
                                        for (var j = 0; j < shape.length; j++)
                                            if (parseInt(data[i].makieudang) === shape[j])
                                                newData.push(data[i]);
                                } else {
                                    for (var i = 0; i < data.length; i++)
                                        newData.push(data[i]);
                                }

                                if (material.length > 0) {
                                    for (var i = 0; i < newData.length; i++)
                                        for (var j = 0; j < material.length; j++)
                                            if (parseInt(newData[i].machatlieu) === material[j])
                                                newData2.push(newData[i]);
                                } else {
                                    for (var i = 0; i < newData.length; i++)
                                        newData2.push(newData[i]);
                                }

                                if (sex.length > 0) {
                                    for (var i = 0; i < newData2.length; i++)
                                        for (var j = 0; j < sex.length; j++)
                                            if (parseInt(newData2[i].madoituongsd) === sex[j])
                                                newData3.push(newData2[i]);
                                } else {
                                    for (var i = 0; i < newData2.length; i++)
                                        newData3.push(newData2[i]);
                                }

                                for (var i = 0; i < newData3.length; i++) {
                                    if (parseInt(newData3[i].dongia) >= parseInt($from_price) && (parseInt(newData3[i].dongia) <= parseInt($to_price))) {
                                        newData4.push(newData3[i]);
                                    }
                                }
                                console.log(newData4);
                                divListProduct = document.getElementById('list-product');
                                if (newData4.length === 0) {
                                    divListProduct.innerHTML = "";
                                    divListProduct.innerHTML = `
                            <div class="not-found">
                                <h3> Không tìm thấy sản phẩm</h3>
                            </div>    
                            `;
                                } else {
                                    hienThiTrangSanPham(1, newData4, 16);
                                    doiMauNutPhanTrang(1);
                                }
                            }
                        })
                    }
                </script>


            </div>


        </div>
    </div>
    <!-- -------------------------slideshow-------------------------------- -->
    <section>
        <div class="slider">
            <div class="slide-show">
                <?php
                $dir = "images/slider/";
                $scan_dir = scandir($dir);
                foreach ($scan_dir as $img) :
                    if (in_array($img, array('.', '..')))
                        continue;
                ?>
                    <img src="<?php echo $dir . $img ?>" alt="<?php echo $img ?>">
                <?php endforeach; ?>
            </div>
        </div>
    </section>



    <section>
        <div class="sort-product-menu-bar">
            <div class="sort-product">
                <span> Xem sản phẩm theo </span>
                <button class="sort-product-checkbox" id="lowtohigh" onclick="loadData('sanPhamTheoGiaTang', document.getElementById('search-box').value.toLowerCase())"> Giá tăng dần </button>
                <button class="sort-product-checkbox" id="hightolow" onclick="loadData('sanPhamTheoGiaGiam', document.getElementById('search-box').value.toLowerCase())"> Giá giảm dần </button>
                <button class="sort-product-checkbox" id="normal" onclick="loadData('',document.getElementById('search-box').value.toLowerCase())"> Ban đầu </button>
            </div>
        </div>

    </section>


    <section>
        <div id="show-product-container">
            <div class="show-product">
                <div id="list-product">

                </div>
            </div>
            <div id="product-detail">
                <!-- <div class="close-product-detail">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-content-left">
                        <img src="http://localhost:100/web2/DoAnWeb2/images/product/AF2012N-4S_11zon.png" alt="">
                        <button class="add-to-cart" id=""> Thêm vào giỏ hàng </button>
                    </div>
                    <div class="detail-content-right">
                        <div style="font-size: 27px;"> Chi tiết sản phẩm </div>
                        Sản phẩm: AIR FIT AF2012N-4S <br>
                        Kiểu dáng: Vuông/Chữ nhật<br>
                        Chất liệu: Nhựa dẻo<br>
                        Dành cho: Men <br>
                        <div style="font-size: 35px; color:#353535;"> 2.500.000đ </div>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="pagination-bar">

        </div>
        <script>
            $(document).ready(function() {
                loadData('', ''); // trang đầu ko cần sort sản phẩm
                // loadData('sanPhamTheoGiaTang');   
                // loadData('sanPhamTheoGiaGiam');  

            });

            function loadData($sortby, $name) {
                $.ajax({
                    url: 'listtimkiem.php',
                    type: 'GET',
                    data: {
                        type: $sortby,
                        name: $name
                    },
                    success: function(data) {
                        divListProduct = document.getElementById('list-product');
                        if (data.length === 0) {
                            divListProduct.innerHTML = "";
                            divListProduct.innerHTML = `
                            <div class="not-found">
                                <h3> Không tìm thấy sản phẩm</h3>
                            </div>    
                            `;
                        } else {
                            hienThiTrangSanPham(1, data, 16);
                            doiMauNutPhanTrang(1);
                        }

                    }
                });
            }


            // Hiển thị 1 trang sản phẩm------------------------------------------------------------
            function hienThiTrangSanPham(viTri, list, soSanPham1Trang) {
                $("#list-product div.product-item-container").remove();
                var soTrang = Math.ceil(list.length / soSanPham1Trang);
                var start = (viTri - 1) * soSanPham1Trang;
                var divListProduct = document.getElementById('list-product');
                divListProduct.innerHTML = "";

                if (soTrang > 1) {
                    if (viTri === soTrang) {
                        var soSpConThieu = list.length % soSanPham1Trang;
                        // số sp còn thiếu để lấp đầy trang 
                        end = start + (soSanPham1Trang - soSpConThieu);
                        for (var i = start; i < end; i++) {
                            taoDivSanPham(list[i], divListProduct);
                        }
                        for (var i = 0; i < soSpConThieu; i++) {
                            taoDivSanPhamAo(divListProduct);
                            // tạo div sản phẩm ảo để lấp đầy trang
                        }
                    } else {
                        var end = start + soSanPham1Trang;
                        for (var i = start; i < end; i++) {
                            taoDivSanPham(list[i], divListProduct);
                        }
                    }
                } else { // length < số sản phẩm 1 trang 
                    var end = list.length;
                    for (var i = start; i < end; i++) {
                        taoDivSanPham(list[i], divListProduct);
                    }
                    if (end < soSanPham1Trang) {
                        for (var i = 0; i < soSanPham1Trang - end; i++) {
                            taoDivSanPhamAo(divListProduct);
                        }
                    }
                }



                themThanhPhanTrang(viTri, list, soSanPham1Trang);
                onclickPhanTrang(list, soSanPham1Trang);
                document.getElementById("show-product-container").scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }

            function themThanhPhanTrang(viTri, list, soSanPham1Trang) {
                var soTrang = Math.ceil(list.length / soSanPham1Trang);
                var divPhanTrang = document.getElementsByClassName('pagination-bar')[0];
                divPhanTrang.innerHTML = "";
                if (soTrang > 1) {
                    for (var i = 1; i <= soTrang; i++) {
                        divPhanTrang.innerHTML += `<button class="page-item" id="page` + i + `">` + i + `</button>`;
                    }
                }
            }
            // Phân trang-----------------------------------------------------------------------
            function onclickPhanTrang(list, soSanPham1Trang) {
                var page_item = document.getElementsByClassName('page-item');
                for (var i = 0; i < page_item.length; i++) {
                    (function(page_num) {
                        page_item[i].onclick = function() {
                            console.log(page_num);
                            hienThiTrangSanPham(page_num, list, soSanPham1Trang);
                            doiMauNutPhanTrang(page_num);
                        };
                    })(parseInt(page_item[i].id.substr(page_item[i].id.length - 1)));
                }
            }

            function formatPrice(dongia) {
                var dongia = dongia.toString();
                var ketqua = '';
                for (var i = dongia.length - 1; i >= 0; i--) {
                    ketqua = dongia[i] + ketqua;
                    if ((dongia.length - i) % 3 === 0 && i != 0) {
                        ketqua = '.' + ketqua;
                    }
                }
                return ketqua + '₫';
            }

            function taoDivSanPham(p, divListProduct) {
                tenSP = JSON.stringify(p.tenSP);
                img = JSON.stringify(p.img_src);
                img = img.replace(/"/g, '');
                dongia = parseInt(p.dongia);
                maSP = parseInt(p.maSP);
                var newDiv = `
<div class="product-item-container"> 
    <div class="product-item"> 
        <img src="images/product/` + img + `_11zon.png">
        <div class="product-item-info">
            <div class="product-item-name">` + p.tenSP + ` </div>
            <div class="product-item-price">` + formatPrice(dongia) + `</div>
            <div class="product-detail-button">
                <button id="` + maSP + `" onclick = "chiTietSanPham(` + maSP + `)"> Xem chi tiết </button>
            </div>
        </div>  
    </div> 
</div>     `
                divListProduct.innerHTML += newDiv;
            }

            function taoDivSanPhamAo(divListProduct) {
                var newDiv = `
    <div class="empty-product-item"> 
    </div>`
                divListProduct.innerHTML += newDiv;
                // sản phẩm ảo để lấp đầy trang
            }
            // Đổi màu nút phân trang khi click-----------------------------------------
            function doiMauNutPhanTrang(page_num) {
                var pagi_buttons = document.getElementsByClassName('page-item');
                for (var i = 0; i < pagi_buttons.length; i++) {
                    var btn = pagi_buttons[i];
                    if (btn.id === 'page' + page_num) {
                        btn.style.color = '#e0e0e0';
                        btn.style.backgroundColor = '#494949';
                    } else {
                        btn.style.color = '#494949';
                        btn.style.backgroundColor = '#e0e0e0';
                    }
                }
            }
            // Hiển thị chi tiết sản phẩm ---------------------------------------------------------
            function chiTietSanPham(id) {
                $.ajax({
                    url: 'chitietsanpham.php',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(chiTietSanPham) {
                        // console.log(chiTietSanPham);
                        taoDivChiTiet(chiTietSanPham);
                        document.getElementById('product-detail').style.display = 'flex';
                        dongGioHang();
                    }
                });
            }

            function taoDivChiTiet(ctsp) {
                var divChiTiet = document.getElementById('product-detail');
                divChiTiet.innerHTML = "";
                divChiTiet.innerHTML += `
                <button class="close-product-detail" onclick="dongChiTiet()">
                    <i class="fa-solid fa-circle-xmark " ></i>
                </button> 
                <div class="detail-content">
                    <div class="detail-content-left">
                    <img src="images/product/` + ctsp.img + `_11zon.png">
                        <button class="add-to-cart" id="` + ctsp.maSP + `" onclick="themVaoGioHang(` + ctsp.maSP + `,` + ctsp.soLuong + `)"> Thêm vào giỏ hàng </button>
                    </div>
                    <div class="detail-content-right">
                        <div style="font-size: 27px;"> Chi tiết sản phẩm </div>
                        Sản phẩm: ` + ctsp.tenSP + ` <br>
                        Kiểu dáng: ` + ctsp.kieuDang + `<br>
                        Chất liệu: ` + ctsp.chatLieu + `<br>
                        Dành cho: ` + ctsp.doiTuongSD + ` <br>
                        <div style="font-size: 35px; color:#353535;"> ` + formatPrice(ctsp.donGia) + `</div>
                    </div>
                </div>`
            }

            function dongChiTiet() {
                document.getElementById('product-detail').style.display = 'none';
            }

            //Thêm vào giỏ hàng-----------------------------------------------------------

            var listProductIncart = [];

            function themVaoGioHang(id, soluongkho) {
                var existProduct = listProductIncart.find(p => p.id === id);
                if (existProduct) {

                    if ((existProduct.count + 1) > soluongkho) {
                        alert('Số lượng kho không đủ !');
                    } else {
                        existProduct.count++;
                    }

                } else {
                    listProductIncart.push({
                        id: id,
                        count: 1
                    });
                }
                console.log(listProductIncart);
                capNhatGioHang('', '');
            }

            function capNhatGioHang($sortby, $name) {
                $.ajax({
                    url: 'listtimkiem.php',
                    type: 'GET',
                    data: {
                        type: $sortby,
                        name: $name
                    },
                    success: function(data) {
                        var divListProductInCart = document.querySelector('.list-product-in-cart');
                        divListProductInCart.innerHTML = '';
                        // console.log(data);
                        for (var i = 0; i < listProductIncart.length; i++) {
                            var prd = data.find(p => parseInt(p.maSP) === listProductIncart[i].id);
                            if (prd) {
                                // console.log(prd);
                                var itemInCart = document.createElement('div');
                                itemInCart.classList.add('item-in-cart-container');
                                itemInCart.innerHTML = ''
                                itemInCart.innerHTML = `
                                <div class="item-in-cart">
                                    <div class="delete-product">
                                        <i class="fa-solid fa-trash-can" onclick="clickXoaSanPhamGioHang(` + listProductIncart[i].id + `)"></i>
                                    </div>
                                    <div> <img src="images/product/` + prd.img_src + `_11zon.png" alt=""></div>
                                    <div class="item-in-cart-info">
                                        <div class="item-in-cart-name">` + prd.tenSP + `</div>
                                        <div>
                                            <div class="item-quantity-bar">
                                                <button class="decrease" onclick="giamSanPhamGioHang(` + listProductIncart[i].id + `)"> <i class="fa-solid fa-minus"></i> </button>
                                                <div class="selected-product-num">` + listProductIncart[i].count + `</div>
                                                <button class="increase" onclick="tangSanPhamGioHang(` + listProductIncart[i].id + `,` + prd.soluong + `)"> <i class="fa-solid fa-plus"></i> </button>
                                            </div>
                                            <div class="item-in-cart-price">` + formatPrice(prd.dongia) + `</div>
                                        </div>
                                    </div>
                                    <div class="select-item-in-cart">
                                        <input type="checkbox" class="select-to-pay" id="pay` + i + `">
                                    </div> 
                                </div> 
                                `
                                divListProductInCart.appendChild(itemInCart);
                            }
                        }


                    }
                });
            }

            function xemGioHang() {
                document.querySelector('.cart-display').style.display = 'flex';
                dongChiTiet();

            }

            function dongGioHang() {
                document.querySelector('.cart-display').style.display = 'none';
            }

            function tangSanPhamGioHang(maSP, soluongkho) {
                var divSoLuong = document.querySelector('.selected-product-num');
                for (var i = 0; i < listProductIncart.length; i++) {
                    if (listProductIncart[i].id === maSP) {
                        if ((listProductIncart[i].count + 1) > soluongkho) {
                            alert('Số lượng kho không đủ !');
                        } else {
                            listProductIncart[i].count += 1;
                            divSoLuong.innerHTML = '';
                            divSoLuong.innerHTML += listProductIncart[i].count;
                        }
                    }
                }
                capNhatGioHang('', '');
                console.log(listProductIncart);
            }

            function giamSanPhamGioHang(maSP) {
                console.log(listProductIncart);
                var divSoLuong = document.querySelector('.selected-product-num');
                for (var i = 0; i < listProductIncart.length; i++) {
                    if (listProductIncart[i].id === maSP) {
                        listProductIncart[i].count -= 1;
                        if (listProductIncart[i].count < 1) {
                            giamSanPhamGioHangVe0(listProductIncart[i].id);
                        } else {
                            divSoLuong.innerHTML = '';
                            divSoLuong.innerHTML += listProductIncart[i].count;
                        }
                    }
                }
                capNhatGioHang('', '');
                console.log(listProductIncart);
            }

            function giamSanPhamGioHangVe0(maSP) {
                var choice = confirm("Bạn có chắn chắn muốn xóa sản phẩm này?")
                if (choice == true) {
                    for (var i = 0; i < listProductIncart.length; i++) {
                        if (listProductIncart[i].id === maSP) {
                            listProductIncart.splice(i, 1)
                        }
                    }
                } else {
                    for (var i = 0; i < listProductIncart.length; i++) {
                        if (listProductIncart[i].id === maSP) {
                            listProductIncart[i].count = 1;
                        }
                    }
                }
            }

            function clickXoaSanPhamGioHang(maSP) { // click thùng rác 
                var choice = confirm("Bạn có chắn chắn muốn xóa sản phẩm này?")
                if (choice == true) {
                    for (var i = 0; i < listProductIncart.length; i++) {
                        if (listProductIncart[i].id === maSP) {
                            listProductIncart.splice(i, 1)
                        }
                    }
                }
                capNhatGioHang('', '');
                console.log(listProductIncart);
            }

            function thanhToanGioHang() {
                var selectedIndex = []; // mảng chứa index đã được chọn trong list product in cart
                var selectedProduct = []; // mảng chứa id, count sản phẩm đã bấm thanh toán
                var selectedProductInCart = document.querySelectorAll('input[type="checkbox"].select-to-pay:checked');
                selectedProductInCart.forEach(function(checkbox) {
                    selectedIndex.push(parseInt((checkbox.id).substring(3)));
                });
                console.log('list index đã chọn ra từ mảng sp trong giỏ: ');
                selectedIndex.sort((a, b) => b - a);
                console.log(selectedIndex);
                selectedIndex.forEach(i => {
                    selectedProduct.push(listProductIncart[i]);
                    listProductIncart.splice(i, 1);
                });
                capNhatGioHang('', '');
                console.log('list sản phẩm trong giỏ hiện tại: ');
                console.log(listProductIncart);
                console.log('list id sản phẩm đã bấm thanh toán: ');
                console.log(selectedProduct);

                // Xử lí bấm nút thanh toán ------------------------------------------
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "xulibamthanhtoan.php", true);
                xhr.setRequestHeader("Content-Type", "application/json");
                var data = JSON.stringify({
                    selectedProduct: selectedProduct
                });
                xhr.send(data);
            }
        </script>

    </section>

    <footer class="footer">
        <div class="footer-box1">
            <ul class="footer-item">
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>
            </ul>
            <ul class="footer-item">
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>sss
                <li> Lorem ipsum dolor sit amet </li>
            </ul>
            <ul class="footer-item">
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>
            </ul>
            <ul class="footer-item">
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>
                <li> Lorem ipsum dolor sit amet </li>
            </ul>
        </div>
        <div class="footer-box2">
            <div class="footer-logo"> LOGO </div>
            <div class="contact-icon"> icon </div>
        </div>

    </footer>


</body>

</html>