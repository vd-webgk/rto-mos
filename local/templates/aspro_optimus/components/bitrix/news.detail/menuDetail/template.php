<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?
$id = $arParams['ELEMENT_ID'];
?>
<?if($id){?>
<?
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
        //arshow($arResult);      
    }
  
}
?>
<div class="mainElement">
    <div class="imgElement">
    <?//arshow($arResult);?>
    <?if($arResult['PREVIEW_PICTURE'] || $arResult['DETAIL_PICTURE']){
        echo '<img style="max-width:150px;max-height:150px" src="';echo $arResult['PREVIEW_PICTURE'];echo '"></img>';             
    }?>
    </div>
    <div class="nameElement">
        <a href="<?=$arResult['DETAIL_PAGE_URL']?>">
            <?=$arResult['NAME']?>
        </a>
    </div>
</div>
<?}?>