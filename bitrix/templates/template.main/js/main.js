'use strict';

var app = {};
app.init = function() {
    app.addClassToStandartButton(); // Добавляем класс 'g-button' к стандартной кнопке оплаты через Яндекс.кассу
    app.initHeader();
    app.initHeaderNavigation();
    app.initCatalogSectionsSlider();
    app.initBrandsSlider();
    app.initCatalogFilter();
    app.showHeaderSearch();
};

app.addClassToStandartButton = function() { 
    try {
        $('.bx_order_make input[type="submit"]').addClass('g-button');
    } catch (e) {
        console.log(e);
    }
};

app.initHeader = function() {
    var page = $(".jsPage");
    var header = $(".jsHeader");
    var headerHeight = header.outerHeight();

    fixHeader = function() {

        var windowTop = $(window).scrollTop();
        
        if (windowTop >= headerHeight) {
            page.css("paddingTop", headerHeight+"px");
            header.addClass("b-header--fixed");

            if (windowTop >= headerHeight + 200) {
                header.addClass("b-header--translated");
                header.removeClass("b-header--showed");

                if (windowTop >= headerHeight + 300) {
                    header.addClass("b-header--showed");
                }
            }
        }
        else {
            page.removeAttr("style");
            header.removeClass("b-header--fixed");
            header.removeClass("b-header--showed");
            header.removeClass("b-header--translated");
        }

    };

    fixHeader();

    $(document).scroll(function() {
        fixHeader();
    });

};

app.initHeaderNavigation = function() { 
    var header = $(".jsHeader"),
    	headerNavBtn = $(".jsHeaderNavButton");

    headerNavBtn.on("click", function(e) {
    	e.preventDefault();

    	header.toggleClass("open-menu");
    })

};

app.initCatalogSectionsSlider = function() {
	var slider = $(".jsCatalogSectionSlider");

	slider.owlCarousel({
		items: 3,
		// loop: true,
		nav: true,
		navText: ["Назад", "Вперед"],
		dots: false,
		smartSpeed: 500
	});
};

app.initBrandsSlider = function() {
	var slider = $(".jsBrandsSlider");

	slider.owlCarousel({
		items: 5,
		margin: 15,
		loop: true,
		// autoWidth: true,
		nav: true,
		navText: ["Назад", "Вперед"],
		dots: false,
		smartSpeed: 500
	});
};

app.initCatalogFilter = function() {
    var filter = $(".jsFilter"),
        filterButton = filter.find(".jsFilterButton");

    filterButton.on("click", function(e) {
        e.preventDefault();

        var node = $(this);

        if (!(filter.hasClass("b-catalog-filter--invert"))) {
            node.toggleClass("g-button--close");
            filter.toggleClass("b-catalog-filter--active");
        }
        
    })
};

app.showHeaderSearch = function() {
    var searchBlock = $("#header-title-search"),
        btnSearch = $("#header-title-search .bx_input_submit"),
        inputSearch = $("#header-title-search .bx_input_text"),
        inputSearchValue = inputSearch.val();

    if (inputSearchValue.length >= 1) {
        btnSearch.addClass("active");
    }
    searchBlock.on('mouseenter', function() {
        $(this).addClass('show');
    });

    inputSearch.on('keyup', function(){
        var value = $(this).val();
        console.log(value);
        if (value.length >= 1) {
            btnSearch.addClass('active');
        } else {
            btnSearch.removeClass("active");
        }
    });

    $(document).on("click", function() {
        btnSearch.removeClass('show');
    });

    $(document).on("click", function(event){
        if ($(event.target).closest("#header-title-search").length || $(event.target).closest(".header-title-search-result").length  ) return;
        $("#header-title-search").removeClass('show');
    });
};

$(app.init);