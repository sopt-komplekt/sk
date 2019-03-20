$(document).ready(function(){

    $(".activate_user>span").on("click", function() {
        $_this = $(this);
        $id = $(this).data("activate");
        $.ajax({
            type: "post",
            url: "/bitrix/components/kh/kh.b2b/activate.php",
            data: {'legal_entity_id': $id},
            success: function (res) {
                if(!isNaN(1*res)){
                    $_this.parents('.card').remove();
                }else console.log(res);
            },
            error: function (res) {
                console.log(res);
            }
        });
    });

});