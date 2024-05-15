<div class="header-contain">
        <div class="heading">
            <div class="header-logo">
                 <img src="images/logo/logo.png" alt=""> 
            </div>
            <div class="header-content">
                <!---------------------------top menu------------------>
                <div class="header-top-menu">
                    <ul>
                        <li><a href="../index.php">Trang chủ</a></li>
                        <li><a href="./lichsudonhang.php">Lịch sử đơn hàng</a></li>
                        <!-- <li><a href="./theodoidonhang.php">Theo dõi đơn hàng</a></li> -->
                        <?php
                        session_start(); // Bắt đầu hoặc tiếp tục session
                        if(isset($_SESSION["username"]) && $_SESSION["login"] === true){ ?>
                            <!-- Nếu người dùng đã đăng nhập -->
                          <div class="dropdown">
                            <button class="btn-dropdown">
                                <i class="fa-regular fa-user"></i>
                                <?php echo $_SESSION["username"]; ?>
                                <i class="fa-solid fa-angle-down"></i>
                            </button>
                            <div class="dropdown-content">
                                <a href="../profile.php">Thông tin cá nhân</a>
                                <a href="../logout.php">Đăng xuất</a>
                            </div>
                            </div>
                        <?php } else { ?>
                            <!-- Nếu người dùng chưa đăng nhập -->
                            <li><a href="signin.php">Đăng nhập</a></li>
                        <?php } ?>
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

            </div>


        </div>
    </div>