<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax",
	"template1",
	Array(
		"ACTION_VARIABLE" => "soa-action",
		"ADDITIONAL_PICT_PROP_13" => "-",
		"ADDITIONAL_PICT_PROP_14" => "-",
		"ADDITIONAL_PICT_PROP_17" => "-",
		"ADDITIONAL_PICT_PROP_18" => "-",
		"ADDITIONAL_PICT_PROP_2" => "-",
		"ADDITIONAL_PICT_PROP_20" => "-",
		"ADDITIONAL_PICT_PROP_21" => "-",
		"ADDITIONAL_PICT_PROP_3" => "-",
		"ALLOW_APPEND_ORDER" => "Y",
		"ALLOW_AUTO_REGISTER" => "N",
		"ALLOW_NEW_PROFILE" => "N",
		"ALLOW_USER_PROFILES" => "N",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"BASKET_POSITION" => "before",
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "template1",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"DELIVERIES_PER_PAGE" => "",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"DELIVERY_NO_AJAX" => "N",
		"DELIVERY_NO_SESSION" => "N",
		"DELIVERY_TO_PAYSYSTEM" => "p2d",
		"DISABLE_BASKET_REDIRECT" => "N",
		"DISPLAY_IMG_HEIGHT" => "90",
		"DISPLAY_IMG_WIDTH" => "90",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"PATH_TO_AUTH" => SITE_DIR."auth/",
		"PATH_TO_BASKET" => SITE_DIR."basket/",
		"PATH_TO_PAYMENT" => "",
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",
		"PAY_FROM_ACCOUNT" => "N",
		"PAY_SYSTEMS_PER_PAGE" => "",
		"PICKUPS_PER_PAGE" => "",
		"PICKUP_MAP_TYPE" => "yandex",
		"PRODUCT_COLUMNS" => "",
		"PRODUCT_COLUMNS_HIDDEN" => array(0=>"PREVIEW_PICTURE",1=>"DETAIL_PICTURE",2=>"PREVIEW_TEXT",3=>"PROPS",4=>"NOTES",5=>"DISCOUNT_PRICE_PERCENT_FORMATED",6=>"PRICE_FORMATED",7=>"WEIGHT_FORMATED",8=>"PROPERTY_MINIMUM_PRICE",9=>"PROPERTY_MAXIMUM_PRICE",10=>"PROPERTY_HIT",11=>"PROPERTY_BRAND",12=>"PROPERTY_IN_STOCK",13=>"PROPERTY_PROP_2033",),
		"PRODUCT_COLUMNS_VISIBLE" => array(0=>"PREVIEW_PICTURE",1=>"PROPS",2=>"NOTES",3=>"DISCOUNT_PRICE_PERCENT_FORMATED",4=>"PRICE_FORMATED",5=>"WEIGHT_FORMATED",),
		"PROPS_FADE_LIST_1" => array(0=>"7",),
		"PROPS_FADE_LIST_2" => array(),
		"PROP_1" => "",
		"PROP_2" => "",
		"PROP_3" => "",
		"PROP_4" => "",
		"SEND_NEW_USER_NOTIFY" => "N",
		"SERVICES_IMAGES_SCALING" => "standard",
		"SET_TITLE" => "Y",
		"SHOW_BASKET_HEADERS" => "Y",
		"SHOW_COUPONS_BASKET" => "N",
		"SHOW_COUPONS_DELIVERY" => "N",
		"SHOW_COUPONS_PAY_SYSTEM" => "N",
		"SHOW_DELIVERY_INFO_NAME" => "N",
		"SHOW_DELIVERY_LIST_NAMES" => "N",
		"SHOW_DELIVERY_PARENT_NAMES" => "N",
		"SHOW_MAP_FOR_DELIVERIES" => array(0=>"1",1=>"2",),
		"SHOW_MAP_IN_PROPS" => "N",
		"SHOW_NEAREST_PICKUP" => "N",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "N",
		"SHOW_ORDER_BUTTON" => "always",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "N",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "N",
		"SHOW_PICKUP_MAP" => "N",
		"SHOW_STORES_IMAGES" => "N",
		"SHOW_TOTAL_ORDER_BUTTON" => "N",
		"SHOW_VAT_PRICE" => "N",
		"SKIP_USELESS_BLOCK" => "Y",
		"SPOT_LOCATION_BY_GEOIP" => "N",
		"TEMPLATE_LOCATION" => "popup",
		"TEMPLATE_THEME" => "blue",
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
		"USE_CUSTOM_ERROR_MESSAGES" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "N",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_PRELOAD" => "N",
		"USE_PREPAYMENT" => "N",
		"USE_YM_GOALS" => "N"
	)
);?>&nbsp;<br>
 <?$APPLICATION->IncludeComponent("aspro:oneclickbuy.optimus", "formInBasket", Array(
	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
		"DEFAULT_CURRENCY" => "RUB",	// Валюта по умолчанию
		"DEFAULT_DELIVERY" => "0",	// Cпособ доставки
		"DEFAULT_PAYMENT" => "0",	// Cпособ оплаты
		"DEFAULT_PERSON_TYPE" => "2",	// Тип плательщика для вновь зарегистрированного пользователя
        "ELEMENT_ID" => $_REQUEST['ELEMENT_ID_BASKET'],    // ID товара
		"IBLOCK_ID" => "20",	// ID информационного блока
		"IBLOCK_TYPE" => "1c_catalog",	// Тип информационного блока
		"PRICE_ID" => "1",	// ID цены
		"PROPERTIES" => array(	// Поля формы
			0 => "FIO",
			1 => "PHONE",
			2 => "EMAIL",
			3 => "COMMENT",
		),
		"REQUIRED" => array(	// Обязательные поля
			0 => "FIO",
			1 => "PHONE",
		),
		"SHOW_DELIVERY_NOTE" => "N",	// Отображать текст о стоимости доставки
		"USE_QUANTITY" => "N",	// Показывать только для товара в наличии
		"USE_SKU" => "N",	// Использовать товарные предложения (SKU)
		"COMPONENT_TEMPLATE" => "formInBasket"
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>