<?php
require_once('../manager/includes/default.config.php');
require_once('functions.php');
install_session_start();
$language = getOption('install_language');
includeLang($language);

if(isset($_POST['host'])) $host = $_POST['host'];
if(isset($_POST['uid']))  $uid  = $_POST['uid'];
$pwd  = (isset($_POST['pwd'])) ? $_POST['pwd'] : '';

if(!isset($host) || !isset($uid))
{
	$conn = false;
}
else $conn = @ mysql_connect($host, $uid, $pwd);

if (!$conn) {
    $output = '<span id="server_fail" style="color:#FF0000;"> '.$_lang['status_failed'].'</span>';
} else {
    $output = '<span id="server_pass" style="color:#388000;"> '.$_lang['status_passed_server'].'</span>';
    $_SESSION['database_server']   = $host;
    $_SESSION['database_user']     = $uid;
    $_SESSION['database_password'] = $pwd;

    // Mysql version check
    if ( strpos(mysql_get_server_info(), '5.0.51')!==false ) {
        $output .= '<br /><span style="color:#FF0000;"> '.$_lang['mysql_5051'].'</span>';
    }
    // Mode check
    $mysqlmode = @ mysql_query("SELECT @@session.sql_mode");
    if (@mysql_num_rows($mysqlmode) > 0 && !is_webmatrix() && !is_iis()){
        $modes = mysql_fetch_array($mysqlmode, MYSQL_NUM);
        $strictMode = false;
        foreach ($modes as $mode) {
    		if (stristr($mode, "STRICT_TRANS_TABLES") !== false || stristr($mode, "STRICT_ALL_TABLES") !== false) {
    			$strictMode = true;
    		}
        }
        if ($strictMode) $output .= '<br /><span style="color:#FF0000;"> '.$_lang['strict_mode'].'</span>';
    }
}
echo '<div style="background: #eee;">' . $_lang["status_connecting"] . $output . '</div>';
