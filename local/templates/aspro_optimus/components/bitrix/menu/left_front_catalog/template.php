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
                                    $select = array('ID', 'NAME', 'PROPERTY_SHOW_IN_MENU', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID');
                                    $getElly = CIBlockElement::GetList(
                                        array(),
                                        $filter,
                                        false,
                                        false,
                                        $select
                                    );
                                    while($elementToShow = $getElly -> fetch()){
                                      $sectionSelect[] = array('ID' => $elementToShow['ID'],
                                                               'SECT' => $elementToShow['PROPERTY_SHOW_IN_MENU_VALUE'],
                                                               "NAME" => $elementToShow['NAME'],
                                                               'DETAIL_PAGE_URL' => $elementToShow['DETAIL_PAGE_URL'],
                                                               'IBLOCK_SECTION_ID' => $elementToShow['IBLOCK_SECTION_ID']
                                      );
                                         
                                      }
                                      //ARSHOW($sectionSelect);
                                     $i = 0; 
                                     foreach($sectionSelect as  $v){                                        
                                         if($v['SECT'] == $arItem["NAME"]){
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
                                                } 
                                            }
                                            ?>
                                            <div class="mainElement">
                                                <div class="imgElement">
                                                <?if($picture){
                                                    echo '<img style="max-width:150px;max-height:150px" src="';echo $picture;echo '"></img>';             
                                                }?>
                                                </div>
                                                <div class="nameElement">
                                                    <a href="<?=$v['DETAIL_PAGE_URL']?>">
                                                        <?=$v['NAME']?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?
                                         
                                         } 
                                     } 
               ?>
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