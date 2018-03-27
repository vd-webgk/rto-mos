<?
      function logger($data, $file) {
        file_put_contents(
            $file,
            var_export($data, 1)."\n",
            FILE_APPEND
        );
    }
    function arshow($array, $adminCheck = false){
        global $USER;
        $USER = new Cuser;
        if ($adminCheck) {
            if (!$USER->IsAdmin()) {
                return false;
            }
        }
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
?>