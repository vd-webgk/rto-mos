<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if( !empty( $arResult ) ){
        global $TEMPLATE_OPTIONS;?>
    <div class="menu_top_block catalog_block">
        <ul class="menu dropdown">
            <?foreach( $arResult as $key => $arItem ){?>
            <?if(!empty($arItem['NAME'])){?>
                <li class="full <?=($arItem["CHILD"] ? "has-child" : "");?> <?=($arItem["SELECTED"] ? "current" : "");?> m_<?=strtolower($TEMPLATE_OPTIONS["MENU_POSITION"]["CURRENT_VALUE"]);?>">
                    <a class="icons_fa <?=($arItem["CHILD"] ? "parent" : "");?>" href="<?=$arItem["SECTION_PAGE_URL"]?>" ><?=$arItem["NAME"]?></a>
                    <?if($arItem["CHILD"]){?>
                        <ul class="dropdown">
                            <?$alreadyShow = array();?>
                            <?if(count($arItem["CHILD"]) < 6){
                                $cnt = count($arItem["CHILD"]);
                                for($k = 0; $k <= 6 - $cnt; $k++){
                                    $arItem["CHILD"][6 - $k] = array("IMAGES" => $k+1, "CHILD" => $k+1 );       
                                }   
                            }?>
                            <?foreach($arItem["CHILD"] as $i => $arChildItem){?>
                                <?//arshow($arChildItem)?>
                                <li class="<?=($arChildItem["CHILD"] ? "has-childs" : "");?> <?if($arChildItem["SELECTED"]){?> current <?}?>">
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

                                </li>
                                <?if(($i+1) % 3 == 0){ //Вывод элементов в 3 и 4 столбцах меню?>     
                                    <?if ($i+1 == 3 || $i+1 == 6) {   
                                         foreach($arResult['SECTIONS_TO_SHOW'] as  $v){    //Выводим элемент в меню
                                            if (in_array($v["ID"], $alreadyShow)) {
                                                continue;
                                            }?>
                                             <?if($v['SECT'] == $arItem['NAME']){// Если совпадает раздел, выводим элемент в соответствующем разделе?>
                                                <li>                       
                                                    <div class="mainElement">
                                                        <div class="imgElement">
                                                            <?if($arResult['PICTURES_IN_MENU'][$v['ID']]){
                                                                echo "<a href='".$v['DETAIL_PAGE_URL']."'>";
                                                                echo '<img style="max-width:150px;max-height:150px" src="' . $arResult['PICTURES_IN_MENU'][$v['ID']] . '"></img>';
                                                                echo "</a>";             
                                                            }?>
                                                        </div>
                                                        <div class="nameElement">
                                                            <a href="<?=$v['DETAIL_PAGE_URL']?>">
                                                                <?=$v['NAME']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?$alreadyShow[] = $v["ID"];
                                                break;
                                                ?>
                                             <?}?>
                                        <?}?>                                          
                                        
                                        <?}?>
                                         
                                    <?}?>
                                <?}?>
                        </ul>
                        <?}?>
                </li>
                <?}?>
                <?}?>
        </ul>
    </div>
    <?}?>