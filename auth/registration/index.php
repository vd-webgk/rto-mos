<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Регистрация");

    if(!$USER->IsAuthorized())
    {?>

    <?
        $APPLICATION->IncludeComponent(
	"bitrix:main.register", 
	"main", 
	array(
		"USER_PROPERTY_NAME" => "",
		"SHOW_FIELDS" => array(
			0 => "EMAIL",
			1 => "NAME",
			2 => "PERSONAL_PHONE",
		),
		"REQUIRED_FIELDS" => array(
			0 => "EMAIL",
			1 => "NAME",
			2 => "PERSONAL_PHONE",
		),
		"AUTH" => "Y",
		"USE_BACKURL" => "Y",
		"SUCCESS_PAGE" => "",
		"SET_TITLE" => "N",
		"USER_PROPERTY" => array(
			0 => "UF_IM_SEARCH",
			1 => "UF_BIZ",
			2 => "UF_NAME",
			3 => "UF_HOW_YOU_FIND",
			4 => "UF_DIRECT_OF_INTERES",
			5 => "UF_MULINE",
			6 => "UF_THREADS",
			7 => "UF_PROVIDER",
			8 => "UF_INDICATORS",
			9 => "UF_INFORMATION",
			10 => "UF_WISHES",
		),
		"COMPONENT_TEMPLATE" => "main",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);
        $_REQUEST["REGISTER[LOGIN]"] = $_REQUEST["REGISTER[EMAIL]"];
    } elseif(!empty( $_REQUEST["backurl"] )) {LocalRedirect( $_REQUEST["backurl"] );} else { LocalRedirect(SITE_DIR.'personal/');}

    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>