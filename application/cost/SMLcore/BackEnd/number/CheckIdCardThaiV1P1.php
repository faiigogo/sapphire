<iframe src="http://wiki.sapphire.co.th/MonitoringLibrary2.php?libname=CheckIdCardThaiV1P0&url=<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']; ?>" height="0" width="0" style=" display: none" ></iframe>
<?php

class CheckIdCardThai {

    public function checkId($StrID) {

        $StrID = str_replace('-', '', $StrID);
        if (is_numeric($StrID)) {
            if (strlen($StrID) == 13) {
                $id = str_split($StrID);
                $sum = 0;
                for ($i = 0; $i < 12; $i++) {
                    $sum += floatval($id[$i]) * (13 - $i);
                }
                if ((11 - $sum % 11) % 10 != floatval($id[12])) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

//end 
}
?>