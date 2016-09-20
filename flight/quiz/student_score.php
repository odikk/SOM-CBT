<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_REPORT);
init_userprefs($userdata);
//
// End session management

if( $userdata['session_logged_in'] && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) ) {

	include($somCBT_root_path . 'includes/page_header.php');

	$template->set_filenames(array(	'body' => 'quiz/quiz_score.tpl') );
	
	$sql = " SELECT count(*) AS total_ques FROM ". QUIZ_QUESTIONS_TABLE ." where quiz_id = ". $qid;

	$result = $db->sql_query($sql);
	$total_ques = $db->sql_fetchrow($result);

	$sql = " SELECT * FROM ". QUIZ_QUESTIONS_TABLE ." where quiz_id = ". $qid;
	$result = $db->sql_query($sql);
	while ($question = $db->sql_fetchrow($result)) {
		if($question['qtype']=='2') {
			$arr_pts = explode("#", $question['points']);
			$pts = $arr_pts[4];
			$total_pts = $total_pts + $pts;
		}else{
			$total_pts = $total_pts + 1;
		}
	}
	
	$sql = "SELECT u.user_id, username, user_fname, user_lname, timefinish, timestart, grade FROM ".USERS_TABLE." u, ".COURSE_USERS_TABLE." cu, ".QUIZ_ATTEMPTS_TABLE." qa WHERE cu.course_id = ".$cid." AND cu.user_id = u.user_id AND cu.access_level = '5' AND qa.user_id = u.user_id AND qa.quiz_id = ".$qid . " ORDER BY user_lname";

	if ( ($result = $db->sql_query($sql)) ) {
		$c =1;
		while( $quiz_attempts = $db->sql_fetchrow($result) )
		{
			if ( $c % 2) { $color = "#FFFFD1";$c=0;} else { $color ="#D4D4D4" ;$c=1;}
			$timetaken = calculateDateDiff($quiz_attempts['timefinish'], $quiz_attempts['timestart']) ;
			$total = $total_pts;
			$template->assign_block_vars('quiz_attempts', array('NAME' => $quiz_attempts['user_fname'].' '.$quiz_attempts['user_lname'],
																'USERNAME' => $quiz_attempts['username'],
																'PERCENT' => round((($quiz_attempts['grade']/$total_pts) * 100 ),1),
																'SCORE' => $quiz_attempts['grade'],
																'TIME' => '<a href="javascript:void(0);" class="genmed" onclick = "window.location=\''.append_sid('admin_review.php?ARG1='.$cid.'&ARG2='.$qid.'&ARG4='.$quiz_attempts['user_id'].'&ARG5='.$total).'\'; return false;">'.$timetaken['hours']. ' h '.$timetaken['minutes'].' min'.'</a>',
																'BGCOLOR' => $color
										));
		}
	}
	
	$template->assign_vars(array(
				'count' => $total_ques['total_ques'],
				'QUESTION_TOTAL' => $total_ques['total_ques'],
				'POINT_TOTAL' => $total_pts,
				'S_ROOTDIR' => $somCBT_root_path,
				'S_NAV' => $nav_path,
				'Q_POST_ACTION' => append_sid('report.php')
			));

	

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
