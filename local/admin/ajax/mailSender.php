<?require ($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php');         
    use Bitrix\Main\Mail\Event;
    global $USER;

    $user_id = intval($_POST["user_id"]);

    if ($_POST["action"] == "mailSender" && $_POST['selectedOpt']  && !empty($user_id) && substr_count($_SERVER["HTTP_REFERER"], "bitrix/admin/user_edit.php") > 0 && $USER->IsAuthorized()){
        $user = CUser::GetList($by = "ID", $sort = "ASC", array("ID" => $user_id))->Fetch();
        $user->Update($ID, $fields);
        /*if($user['ID']){
            if($_POST['selectedOpt'] == 'temp'){
                if(Event::send(array(
                        "EVENT_NAME" => "USER_INFO",
                        "LID" => "s1",
                        "C_FIELDS" => array(
                            "EMAIL" => "vd@webgk.ru",
                            "NAME" => $user['NAME'],
                            
                        ),
                        "DUPLICATE" => 'N',
                        "MESSAGE_ID" => 94, 
                ))){
                    $result = "success";
                } else {
                    $result = "nope";   
                }
            }
        } */
    echo $result;   

}