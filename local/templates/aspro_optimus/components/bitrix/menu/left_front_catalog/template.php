<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if( !empty( $arResult ) ){
	global $TEMPLATE_OPTIONS;?>
	<div class="menu_top_block catalog_block">
		<ul class="menu dropdown">
			<?foreach( $arResult as $key => $arItem ){?>
            <?$elementSections[] = $arItem["SECTION_PAGE_URL"];?>
				<li class="full <?=($arItem["CHILD"] ? "has-child" : "");?> <?=($arItem["SELECTED"] ? "current" : "");?> m_<?=strtolower($TEMPLATE_OPTIONS["MENU_POSITION"]["CURRENT_VALUE"]);?>">
					<a class="icons_fa <?=($arItem["CHILD"] ? "parent" : "");?>" href="<?=$arItem["SECTION_PAGE_URL"]?>" ><?=$arItem["NAME"]?></a>
					<?if($arItem["CHILD"]){?>
						<ul class="dropdown">
                        <?$count = 0;?>
							<?foreach($arItem["CHILD"] as $arChildItem){?>
								<li <?if($count == 1 || $count == 3 || $count == 5 || $count == 7 || $count == 9){?>style="float:none !important"<?}?> class="<?=($arChildItem["CHILD"] ? "has-childs" : "");?> <?if($arChildItem["SELECTED"]){?> current <?}?>">
									<?if($arChildItem["IMAGES"]){?>
										<span class="image"><a href="<?=$arChildItem["SECTION_PAGE_URL"];?>"><img src="<?=$arChildItem["IMAGES"]["src"];?>" alt="<?=$arChildItem["NAME"];?>" /></a></span>
									<?}?>
									<a class="section" href="<?=$arChildItem["SECTION_PAGE_URL"];?>"><span><?=$arChildItem["NAME"];?></span></a>
									<?if($arChildItem["CHILD"]){?>
										<ul class="dropdown">
											<?foreach($arChildItem["CHILD"] as $arChildItem1){?>
												<li class="menu_item <?if($arChildItem1["SELECTED"]){?> current <?}?>">
													<a class="parent1 section1" href="<?=$arChildItem1["SECTION_PAGE_URL"];?>"><span><?=$arChildItem1["NAME"];?></span></a>
												</li>
											<?}?>
										</ul>
									<?}?>
									<div class="clearfix"></div>
                                    
								</li> <?if($count == 5 || $count == 7 || $count == 9 || $count == 11){?>
                                    <li style="width: 200px !important;" class="custom"></li>
                                <?}?>
                                <?if($count == 1 || $count == 3){?>                            
                                    <li style="width: 200px !important;" class="custom">
                                 <?                               
                                 $filter = array('IBLOCK_ID' => 20,'SECTION_PAGE_URL' => $elementSections, '!PROPERTY_SHOW_IN_MENU' => false);
                                    $select = array('ID', 'NAME', 'PROPERTY_SHOW_IN_MENU');
                                    $getElly = CIBlockElement::GetList(
                                        array(),
                                        $filter,
                                        false,
                                        false,
                                        $select
                                    );
                                    while($elementToShow = $getElly -> fetch()){
                                      $sectionSelect[] = array('ID' => $elementToShow['ID'], 'SECT' => $elementToShow['PROPERTY_SHOW_IN_MENU_VALUE']);
                                         
                                      }
                                     // ARSHOW($sectionSelect); 
                                     foreach($sectionSelect as $k => $v){                                          
                                     if($v['ID'] && $v['SECT'] == $arItem["NAME"]){
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
                                            $arResult['PREVIEW_PICTURE'] = '/upload/product_images/'.$barcode['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';   
                                        } 
                                    }
                                    ?>
                                    <div class="mainElement">
                                        <div class="imgElement">
                                        <?if($arResult['PREVIEW_PICTURE'] || $arResult['DETAIL_PICTURE']){
                                            echo '<img style="max-width:150px;max-height:150px" src="';echo $arResult['PREVIEW_PICTURE'];echo '"></img>';             
                                        }?>
                                        </div>
                                        <div class="nameElement">
                                            <a href="<?=$arResult['DETAIL_PAGE_URL']?>">
                                                <?=$elementToShow['NAME']?>
                                            </a>
                                        </div>
                                    </div>
                                    <?}     
                                          } 
                                     // arshow($elementToShow);

                                  /*  if($id && $sectionSelect == $arItem["CODE"]){
                                    $filter = array('ID' => $id);
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
                                            $arResult['PREVIEW_PICTURE'] = '/upload/product_images/'.$barcode['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';   
                                        } 
                                    }
                                    ?>
                                    <div class="mainElement">
                                        <div class="imgElement">
                                        <?if($arResult['PREVIEW_PICTURE'] || $arResult['DETAIL_PICTURE']){
                                            echo '<img style="max-width:150px;max-height:150px" src="';echo $arResult['PREVIEW_PICTURE'];echo '"></img>';             
                                        }?>
                                        </div>
                                        <div class="nameElement">
                                            <a href="<?=$arResult['DETAIL_PAGE_URL']?>">
                                                <?=$elementToShow['NAME']?>
                                            </a>
                                        </div>
                                    </div>
                                    <?}  */
                                 /*$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "menuDetail",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_ELEMENT_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BROWSER_TITLE" => "-",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_CODE" => "",
        "ELEMENT_ID" => $arParams['ELEMENT_ID'],
        "FIELD_CODE" => array("", ""),
        "IBLOCK_ID" => "20",
        "IBLOCK_TYPE" => "1c_catalog",
        "IBLOCK_URL" => "",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "MESSAGE_404" => "",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Страница",
        "PROPERTY_CODE" => array("", ""),
        "SET_BROWSER_TITLE" => "N",
        "SET_CANONICAL_URL" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "STRICT_SECTION_CHECK" => "N",
        "USE_PERMISSIONS" => "N",
        "USE_SHARE" => "N"
    )
);*/?>
                                </li>
                                <?}?>
                                <?$count++;?>
							<?}?>
                      
						</ul>
					<?}?>
				</li>
			<?}?>
		</ul>
	</div>
<?}?>
<script>
$(document).on('change', function(){
    $('li.full').on('focus','ul.dropdown li.has-childs', function(e){
        e.preventDefault();
      var height = $('li.has-childs').css('height');
    console.log(height);  
    })
    
})
</script>