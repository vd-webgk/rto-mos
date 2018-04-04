<?
      function logger($data, $file) {
        file_put_contents(
            $file,
            var_export($data, 1)."\n",
            FILE_APPEND
        );
    }
    function arshow($array, $adminCheck = false){
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
                            if($arOneValue['QUANTITY'] > 0){
                                $templateRow .= '<span class="cnt_1">в наличии</span>';
                            } else{    
                               $templateRow .= '<span class="cnt_1">нет в наличии</span>'; 
                            }
                            $templateRow .= '<span class="cnt_1">Количество: '.$arOneValue['QUANTITY'].'</span>';
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
?>