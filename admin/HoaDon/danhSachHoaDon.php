<div class="danhsach-container">
    <div class="title">
        <h1>Danh sách hóa đơn</h1>
    </div>
    <div class="date-picker">
        <form action="" id="search-form">
            <label for="start-date">Từ ngày:</label>
            <input type="date" id="start-date" name="start-date">
            <label for="end-date">Đến ngày:</label>
            <input type="date" id="end-date" name="end-date">
            <input type="submit" value="Tìm kiếm" style="margin-bottom: 5px">
        </form>
    </div>
    <div class="table-container">
        <table class="data-table">
            <tr>
                <!-- <td></td> -->
                <td>Mã HĐ</td>
                <td>Ngày xuất</td>
                <td>Khách Hàng</td>
                <td>Thành tiền</td>
                <td>Trạng thái</td>
                <td></td>
            </tr>
            <tbody class="filter">

            </tbody>
        </table>
        <script>
            var defaultEndDate = new Date().toISOString().split('T')[0];
            $(document).ready(function () {
                $.ajax({
                    url: 'HoaDon/locHoaDon.php',
                    type: 'POST',

                    success: function (response) {
                        $('.filter').html(response);

                        $('.status-select').on('change', function () {
                            var hoadonId = $(this).data('hoadon-id');
                            var status = $(this).val();
                            $.ajax({
                                url: 'HoaDon/updateTrangthai.php',
                                type: 'POST',
                                data: {
                                    hoadonId: hoadonId,
                                    status: status
                                },
                                success: function (response) {
                                    // Handle the response from the server
                                    console.log(response);
                                },
                            });
                        });
                    }
                });

                $('#search-form').submit(function (e) {
                    e.preventDefault();
                    var startDate = $('#start-date').val() || '2000-01-01';
                    var endDate = $('#end-date').val() || defaultEndDate;
                    $.ajax({
                        url: 'HoaDon/locHoaDon.php',
                        type: 'POST',
                        data: {
                            startDate: startDate,
                            endDate: endDate
                        },

                        success: function (response) {
                            $('.filter').html(response);

                            $('.status-select').on('change', function () {
                                var hoadonId = $(this).data('hoadon-id');
                                var status = $(this).val();
                                $.ajax({
                                    url: 'HoaDon/updateTrangthai.php',
                                    type: 'POST',
                                    data: {
                                        hoadonId: hoadonId,
                                        status: status
                                    },

                                    success: function (response) {
                                        // Handle the response from the server
                                        console.log(response);
                                    },
                                });
                            });
                        }
                    });
                });
            });
        </script>
    </div>
</div>