<?
addEventHandler("iblock", "OnBeforeIblockElementUpdate", array("catalogHandlers", "getItemBrand"));
addEventHandler("iblock", "OnAfterIblockElementUpdate", array("catalogHandlers", "setItemBrand"));

class catalogHandlers {
    
    static $catalogIblockCode = "main_catalog";
    
    /**
    * перед изменением элемента получаем его бренд и сохраняем в сессию
    * 
    * @param mixed $arFields
    */
     function getItemBrand(&$arFields) {
        $item = CIBlockElement::GetList(array(), array("ID" => $arFields["ID"], "IBLOCK_CODE" => $catalogIblockCode), false, false, array("ID", "PROPERTY_BRAND"))->Fetch();
        if ($item["PROPERTY_BRAND_VALUE"]) {
            $_SESSION["ITEM_BRANDS"][$item["ID"]] = $item["PROPERTY_BRAND_VALUE"];
        }    
     }
     
     /**
     * после изменения элемента проверяем - если бренд стал пустым, возвращаем его из сессии
     * 
     * @param mixed $arFields
     */
     function setItemBrand(&$arFields) {
        $item = CIBlockElement::GetList(array(), array("ID" => $arFields["ID"], "IBLOCK_CODE" => $catalogIblockCode), false, false, array("ID", "PROPERTY_BRAND"))->Fetch();
        if (!$item["PROPERTY_BRAND_VALUE"] && $_SESSION["ITEM_BRANDS"][$arFields["ID"]]) {
            CIBlockElement::SetPropertyValuesEx($arFields["ID"], false, array("BRAND" => $_SESSION["ITEM_BRANDS"][$arFields["ID"]]));            
        }    
        unset($_SESSION["ITEM_BRANDS"][$arFields["ID"]]);
     }
    
} 