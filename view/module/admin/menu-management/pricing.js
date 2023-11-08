function setprice(foodid) {
    $(document).ready(function () {
        $('#setpriceModal').modal('show');
        var food_itemId = foodid;

        $.ajax({
            type: 'POST',
            url: '../../../../controller/menu_controller.php?status=get-foodItem',
            data: { data: food_itemId },
            success: function (response) {
                var foodname = response.item_name;
                var foodid = response.food_Id;
                var price = response.price;
                console.log(response);
                $('#exampleModalLabel').text('Set price for ' + foodname);
                $('#food_id').val(foodid);
                $('#price').val(price);
            },
        });
    });
}