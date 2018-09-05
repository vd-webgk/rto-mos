<?
$catalog_id=\Bitrix\Main\Config\Option::get("aspro.optimus", "CATALOG_IBLOCK_ID", COptimusCache::$arIBlocks[SITE_ID]['aspro_optimus_catalog']['aspro_optimus_catalog'][0]);
$arSections = COptimusCache::CIBlockSection_GetList(array('SORT' => 'ASC', 'ID' => 'ASC', 'CACHE' => array('TAG' => COptimusCache::GetIBlockCacheTag($catalog_id), 'GROUP' => array('ID'))), array('IBLOCK_ID' => $catalog_id, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y', '<DEPTH_LEVEL' =>\Bitrix\Main\Config\Option::get("aspro.optimus", "MAX_DEPTH_MENU", 2)), false, array("ID", "NAME", "PICTURE", "LEFT_MARGIN", "RIGHT_MARGIN", "DEPTH_LEVEL", "SECTION_PAGE_URL", "IBLOCK_SECTION_ID"));
if($arSections){
	$arResult = array();
	$cur_page = $GLOBALS['APPLICATION']->GetCurPage(true);
	$cur_page_no_index = $GLOBALS['APPLICATION']->GetCurPage(false);

	foreach($arSections as $ID => $arSection){
		$arSections[$ID]['SELECTED'] = CMenu::IsItemSelected($arSection['SECTION_PAGE_URL'], $cur_page, $cur_page_no_index);
		if($arSection['PICTURE']){
			$img=CFile::ResizeImageGet($arSection['PICTURE'], Array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$arSections[$ID]['IMAGES']=$img;
		}
		if($arSection['IBLOCK_SECTION_ID']){
			if(!isset($arSections[$arSection['IBLOCK_SECTION_ID']]['CHILD'])){
				$arSections[$arSection['IBLOCK_SECTION_ID']]['CHILD'] = array();
			}
			$arSections[$arSection['IBLOCK_SECTION_ID']]['CHILD'][] = &$arSections[$arSection['ID']];
		}

		if($arSection['DEPTH_LEVEL'] == 1){
			$arResult[] = &$arSections[$arSection['ID']];
		}
	}
}
foreach( $arResult as $key => $arItem ){
    $filter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'PROPERTY_SHOW_IN_MENU_VALUE' => $arItem["NAME"], '!PROPERTY_SHOW_IN_MENU' => false);
    $select = array('ID', 'NAME', 'PROPERTY_SHOW_IN_MENU', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID');
    $getElly = CIBlockElement::GetList(
        array(),
        $filter,
        false,
        false,
        $select
    );

    $sectionSelect = array();
    while($elementToShow = $getElly -> Getnext()){
        $sectionSelect[] = array('ID' => $elementToShow['ID'],
            'SECT' => $elementToShow['PROPERTY_SHOW_IN_MENU_VALUE'],
            "NAME" => $elementToShow['NAME'],
            'DETAIL_PAGE_URL' => $elementToShow['DETAIL_PAGE_URL'],
            'IBLOCK_SECTION_ID' => $elementToShow['IBLOCK_SECTION_ID']
        );

    }
    $arResult['SECTIONS_TO_SHOW'] = $sectionSelect;
    foreach($sectionSelect as  $v){  
        $filter = array('ID' => $v['ID']);
        $select = array('PROPERTY_CML2_BAR_CODE');
        $getPicture = CIBlockElement::GetList(
            array(),
            $filter,
            false,
            false,
            $select
        );
        if($barcode = $getPicture -> fetch()){
            if(is_file($_SERVER['DOCUMENT_ROOT'].'/upload/product_images/'.$barcode['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg')){
                $picture =  '/upload/product_images/'.$barcode['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';
                $arResult['PICTURES_IN_MENU'][$v['ID']] = $picture;   
            } 
        }
    }
}
?>