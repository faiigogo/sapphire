<?php

/**
 * SMLcore Version 1.5
 *
 * @copyright     Copyright (c) Sapphire Research and Development Co, Ltd. (http://www.sapphire.co.th)
 * @link          http://wiki.sapphire.co.th/ Sapphire Wiki Project
 * @package       Core
 * @since         SMLcore(tm) v 1.2
 * @license       @todo waiting
 */
// include file when call new class
function __autoload($classname) {
    $SMLpath = '';
    if ($classname == 'CheckIdCardThai') {
        $SMLpath = '/BackEnd/number/' . $classname . "V1P1.php";
    } else if ($classname == 'ZipFile') {
        $SMLpath = '/BackEnd/folderAndFile/' . $classname . "V1P0.php";
    } else if ($classname == 'BrowserDetect') {
        $SMLpath = '/BackEnd/utilities/' . $classname . "V1P0.php";
    } else if ($classname == 'MobileDetect') {
        $SMLpath = '/BackEnd/utilities/' . $classname . ".php";
    } else if ($classname == 'NumberFormatThai') {
        $SMLpath = '/BackEnd/number/' . $classname . "V1P0.php";
    } else if ($classname == 'DateFormatThai') {
        $SMLpath = '/BackEnd/dateAndTime/' . $classname . "V1P0.php";
    } else if ($classname == 'CilentMachineDetect') {
        $SMLpath = '/BackEnd/utilities/' . $classname . "V1P1.php";
    }
    require_once(__DIR__ . $SMLpath);
}

?>
