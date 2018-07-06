<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);
foreach($arResult['JS_DATA']['GRID']['ROWS'] as $elementInbasket){
        $_POST['ELEMENT_QUANTITY'] = $elementInbasket['data']['QUANTITY'];
       /* for($i=0; $i <= $elementInbasket['data']['QUANTITY']; $i++ ){   */
        $getIDbasketItems[] = $elementInbasket['data']['PRODUCT_ID'];
        $_REQUEST['ELEMENT_ID_BASKET'] = $getIDbasketItems;
       /* }  */    
      }
      $_POST['ELEMENT_ID'] = $getIDbasketItems;
     //ARSHOW($component);