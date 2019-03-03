<?$APPLICATION->IncludeComponent("ma:search.title", "footer-search-title", Array(
	"CATEGORY_0" => "",	// Ограничение области поиска
		"CATEGORY_0_TITLE" => "",	// Название категории
		"CHECK_DATES" => "N",	// Искать только в активных по дате документах
		"CONTAINER_ID" => "title-search",	// ID контейнера, по ширине которого будут выводиться результаты
		"INPUT_ID" => "title-search-input",	// ID строки ввода поискового запроса
		"NUM_CATEGORIES" => "1",	// Количество категорий поиска
		"ORDER" => "date",	// Сортировка результатов
		"PAGE" => "#SITE_DIR#catalog/search/",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
		"SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
		"SHOW_OTHERS" => "N",	// Показывать категорию "прочее"
		"TOP_COUNT" => "5",	// Количество результатов в каждой категории
		"USE_LANGUAGE_GUESS" => "N",	// Включить автоопределение раскладки клавиатуры
		"COMPONENT_TEMPLATE" => "visual",
		"PRICE_CODE" => "",	// Тип цены
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода
		"SHOW_PREVIEW" => "Y",	// Показать картинку
		"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
		"PREVIEW_WIDTH" => "75",	// Ширина картинки
		"PREVIEW_HEIGHT" => "75",	// Высота картинки
	),
	false
);?>