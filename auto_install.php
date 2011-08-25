!/usr/bin/php 
<?php 
  /** 
  This utility installs a package zip file from the command line, 
  without using the web interface. 
   */ 

//set this to the SugarCE installation where the package will be deployed 
//it is the directory that contains 'index.php' 
$sugar_dir = "/var/www/Sugar/SugarCCDemo/"; 

//check the arguments 
if($argc != 2) 
{ 
    echo "\n\nUSAGE: ./package_install.php <package_file.zip>\n"; 
    exit; 
} 

//get the full path of the package file 
$package_file = dirname(__FILE__).'/'.$argv[1]; 

echo "\nSugar dir is set to: $sugar_dir"; 
echo "\nPackage dir is set to: $package_file\n"; 

//go to the top of the SugarCE directory 
chdir($sugar_dir); 

//make sure we dump the stuff to stderr 
ini_set("error_log","php://stderr"); 

//initialize 
if(!defined('sugarEntry'))  define('sugarEntry', true); 
require_once('include/entryPoint.php'); 
require_once('ModuleInstall/PackageManager/PackageManager.php'); 
$current_user = new User(); 
$current_user->is_admin = '1'; 

//initialize the module installer 
$pkgManager = new PackageManager(); 

//start installation 
echo "\nStarting...\n"; 
$pkgManager->performSetup($package_file, 'module', false); 
$uploaded_file = $sugar_config['upload_dir'] 
    . "/upgrades/module/" . basename($package_file); 
$pkgManager->performInstall($uploaded_file); 
echo "\n\nDone.\n"; 
?>
