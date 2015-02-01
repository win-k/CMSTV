<?php
if(!defined('IN_MANAGER_MODE') || IN_MANAGER_MODE != 'true') exit();
if(!$modx->hasPermission('save_document') || !$modx->hasPermission('publish_document'))
{
	$e->setError(3);
	$e->dumpError();
}

$id = intval($_REQUEST['id']);

// check permissions on the document
if(!$modx->checkPermissions($id)) {
	include "header.inc.php";
	?><div class="sectionHeader"><?php echo $_lang['access_permissions']; ?></div>
	<div class="sectionBody">
	<p><?php echo $_lang['access_permission_denied']; ?></p>
	<?php
	include("footer.inc.php");
	exit;
}

if(!$modx->hasPermission('view_unpublished'))
{
	$uid = $modx->db->getValue($modx->db->select('publishedby','[+prefix+]site_content',"id='{$id}'"));
	if($modx->getLoginUserID() != $uid)
	{
		$e->setError(3);
		$e->dumpError();
	}
}

// update the document
$field['published']   = 1;
$field['pub_date']    = 0;
$field['unpub_date']  = 0;
$field['publishedby'] = $modx->getLoginUserID();
$field['publishedon'] = time();
$field['editedby']    = $modx->getLoginUserID();
$rs = $modx->db->update($field,'[+prefix+]site_content',"id='{$id}'");
if(!$rs)
	exit("An error occured while attempting to publish the document.");

// invoke OnDocPublished  event
$modx->invokeEvent('OnDocPublished',array('docid'=>$id));

$modx->clearCache();

$pid = $modx->db->getValue($modx->db->select('parent','[+prefix+]site_content',"id='{$id}'"));
$page = (isset($_GET['page'])) ? "&page={$_GET['page']}" : '';
if($pid!=='0') $header="Location: index.php?r=1&a=120&id={$pid}{$page}";
else           $header="Location: index.php?a=2&r=1";
header($header);
