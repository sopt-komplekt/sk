$(document).ready(function(){
    $(document).on("click", "#new_yulick_form .new_yulick_button", function(e){
        e.preventDefault();
        var form = new FormData($("#new_yulick_form")[0]);
        $.ajax({
           type: "post",
           contentType: false,
           processData: false,
            url: "/personal/b2b/ajax.php",
            data: form,
            success: function(data) {
                $("#container_kh_b2b").html(data);
            }
        })
    })

});