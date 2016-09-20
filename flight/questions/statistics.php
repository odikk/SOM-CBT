<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : -1) ;
$ca =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
$qid =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : 0) ;
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

	$template->set_filenames(array(	'body' => 'questions/statistics.tpl')	);
	
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


	$sql = " SELECT * FROM ".QUESTION_STATS_TABLE. " WHERE question_id = " . $qid;
	
	if ( ($result = $db->sql_query($sql) ) && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) ) {
				
		while ($stats = $db->sql_fetchrow($result) ) {

			$template->assign_block_vars('stats',array('QZ_NAME' => $stats['quiz_id'],
														'YEAR' => $stats['year'],
														'N' => $stats['total'],
														'WHOLE' => $stats['whole'],
														'U25' => $stats['upper25'],
														'L25' => $stats['lower25'],
														'DISCRI' => $stats['discri'],
														'CRCT' => $stats['correct'],
														'F1' => $stats['f1'], 'F2' => $stats['f2'],
														'F3' => $stats['f3'], 'F4' => $stats['f4'], 'F5' => $stats['f5']
			
									));

		}// eof while stats
	}	// eof resultset

//The following ncluded to deal with WebCT statistics table. Displayed beneath - SMQ

	$sql = " SELECT * FROM ".WEBCT_STATS_TABLE. " WHERE question_id = " . $qid;
	
	if ( ($result = $db->sql_query($sql) ) && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) ) {
				
		while ($stats = $db->sql_fetchrow($result) ) {

			$template->assign_block_vars('stats',array('QZ_NAME2' => 'WebCT',
														'YEAR2' => $stats['year'],
														'N2' => $stats['total'],
														'WHOLE2' => $stats['whole'],
														'U252' => $stats['upper25'],
														'L252' => $stats['lower25'],
														'DISCRI2' => $stats['discri'],
														'CRCT2' => $stats['correct'],
														'F12' => $stats['f1'], 'F22' => $stats['f2'],
														'F32' => $stats['f3'], 'F42' => $stats['f4'], 'F52' => $stats['f5']
			
									));

		}// eof while retro stats - SMQ
	}	// eof retro stats resultset - SMQ

	$template->assign_vars(array(
				'QUESTION' => append_sid('questions.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'STATS' => append_sid('statistics.php?ARG1='.$cid.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'PREVIEW' => append_sid('preview.php?ARG1='.$cid.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'MISC' => append_sid('misc.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'COMMENTS' => append_sid('comments.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'USMLE' => append_sid('usmle.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),																										
				'S_ROOTDIR' => $somCBT_root_path,
				'S_NAV' => 'Question Statistics')
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

$template->pparse('overall_header');

$template->pparse('body');

include($somCBT_root_path . 'includes/page_tail.php');
?>
