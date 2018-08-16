<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<div class="form-wr" style="padding: 0;">
		<form method="post" id="one_click_buy_form" action="<?=$arResult['SCRIPT_PATH']?>/script.php">
			<?foreach($arParams['PROPERTIES'] as $field):
				$class.="inputtext";
                ?>
				<div class="form-control bg">
					<label class="description">
						<?if($field == "COMMENT"):?>
							<?=GetMessage('CAPTION_'.$field)?>
						<?else:?>
							<?=GetMessage('CAPTION_'.$field)?>
						<?endif;?>
						<?if (in_array($field, $arParams['REQUIRED'])):?><span class="star">*</span><?endif;?>
					</label>
					<?if($field=="PHONE"){
						$class.=" phone";
					}?>
					<?if($field=="COMMENT"):?>
						<textarea name="ONE_CLICK_BUY[<?=$field?>]" id="one_click_buy_id_<?=$field?>" class="<?=$class;?>"></textarea>
					<?else:?>
						<input type="<?=($field=="EMAIL" ? "email" : ($field=="PHONE" ? "tel" : "text"));?>" name="ONE_CLICK_BUY[<?=$field?>]" value="<?=$value?>" class="<?=$class;?>" id="one_click_buy_id_<?=$field?>" />
					<?endif;?>
				</div>
			<?endforeach;?>
			<?if(COption::GetOptionString("aspro.optimus", "SHOW_LICENCE", "N") == "Y"):?>
				<div class="form">
					<div class="licence_block filter label_block">
						<input type="checkbox" id="licenses_popup_OCB" <?=(COption::GetOptionString("aspro.optimus", "LICENCE_CHECKED", "N") == "Y" ? "checked" : "");?> name="licenses_popup_OCB" required value="Y">
						<label for="licenses_popup_OCB" class="license">
							<?$APPLICATION->IncludeFile(SITE_DIR."include/licenses_text.php", Array(), Array("MODE" => "html", "NAME" => "LICENSES")); ?>
						</label>
					</div>
				</div>
			<?endif;?>
			<div class="but-r clearfix">
				<!--noindex-->
					<?if($arParams['SHOW_DELIVERY_NOTE'] === 'Y'):?>
						<div class="delivery_note">
							<a  href="javascript:;" class="title"><?=GetMessage('DELIVERY_NOTE_TITLE')?></a>
							<div class="text hidden"><?$APPLICATION->IncludeFile(SITE_DIR."include/oneclick_delivery_text.php", Array(), Array("MODE" => "html"));?></div>
						</div>
					<?endif;?>
					<button class="button short form_basket_button" type="submit" id="one_click_buy_form_button" name="one_click_buy_form_button" value="<?=GetMessage('ORDER_BUTTON_CAPTION')?>"><span><?=GetMessage("ORDER_BUTTON_CAPTION")?></span></button>
				<!--/noindex-->
			</div>
			<?if(strlen($arParams['OFFER_PROPERTIES'])):?>
				<input type="hidden" name="OFFER_PROPERTIES" value="<?=$arParams['OFFER_PROPERTIES']?>" />
			<?endif;?>
			<?if(intVal($arParams['IBLOCK_ID'])):?>
				<input type="hidden" name="IBLOCK_ID" value="<?=intVal($arParams['IBLOCK_ID']);?>" />
			<?endif;?>
			<?if(intVal($arParams['ELEMENT_ID'])):?>
				<input type="hidden" name="ELEMENT_ID" value="<?=intVal($arParams['ELEMENT_ID']);?>" />
			<?endif;?>
			<?if((float)($arParams['ELEMENT_QUANTITY'])):?>
				<input type="hidden" name="ELEMENT_QUANTITY" value="<?=(float)($arParams['ELEMENT_QUANTITY']);?>" />
			<?endif;?>
			<?if($arParams['BUY_ALL_BASKET']=="Y"):?>
				<input type="hidden" name="BUY_TYPE" value="ALL" />
			<?endif;?>
			<input type="hidden" name="CURRENCY" value="<?=$arParams['DEFAULT_CURRENCY']?>" />
			<input type="hidden" name="SITE_ID" value="<?=SITE_ID;?>" />
			<input type="hidden" name="PROPERTIES" value='<?=serialize($arParams['PROPERTIES'])?>' />
			<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arParams['DEFAULT_PAYMENT'];?>" />
			<input type="hidden" name="DELIVERY_ID" value="<?=$arParams['DEFAULT_DELIVERY']?>" />
            <input type="hidden" name="PERSON_TYPE_ID" value="<?=$arParams['DEFAULT_PERSON_TYPE']?>" />
            <input type="hidden" name="ELEMENT_ID" value="<?=serialize($arParams['~ELEMENT_ID'])?>" />
			<?=bitrix_sessid_post()?>
		</form>
        
		<div class="one_click_buy_result" id="">
			<div class="one_click_buy_result_success"><?=GetMessage('ORDER_SUCCESS')?></div>
			<div class="one_click_buy_result_fail"><?=GetMessage('ORDER_ERROR')?></div>
            <div class="one_click_buy_result_text"><?=GetMessage('ORDER_SUCCESS_TEXT')?></div>
			<div class="one_click_buy_result_text"><?=GetMessage('ORDER_SUCCESS_TEXT2')?><a href="<?=$_SERVER['SERVER_NAME']?>/personal/"><?=GetMessage('CLICK_HERE')?></a></div>
		</div>
	</div>

    
<script>
$('#one_click_buy_form').on("submit", function(){
                if($('#one_click_buy_form').valid()){
                    if($('.'+name+'_frame form input.error').length || $('.'+name+'_frame form textarea.error').length) {
                        return false
                    }
                    else if(!$(this).find('#one_click_buy_form_button').hasClass('clicked')){
                        if(!$(this).find('#one_click_buy_form_button').hasClass("clicked"))
                            $(this).find('#one_click_buy_form_button').addClass("clicked");
                        $.ajax({
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            type: 'POST',
                            dataType: 'json',
                            error: function(data) {
                                window.console&&console.log(data);
                            },
                            success: function(data) {
                                if(data.result == 'Y') {
                                    if(arOptimusOptions['COUNTERS']['USE_FASTORDER_GOALS'] !== 'N'){
                                        var eventdata = {goal: 'goal_fastorder_success'};
                                        BX.onCustomEvent('onCounterGoals', [eventdata])
                                    }
                                    $('#bx-soa-order-form').hide();
                                    $('.one_click_buy_result').show();
                                    $('.one_click_buy_result_success').show();
                                    setTimeout(function(){
                                        var url = window.location.href
                                        var url_arr = url.split("/");
                                        var result_url = url_arr[0] + "//" + url_arr[2]  + "/personal/";
                                        document.location.href = result_url;
                                    } , 5000);
                                    
                                    purchaseCounter(data.message, arOptimusOptions["COUNTERS"]["TYPE"]["QUICK_ORDER"]);
                                }
                                else{
                                    $('.one_click_buy_result').show();
                                    $('.one_click_buy_result_fail').show();
                                    if(('err' in data) && data.err)
                                        data.message=data.message+' \n'+data.err;
                                    $('.one_click_buy_result_text').text(data.message);
                                }
                                $('.one_click_buy_modules_button', self).removeClass('disabled');
                                $('#one_click_buy_form').hide();
                                $('#one_click_buy_form_result').show();
                            }
                        });
                    }
                }
                return false;
            });
</script>    
<script type="text/javascript">
$('#one_click_buy_form').validate({
	rules: {
	"ONE_CLICK_BUY['EMAIL']": {email : true},
		<?
		foreach($arParams['REQUIRED'] as $key => $value){
			echo '"ONE_CLICK_BUY['.$value.']": {required : true}';
			if($arParams['REQUIRED'][$key + 1]){
				echo ',';
			}
		}
		?>
	},
	highlight: function( element ){
		$(element).removeClass('error');
	},
	errorPlacement: function( error, element ){
		error.insertBefore(element);
	},
	messages:{
      licenses_popup_OCB: {
        required : BX.message('JS_REQUIRED_LICENSES')
      }
	}
});

$(document).ready(function(){
	$('#one_click_buy_form .delivery_note .title').on('click', function(e){
		e.preventDefault();
		$(this).addClass('hidden');
		$(this).closest('.delivery_note').find('.text').removeClass('hidden');
	});

	$('#one_click_buy_form .delivery_note .text a').on('click', function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		if(typeof href !== 'undefined' && href.length){
			window.open(href, '_blank');
		}
	});

<?if($arParams['BUY_ALL_BASKET'] == "Y"):?>
	if(arOptimusOptions['COUNTERS']['USE_FASTORDER_GOALS'] !== 'N'){
		var eventdata = {goal: 'goal_fastorder_begin'};
		BX.onCustomEvent('onCounterGoals', [eventdata])
	}
<?else:?>
	if(arOptimusOptions['COUNTERS']['USE_1CLICK_GOALS'] !== 'N'){
		var eventdata = {goal: 'goal_1click_begin'};
		BX.onCustomEvent('onCounterGoals', [eventdata])
	}
<?endif;?>
});

$('.popup').jqmAddClose('.jqmClose');

if(arOptimusOptions['THEME']['PHONE_MASK']){
	$('#one_click_buy_id_PHONE').inputmask( "mask", { "mask": arOptimusOptions['THEME']['PHONE_MASK'], "showMaskOnFocus": false } );
}
</script>