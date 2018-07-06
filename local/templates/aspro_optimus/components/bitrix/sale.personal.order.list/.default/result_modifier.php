<?
CModule::IncludeModule("iblock");
foreach ($arResult["ORDERS"] as $key => $arItems){         
    $dbOrderProps = CSaleOrderPropsValue::GetList(                                         
        array("SORT" => "ASC"),
        array("ORDER_ID" => $arItems["ORDER"]["ID"], "ORDER_PROPS_ID"=> array(22,23,24,25))                 
    );
    while ($arOrderProps = $dbOrderProps->Fetch()){
    switch($arOrderProps["ORDER_PROPS_ID"]){
        case 22:
        $arResult["ORDERS"][$key]["ORDER"]["INVOICE_ATTACH"] =  CFile::GetPath($arOrderProps["VALUE"]);
        break;
        case 23:
        $arResult["ORDERS"][$key]["ORDER"]["UPD_ATTACH"] =  CFile::GetPath($arOrderProps["VALUE"]);
        break;
        case 24:
        $arResult["ORDERS"][$key]["ORDER"]["INVOICE_SRING"] =  $arOrderProps["VALUE"];
        break;
        case 25:
        $arResult["ORDERS"][$key]["ORDER"]["TRACK"] =  $arOrderProps["VALUE"];
    }
    }      
}