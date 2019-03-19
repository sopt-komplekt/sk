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
             //console.log(data);
             $("#new_yulick").removeClass("show");
             if(data == "Y"){
                 $("#success_yul_add_popup").parent().toggle();
             }else if(data.indexOf('уже существует') !== -1){
                 $("#exists_yul_add_popup").parent().toggle();
             }else{
                 $("#error_yul_add_popup").parent().toggle();
             }
            },
            error: function(data){
                $("#new_yulick").removeClass("show");
                $("#error_yul_add_popup").parent().toggle();
                //console.log(data);
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
            url: "/personal/b2b/ajax_dadata.php",
            data: {'INN': inn_val, 'dadata':"YES"},
            success: function(res) {

                res = JSON.parse(res);
                if(res.STATUS == 'success'){
                    $("#new_yulick").addClass("show");
                    $("input[name='WORK_COMPANY']").val(res.WORK_COMPANY);
                    $("input[name='WORK_CITY']").val(res.CITY);
                    $("input[name='PERSONAL_CITY']").val(res.CITY);
                    $("input[name='WORK_STREET']").val(res.STREET);
                    $("input[name='PERSONAL_STREET']").val(res.STREET);
                    $("input[name='UF_INN']").val(res.INN);
                    $("input[name='UF_KPP']").val(res.KPP);
                    $("input[name='NAME']").val(res.NAME);
                    $("input[name='LAST_NAME']").val(res.LAST_NAME);
                }else{
                    $("#inn_to_check_errors").html("Проверьте правильность введённых данных!");
                }
            },
            error: function(err){
                $("#inn_to_check_errors").html("Ошибка запроса данных! Попробуйте позже или обратитесь к нам по контактным данным");
                console.log(err);
            }
        })
    });

    $(".cross_close_popup span").on("click", function(){
        $(this).parents(".yul_add_popup_cover").toggle();
    })

});