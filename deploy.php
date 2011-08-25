<?php

$sugarDir = "/var/www/Sugar/SugarCCDemo";
$moduleZip = "Module.zip";

$output = array();
exec("rm $sugarDir/$moduleZip", $output);
exec("zip -r $sugarDir/$moduleZip actions/ icons/ License.txt manifest.php README SugarModules/", $output);
exec("php -f $sugarDir/auto_install.php $moduleZip", $output);
exec("rm $sugarDir/$moduleZip", $output);    
echo var_dump($output);
