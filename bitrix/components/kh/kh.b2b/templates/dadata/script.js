$(document).ready(function(){


   $(document).on("submit", "#new_yulick_form", function(e){
        e.preventDefault();
        var form = new FormData($("#new_yulick_form")[0]);
        $.ajax({
            type: "post",
           contentType: false,
           processData: false,
            url: "/personal/b2b/ajax.php",
            data: form,
            success: function(data) {
             console.log(data);
                $("#container_kh_b2b").replaceWith(data);
                $("[data-target='#new_yulick']").trigger("click");
            },
            error: function(data){
                console.log(data);
            }
        })
    });

    //Проверяем ИНН юр.лица
    $('#inn_to_check>span').on("click", function(){
        $("#inn_to_check_errors").html('');
        var inn = $('input#INN_TO_CHECK');
        inn.removeClass('border-red');
        var inn_val = inn.val();

        //Check INN for validity
        if(!inn_val){
           inn.addClass('border-red');
           $("#inn_to_check_errors").html("Введите ИНН");
           return false;
        }else if(inn_val.length != 10){//Проверяем длину ИНН
            inn.addClass('border-red');
            $("#inn_to_check_errors").html("Не верная длина ИНН");
            return false;
        }

        for(var i in inn_val){
            if(isNaN(1*inn_val[i])){
                inn.addClass('border-red');
                $("#inn_to_check_errors").html("ИНН может содержать только цифры");
                return false;
            }
        }
        //Check INN for validity

        //Send request to find information in dadata
        $.ajax({
            type: "post",
            //dataType: 'application/json',
            url: "/personal/b2b/ajax_dadata.php",
            data: {'INN': inn_val, 'dadata':"YES"},
            success: function(res) {
                console.log(res);
            },
            error: function(err){
                console.log(err);
            }
        })
    });

});