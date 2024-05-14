<div class="content">
    <h1>Thêm mới chất liệu sản phẩm</h1>
    <div class="row">
        <form action="index.php?act=addChatLieuSp" method="post">
            <div class="row">
                Tên chất liệu: <input type="text" name="ten" required="true">
            </div>
            <div class="">
                <input type="submit" name="themmoi" value="Thêm mới">
                <a href="index.php?act=danhSachChatLieu"><input type="button" value="Danh sách"></a>
            </div>
            <?php if (isset($thongbao) && ($thongbao != ''))
                echo $thongbao; ?>
        </form>
    </div>

</div>
</div>