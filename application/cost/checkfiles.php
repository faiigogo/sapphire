<?php


include ("cost/function.php");

$sapphire_files  = readFiles('../cost/attach');
$gnis_files  = readFiles('../cost_gnis/attach');

foreach($gnis_files as $k=>$filename){
	if (in_array($filename, $sapphire_files)) {
    	echo $filename."<br/>";
	}
}

?>
 