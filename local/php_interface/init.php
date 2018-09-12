<?
use Bitrix\Main; 
      function logger($data, $file) {
        file_put_contents(
            $file,
            var_export($data, 1)."\n",
            FILE_APPEND
        );
    }
    function arshow($array, $adminCheck = true){
        global $USER;
        $USER = new Cuser;
        if ($adminCheck) {
            if (!$USER->IsAdmin()) {
                return false;
            }
        }
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
    
class COptimusNew{
    function GetSKUPropsArray(&$arSkuProps, $iblock_id=0, $type_view="list", $hide_title_props="N", $group_iblock_id="N", $Result){
        $arSkuTemplate = array();
        $class_title=($hide_title_props=="Y" ? "hide_class" : "show_class");
        $class_title.=' bx_item_section_name';

        if($iblock_id){
            //$arPropsSku=COptimus::GetPropertyViewType($iblock_id);
            $arPropsSku=CIBlockSectionPropertyLink::GetArray($iblock_id, 64);
            if($arPropsSku){
                foreach ($arSkuProps as $key=>$arProp){
                    if($arPropsSku[$arProp["ID"]]){
                        $arSkuProps[$key]["DISPLAY_TYPE"]=$arPropsSku[$arProp["ID"]]["DISPLAY_TYPE"];
                    }
                }
            }
        }?>

        <?
        if($group_iblock_id=="Y"){
            foreach ($arSkuProps as $iblockId => $skuProps){
                $arSkuTemplate[$iblockId] = array();
                foreach ($skuProps as $key=>&$arProp){
                    $templateRow = '';
                    $class_title.= (($arProp["HINT"] && $arProp["SHOW_HINTS"] == "Y") ? ' whint char_name' : '');
                    $hint_block = (($arProp["HINT"] && $arProp["SHOW_HINTS"]=="Y") ? '<div class="hint"><span class="icon"><i>?</i></span><div class="tooltip">'.$arProp["HINT"].'</div></div>' : '');
                    if(($arProp["DISPLAY_TYPE"]=="P" || $arProp["DISPLAY_TYPE"]=="R" ) && $type_view!= 'block' ){
                        $templateRow .= '<div class="bx_item_detail_size" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
        '<span class="'.$class_title.'">'.$hint_block.htmlspecialcharsex($arProp['NAME']).'</span>'.
        '<div class="bx_size_scroller_container form-control bg"><div class="bx_size"><select id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                        foreach ($arProp['VALUES'] as $arOneValue){
                            //if($arOneValue['ID']>0){
                                $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                                $templateRow .= '<option data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-showtype="select" data-onevalue="'.$arOneValue['ID'].'" ';
                                if($arProp["DISPLAY_TYPE"]=="R"){
                                    $templateRow .= 'data-img_src="'.$arOneValue["PICT"]["SRC"].'" ';
                                }
                                $templateRow .= 'title="'.$arProp['NAME'].': '.$arOneValue['NAME'].'">';
                                $templateRow .= '<span class="cnt"><img src="'.$arOneValue['PICTURIE'].'" width="50"></span>';
                                $templateRow .= '<span class="cnt_1">Состав: '.$arOneValue['SOSTAV'].'</span>';
                                $templateRow .= '<span class="cnt_2">Длина: '.$arOneValue['[DLINA'].'</span>';
                                $templateRow .= '</option>';
                            //}
                        }
                        $templateRow .= '</select></div>'.
        '</div></div>';
                    } elseif ('TEXT' == $arProp['SHOW_MODE']){
                        $templateRow .= '<div class="bx_item_detail_size" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
        '<span class="'.$class_title.'">'.$hint_block.htmlspecialcharsex($arProp['NAME']).'</span>'.
        '<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                        foreach ($arProp['VALUES'] as $arOneValue){
                            //if($arOneValue['ID']>0){
                                $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                                $templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-showtype="li" data-onevalue="'.$arOneValue['ID'].'" title="'.$arProp['NAME'].': '.$arOneValue['NAME'].'"><i></i><span class="cnt">'.$arOneValue['NAME'].'</span></li>';
                            //}
                        }
                        $templateRow .= '</ul></div>'.
        '</div></div>';
                    } elseif ('PICT' == $arProp['SHOW_MODE']){
                        $isHasPicture = true;
                        foreach ($arProp['VALUES'] as $arOneValue){
                            if($arOneValue['ID']>0){
                                if(!isset($arOneValue['PICT']['SRC']) || !$arOneValue['PICT']['SRC'])
                                    $isHasPicture = false;
                            }
                        }
                        if($isHasPicture) {
                            $templateRow .= '<div class="bx_item_detail_scu" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
        '<span class="'.$class_title.'">'.$hint_block.htmlspecialcharsex($arProp['NAME']).'</span>'.
        '<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                        } else {
                            $templateRow .= '<div class="bx_item_detail_size" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
        '<span class="'.$class_title.'">'.$hint_block.htmlspecialcharsex($arProp['NAME']).'</span>'.
        '<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                        }
                        foreach ($arProp['VALUES'] as $arOneValue){
                            //if($arOneValue['ID']>0){
                                $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                                if(isset($arOneValue['PICT']['SRC']) && $arOneValue['PICT']['SRC'] && $isHasPicture) {
                                    $templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-showtype="li" data-onevalue="'.$arOneValue['ID'].'"><i title="'.$arProp['NAME'].': '.$arOneValue['NAME'].'"></i>'.
            '<span class="cnt1"><span class="cnt_item" style="background-image:url(\''.$arOneValue['PICT']['SRC'].'\');" title="'.$arProp['NAME'].': '.$arOneValue['NAME'].'"></span></span></li>';
                                } else {
                                    $templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-showtype="li" data-onevalue="'.$arOneValue['ID'].'" title="'.$arProp['NAME'].': '.$arOneValue['NAME'].'"><i></i><span class="cnt1"><span class="cnt_item">'.$arOneValue['NAME'].'</span></span></li>';
                                }
                            //}
                        }
                        $templateRow .= '</ul></div>'.
        '</div></div>';
                    }
                    $arSkuTemplate[$iblockId][$arProp['CODE']] = $templateRow;
                }
            }
        } else {
            foreach ($arSkuProps as $key=>&$arProp){
                $templateRow = '';
                $class_title.= (($arProp["HINT"] && $arProp["SHOW_HINTS"] == "Y") ? ' whint char_name' : '');
                $hint_block = (($arProp["HINT"] && $arProp["SHOW_HINTS"]=="Y") ? '<div class="hint"><span class="icon"><i>?</i></span><div class="tooltip">'.$arProp["HINT"].'</div></div>' : '');
                if(($arProp["DISPLAY_TYPE"]=="P" || $arProp["DISPLAY_TYPE"]=="R" ) && $type_view!= 'block' ){
                    $templateRow .= '<div class="bx_item_detail_size" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
    '<span class="'.$class_title.'">'.$hint_block.htmlspecialcharsex($arProp['NAME']).'</span>'.
    '<div class="bx_size_scroller_container form-control bg"><div class="bx_size"><select id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                    foreach ($arProp['VALUES'] as $arOneValue){
                        //if($arOneValue['ID']>0){
                            $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                            $templateRow .= '<option data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-showtype="select" data-onevalue="'.$arOneValue['ID'].'" ';
                            if($arProp["DISPLAY_TYPE"]=="R"){
                                $templateRow .= 'data-img_src="'.$arOneValue["PICT"]["SRC"].'" ';
                            }
                                $templateRow .= 'title="'.$arProp['NAME'].': '.$arOneValue['NAME'].'">';
                                $templateRow .= '<span class="cnt"><img src="'.$arOneValue['PICTURIE'].'" width="50"></span>';
                                $templateRow .= '<span class="cnt_1">Состав: '.$arOneValue['SOSTAV'].'</span>';
                                $templateRow .= '<span class="cnt_2">Длина: '.$arOneValue['[DLINA'].'</span>';
                                $templateRow .= '</option>';
                        //}
                    }
                    $templateRow .= '</select></div>'.
    '</div></div>';
                } elseif ('TEXT' == $arProp['SHOW_MODE']){
                    $templateRow .= '<div class="bx_item_detail_size" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
    '<span class="'.$class_title.'">'.$hint_block.htmlspecialcharsex($arProp['NAME']).'</span>'.
    '<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                    foreach ($arProp['VALUES'] as $arOneValue){
                        //if($arOneValue['ID']>0){
                            $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                            $templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-showtype="li" data-onevalue="'.$arOneValue['ID'].'" title="'.$arProp['NAME'].': '.$arOneValue['NAME'].'"><i></i>
                            <span class="cnt">
                                <a href="'.$arOneValue['PICTURIE'].'" data-fancybox-group="item_slider" class="imageFancy" title="">
                                    <img src="'.$arOneValue['PICTURIE'].'" height="50">
                                </a>
                            </span>';
                            $templateRow .= '<span class="cnt">'.$arOneValue['NAME'].'</span>';
                            if($arOneValue['SOSTAV']){
                                $templateRow .= '<span class="cnt_1">Состав: '.$arOneValue['SOSTAV'].'</span>';
                            }  
                            if($arOneValue['DLINA']){
                                $templateRow .= '<span class="cnt_1">Длина: '.$arOneValue['DLINA'].'</span>';
                            }    
                            if($arOneValue['QUANTITY'] > 5){
                                $templateRow .= '<div class="item-stock" ><span class="icon stock"></span><span class="value"><span class="store_view">Много</span></span></div>';
                            } else if ($arOneValue['QUANTITY'] < 5 && $arOneValue['QUANTITY'] > 0){    
                                $templateRow .= '<div class="item-stock" ><span class="icon stock"></span><span class="value"><span class="store_view">Мало</span></span></div>';
                            } else{    
                                $templateRow .= '<div class="item-stock" ><span class="icon order"></span><span class="value"><span class="store_view">Нет в наличии</span></span></div>';
                            }
                            if($arOneValue['PRICE']){
                                $templateRow .= '<span class="cnt_1">Цена: '.$arOneValue['PRICE'].'</span>';
                            }
                            if($arOneValue['QUANTITY'] > 0){
                                $templateRow .= '<div class="offer_buy_block buys_wrapp" style="display:none;">
                                    <div class="counter_wrapp"></div>
                                </div>';  
                            }                     
                            $templateRow .= '</li>';                       
                        //}
                    }
                    $templateRow .= '</ul></div>'.
    '</div></div>';
                } elseif ('PICT' == $arProp['SHOW_MODE']){
                    $isHasPicture = true;
                    foreach ($arProp['VALUES'] as $arOneValue){
                        if($arOneValue['ID']>0){
                            if(!isset($arOneValue['PICT']['SRC']) || !$arOneValue['PICT']['SRC'])
                                $isHasPicture = false;
                        }
                    }
                    if($isHasPicture) {
                        $templateRow .= '<div class="bx_item_detail_scu" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
    '<span class="'.$class_title.'">'.$hint_block.htmlspecialcharsex($arProp['NAME']).'</span>'.
    '<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                    } else {
                        $templateRow .= '<div class="bx_item_detail_size" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
    '<span class="'.$class_title.'">'.$hint_block.htmlspecialcharsex($arProp['NAME']).'</span>'.
    '<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list">';

                    }
                    foreach ($arProp['VALUES'] as $arOneValue){
                        //if($arOneValue['ID']>0){
                            $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                            if(isset($arOneValue['PICT']['SRC']) && $arOneValue['PICT']['SRC'] && $isHasPicture)
                            {
                                $templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-showtype="li" data-onevalue="'.$arOneValue['ID'].'"><i title="'.$arProp['NAME'].': '.$arOneValue['NAME'].'"></i>'.
        '<span class="cnt1"><span class="cnt_item" style="background-image:url(\''.$arOneValue['PICT']['SRC'].'\');" title="'.$arProp['NAME'].': '.$arOneValue['NAME'].'"></span></span></li>';
                            } else {
                                $templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-showtype="li" data-onevalue="'.$arOneValue['ID'].'" title="'.$arProp['NAME'].': '.$arOneValue['NAME'].'"><i></i><span class="cnt1"><span class="cnt_item">'.$arOneValue['NAME'].'</span></span></li>';
                            }
                        //}
                    }
                    $templateRow .= '</ul></div>'.
    '</div></div>';
                }
                $arSkuTemplate[$arProp['CODE']] = $templateRow;
            }
        }
        unset($templateRow, $arProp);
        return $arSkuTemplate;
    }    
}

AddEventHandler("main", "OnBeforeUserRegister", "newNonActiveUser");

    function newNonActiveUser(&$arFields)
    {
    
        $hash = rand(100, 1000);
        $hashPassword = md5($hash);
        $arFields["ACTIVE"] = "N";
        $arFields["PASSWORD "] = $hashPassword ;
        $arFields["CONFIRM_PASSWORD "] = $hashPassword ;
        
        
        
       
    }
//Добавление выпалающего списка с вариантами отправки почтового шаблона на страницу в админ. панели.
AddEventHandler("main", "OnProlog", array("rtoHandlers", "OnPrologHandler"));
// Отправка почтового уведомления пользователю в соответствии с выбранным шаблоном.
AddEventHandler("main", "OnBeforeUserUpdate", array("rtoHandlers", "sendMailToUser"));
//Отправка почтового события "Новый заказ"
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleComponentOrderCreated',
    'newOrder'
);
function newOrder($order, &$arUserResult, $request, &$arParams, &$arResult){
            $getAvailableFields = $order->getAvailableFields();
            $basket = $order->getBasket();
            $basketItems = $basket->getBasketItems();
            foreach($basketItems as $item ){
                $getPropertyCollection = $item->getPropertyCollection() ;
            }
            $currency = $order->getField('CURRENCY');
            $PRICE = $order->getField('PRICE');
            $DATE_INSERT = $order->getField('DATE_INSERT');
            $orderId = $order->getId();
            if($arResult['ORDER_PROP']['USER_PROFILES']){
                foreach($arResult['ORDER_PROP']['USER_PROFILES'] as $k => $v){
                    if($v['CHECKED'] == 'Y'){
                        $userID = $v['USER_ID']; 
                    }
                }
                if($userID){
                    $user = CUser::GetByID($userID);
                    $arUser = $user->Fetch();
                    if(!empty($arUser['NAME'])){
                        if(!empty($arUser['LAST_NAME'])){
                         $name = $arUser['NAME']." ".$arUser['LAST_NAME'];       
                        }
                        else {
                            $name = $arUser['NAME'];
                        }                  
                    }
                    else {
                        $name = $arUser['LOGIN'];    
                    }
                    $PERSONAL_PHONE = $arUser['PERSONAL_PHONE'];
                    $company = $arUser['UF_NAME'];   
                    $deliveryAddress = $arUser['UF_INFORMATION'];   
                    $legalAddress = $arUser['UF_INFORMATION'];
                    $country = $arUser['WORK_COUNTRY'];   
                }
                
                Bitrix\Main\Mail\Event::send(array(
                    "EVENT_NAME" => "SALE_NEW_ORDER",
                    "LID" => 's1',
                    "C_FIELDS" => array(
                        "EMAIL" => $arUserResult['ORDER_PROP'][13],
                        "NAME" => $name,
                        "LOGIN" => $arUser['LOGIN'],
                        "COUNTRY" => $country,
                        "COMPANY" => $company,
                        "MESSAGE" => 1,
                        "TELEPHONE" => $PERSONAL_PHONE,
                        "LEGAL_ADDRESS" => $deliveryAddress,
                        "DELIVERY_ADDRESS" => $deliveryAddress,
                        "ORDER_ID" => $orderId,
                        "DATE" => $DATE_INSERT,
                        "CURRENCY" => $currency,
                        "TOTAL" => $PRICE,
                        
                    ),
                    "DUPLICATE" => 'N',
                    "MESSAGE_ID" => 101, 
                ));  
            }            
        }
class rtoHandlers
    {   
        function OnPrologHandler() //Если указана нужная нам страница в админ. панели, подключаем jquery, подлкючаем js-скрипт с отрисовкой верстки, подключаем стили.
        {
            global $APPLICATION;
            if ($APPLICATION->GetCurPage() == "/bitrix/admin/user_edit.php") {
                $APPLICATION->AddHeadScript("//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js");
                $APPLICATION->AddHeadScript("/local/templates/aspro_optimus/js/admin_scripts.js");
                $APPLICATION->SetAdditionalCSS("/local/templates/aspro_optimus/css/admin_styles.css");
            }
        } // Отправка почтового уведомления пользователю в соответствии с выбранным шаблоном.
        function sendMailToUser($arFields){  
            if($arFields['ID']){
                if($_REQUEST['sendMailTemplate'] == 'temp'){ //Временная регистрация
                    Bitrix\Main\Mail\Event::send(array(
                        "EVENT_NAME" => "USER_INFO",
                        "LID" => $arFields['LID'],
                        "C_FIELDS" => array(
                            "EMAIL" => $arFields['EMAIL'],
                            "NAME" => $arFields['NAME'],
                            "LOGIN" => $arFields['LOGIN'],
                            "MESSAGE" => $arFields['PASSWORD'],
                            
                        ),
                        "DUPLICATE" => 'N',
                        "MESSAGE_ID" => 94, 
                    ));
                }
                if($_REQUEST['sendMailTemplate'] == 'reg'){    //Постоянная регистрация
                    Bitrix\Main\Mail\Event::send(array(
                        "EVENT_NAME" => "USER_INFO",
                        "LID" => $arFields['LID'],
                        "C_FIELDS" => array(
                            "EMAIL" => $arFields['EMAIL'],
                            "NAME" => $arFields['NAME'],
                            "LOGIN" => $arFields['LOGIN'],
                            "MESSAGE" => $arFields['PASSWORD'],
                                
                            ),
                        "DUPLICATE" => 'N',
                        "MESSAGE_ID" => 95, 
                    ));
                }
                if($_REQUEST['sendMailTemplate'] == 'denied'){    //Регистрация невозможна
                    Bitrix\Main\Mail\Event::send(array(
                        "EVENT_NAME" => "USER_INFO",
                        "LID" => $arFields['LID'],
                        "C_FIELDS" => array(
                            "EMAIL" => $arFields['EMAIL'],
                            "NAME" => $arFields['NAME'],                                
                        ),
                        "DUPLICATE" => 'N',
                        "MESSAGE_ID" => 96, 
                    ));
                }
            }           
        }        
    }    
AddEventHandler("sale", "OnOrderSave", "checkTrackNumber");                 //Отправка имейла при заполнении трек-номера.
function checkTrackNumber($orderFields, $orderId, $fields, $isNew){
   $dbOrderProps = CSaleOrderPropsValue::GetList( array("SORT" => "ASC"), array("ORDER_ID" => $fields['ID'], "CODE"=>"TRACK"));
    while ($arOrderProps = $dbOrderProps->Fetch()){
        if(!empty($arOrderProps['VALUE'])){
            $arEventFields = array(
            "EMAIL" => $fields['USER_EMAIL']
            );
        CEvent::Send("CHECK_TRACK_NUMBER", "s1", $arEventFields);
        }   
    }
}

//AddEventHandler("sale", "OnOrderAdd", "fillComapnyName");
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleComponentOrderCreated',
    'fillComapnyName'
);
function fillComapnyName($order, &$arUserResult, $request, &$arParams, &$arResult){
    $us_id = $order->getUserId();
    $rsUser = CUser::GetByID($us_id);
    $arUser = $rsUser->Fetch();
    $propertyCollection = $order->getPropertyCollection();       
    if($arUser['UF_NAME']){
        $propertyCollection = $order->getPropertyCollection(); 
        $getCompany = $arUser['UF_NAME'];
        $companyVal = $propertyCollection->getItemByOrderPropertyId(26);
        $companyVal->setValue($getCompany);
        $order->save();
    }   
}  
?>