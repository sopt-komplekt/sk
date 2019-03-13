$(document).ready(function(){
    console.log($("[data-target='#new_yulick']"));
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
    })

});