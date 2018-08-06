<?
	if (is_array($arResult["GRID"]["ROWS"]))
	{
		usort($arResult["GRID"]["ROWS"], 'COptimus::cmpByID');
		$arImages = array();
		foreach($arResult["GRID"]["ROWS"] as $key=>$arItem)
		{
			// fix bitrix measure bug
			if(!isset($arItem["MEASURE"]) && !isset($arItem["MEASURE_RATIO"]) && strlen($arItem["MEASURE_TEXT"])){
				$arResult["GRID"]["ROWS"][$key]["MEASURE_RATIO"] = 1;
			} 
			
			//fix image size
			if (isset($arItem["PREVIEW_PICTURE"]) && intval($arItem["PREVIEW_PICTURE"]) > 0)
			{	
				$arImage = CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
				if ($arImage)
				{
					$arFileTmp = CFile::ResizeImageGet( $arImage, array("width" => $arParams["PICTURE_WIDTH"], "height" =>$arParams["PICTURE_HEIGHT"]), BX_RESIZE_IMAGE_PROPORTIONAL, true);
					$picture = array();
					foreach($arFileTmp as $name => $value) { $picture[strToUpper($name)] = $value; }
					$arResult["GRID"]["ROWS"][$key]["PREVIEW_PICTURE"]  = $picture;
				}
			}

			if (isset($arItem["DETAIL_PICTURE"]) && intval($arItem["DETAIL_PICTURE"]) > 0)
			{
				$arImage = CFile::GetFileArray($arItem["DETAIL_PICTURE"]);
				if ($arImage)
				{
					$arFileTmp = CFile::ResizeImageGet($arImage, array("width" => $arParams["PICTURE_WIDTH"], "height" =>$arParams["PICTURE_HEIGHT"]), BX_RESIZE_IMAGE_PROPORTIONAL, true);
					$picture = array();
					foreach($arFileTmp as $name => $value) { $picture[strToUpper($name)] = $value; }
					$arResult["GRID"]["ROWS"][$key]["DETAIL_PICTURE"]  = $picture;
				}
			}
			if(strpos($arItem["PRODUCT_XML_ID"], "#")!==false){
				$arXmlID=explode("#", $arItem["PRODUCT_XML_ID"]);
				$arItem1 =COptimusCache::CIBLockElement_GetList(array('CACHE' => array("MULTI"=>"N", "TAG" => COptimusCache::GetIBlockCacheTag($arItem["IBLOCK_ID"]))), array("IBLOCK_ID" => $arItem["IBLOCK_ID"], "ACTIVE"=>"Y", "ACTIVE_DATE" => "Y", "XML_ID" => $arXmlID[0]), false, false, array("ID", "IBLOCK_ID"));
				$arResult["GRID"]["ROWS"][$key]["IBLOCK_ID"]=$arItem1["IBLOCK_ID"];
				$arResult["ITEMS_IBLOCK_ID"]=$arItem1["IBLOCK_ID"];
			}
        
                      
		}
        
		foreach($arResult["GRID"]["ROWS"] as $key=>$arItem)
		{
			if ($arImages[$key]["PREVIEW_PICTURE"]) {$arResult["GRID"]["ROWS"][$key]["PREVIEW_PICTURE"] = $arImages[$key]["PREVIEW_PICTURE"];}
			if ($arImages[$key]["DETAIL_PICTURE"]) {$arResult["GRID"]["ROWS"][$key]["DETAIL_PICTURE"] = $arImages[$key]["DETAIL_PICTURE"];}
			$symb = substr($arItem["PRICE_FORMATED"], strrpos($arItem["PRICE_FORMATED"], ' '));
			//if((int)$symb){
				$arResult["GRID"]["ROWS"][$key]["SUMM_FORMATED"]=$arItem["SUM"];
			/*}else{
				$arResult["GRID"]["ROWS"][$key]["SUMM_FORMATED"] = str_replace($symb, "", FormatCurrency($arItem["PRICE"]*$arItem["QUANTITY"], $arItem["CURRENCY"])).$symb;
			}*/
		}
		unset($arImages);
		
		$isPrice = false;
		$priceIndex = 0;
		foreach($arResult["GRID"]["HEADERS"] as $key => $arHeader)
		{
			if($arHeader["id"]=="PRICE") 
			{
				$isPrice = true; 
				$priceIndex = $key;
			}
		}
		
		foreach($arResult["GRID"]["HEADERS"] as $key => $arHeader)
		{
				if ($arHeader["id"]=="QUANTITY" && $isPrice && $priceIndex)
				{
					$arResult["GRID"]["HEADERS"] = array_merge(	array_slice($arResult["GRID"]["HEADERS"], 0, $priceIndex), 
								array(array("id"=>"SUMM", "name"=>"")), 
								array_slice($arResult["GRID"]["HEADERS"], $priceIndex, count($arResult["GRID"]["HEADERS"]))
							);
				}
		}
					
		foreach($arResult["GRID"]["HEADERS"] as $key => $arHeader)
		{
			switch($arHeader["id"])
			{
				case "DELETE": $arResult["GRID"]["HEADERS"][$key]["SORT"] = 100; break;	
				case "NAME": $arResult["GRID"]["HEADERS"][$key]["SORT"] = 200; break;	
				case "DISCOUNT": $arResult["GRID"]["HEADERS"][$key]["SORT"] = 300; break;		
				case "PROPS": $arResult["GRID"]["HEADERS"][$key]["SORT"] = 400; break;
				case "WEIGHT": $arResult["GRID"]["HEADERS"][$key]["SORT"] = 500; break;
				case "PRICE": $arResult["GRID"]["HEADERS"][$key]["SORT"] = 600; break;
				case "QUANTITY": $arResult["GRID"]["HEADERS"][$key]["SORT"] = 700; break;
				case "SUMM": $arResult["GRID"]["HEADERS"][$key]["SORT"] = 800; break;
				case "DELAY": $arResult["GRID"]["HEADERS"][$key]["SORT"] = 1000; break;
				default :  $arResult["GRID"]["HEADERS"][$key]["SORT"] = 900; break;
			}
		}
		usort($arResult["GRID"]["HEADERS"], 'COptimus::cmpBySort');
		
		
		$arNormal = array();
		$arDelay = array();
		$arSubscribe = array();
		$arNa = array();	
		$arTotals = array();
		$arResult["DELAY_PRICE"]["SUMM"]=0;
			
		foreach ($arResult["GRID"]["ROWS"] as $k => $arItem)
		{
			if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y")
			{
				$arNormal[$arItem["ID"]] = $arItem;  
			}
			if ($arItem["DELAY"] == "Y" && $arItem["CAN_BUY"] == "Y")
			{
				$arDelay[$arItem["ID"]] = $arItem;
				$arResult["DELAY_PRICE"]["SUMM"]+=$arItem["PRICE"];
				
			}
			if ($arItem["CAN_BUY"] == "N" && $arItem["SUBSCRIBE"] == "Y")
			{
				$arSubscribe[$arItem["ID"]] = $arItem;
			}
			if (isset($arItem["NOT_AVAILABLE"]) && $arItem["NOT_AVAILABLE"] == true)
			{
				$arNa[$arItem["ID"]] = $arItem;
			}
          // arshow($arResult)  ;
            $db_props = CIBlockElement::GetList(array(), array("ID" => $arItem['PRODUCT_ID']), false, false, Array('PROPERTY_CML2_BAR_CODE'));
                                        if($ar_props = $db_props->fetch()){
                                            $propsss = $ar_props;
                                          // $arItem['PROPERTIES'][0]['VALUE'] = $propsss['PROPERTY_CML2_BAR_CODE_VALUE']; 
                                          // arshow($propsss);                                 
                                        
          //  if($arItem['PROPERTIES'][0]['CODE'] == "CML2_BAR_CODE" && $arItem['PROPERTIES'][0]['VALUE'] > 0) {
                    //debug($arItem['PROPERTIES']['CML2_BAR_CODE']);die();
                    $destinationFile = $_SERVER['DOCUMENT_ROOT'].'/upload/product_images/small/'.$propsss['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';
                    if(is_file($destinationFile))
                    {
                       $arItem['PREVIEW_PICTURE']['SRC'] = '/upload/product_images/small/'.$propsss['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';;
                    }
                    elseif (is_file($_SERVER['DOCUMENT_ROOT'].'/upload/product_images/'.$propsss['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg'))
                    {
                        $sourceFile = $_SERVER['DOCUMENT_ROOT'].'/upload/product_images/'.$propsss['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';
                        $imgSize = getimagesize($_SERVER['DOCUMENT_ROOT'].'/upload/product_images/'.$propsss['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg');
                   // arshow($imgSize);
                    if($imgSize[0] > 180 || $imgSize[1] > 240){
                        $newImg = $_SERVER['DOCUMENT_ROOT'] . $filePath;
                        CFile::ResizeImageFile(
                            $src,
                            $newImg,
                            array('width'=>230, 'height'=>250),
                            BX_RESIZE_IMAGE_EXACT 
                        );
                        $arItem['PREVIEW_PICTURE']['SRC'] = $filePath;
                    } else {
                       $arItem['PREVIEW_PICTURE']['SRC'] = '/upload/product_images/small/'.$propsss['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg';
                        $arItem['DETAIL_PICTURE']['SRC'] = '/upload/product_images/small/'.$propsss['PROPERTY_CML2_BAR_CODE_VALUE'].'.jpg'; 
                    }    
                        
                    }
                    $arResult["GRID"]["ROWS"][$k] = $arItem;

            //}
                                        }
		}
		
        
		foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader)	{	if ($arHeader["id"] == "WEIGHT"){ $bWeightColumn = true;}	}
		 
		if ($bWeightColumn) { $arTotal["WEIGHT"]["NAME"] = GetMessage("SALE_TOTAL_WEIGHT"); $arTotal["WEIGHT"]["VALUE"] = $arResult["allWeight_FORMATED"];}
		if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") 
		{ 
			$arTotal["VAT_EXCLUDED"]["NAME"] = GetMessage("SALE_VAT_EXCLUDED"); $arTotal["VAT_EXCLUDED"]["VALUE"] = $arResult["allSum_wVAT_FORMATED"];
			$arTotal["VAT_INCLUDED"]["NAME"] = GetMessage("SALE_VAT_INCLUDED"); $arTotal["VAT_INCLUDED"]["VALUE"] = $arResult["allVATSum_FORMATED"];
		}
		if (doubleval($arResult["DISCOUNT_PRICE_ALL"]) > 0)
		{
			$arTotal["PRICE"]["NAME"] = GetMessage("SALE_TOTAL"); 
			$arTotal["PRICE"]["VALUES"]["ALL"] = str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"]);
			$arTotal["PRICE"]["VALUES"]["WITHOUT_DISCOUNT"] = $arResult["PRICE_WITHOUT_DISCOUNT"];
		}
		else
		{
			$arTotal["PRICE"]["NAME"] = GetMessage("SALE_TOTAL"); 
			$arTotal["PRICE"]["VALUES"]["ALL"] = $arResult["allSum_FORMATED"];
		}

		$arNormal["COUNT"] = count($arNormal);
		$arNormal["TOTAL"] = $arTotal;
		
		$arDelay["COUNT"] = count($arDelay);
		$arSubscribe["COUNT"] = count($arSubscribe);
		$arNa["COUNT"] = count($arNa);

		$arResult["DELAY_PRICE"]["SUMM_FORMATED"]=CCurrencyLang::CurrencyFormat($arResult["DELAY_PRICE"]["SUMM"], CSaleLang::GetLangCurrency(SITE_ID), true);
		
		$arJson = array();
		if ($arNormal["COUNT"]) { $arJson[]= array("AnDelCanBuy"=>$arNormal); }
		if ($arDelay["COUNT"]) { $arJson[]= array("DelDelCanBuy"=>$arDelay); }
		if ($arSubscribe["COUNT"]) { $arJson[]= array("ProdSubscribe"=>$arSubscribe); }
		if ($arNa["COUNT"]) { $arJson[]= array("nAnCanBuy"=>$arNa); }
		
		$arResult["JSON"] = $arJson;
	}
?>