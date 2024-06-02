;(function($){
    $('#update_balanced').on('click',function(){
        let balaced_input = $('.user_balance').val();
        $.ajax({
            url: localize_data.url,
            method: "POST",
            data: {
                action : 'balance_ajax',
                balanced_val : balaced_input,
            },
            success: function (balance) {
                $('.display_balance').html(balance)
            }
        });
    })
})(jQuery)