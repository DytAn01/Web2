<script src="https://kit.fontawesome.com/367278d2a4.js" crossorigin="anonymous"></script>
<div class="header-contain">
        <div class="heading">
            <div class="header-logo">
                <a href="index.php"><img src="./images/logo/logo.png" alt=""></a>
            </div>
            <div class="header-content">
                <!---------------------------top menu------------------>
                <div class="header-top-menu">
                    <ul>
                        <li><a href="index.php">Trang chủ</a></li>
                        <li><a href="#"> Lịch sử đơn hàng </a></li>
                        <li><a href="#"> Theo dõi đơn hàng </a></li>
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
                                <a href="profile.php">Thông tin cá nhân</a>
                                <a href="logout.php">Đăng xuất</a>
                            </div>
                            </div>
                        <?php } else { ?>
                            <!-- Nếu người dùng chưa đăng nhập -->
                            <li><a href="signin.php">Đăng nhập</a></li>
                        <?php } ?>
                        <i class="fa-solid fa-cart-shopping"> </i>
                    </ul>
                </div>
                <div class="search-bar">
                    <input type="search" id="search-box" n value="" placeholder="Nhập từ khóa" autocomplete="off">
                    <button class="search-button" type="submit" onclick="hehehe()">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>    
            </div>


        </div>
    </div>