<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');
define('QUESTIONS_PER_PAGE', 20);

$mode =  ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
$start =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : 0 ;
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_REPORT);
init_userprefs($userdata);
//
// End session management

if( $userdata['session_logged_in'] && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) ) {
	$nav_path = '<a href="'.append_sid($somCBT_root_path.'index.php').'" class="nav">Home</a> ' ;

	include($somCBT_root_path . 'includes/page_header.php');

	$template->set_filenames(array(	'body' => 'quiz/quiz_report_student.tpl') );

	$sql = " SELECT count(*) AS total_ques FROM ". QUIZ_QUESTIONS_TABLE ." where quiz_id = ". $qid;

	$result = $db->sql_query($sql);
	$total_ques = $db->sql_fetchrow($result);

	//$template->assign_block_vars('total_ques',array());

//	$template->assign_block_vars('student',array('id' => 'Name' ));		
	for ( $k = $start; ($k < $start + QUESTIONS_PER_PAGE) && ($k< $total_ques['total_ques']) ; $k++) {
		if ($k  <= $total_ques['total_ques']) {
			if ($k < 9 ){
				$template->assign_block_vars('total_ques',array('qno'=>'0'.($k+1)));	
			}else {
				$template->assign_block_vars('total_ques',array('qno'=>($k+1)));	
			}
		}
	}
	

	$sql = " SELECT cu.user_id, u.username FROM ".COURSE_USERS_TABLE. " cu, ".USERS_TABLE." u WHERE cu.course_id = ".$cid ." AND cu.access_level='5' AND cu.user_id = u.user_id ORDER BY u.username";

	if ( $result = $db->sql_query($sql) )
	 {
		while( $course_user = $db->sql_fetchrow($result)) 
		{
/*			$sql = "SELECT 	grade FROM ".QUIZ_ATTEMPTS_TABLE." WHERE quiz_id = ".$qid." AND user_id = ".$course_user['user_id'];

			if ($result1 = $db->sql_query($sql) ) {
				if ( $c % 2) { $color = "#FFFFD1";$c=0;} else { $color ="#D4D4D4" ;$c=1;}
				$responses = $db->sql_fetchrow($result1);
				$template->assign_block_vars('student',array('id' => $course_user['username'].$responses['grade'], 'bgcolor' => $color ));

			}
*/			
			$sql = "SELECT r.answer, r.grade, ques.qtype, ques.ques_id FROM " . QUIZ_QUESTIONS_TABLE ." ques 
						LEFT JOIN ". QUIZ_RESPONSES_TABLE. " r ON r.user_id = ".$course_user['user_id']." AND ques.ques_id = r.question_id AND r.quiz_id = " . $qid ." 
					     WHERE ques.quiz_id = " . $qid . " GROUP BY ques.ques_order LIMIT ".$start.", ".QUESTIONS_PER_PAGE ;

			if ($result1 = $db->sql_query($sql) ) {
				if ( $c % 2) { $color = "#FFFFD1";$c=0;} else { $color ="#D4D4D4" ;$c=1;}
				
				$template->assign_block_vars('student',array('id' => $course_user['username'], 'bgcolor' => $color ));
		
				while($responses = $db->sql_fetchrow($result1)) {
					if($responses['qtype'] == '1') {
						$letter = array("", "A", "B", "C", "D", "E", "F");
						//$letter = array ("", "a.gif", "b.gif", "c.gif", "d.gif", "e.gif", "F");							

						if ( empty($responses['answer']) ) {
							$answer = '-';
						}
						else {
							$answer = $letter[$responses['answer']];
						}
						if ($responses['grade'] == '1') {
							$template->assign_block_vars('student.student_ques',array('grade'=>"<font color='purple'><i>".$answer."</i><font>"));
						} else {
							$template->assign_block_vars('student.student_ques',array('grade'=>$answer));
						}
					}else{
						$sql2 = "SELECT * FROM ".QUIZ_TEXT_RESPONSES." WHERE quiz_id=".$qid." AND question_id=".$responses['ques_id']." AND user_id=".$course_user['user_id'];
						if($result2 = $db->sql_query($sql2) ) {
							if($txt = $db->sql_fetchrow($result2) ) {
								if ( (empty($txt['answer'])) ) {
									$answer = '-';
								}
								else {
									$answer = 'L';
								}
							$template->assign_block_vars('student.student_ques',array('grade'=>$answer));
							}else{
							$answer = '-';
							$template->assign_block_vars('student.student_ques',array('grade'=>$answer));
							}
						}
					}
				} // eof while resp
			
			} // eof resultset response			
		} // eof while course_user
		
/*		
		$template->assign_block_vars('report_download',array());			
		$template->assign_block_vars('report_download.info',array('Q_INFO' => '<input type="button" value="Excel Format" onclick="javascript:window.location=\''.append_sid('report.php?action=excel&cid='.$cid.'&qid='.$qid).'\'">'));	
//		$template->assign_block_vars('report_download.info',array('Q_INFO' => '<input type="button" value="CSV Format" onclick="javascript:window.location=\''.append_sid('report.php?action=csv&cid='.$cid.'&qid='.$qid).'\'">'));	
//		$template->assign_block_vars('report_download.info',array('Q_INFO' => '<input type="button"value="XML Format"  onclick="javascript:window.location=\''.append_sid('report.php?action=xml&cid='.$cid.'&qid='.$qid).'\'">'));					
	*/	
	} // eof resultset

	$question_link = '';
	for ($x=0; $x < $total_ques['total_ques']; $x = $x + QUESTIONS_PER_PAGE) {
	
		if (($x + QUESTIONS_PER_PAGE) <= $total_ques['total_ques']) {
			$question_link .= '<a href="'.append_sid('student_report.php?ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$x).'" class="nav">'. ($x+1) .' - '.($x + QUESTIONS_PER_PAGE).'</a>&nbsp;&nbsp;&nbsp;';
		} else {
			$question_link .= '<a href="'.append_sid('student_report.php?ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$x).'" class="nav">'.($x+1) .' - '.$total_ques['total_ques'].'</a>&nbsp;&nbsp;&nbsp;';
		}
	}
	
	$template->assign_vars(array(
				'count' => $total_ques['total_ques'],
				'QUESTION_LINK' => $question_link,
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