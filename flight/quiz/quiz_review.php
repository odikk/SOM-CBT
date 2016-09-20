<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
$quesid =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : 0) ;
$setid =  ( isset($HTTP_GET_VARS['set']) ) ? ($HTTP_GET_VARS['set']) : ( ( isset($HTTP_POST_VARS['set']) ) ? ($HTTP_POST_VARS['set']) : 0) ;
$cmt =  ( isset($HTTP_GET_VARS['comment']) ) ? ($HTTP_GET_VARS['comment']) : ( ( isset($HTTP_POST_VARS['comment']) ) ? ($HTTP_POST_VARS['comment']) : '') ;
$cmt_txt = ( isset($HTTP_GET_VARS['comments']) ) ? ($HTTP_GET_VARS['comments']) : ( ( isset($HTTP_POST_VARS['comments']) ) ? ($HTTP_POST_VARS['comments']) : '') ;
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_QUIZ);
init_userprefs($userdata);
//
// End session management

if( $userdata['session_logged_in']) {

	include($somCBT_root_path . 'includes/page_header.php');

	$template->set_filenames(array('body' => 'quiz/quiz_review.tpl'));

	$sql = "SELECT q.release_quiz, qs.ipfrom, qs.ipto, c.media_dir FROM ". QUIZ_TABLE. " q, ".QUIZ_SETTINGS_TABLE." qs, ".COURSE_TABLE." c WHERE qs.timeopen <= ".time(). " AND qs.timeclose >= ".time()." AND q.quiz_id = ". $qid . " AND q.course_id = ".$cid." AND qs.set_id = ".$setid." AND q.course_id = c.course_id LIMIT 1";

	if ($result = $db->sql_query($sql) ) {
	
		if( $cmt=='save' ) {

			$updcmnt = " INSERT INTO ".QUESTION_COMMENTS_TABLE. " (question_id, user_id, comments, post_time) VALUES 
					(".$quesid.", ".$userdata['session_user_id'].", '".$cmt_txt."', ".time().")";
			$r = $db->sql_query($updcmnt);
			
			$updques = " UPDATE ".QUESTIONS_TABLE. " SET flag = 'a' WHERE question_id = ".$quesid;
			$r2 = $db->sql_query($updques);

		}
		

		if ($quiz = $db->sql_fetchrow($result)) {
	
			$release_review_options = explode("#", $quiz['release_quiz']);
			// check quiz settings page for release_quiz options/format
			if ( (isIPInRange(decode_ip($userdata['session_ip']), decode_ip($quiz['ipfrom']), decode_ip($quiz['ipto'])) ) && ($release_review_options[3] == 1)) {

				$sql2 = " SELECT * FROM ". QUIZ_QUESTIONS_TABLE . " WHERE quiz_id = ".$qid." AND ques_id =".$quesid." LIMIT 1";

				if ($result2 = $db->sql_query($sql2) ) {

					if ($question = $db->sql_fetchrow($result2)) {

						if ($question['qtype']=='1') {
			
							$sql1 = "SELECT answer, grade FROM ".QUIZ_RESPONSES_TABLE . " WHERE quiz_id = ".$qid. " AND question_id = ".$quesid."  AND user_id =".$userdata['session_user_id'] . " LIMIT 1";

							if ($result = $db->sql_query($sql1) ) {

								if ($response = $db->sql_fetchrow($result)) { 
				
									$answer = $response['answer'];
									$show_question = 1;
						
									if ( ($release_review_options[4] == 1) && ( $response['grade'] == 1 ) ) { // correct && permission to set to see all
									$show_question = 0;
									$template->assign_block_vars('denied',array()); 							
									}
								}
								else { // no rows returned, not answered at all 				
									$show_question = 1;  
									$answer = '';
					
								}
							}//end sql1 - SMQ
						}
						elseif ($question['qtype']=='2') {
							
							$longarr = explode("#", $question['points']);
							$longpt = $longarr[4];
							
							$sql2 = "SELECT * FROM ".QUIZ_TEXT_RESPONSES_TABLE . " WHERE quiz_id = ".$qid. " AND question_id = ".$quesid."  AND user_id =".$userdata['session_user_id'] . " LIMIT 1";

							if ($result2 = $db->sql_query($sql2) ) {

								if ($response2 = $db->sql_fetchrow($result2)) { 
					
									$answer = $response2['answer'];
									$resp = $response2['grade_resp'];
									$point = $response2['point'];
									$show_question = 1;
						
								}
								else { // no rows returned, not answered at all 				
									$show_question = 1;  
									$answer = '';
									$resp = '';
									$point = '';
					
								}
							}//end sql2 - SMQ
						}
					}
				}
				
				if ( $show_question ) {
					$sql3 = " SELECT * FROM ". QUIZ_QUESTIONS_TABLE . " WHERE quiz_id = ".$qid." AND ques_id =".$quesid. " LIMIT 1";

					if ($result3 = $db->sql_query($sql3) ) {

						if ($question = $db->sql_fetchrow($result3)) {

							switch ($question['qtype']) {
				
							case MULTIPLECHOICE :
							{
	
								$letters = array("NA","A","B","C","D","E", "F");
								for ( $z = 0; $z < 6; $z++) {
									if (!empty($question['choice'.($z+1)])) {
										$ques_options .= '<p>&nbsp&nbsp;&nbsp;&nbsp;'.$letters[($z+1)].'.&nbsp;&nbsp;'.$question['choice'.($z+1)]."</p>";
									}							
								}	
					
								$points = explode ( "#", $question['points']);
								array_pop($points); // last element will always be empty bcos the points seperated by # and also end with #
								arsort($points);
								reset($points);
								$correct_answer_point = current($points) != 0 ? current($points) : 0 ; // max points is considered a correct answer
											
								$answer = ( empty($answer) ) ? 0 : $answer ;
								$correct_answer_index = array_keys($points, $correct_answer_point);
								foreach ($correct_answer_index as $key => $value) {
									$correct_answer_index[$key] = $letters[($value+1)];
								}
								if ( trim($question['media_name']) != '' ) {
									$media_array = explode(",",$question['media_name']);
									if (substr($media_array[0], -3) == 'mov') {
										//print_r(getimagesize($somCBT_root_path.'media/'.$courses['media_dir'].$question['media_name']));
										$media = '<center><object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab"  width="'.$media_array[1].'" height="'.($media_array[2]+16).'">';
										$media .= '<param name="SRC" value="'.$somCBT_root_path.'media/'.$HTTP_GET_VARS['dir'].$media_array[0].'">';
										$media .= '<param name="AUTOPLAY" value="true"> <param name="CONTROLLER" value="true">';
										$media .= '<embed src="'.$somCBT_root_path.'media/'.$HTTP_GET_VARS['dir'].$media_array[0].'" autoplay="true" width="'.$media_array[1].'" height="'.($media_array[2]+16).'" controller="true" pluginspage="http://www.apple.com/quicktime/download/"></embed>'; 
										$media .= '</object></center>';
									}
									else {
										$media='<center><img src="'.$somCBT_root_path.'media/'.$HTTP_GET_VARS['dir'].$media_array[0].'" border="0" alt="media"></center>';
									}
								} // eof media display
									
								$template->assign_block_vars('question',array('QNO' => $HTTP_GET_VARS['ARG4'],
																		'QID' => $question['ques_id'],
																		'STEM' => $question['stem']."<br><br>".$media,
																		'LABEL' => "Correct Answer:",
																		'STU_ANS' => $letters[$answer],
																		'ANSWER' => implode(", ",$correct_answer_index),
																		'FEEDBACK' => $question['feedback'],								
																		'ATTRIBUTES' => $ques_options."<br>"
							
															));
								if (! empty( $question['feedback']) ) { // show feedback only if it is given to the question
									$template->assign_block_vars('question.feedback',array('FEEDBACK' => $question['feedback']));															
								}
								break;										
							} // eof multiplechoice
							case DESCRIPTION :
							{
								$totpnts = 0;
								$arrpts = explode("#", $question['points']);
								$totpnts = $arrpts[4];
								
								if ( trim($question['media_name']) != '' ) {
									$media_array = explode(",",$question['media_name']);
									if (substr($media_array[0], -3) == 'mov') {
									//print_r(getimagesize($somCBT_root_path.'media/'.$courses['media_dir'].$question['media_name']));
										$media = '<center><object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab"  width="'.$media_array[1].'" height="'.($media_array[2]+16).'">';
										$media .= '<param name="SRC" value="'.$somCBT_root_path.'media/'.$HTTP_GET_VARS['dir'].$media_array[0].'">';
										$media .= '<param name="AUTOPLAY" value="true"> <param name="CONTROLLER" value="true">';
										$media .= '<embed src="'.$somCBT_root_path.'media/'.$HTTP_GET_VARS['dir'].$media_array[0].'" autoplay="true" width="'.$media_array[1].'" height="'.($media_array[2]+16).'" controller="true" pluginspage="http://www.apple.com/quicktime/download/"></embed>'; 
										$media .= '</object></center>';
									}
									else {
										$media='<center><img src="'.$somCBT_root_path.'media/'.$HTTP_GET_VARS['dir'].$media_array[0].'" border="0" alt="media"></center>';
									}
								} // eof media display
									
								$template->assign_block_vars('question',array('QNO' => $HTTP_GET_VARS['ARG4'],
																		'QID' => $question['ques_id'],
																		'STEM' => $question['stem']."<br><br>".$media,
																		'STU_ANS' => $answer,
																		'LABEL1' => "Score:",
																		'LABEL2' => "Grader's Comments:",
																		'COMMENT' => $resp,
																		'STU_PNTS' => $point."&nbsp;out of&nbsp;",
																		'TOT_PTS' => $totpnts,								
																		'ATTRIBUTES' => $ques_options."<br>"
												));
								if (! empty( $question['feedback']) ) { // show feedback only if it is given to the question
									$template->assign_block_vars('question.feedback',array('FEEDBACK' => $question['feedback']));															
								}
							break;										
							} // eof description - SMQ
						}	
					}// eof question if
				} //eof question resultset
			} // eof show question
		} // eof IP in range
	} // eof quiz fetch row
} // eof quiz resultset
	
	
	$template->assign_vars(array(
			'S_ROOTDIR' => $somCBT_root_path,
			'Q_FORM_ACTION' => append_sid('quiz_review.php'),
			'COURSE_ID' => $cid,		
			'QUIZ_ID' => $qid,
			'SET_ID' => $setid,
			'QUES_ID' => $quesid,
			'CMMT' => "save",
			'L_LOGIN_LOGOUT' => '', // remove the logout link from the top
			'S_NAV' => $nav_path)
		);


}
else {
	redirect(append_sid("login.$phpEx", true));
}
//
// Generate the page
//

$template->pparse('overall_header');

$template->pparse('body');

include($somCBT_root_path . 'includes/page_tail.'.$phpEx);
?>