!/usr/bin/php 
<?php 
  /** 
  This utility uninstalls a module from the command line, 
  without using the web interface. 
   */ 

// Set this to your root Sugar directory
$sugar_dir = "/var/www/path/to/sugar"; 

echo "\nSugar path is set to: $sugar_dir\n"; 

//go to the top of the sugar directory 
chdir($sugar_dir); 

//make sure we dump the stuff to stderr 
ini_set("error_log","php://stderr"); 

//initialize 
if(!defined('sugarEntry'))  define('sugarEntry', true); 
require_once('include/entryPoint.php'); 
require_once('ModuleInstall/PackageManager/PackageManager.php');
require_once('modules/Administration/UpgradeHistory.php');
$current_user = new User(); 
$current_user->is_admin = '1'; 

//initialize the module installer 
$pkgManager = new PackageManager(); 
$upgradeHistory = new UpgradeHistory();

//Grab all installed modules
$uhs = $upgradeHistory->GetAll();

$i = 1;
foreach($uhs as $uh) {
    echo "$i: " . $uh->name . PHP_EOL;
    $i++;
}

$visIndex = ($i == 1 ? 1 : $i-1);
echo "Uninstall which (1-$visIndex, 0 to cancel)? ";

$sel = fgets(STDIN);
$sel = (int)$sel;

if($sel >= 1 && $sel <= $visIndex) {
    echo "\nUninstalling " . $uhs[$sel-1]->name . "...";
    $pkgManager->performUninstall($uhs[$sel-1]->id_name);
} else {
    echo "\nCancelling.\n";
}

echo "\nDone.\n";

?>
