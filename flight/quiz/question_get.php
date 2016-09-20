<?php
define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');


//$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$ca =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_INDEX);
init_userprefs($userdata);
//
// End session management

if( ( $userdata['session_logged_in'] ) && ( ($userdata['user_level'] == ADMIN) || ($userdata['user_level'] == TEACHER )) ){

	
	include($somCBT_root_path . 'includes/page_header.'.$phpEx);


}
else {
	redirect(append_sid("login.php", true));
}

$template->pparse('overall_header');



?>
<body>
<form enctype="multipart/form-data" action="file_upload_handler.php" method=post>
	<input type = "hidden" name="MAX_FILE_SIZE" value="1000000">
	Upload text file of questions: <input name="userfile" type="file">
	<input type ="submit" value="Send File">
  	<input type="hidden" name="c_id" value="<?php echo $_GET['ARG1']; ?>" />
  	<input type="hidden" name="q_id" value="<?php echo $_GET['ARG2']; ?>" />
</form>