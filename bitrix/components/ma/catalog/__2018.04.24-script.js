function updateMiniBasket() {
    $.get('/bitrix/components/ma/sale.basket.basket/get-basket-mini.php', $.proxy(function(data){
        if($('#i-basket-mini').length){
            $('#i-basket-mini').replaceWith(data);
        }
    }));
}

function disableAddToCart(elementId, text) { 
    var element = $("#"+elementId);
    if (!element) return;
    if(!text) text = 'В корзине';
    $(element).html(text);

    //$(element).removeAttr("href").removeAttr("onclick").html("<span>в корзине</span>");
    /*if (mode == "detail")
    $(element).html(text).removeAttr("href").unbind('click').css("cursor", "default").removeClass("addtoCart").addClass("incart");
    else if (mode == "list")
        $(element).html(text).unbind('click').css("cursor", "default").removeAttr("href").removeClass("addtoCart").addClass("incart");
    else if (mode == "detail_short")
        $(element).html(text).unbind('click').css("cursor", "default").removeAttr("href");*/
}

function disableAddToCompare(elementId, text) { 
    
}


function disableAddToFavotite(id, link, text) { 
    console.log(link);

    // var element = $(".b-sebi-"+id+" .bmcl_supply-favorite a");
    // if (!element) return;
    // if(!text) text = 'В избранном';
    // console.log(element.attr('href'));
    // console.log(text);

    $(element).html(text);

    //$(element).removeAttr("href").removeAttr("onclick").html("<span>в корзине</span>");
    /*if (mode == "detail")
    $(element).html(text).removeAttr("href").unbind('click').css("cursor", "default").removeClass("addtoCart").addClass("incart");
    else if (mode == "list")
        $(element).html(text).unbind('click').css("cursor", "default").removeAttr("href").removeClass("addtoCart").addClass("incart");
    else if (mode == "detail_short")
        $(element).html(text).unbind('click').css("cursor", "default").removeAttr("href");*/


}