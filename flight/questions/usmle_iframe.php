<?php
/* 
 * Comments can be posted by other faculties regarding a question
 * Course Director can edit/delete any comments
 * Others can only edit their own posts
 */

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$qid =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : 0) ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$ca =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$lock = ( isset($HTTP_GET_VARS['lck']) ) ? ($HTTP_GET_VARS['lck']) : ( ( isset($HTTP_POST_VARS['lck']) ) ? ($HTTP_POST_VARS['lck']) : 'n') ;
$qzid = ( isset($HTTP_GET_VARS['QUIZ']) ) ? ($HTTP_GET_VARS['QUIZ']) : ( ( isset($HTTP_POST_VARS['QUIZ']) ) ? ($HTTP_POST_VARS['QUIZ']) : 0) ;
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_CREATE);
init_userprefs($userdata);
//
// End session management

if( ( $userdata['session_logged_in'] ) && ( ($userdata['user_level'] == ADMIN) || ($userdata['user_level'] == TEACHER )) ){

	include($somCBT_root_path . 'includes/page_header.php');
	$template->set_filenames(array(	'body' => 'questions/usmle_iframe.tpl')	);


	if  ( $userdata['user_level'] == TEACHER )  {
		$sql = "SELECT c.*, cu.access_level FROM " . COURSE_USERS_TABLE . " cu, ".COURSE_TABLE." c WHERE c.course_id = cu.course_id AND cu.course_id = ".$cid."  AND cu.user_id = " . $userdata['session_user_id'] ." LIMIT 1";

		if ( $result = $db->sql_query($sql) ) {
	
			$courses = $db->sql_fetchrow($result) ;

			if ( ( $courses['access_level'] == FACULTY ) || ( $courses['access_level'] == DIRECTOR )  ) {

				$template->assign_block_vars('hide_question',array());
				
			}
		}
		
	}
	
	if ( $userdata['user_level'] == ADMIN ) {
		$template->assign_block_vars('hide_question',array());	
	}

	if ($mode == 'del') { // delete comment
		$sql = " DELETE FROM ". VOC_XREF_TABLE. " WHERE voc_id = " . $HTTP_GET_VARS['voc'];
		$r = $db->sql_query($sql);
	}

	// Pull currently associated elements for this question and display in iframe
	$sql = " SELECT * FROM ".VOC_XREF_TABLE." WHERE question_id = ".$qid;

	if ( ($result = $db->sql_query($sql) ) && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) ) {
				
		while ($comments = $db->sql_fetchrow($result) ) {

			// delete option only if admin/course director/own post
			if ( ($userdata['user_level'] == ADMIN) || ($courses['access_level'] == DIRECTOR ) || ($userdata['session_user_id'] == $comments['user_id']) ) {
			
				$post_del = '<img src="'.$somCBT_root_path.'templates/'.$theme['template_name'].'/images/icon_delete.gif" border="0" alt="Del" align="absmiddle">';

			}
			else {
				$post_del = '';
			}
			
			$sql2 = " SELECT * FROM ".USMLE_TABLE." WHERE voc_id = ".$comments['voc_id'];
			
			$result2 = $db->sql_query($sql2);
			
			$element = $db->sql_fetchrow($result2);
			
			$element_post = $element['element'];
			
			$loop_cnt = $comments['level'] - 1;
			
			$currlevel = "level_1 = ".$element['level_1'];
			
			$elem_no = $element['level_1'].".".$element['level_2'].".".$element['level_3'].".".$element['level_4'].".".$element['level_5'];
			
			for($i=0;$i<$loop_cnt;$i++) 
			{
			

				$currlevel = $currlevel." AND level_".($i+1)." = ".$element['level_'.($i+1)];
				
				$sql3 = "SELECT * FROM ".USMLE_TABLE." WHERE ".$currlevel;
				
				$result3 = $db->sql_query($sql3);
			
				$element2 = $db->sql_fetchrow($result3);
			
				$element_post2 = $element_post2.$element2['element']." --> ";
			}
			
			$post = $element_post2.$element_post;
			
			$template->assign_block_vars('postrow', array('ELEM_ID' => $elem_no,
														   'POST' => $post,
														   'POST_DEL' => $post_del ,
														   'DEL_LINK' => append_sid('usmle_iframe.php?action=del&ARG1='.$cid.'&ARG3='.$qid.'&voc='.$comments['voc_id'].'&lck='.$lock.'&QUIZ='.$qzid)
			));
		
			unset($post, $element_post, $element_post2);
		} // eof while comments
		
	} // eof comments resultset


	$template->assign_vars(array(
				'QUESTION' => append_sid('questions.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'STATS' => append_sid('statistics.php?ARG1='.$cid.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'PREVIEW' => append_sid('preview.php?ARG1='.$cid.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),								
				'MISC' => append_sid('misc.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'COMMENTS' => append_sid('comments.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),	
				'USMLE' => append_sid('usmle.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),											
				'S_ROOTDIR' => $somCBT_root_path,
				'S_NAV' => 'USMLE Entitities')
			);

	

}
else {
	if ( $userdata['user_level'] == STUDENT ) {
		redirect(append_sid("index.php", true));	
	} else {
		redirect(append_sid("login.php", true));
	}

}
//
// Generate the page
//

$template->pparse('body');

?>
