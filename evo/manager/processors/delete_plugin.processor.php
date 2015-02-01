<?php
if(!defined('IN_MANAGER_MODE') || IN_MANAGER_MODE != 'true') exit();

if(!$modx->hasPermission('delete_plugin')) {
	$e->setError(3);
	$e->dumpError();
}

$id=intval($_GET['id']);

// invoke OnBeforePluginFormDelete event
$modx->invokeEvent('OnBeforePluginFormDelete',
						array(
							'id' => $id
						));

// delete the plugin.
$rs = $modx->db->delete('[+prefix+]site_plugins',"id='{$id}'");
if(!$rs)
{
	echo "Something went wrong while trying to delete the plugin...";
	exit;
}
else
{
	// delete the plugin events.
	$rs = $modx->db->delete('[+prefix+]site_plugin_events',"pluginid='{$id}'");
	if(!$rs)
	{
		echo "Something went wrong while trying to delete the plugin events...";
		exit;
	}
	else
	{
		// invoke OnPluginFormDelete event
		$modx->invokeEvent('OnPluginFormDelete',
								array(
									'id' => $id
								));
		// empty cache
		$modx->clearCache();
		header('Location: index.php?a=76');
	}
}
