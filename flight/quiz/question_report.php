<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');
define('QUESTIONS_PER_PAGE', 20);

$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
$year = ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : '';

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_REPORT);
init_userprefs($userdata);
//
// End session management

if( $userdata['session_logged_in'] && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) ) {

	include($somCBT_root_path . 'includes/page_header.php');

	$template->set_filenames(array(	'body' => 'quiz/quiz_report_questions.tpl') );

	$sql = " SELECT qq.ques_name, qq.ques_id, qq.points, qq.qtype, qq.ques_order, stats.* FROM ".QUIZ_QUESTIONS_TABLE." qq, ".STATISTICS_TABLE." stats WHERE qq.quiz_id = ".$qid." AND qq.qtype = '1' AND stats.question_id = qq.ques_id AND stats.year = '".$year."' ORDER BY ques_order ASC";

	if ( $result = $db->sql_query($sql) )
	 {
		$total_ques = $db->sql_numrows($result);
		while( $stats = $db->sql_fetchrow($result)) 
		{
			if ( $c % 2) { $color = "#FFFFD1";$c=0;} else { $color ="#D4D4D4" ;$c=1;}

			$freq = array($stats['f1'],$stats['f2'],$stats['f3'],$stats['f4'],$stats['f5']);
			$sum = array_sum($freq);
			$points = explode ( "#", $stats['points']);
			array_pop($points); // last element will always be empty bcos the points seperated by # and also end with #
			arsort($points);
			reset($points);
			$correct_answer_point = current($points) != 0 ? current($points) : 0 ; // max points is considered a correct answer
//print_r($points);
			$correct_answer_index = array_keys($points, $correct_answer_point);
			foreach ($correct_answer_index as $key => $value) {
				//echo $value;
				$freq[$value] = '<b><i>'.$freq[$value].'</i></b>';
//				$correct_answer_index[$key] = $letters[($value+1)];
			}
			
			$template -> assign_block_vars('stats', array('QNO' => $stats['ques_order'], 'QTITLE' => $stats['ques_name'], 'QDBNO' => $stats['ques_id'], 'BGCOLOR' => $color,
															'WHOLE' => $stats['whole'], 'UPPER' => $stats['upper25'], 'LOWER' => $stats['lower25'],
															'DISCRIM' => round((float)($stats['discri']),2), 
															'AFREQ' => $freq[0], 'BFREQ' => $freq[1], 'CFREQ' =>$freq[2], 'DFREQ' => $freq[3], 'EFREQ' =>$freq[4], 'SUM' => $sum
								));
					
		} // eof while stats
	} // eof resultset
/*		
		$template->assign_block_vars('report_download',array());			
		$template->assign_block_vars('report_download.info',array('Q_INFO' => '<input type="button" value="Excel Format" onclick="javascript:window.location=\''.append_sid('report.php?action=excel&cid='.$cid.'&qid='.$qid).'\'">'));	
//		$template->assign_block_vars('report_download.info',array('Q_INFO' => '<input type="button" value="CSV Format" onclick="javascript:window.location=\''.append_sid('report.php?action=csv&cid='.$cid.'&qid='.$qid).'\'">'));	
//		$template->assign_block_vars('report_download.info',array('Q_INFO' => '<input type="button"value="XML Format"  onclick="javascript:window.location=\''.append_sid('report.php?action=xml&cid='.$cid.'&qid='.$qid).'\'">'));					
	*/	

	
	$template->assign_vars(array(
				'count' => $total_ques,
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
