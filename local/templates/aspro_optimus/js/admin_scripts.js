$(document).on('ready', function(){    
    //добавление кнопки для сброса пароля пользователя на странице редактирования пользователя
    var url = document.location.href;
    if (url.indexOf("bitrix/admin/user_edit.php")) {
        $('input[name="user_info_event"]').hide();
        $('#tr_user_info_event .adm-designed-checkbox-label').hide();
        var addMailSelect = '<tr><td><select name="sendMailTemplate" class="selectMail"><option value="empty"></option><option value="temp">Временный доступ</option><option value="reg">Постоянный доступ</option><option value="denied">Регистрация невозможна</option></select></tr></td>';
        $("#tr_user_info_event").after(addMailSelect);
        $('select.selectMail').on('change', function(){
            var selectedOpt = $('select.selectMail option:selected').val();    
        })
       
    }
});