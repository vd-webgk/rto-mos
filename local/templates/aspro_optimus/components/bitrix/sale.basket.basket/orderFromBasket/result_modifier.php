<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;

$defaultParams = array(
	'TEMPLATE_THEME' => 'blue'
);
$arParams = array_merge($defaultParams, $arParams);
unset($defaultParams);

$arParams['TEMPLATE_THEME'] = (string)($arParams['TEMPLATE_THEME']);
if ('' != $arParams['TEMPLATE_THEME'])
{
	$arParams['TEMPLATE_THEME'] = preg_replace('/[^a-zA-Z0-9_\-\(\)\!]/', '', $arParams['TEMPLATE_THEME']);
	if ('site' == $arParams['TEMPLATE_THEME'])
	{
		$templateId = (string)Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', SITE_ID);
		$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? 'eshop_adapt' : $templateId;
		$arParams['TEMPLATE_THEME'] = (string)Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', SITE_ID);
	}
	if ('' != $arParams['TEMPLATE_THEME'])
	{
		if (!is_file($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
			$arParams['TEMPLATE_THEME'] = '';
	}
}
if ('' == $arParams['TEMPLATE_THEME'])
	$arParams['TEMPLATE_THEME'] = 'blue';
    foreach ($arResult['ITEMS']['AnDelCanBuy'] as $arItem){
        //arshow($arItem);   
                $destinationFile = $_SERVER['DOCUMENT_ROOT'].'/upload/product_images/small/'.$arItem['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';
                if(is_file($destinationFile))
                {                                          
                    $src = $_SERVER['DOCUMENT_ROOT'].'/upload/product_images/'.$arItem['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';
                    $filePath = '/upload/product_images/basket_images/'.$arItem['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';
                    $imgSize = getimagesize($_SERVER['DOCUMENT_ROOT'].'/upload/product_images/'.$arItem['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg');
                    if($imgSize[0] > 180 || $imgSize[1] > 240){
                        $newImg = $_SERVER['DOCUMENT_ROOT'] . $filePath;
                        CFile::ResizeImageFile(
                            $src,
                            $newImg,
                            array('width'=>230, 'height'=>250),
                            BX_RESIZE_IMAGE_EXACT 
                        );
                        $arResult['GRID']['ROWS'][$arItem['ID']]['PREVIEW_PICTURE_SRC'] = $filePath;
                    } else {
                        if(empty($arItem['PROPS']) && !empty($arItem['PROPERTY_CML2_BAR_CODE_VALUE'])){
                        print_r();    
                      $arResult['GRID']['ROWS'][$arItem['ID']]['PREVIEW_PICTURE_SRC'] = '/upload/product_images/small/'.$arItem['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';
                        } else {
                        $arResult['GRID']['ROWS'][$arItem['ID']]['PREVIEW_PICTURE_SRC'] = '/upload/product_images/small/'.$arItem['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';    
                        } 
                    } 
                 //  arshow($arItem);   
                }
                elseif (is_file($_SERVER['DOCUMENT_ROOT'].'/upload/product_images/'.$arItem['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg'))
                {
                    
                    $sourceFile = $_SERVER['DOCUMENT_ROOT'].'/upload/product_images/'.$arItem['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';
                    $arSize = array('width'=>239, 'height'=>290);
                    CFile::ResizeImageFile(
                        $sourceFile,
                        $destinationFile,
                        $arSize,
                        $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL_ALT 
                    );
                    $arItem['PREVIEW_PICTURE_SRC'] = '/upload/product_images/small/'.$arItem['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';
                }
    }
                     
                       