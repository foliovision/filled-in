<?php
/*
Plugin Name: Filled In
Plugin URI: http://urbangiraffe.com/plugins/filled-in/
Description: Generic form processor allowing forms to be painlessly processed and aggregated, with numerous options to validate data and perform custom commands
Author: John Godley
Version: 1.9.3
Author URI: http://urbangiraffe.com/
License: GPL-3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.txt
*/

include (dirname (__FILE__).'/plugin.php');
include (dirname (__FILE__).'/models/form.php');

global $fi_globals;
$fi_globals = array ();

// And the shortest plugin award goes to...
if (is_admin ())
	include (dirname (__FILE__).'/controller/admin.php');
else
	include (dirname (__FILE__).'/controller/front.php');

//Cron actions
include (dirname (__FILE__).'/controller/cron.php');