<?php
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 *
 * File Name: connector.php
 * 	Main connector file, implements the State Pattern to 
 * 	redirect requests to the appropriate class based on 
 * 	the command name passed.
 * 
 * File Authors:
 * 		Grant French (grant@mcpuk.net)
 */
//Errors in the config.php could still cause problems.

define('IN_MANAGER_MODE', 'true');
define('MODX_API_MODE', true);
$self = 'manager/media/browser/mcpuk/connectors/php/connector.php';
$base_path = str_replace($self,'',str_replace('\\','/',__FILE__));
include_once("{$base_path}index.php");
if(!isset($_SESSION['mgrValidated'])) {
	if(!isset($_SESSION['webValidated'])){
		die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODX Content Manager instead of accessing this file directly.");
	}
}
$mcpuk_path = "{$base_path}manager/media/browser/mcpuk/";

$modx->db->connect();

global $fckphp_config;
include_once("{$mcpuk_path}connectors/php/config.php");

outputHeaders();
//These are the commands we may expect
$valid_commands=$fckphp_config['Commands'];
$valid_resource_types=$fckphp_config['ResourceTypes'];

//Get the passed data
$command = (isset($_GET['Command']) && $_GET['Command']!='')             ? $_GET['Command']       : '' ;
$type    = (isset($_GET['Type']) && $_GET['Type']!='')                   ? $_GET['Type']          : 'files';
$type    = strtolower($type);
$cwd     = (isset($_GET['CurrentFolder']) && $_GET['CurrentFolder']!='') ? $_GET['CurrentFolder'] : '/';
$cwd     = str_replace('..', '', $cwd);
$extra   = (isset($_GET['ExtraParams']) && $_GET['ExtraParams']!='')     ? $_GET['ExtraParams']   : '';

if ($fckphp_config['Debug']===true)
{
	$msg  = '$command=' . "{$command}\n";
	$msg .= '$type='    . $type . "\n";
	$msg .= '$cwd='     . $cwd . "\n";
	$msg .= '$extra='   . $extra . "\n";
	$msg .= '$_GET='      . print_r($_GET,true) . "\n";
	$msg .= '$_POST='     . print_r($_POST,true) . "\n";
	$msg .= '$_SERVER='   . print_r($_SERVER,true) . "\n";
	$msg .= '$_SESSIONS=' . print_r($_SESSION,true) . "\n";
	$msg .= '$_COOKIE='   . print_r($_COOKIE,true) . "\n";
	$msg .= '$_FILES='    . print_r($_FILES,true) . "\n";
	
	$msg = htmlspecialchars($msg,ENT_QUOTES,$modx->config['modx_charset']);
	$msg = str_replace(' ', '&nbsp;',$msg);
	$msg = nl2br($msg);
	
	$modx->logEvent(0,1,$msg,'mcpuk connector');
}

if (in_array($command,$valid_commands))
{
	//bit of validation
	if (!in_array($type,$valid_resource_types))
	{
		$modx->logEvent(0,3,'Invalid resource type.');
		exit(0);
	}
	
	$rs = include_once("{$mcpuk_path}connectors/php/Commands/{$command}.php");

	$action=new $command($fckphp_config,$type,$cwd);
	$action->run();
}
else
{
	$modx->logEvent(0,3,'Invalid command.(No reason for me to be here)');
	exit(0);
}

function outputHeaders() {

	//Anti browser caching headers
	//Borrowed from fatboy's implementation  (fatFCK@code247.com)
	
	// ensure file is never cached
	// Date in the past
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	
	// always modified
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	
	// HTTP/1.1
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	
	// HTTP/1.0
	header("Pragma: no-cache");
}
