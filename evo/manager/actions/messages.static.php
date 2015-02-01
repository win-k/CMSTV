<?php
if(!defined('IN_MANAGER_MODE') || IN_MANAGER_MODE != 'true') exit();
if(!$modx->hasPermission('messages')) {
    $e->setError(3);
    $e->dumpError();
}
if(isset($_REQUEST['id'])) $msgid = intval($_REQUEST['id']);
$uid = $modx->getLoginUserID();
?>
<h1><?php echo $_lang['messages_title']; ?></h1>
<?php
	$location = isset($_GET['id']) ? '10' : '2';
?>
<div id="actions">
  <ul class="actionButtons">
      <li id="Button5"><a href="#" onclick="documentDirty=false;document.location.href='index.php?a=<?php echo $location;?>';"><img alt="icons_cancel" src="<?php echo $_style["icons_cancel"] ?>" /> <?php echo $_lang['cancel']?></a></li>
  </ul>
</div>

<?php if(isset($msgid) && $_REQUEST['m']=='r') { ?>
<div class="section">
<div class="sectionHeader"><?php echo $_lang['messages_read_message']; ?></div>
<div class="sectionBody" id="lyr3">
<?php
$rs = $modx->db->select('*','[+prefix+]user_messages',"id='{$msgid}'");
$limit = $modx->db->getRecordCount($rs);
if($limit!=1) {
    echo "Wrong number of messages returned!";
} else {
    $message=$modx->db->getRow($rs);
    $message['subject'] = decrypt($message['subject']);
    $message['message'] = decrypt($message['message']);
    if($message['recipient']!=$uid) {
        echo $_lang['messages_not_allowed_to_read'];
    } else {
        // output message!
        // get the name of the sender
        $sender = $message['sender'];
        if($sender==0) {
            $sendername = $_lang['messages_system_user'];
        } else {
            $rs2 = $modx->db->select('username', '[+prefix+]manager_users', "id={$sender}");
            $row2 = $modx->db->getRow($rs2);
            $sendername = $row2['username'];
        }
?>
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2">
    <ul class="actionButtons">
        <li id="btn_reply"><a href="index.php?a=10&t=c&m=rp&id=<?php echo $message['id']; ?>"><img src="<?php echo $_style["icons_message_reply"] ?>" /> <?php echo $_lang['messages_reply']; ?></a></li>
        <li><a href="index.php?a=10&t=c&m=f&id=<?php echo $message['id']; ?>"><img src="<?php echo $_style["icons_message_forward"] ?>" /> <?php echo $_lang['messages_forward']; ?></a></li>
        <li><a href="index.php?a=65&id=<?php echo $message['id']; ?>"><img src="<?php echo $_style["icons_delete_document"] ?>" /> <?php echo $_lang['delete']; ?></a></li>
		<?php if($message['sender']==0) { ?>
			<script type="text/javascript">document.getElementById("btn_reply").className='disabled';</script>
		<?php } ?>
    </ul>
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="width: 120px;"><b><?php echo $_lang['messages_from']; ?>:</b></td>
    <td style="width: 480px;"><?php echo $sendername; ?></td>
  </tr>
  <tr>
    <td><b><?php echo $_lang['messages_sent']; ?>:</b></td>
    <td><?php echo $modx->toDateFormat($message['postdate']+$server_offset_time); ?></td>
  </tr>
  <tr>
    <td><b><?php echo $_lang['messages_subject']; ?>:</b></td>
    <td><?php echo $message['subject']; ?></td>
  </tr>
  <tr>
    <td colspan="2">
    <?php
    // format the message :)
    $message = str_replace ("\n", "<br />", $message['message']);
    $dashcount = substr_count($message, "-----");
    $message = str_replace ("-----", "<i style='color:#666;'>", $message);
    for( $i=0; $i<$dashcount; $i++ ){
    $message .= "</i>";
    }
    echo $message;
    ?>
    </td>
  </tr>
</table>
<?php
        // mark the message as read
        $rs = $modx->db->update('messageread=1', '[+prefix+]user_messages', "id='{$msgid}'");
    }
}
?>
    </div>
</div>
<?php } ?>


<div class="section">
<div class="sectionHeader"><?php echo $_lang['messages_inbox']; ?></div>
<div class="sectionBody">
<?php

// Get  number of rows
$rs=$modx->db->select('count(id)', '[+prefix+]user_messages', "recipient='{$uid}'");
$num_rows = $modx->db->getValue($rs);

// ==============================================================
// Exemple Usage
// Note: I make 2 query to the database for this exemple, it
// could (and should) be made with only one query...
// ==============================================================

// If current position is not set, set it to zero
if( !isset( $_REQUEST['int_cur_position'] ) || $_REQUEST['int_cur_position'] == 0 ){
  $int_cur_position = 0;
} else {
    $int_cur_position = $_REQUEST['int_cur_position'];
}

// Number of result to display on the page, will be in the LIMIT of the sql query also
$int_num_result = $number_of_messages;


$extargv =  "&a=10"; // extra argv here (could be anything depending on your page)

include_once "paginate.inc.php";
// New instance of the Paging class, you can modify the color and the width of the html table
$p = new Paging( $num_rows, $int_cur_position, $int_num_result, $extargv );

// Load up the 2 array in order to display result
$array_paging = $p->getPagingArray();
$array_row_paging = $p->getPagingRowArray();

// Display the result as you like...
$pager .= $_lang['showing']." ". $array_paging['lower'];
$pager .=  " ".$_lang['to']." ". $array_paging['upper'];
$pager .=  " (". $array_paging['total']." ".$_lang['total'].")";
$pager .=  "<br />". $array_paging['previous_link'] ."&lt;&lt;" . (isset($array_paging['previous_link']) ? "</a> " : " ");
for( $i=0; $i<sizeof($array_row_paging); $i++ ){
  $pager .=  $array_row_paging[$i] ."&nbsp;";
}
$pager .=  $array_paging['next_link'] ."&gt;&gt;". (isset($array_paging['next_link']) ? "</a>" : "");

// The above exemple print somethings like:
// Results 1 to 20 of 597  <<< 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27 28 29 30 >>>
// Of course you can now play with array_row_paging in order to print
// only the results you would like...
$rs = $modx->db->select('*', '[+prefix+]user_messages', "recipient='{$uid}'", 'postdate DESC', "{$int_cur_position}, {$int_num_result}");
$limit = $modx->db->getRecordCount($rs);
if($limit<1):
    echo $_lang['messages_no_messages'];
else:
echo $pager;
$dotablestuff = 1;
?>
<script type="text/javascript" src="media/script/tablesort.js"></script>
  <table border=0 cellpadding=0 cellspacing=0  class="sortabletable sortable-onload-5 rowstyle-even" id="table-1" width='100%'>
    <thead>
      <tr bgcolor='#CCCCCC'>
        <th width="12"></th>
        <th width="60%" class="sortable"><b><?php echo $_lang['messages_subject']; ?></b></th>
        <th class="sortable"><b><?php echo $_lang['messages_from']; ?></b></th>
        <th class="sortable"><b><?php echo $_lang['messages_private']; ?></b></th>
        <th width="20%" class="sortable"><b><?php echo $_lang['messages_sent']; ?></b></th>
      </tr>
    </thead>
    <tbody>
<?php
        while($message = $modx->db->getRow($rs)) :
			$message['subject'] = decrypt($message['subject']);
			$message['message'] = decrypt($message['message']);
            $sender = $message['sender'];
            if($sender==0):
                $sendername = "[System]";
            else:
                $rs2 = $modx->db->select('username', '[+prefix+]manager_users', "id='{$sender}'");
                $row2 = $modx->db->getRow($rs2);
                $sendername = $row2['username'];
            endif;
            $messagestyle = $message['messageread']==0 ? "messageUnread" : "messageRead";
?>
    <tr>
      <td ><?php echo $message['messageread']==0 ? "<img src=\"media/style/{$manager_theme}/images/icons/new1-09.gif\">" : ''; ?></td>
      <td class="<?php echo $messagestyle; ?>" style="cursor: pointer; text-decoration: underline;" onclick="document.location.href='index.php?a=10&id=<?php echo $message['id']; ?>&m=r';"><?php echo $message['subject']; ?></td>
      <td ><?php echo $sendername; ?></td>
      <td ><?php echo $message['private']==0 ? $_lang['no'] : $_lang['yes'] ; ?></td>
      <td ><?php echo $modx->toDateFormat($message['postdate']+$server_offset_time); ?></td>
    </tr>
    <?php
        endwhile;
endif;

if($dotablestuff==1) { ?>
</tbody>
</table>
<?php } ?>
    </div>
</div>
<div class="section">
<div class="sectionHeader"><?php echo $_lang['messages_compose']; ?></div>
<div class="sectionBody">
<?php
if(($_REQUEST['m']=='rp' || $_REQUEST['m']=='f') && isset($msgid)) {
    $rs = $modx->db->select('*','[+prefix+]user_messages',"id='{$msgid}'");
    $limit = $modx->db->getRecordCount($rs);
    if($limit!=1) {
        echo "Wrong number of messages returned!";
    } else {
        $message=$modx->db->getRow($rs);
	    $message['subject'] = decrypt($message['subject']);
	    $message['message'] = decrypt($message['message']);
        if($message['recipient']!=$uid) {
            echo $_lang['messages_not_allowed_to_read'];
        } else {
            // output message!
            // get the name of the sender
            $sender = $message['sender'];
            if($sender==0) {
                $sendername = "[System]";
            } else {
                $rs2 = $modx->db->select('username', '[+prefix+]manager_users', "id={$sender}");
                $row2 = $modx->db->getRow($rs2);
                $sendername = $row2['username'];
            }
            $subjecttext = $_REQUEST['m']=='rp' ? "Re: " : "Fwd: ";
            $subjecttext .= $message['subject'];
            $messagetext = "\n\n\n-----\n".$_lang['messages_from'].": $sendername\n".$_lang['messages_sent'].": ".$modx->toDateFormat($message['postdate']+$server_offset_time)."\n".$_lang['messages_subject'].": ".$message['subject']."\n\n".$message['message'];
            if($_REQUEST['m']=='rp') {
                $recipientindex = $message['sender'];
            }
        }
    }
}
?>

<script type="text/javascript">
function hideSpans(showSpan) {
    document.getElementById("userspan").style.display="none";
    document.getElementById("groupspan").style.display="none";
    document.getElementById("allspan").style.display="none";
    if(showSpan==1) {
        document.getElementById("userspan").style.display="block";
    }
    if(showSpan==2) {
        document.getElementById("groupspan").style.display="block";
    }
    if(showSpan==3) {
        document.getElementById("allspan").style.display="block";
    }
}
</script>
<form action="index.php?a=66" method="post" name="messagefrm" enctype="multipart/form-data">
<fieldset style="width: 600px;background-color:#fff;border:1px solid #ddd;">
<legend><b><?php echo $_lang['messages_send_to']; ?>:</b></legend>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <label><input type=radio name="sendto" VALUE="u" checked onClick='hideSpans(1);'><?php echo $_lang['messages_user']; ?></label>
    <label><input type=radio name="sendto" VALUE="g" onClick='hideSpans(2);'><?php echo $_lang['messages_group']; ?></label>
    <label><input type=radio name="sendto" VALUE="a" onClick='hideSpans(3);'><?php echo $_lang['messages_all']; ?></label><br />
<span id='userspan' style="display:block;"> <?php echo $_lang['messages_select_user']; ?>:&nbsp;
    <?php
    // get all usernames
    $rs = $modx->db->select('mu.username,mu.id', '[+prefix+]manager_users mu INNER JOIN [+prefix+]user_attributes mua ON mua.internalkey=mu.id', "mua.blocked='0'");
    ?>
    <select name="user" class="inputBox" style="width:150px">
    <?php
        while ($row = $modx->db->getRow($rs)) {
            ?>
            <option value="<?php echo $row['id']; ?>" ><?php echo $row['username']; ?></option>
            <?php
        }
    ?>
    </select>
</span>
<span id='groupspan' style="display:none;"> <?php echo $_lang['messages_select_group']; ?>:&nbsp;
    <?php
    // get all usernames
    $rs = $modx->db->select('name, id', '[+prefix+]user_roles');
    ?>
    <select name="group" class="inputBox" style="width:150px">
    <?php
    while ($row = $modx->db->getRow($rs)) {
        ?>
        <option value="<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
        <?php
    }
    ?>
</select>
</span>
<span id='allspan' style="display:none;">
</span>
    </td>
  </tr>
</table>
</fieldset>

<p>

<fieldset style="width: 600px;background-color:#fff;border:1px solid #ddd;">
<legend><b><?php echo $_lang['messages_message']; ?>:</b></legend>

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php echo $_lang['messages_subject']; ?>:</td>
    <td><input name="messagesubject" type=text class="inputBox" style="width: 500px;" maxlength="60" value="<?php echo $subjecttext; ?>"></td>
  </tr>
  <tr>
    <td valign="top"><?php echo $_lang['messages_message']; ?>:</td>
    <td><textarea name="messagebody" style="width:500px; height: 200px;" onLoad="this.focus()" class="inputBox"><?php echo $messagetext; ?></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td>
		<ul class="actionButtons" style="margin-top:15px;">
		        <li><a href="#" class="primary" onclick="documentDirty=false; document.messagefrm.submit();"><img src="<?php echo $_style["icons_save"] ?>" /> <?php echo $_lang['messages_send']; ?></a></li>
		        <li><a href="index.php?a=10&t=c"><img src="<?php echo $_style["icons_cancel"] ?>" /> <?php echo $_lang['cancel']; ?></a></li>
		</ul>
    </td>
  </tr>
</table>

</fieldset>
</form>
</div>
</div>
<?php
// count messages again, as any action on the messages page may have altered the message count
$rs = $modx->db->select('count(*)','[+prefix+]user_messages',"recipient='{$uid}' AND messageread=0");
$_SESSION['nrnewmessages'] = $modx->db->getValue($rs);
$rs = $modx->db->select('count(*)','[+prefix+]user_messages',"recipient='{$uid}'");
$_SESSION['nrtotalmessages'] = $modx->db->getValue($rs);
$messagesallowed = $modx->hasPermission('messages');
?>
<script type="text/javascript">
function msgCountAgain() {
    try {
        top.mainMenu.startmsgcount(<?php echo $_SESSION['nrnewmessages'] ; ?>,<?php echo $_SESSION['nrtotalmessages'] ; ?>,<?php echo $messagesallowed ? 1:0 ; ?>);
    } catch(oException) {
        vv = window.setTimeout('msgCountAgain()',1500);
    }
}

v = setTimeout('msgCountAgain()', 1500); // do this with a slight delay so it overwrites msgCount()

</script>

<?php

// http://d.hatena.ne.jp/hoge-maru/20120715/1342371992
function decrypt($encryptedText, $key='modx')
{
	$enc = base64_decode($encryptedText);
	$plaintext = '';
	$len = strlen($enc);
	for($i = 0; $i < $len; $i++)
	{
		$asciin = ord($enc[$i]);
		$plaintext .= chr($asciin ^ ord($key[$i]));
	}
	return $plaintext;
}