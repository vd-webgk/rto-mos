<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Авторизация");
?>
<?$APPLICATION->IncludeFile(SITE_DIR."include/auth_description.php", Array(), Array("MODE" => "html", "NAME" => GetMessage("AUTH_INCLUDE_AREA"), ));

        $APPLICATION->IncludeComponent(
	"bitrix:system.auth.form", 
	"main", 
	array(
		"REGISTER_URL" => SITE_DIR."auth/registration/",
		"PROFILE_URL" => SITE_DIR."auth/forgot-password/",
		"SHOW_ERRORS" => "Y",
		"COMPONENT_TEMPLATE" => "main",
		"FORGOT_PASSWORD_URL" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);

	
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>