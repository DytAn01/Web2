<!-- <div class="section" id="sales_statistic_section">
    <h2>Thống kê tình hình kinh doanh</h2>
    <form id="sales_statistic_form">
        <label for="start_date_sales">Từ ngày:</label>
        <input type="date" id="start_date_sales" name="start_date_sales">
        <label for="end_date_sales">Đến ngày:</label>
        <input type="date" id="end_date_sales" name="end_date_sales">
        <input type="button" value="Thống kê" onclick="getSalesStatistic()">
    </form>
    <div id="sales_statistic_result"></div>
</div> -->

<div class="section" id="best_selling_section">
    <h2>Thống kê sản phẩm bán chạy</h2>
    <form id="best_selling_form" onsubmit="event.preventDefault(); getBestSellingProducts()">
        <label for="start_date_products">Từ ngày:</label>
        <input type="date" id="start_date_products" name="start_date_products">
        <label for="end_date_products">Đến ngày:</label>
        <input type="date" id="end_date_products" name="end_date_products">
        <input type="submit" value="Thống kê">
    </form>
    <div id="spbanchay"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // function getSalesStatistic() {
    //     var start_date = $("#start_date_sales").val();
    //     var end_date = $("#end_date_sales").val();

    //     $.post("sales_statistic.php", { start_date: start_date, end_date: end_date }, function (data) {
    //         $("#sales_statistic_result").html(data);
    //     });
    // }

    function getBestSellingProducts() {
        var start_date = $('#start_date_products').val() || '2000-01-01';
        var end_date = $('#end_date_products').val() || new Date().toISOString().split('T')[0];

        $.post("ThongKe/spbanchay.php", {
            start_date: start_date,
            end_date: end_date
        }, function (data) {
            $("#spbanchay").html(data);
        });
    }
</script>

<style>
    .section {
        margin: 30px;
    }

    #sales_statistic_section,
    #best_selling_section {
        margin-top: 20px;
    }

    #sales_statistic_form,
    #best_selling_form {
        margin-bottom: 20px;
    }

    #sales_statistic_result ul {
        list-style-type: none;
    }

    #sales_statistic_result ul li {
        margin-bottom: 10px;
    }
</style>