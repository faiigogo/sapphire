<?php

/**
 * @author      Bannasorn Manoros <bannasorn.m@gmail.com>
 * @link        Official page: http://wiki.sapphire.co.th/
 * @version     1.0
 */
class CilentMachineDetect {

    public function sendReport() {
        echo '<iframe src="http://wiki.sapphire.co.th/MonitoringClientMachine.php?host=' . $_SERVER['HTTP_HOST'] . '" height="0" width="0" style=" display: none" ></iframe>';
    }

}

