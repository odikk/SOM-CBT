<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './';

include($somCBT_root_path . 'common.php');

$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? $HTTP_GET_VARS['ARG1'] :  -1 ;

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_COURSE);
init_userprefs($userdata);

//
// End session management

if( $userdata['session_logged_in'] ) {

	$nav_path = '<a href="'.append_sid($somCBT_root_path.'index.php').'" class="nav">Home</a> ' ;
	
	// include header file	
	include($somCBT_root_path . 'includes/page_header.php');
	
 	// assign the template
	$template->set_filenames(array('body' => 'course_body.tpl'));


	// Find the list of courses the user teaches/studies	
	if ($userdata['user_level'] == ADMIN) {
		$sql = "SELECT * FROM " . COURSE_TABLE . " WHERE course_id = ".$cid."  LIMIT 1";		
	}
	else if ($userdata['user_level'] == TEACHER) {
		$sql = "SELECT c.*, cu.access_level FROM " . COURSE_USERS_TABLE . " cu, ".COURSE_TABLE." c WHERE c.course_id = cu.course_id AND c.course_id = ".$cid." AND cu.user_id = " . $userdata['session_user_id'] ." LIMIT 1";
	} else if ( $userdata['user_level'] == STUDENT) {
		$sql = "SELECT c.* FROM " . COURSE_USERS_TABLE . " cu, ".COURSE_TABLE." c WHERE c.course_id = cu.course_id AND c.course_id = ".$cid." AND c.visible = '1' AND cu.user_id = " . $userdata['session_user_id']. " LIMIT 1";
	}

	if ( $result = $db->sql_query($sql) ) {
	
		$courses = $db->sql_fetchrow($result) ;
	}

	$nav_path .= ' - ' . '<a href="'.append_sid($somCBT_root_path.'course.php?ARG1='.$cid).'" class="nav">'.$courses['course_shortname'].'</a>';
//the following block of code was edited by SMQ to bypass image options for students - SMQ
	if ($cid == $courses['course_id']) { // only if the user has permission for this course
		if (($userdata['user_level'] == TEACHER) || (( $userdata['user_level'] == ADMIN )) )	 {//if admin or teacher, show images that link to different admin sections - SMQ 
			$template->assign_block_vars('modules', array());		
			$template->assign_block_vars('modules.course_modules', array( 'IMG' => 'testing.gif', 'LINK' => append_sid('quiz/index.php?action=show&ARG1='.$cid) , 'LINK_NAME'=> 'Quiz'));			
			$template->assign_block_vars('modules.course_modules', array( 'IMG' => 'evaluation.gif', 'LINK' => '' , 'LINK_NAME'=> 'Evaluation'));
			$template->assign_block_vars('modules.course_modules', array( 'IMG' => 'questions.gif', 'LINK' => append_sid('questions/index.php?ARG1='.$cid)  , 'LINK_NAME'=> 'Questions'));			
		}else if($userdata['user_level'] == STUDENT){
			redirect(append_sid('quiz/index.php?action=show&ARG1='.$cid, true)); 
			break;
		}			
		
	} // eof course permission
	else {
		redirect(append_sid("index.php", true));
	}
	

	$template->assign_vars(array(
				'S_ROOTDIR' => $somCBT_root_path,
				'S_NAV' => $nav_path)
			);

	

}
else {
	redirect(append_sid("login.php", true));
}
//
// Generate the page
//

$template->pparse('overall_header');

$template->pparse('body');

include($somCBT_root_path . 'includes/page_tail.php');
?>