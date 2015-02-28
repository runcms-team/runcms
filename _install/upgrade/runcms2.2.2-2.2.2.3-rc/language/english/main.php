<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

define("_UPGRADE_TITLE", "RUNCMS 2.2.2 -> RUNCMS 2.2.3.0 RC");

define("_UPGRADE_FOOTER","
<br /><br />
You must now log into your admin area, specifically your module administration and update ALL MODULES! <br /><br/>

<b>1.</b> Go to Module Admin and make the update of all your modules <br /> 
<b>2.</b> Go to administer / settings fill in the blank fields, then update of your settings.<br />
<b>3.</b> And finally: Now go to the setup of your rights and check that all rights are consistent with your wishes. If not so please correct them!<br />
<b>5.FINISHED! We wish you good luck with your new site :)</b><br /><br />
<br />
<a href='../user.php' 'target='_blank''><b><i>Login here!!</i></b></a><br /><br />");

define("_UPGRADE_SAVE_CONFIG", "Site configuration file successfully overwritten");
define("_UPGRADE_NO_SAVE_CONFIG", "Failed to overwrite the configuration file of the website");

define("_UPGRADE_SAVE_META", "Configuration file meta tag is successfully overwritten");
define("_UPGRADE_NO_SAVE_META", "Failed to overwrite the configuration file meta tags");

define("_UPGRADE_MODULE_UPDATE", "module \"%s\" updated");
define("_UPGRADE_NO_MODULE_UPDATE", "Failed to update the module \"%s\"");

define("_UPGRADE_CONGRAT", "Upgrade Complete! Be sure to delete the folder");

define("_UPGRADE_RMDIR", "Directory \"%s\" removed");
define("_UPGRADE_NO_RMDIR", "Unable to remove directory \"%s\"");


$message[0]['noerror'] = "Type the title field in the table stories was changed to VARCHAR (255)";
$message[0]['error'] = "Type the title field in the table stories was not changed to VARCHAR (255)";

$message[1]['noerror'] = "field type in the table topics topic_title was changed to VARCHAR (255)";
$message[1]['error'] = "field type in the table topics topic_title not been changed to VARCHAR (255)";

$message[2]['noerror'] = "Type the title field in the table nseccont was changed to VARCHAR (255)";
$message[2]['error'] = "Type the title field in the table nseccont not been changed to VARCHAR (255)";

$message[3]['noerror'] = "Field type in the table secname nsections was changed to VARCHAR (255)";
$message[3]['error'] = "Field type in the table secname nsections not been changed to VARCHAR (255)";

$message[4]['noerror'] = "The table session was deleted index PRIMARY";
$message[4]['error'] = "The table session has not been deleted index PRIMARY";

$message[5]['noerror'] = "Table cpsession created";
$message[5]['error'] = "Table cpsession not been created";

$message[6]['noerror'] = "Table login_log created";
$message[6]['error'] = "Table login_log not been created";

$message[7]['noerror'] = "The field type version in the table modules has been changed to VARCHAR (16) NOT NULL DEFAULT '1.0.0'";
$message[7]['error'] = "The field type version in the table modules has been changed to VARCHAR (16) NOT NULL DEFAULT '1.0.0'";

?>