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


function updateMiniFavorite() {
    if ($('#js-favorite-count').length){
        $.get('/bitrix/components/ma/catalog/get-favorite-count.php', $.proxy(function(data){
            console.log(data);
            $('#js-favorite-count').text(data);
        }));
    }
}


/* Добавление в избранное */

$(function(){
    $('.js-favorite-action').on('click', function(event){
        addToFavorite(event);
    });
});

/**
 * Обработка события добавления товара в избранное
 */
function addToFavorite(event) {
    // OPTIMIZE: href меняем через пол секунды, чтобы g-data-ajax успел отработать по правильному адресу
    $elem = $(event.target);
    if ($elem.data('in-favorite')) {
    console.log("Удалить");
        if ('true' == $elem.attr('data-favorite-page')) {
            $elem.closest('.jsProductTable').remove();
            // updateMiniFavorite();
            setTimeout(updateMiniFavorite, 500);
            return;    
        }
        $elem.removeClass('active')
            .attr('title', $elem.data('add-title'))
            .text($elem.data('add-text'))
            .data('in-favorite', false);
        setTimeout("$elem.attr('href', $elem.data('add-href'))", 500);
    } else {
    console.log("Добавить");

        $elem.addClass('active')
            .attr('title', $elem.data('remove-title'))
            .text($elem.data('remove-text'))
            .data('in-favorite', true);
        setTimeout("$elem.attr('href', $elem.data('remove-href'))", 500);
    }
    // updateMiniFavorite();
    setTimeout(updateMiniFavorite, 500);

}

/**
 * Отмечаем товары, добавленные в Избранное при загрузке страницы
 */
function disableAddToFavorite(ids) {
    if (!ids instanceof Array) {
        ids = [ids];
    }
    var jqSelector = [];
    ids.forEach(function(id) {
        jqSelector.push('.b-sebi-' + id + ' .js-favorite-action');
    });
    jqSelector = jqSelector.join(', ');

    var $elemList = $(jqSelector);

    $elemList.each(function(i, elem){
        var $elem = $(elem);
        $elem.addClass('active')
            .attr('href', $elem.data('remove-href'))
            .attr('title', $elem.data('remove-title'))
            .text($elem.data('remove-text'))
            .data('in-favorite', true);
    });    

}