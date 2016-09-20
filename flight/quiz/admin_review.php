<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
$offset =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : 0) ;
$uid =  ( isset($HTTP_POST_VARS['ARG4']) ) ? ($HTTP_POST_VARS['ARG4']) : ( ( isset($HTTP_GET_VARS['ARG4']) ) ? ($HTTP_GET_VARS['ARG4']) : 0) ;
$total_pts = ( isset($HTTP_POST_VARS['ARG5']) ) ? ($HTTP_POST_VARS['ARG5']) : ( ( isset($HTTP_GET_VARS['ARG5']) ) ? ($HTTP_GET_VARS['ARG5']) : 0) ;

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_QUIZ);
init_userprefs($userdata);
//
// End session management

if( $userdata['session_logged_in'] && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) ) {

	include($somCBT_root_path . 'includes/page_header.php');

	$template->set_filenames(array('body' => 'quiz/admin_review.tpl'));
	
	$sql2 = "SELECT qa.ques_order, qa.grade, qa.timestart, qa.timefinish, u.user_fname, u.user_lname  FROM ".QUIZ_ATTEMPTS_TABLE. " qa, ".USERS_TABLE." u WHERE qa.quiz_id = ".$qid." AND qa.user_id = u.user_id AND qa.user_id = ".$uid." LIMIT 1";
			
	if ($result2 = $db->sql_query($sql2) ) {

		if ($qo = $db->sql_fetchrow($result2)) {
			$question_order = explode(",",$qo['ques_order']);
			$grade = $qo['grade'];
			$score = round((($qo['grade']/$total_pts) * 100 ),1);
			$date = date('m/d/Y - H:i a', $qo['timefinish']);
			$name = $qo['user_fname'].' '.$qo['user_lname'];
			
									$template->assign_block_vars('info',array('GRADE'=>$score,
																'DATE'=>$date,
																'NAME'=>$name
										));
		}	
	}
	$count = count($question_order);
	for ($i=0; $i<$count; $i++) {
		$offset = $i+1;
		$media = '';
		$sql = "SELECT qq.*, c.media_dir FROM ".QUIZ_QUESTIONS_TABLE." qq, ".COURSE_TABLE." c
				WHERE qq.quiz_id = ".$qid." AND qq.course_id = ".$cid." AND qq.ques_order = ".$offset." AND c.course_id = ".$cid." LIMIT 1";

		if ($result = $db->sql_query($sql) ) {

			if ($question = $db->sql_fetchrow($result)) {
				$ques_options = '';
				if ($question['qtype'] == '1')
				 {
					$sql1 = "SELECT answer, point FROM ".QUIZ_RESPONSES_TABLE . " WHERE quiz_id = ".$qid. " AND question_id = ".$question['ques_id']." AND user_id =".$uid." LIMIT 1";

					if ($result2 = $db->sql_query($sql1) ) {
						if ( $resp = $db->sql_fetchrow($result2) ) {
							$answer = $resp['answer'];
						} // eof ans							
					}//  eof result2
					
					$letters = array("NA","A","B","C","D","E","F");
					for ( $z = 0; $z < 6; $z++) {
						if (!empty($question['choice'.($z+1)])) {
							$ques_options .= '<p>&nbsp;&nbsp;&nbsp;&nbsp;'.$letters[($z+1)].'.&nbsp;&nbsp;'.$question['choice'.($z+1)]."</p>";
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
							$media .= '<param name="SRC" value="'.$somCBT_root_path.'media/'.$question['media_dir'].$media_array[0].'">';
							$media .= '<param name="AUTOPLAY" value="true"> <param name="CONTROLLER" value="true">';
							$media .= '<embed src="'.$somCBT_root_path.'media/'.$question['media_dir'].$media_array[0].'" autoplay="true" width="'.$media_array[1].'" height="'.($media_array[2]+16).'" controller="true" pluginspage="http://www.apple.com/quicktime/download/"></embed>'; 
							$media .= '</object></center>';
						}
						else {
							$media='<center><img src="'.$somCBT_root_path.'media/'.$question['media_dir'].$media_array[0].'" border="0" alt="media"></center>';
						}
					} // eof media display
												
					$template->assign_block_vars('question',array('QNO' => $offset,
															'STEM' => $question['stem']."<br><br>".$media,
															'ATTRIBUTES' => $ques_options,
															'STU_ANS' => $letters[$answer], 
															'ANSWER' => implode(", ",$correct_answer_index)."<br><hr>"
							
										));		

					
				} // eof multiplechoice
				elseif ($question['qtype'] == '2') 
				{
					$sql1 = "SELECT answer, point, grade_resp FROM ".QUIZ_TEXT_RESPONSES_TABLE . " WHERE quiz_id = ".$qid. " AND question_id = ".$question['ques_id']." AND user_id =".$uid." LIMIT 1";

						if ($result2 = $db->sql_query($sql1) ) {
							if ( $resp = $db->sql_fetchrow($result2) ) {
								$txt_answer = $resp['answer'];
								$grade_resp = $resp['grade_resp'];
								$stupnt = strval($resp['point']);
							} // eof ans							
						}//  eof result2
						
					
						$points = explode ( "#", $question['points']);
						$total_pts = $points[4];

						$ques_options .= '<p>&nbsp;&nbsp;<b>Grader Remarks:</b><font color="red">&nbsp;'.$grade_resp.'&nbsp;&nbsp;</font></p><p><b>&nbsp;&nbsp;Score:</b><font class="gensmallgreen">&nbsp;'.$stupnt.' Out Of '.$total_pts.'</font></p>';

						if ( trim($question['media_name']) != '' ) {
							$media_array = explode(",",$question['media_name']);
							if (substr($media_array[0], -3) == 'mov') {
								//print_r(getimagesize($somCBT_root_path.'media/'.$courses['media_dir'].$question['media_name']));
								$media = '<center><object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab"  width="'.$media_array[1].'" height="'.($media_array[2]+16).'">';
								$media .= '<param name="SRC" value="'.$somCBT_root_path.'media/'.$question['media_dir'].$media_array[0].'">';
								$media .= '<param name="AUTOPLAY" value="true"> <param name="CONTROLLER" value="true">';
								$media .= '<embed src="'.$somCBT_root_path.'media/'.$question['media_dir'].$media_array[0].'" autoplay="true" width="'.$media_array[1].'" height="'.($media_array[2]+16).'" controller="true" pluginspage="http://www.apple.com/quicktime/download/"></embed>'; 
								$media .= '</object></center>';
							}
							else {
								$media='<center><img src="'.$somCBT_root_path.'media/'.$question['media_dir'].$media_array[0].'" border="0" alt="media"></center>';
							}
						} // eof media display
												
						$template->assign_block_vars('question',array('QNO' => $offset,
															'STEM' => $question['stem']."<br><br>".$media,
															'ATTRIBUTES' => $ques_options,
															'STU_ANS' => $txt_answer,
															'ANSWER_TXT' => $question['feedback']
										));
	
				} // eof qtype if - SMQ
			} // eof question if - SMQ
		} // eof question recordset if - SMQ
	}//eof qo for - SMQ

	
	
	$template->assign_vars(array(
			'S_ROOTDIR' => $somCBT_root_path,
			'Q_FORM_ACTION' => append_sid('status.php'),
			'COURSE_ID' => $cid,		
			'QUIZ_ID' => $qid,
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