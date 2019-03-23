$(document).ready(function(){

    $(".activate_user>span").on("click", function() {
        $("#soglashenie_error_div").html('');
        $_this = $(this);
        $id = $(this).data("activate");
        $inn = $_this.data("inn");
        $soglashenie = $('[name="soglashenie_'+$inn+'"]:checked').val();
        if(!$soglashenie){
            $("#soglashenie_error_div").html('Необходимо выбрать тип соглашения!');
        }else{
            $.ajax({
                type: "post",
                url: "/bitrix/components/kh/kh.b2b/activate.php",
                data: {'legal_entity_id': $id, 'soglashenie': $soglashenie},
                success: function (res) {
                    if(!isNaN(1*res)){
                        $_this.parents('.card').remove();
                    }else console.log(res);
                },
                error: function (res) {
                    console.log(res);
                }
            });
        }

    });

});