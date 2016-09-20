<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');


$mode =  ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
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

	$template->set_filenames(array(	'body' => 'quiz/quiz_report_body.tpl')	);

	$nav_path = '<a href="'.append_sid($somCBT_root_path.'index.php').'" class="nav">Home</a> ' ;

	// Find the whether the user teaches particular course
	if ($userdata['user_level'] == ADMIN) {
		$sql = "SELECT c.*, q.* FROM " .COURSE_TABLE." c, ".QUIZ_TABLE ." q WHERE c.course_id = ".$cid." AND q.quiz_id = ".$qid." AND q.course_id = c.course_id LIMIT 1";		
	}
	else if ( $userdata['user_level'] == TEACHER ) {
		$sql = "SELECT c.*, cu.access_level, q.* FROM " . COURSE_USERS_TABLE . " cu, ".COURSE_TABLE." c, ".QUIZ_TABLE." q WHERE c.course_id = cu.course_id AND cu.course_id = ".$cid." AND cu.user_id = " . $userdata['session_user_id'] ." AND q.quiz_id =".$qid." AND q.course_id = c.course_id LIMIT 1";
	}

	if ( $result = $db->sql_query($sql) ) {
	
		if ($course_quiz = $db->sql_fetchrow($result) ) {
	
			$nav_path .= ' -  <a href="'.append_sid($somCBT_root_path.'course.php?ARG1='.$cid).'" class="nav">'.$course_quiz['course_shortname'].'</a> -  <a href="'.append_sid('index.php?action=show&ARG1='.$cid).'" class="nav">'.Test.'</a> -  <a href="'.append_sid('questions.php?action=all&ARG1='.$cid.'&ARG2='.$qid).'" class="nav">'.$course_quiz['quiz_name'].'</a> - <a href="'.append_sid('report.php?action=all&ARG1='.$cid.'&ARG2='.$qid).'" class="nav"> Report </a>'  ;		
			
			if ( ($mode == 'grade') && (( $course_quiz['access_level'] == DIRECTOR ) || ( $userdata['user_level'] == ADMIN )) ) {
			
				$sql = " SELECT count(*) as total_students FROM ". QUIZ_RESPONSES_TABLE. " WHERE quiz_id = ". $qid;
				if ( ($result = $db->sql_query($sql)) ) {
					$temp = $db->sql_fetchrow($result);
					$total_students = $temp['total_students'];
				}
				unset( $temp);
				
				// if an answer is correct the grade is 1
				// if an answer is changed from correct to incorrect after graded once 1 will be still there as i am updating only the correct answers
				// resetting all the responses to the default value which is not correct  (-1) and grading again
								
				$sql = "UPDATE ".QUIZ_RESPONSES_TABLE." SET grade='-1' WHERE quiz_id = ".$qid;
				$db->sql_query($sql);
				
				$sql = " SELECT ques_id, points, qtype FROM ".QUIZ_QUESTIONS_TABLE." WHERE quiz_id = ".$qid. " ORDER BY ques_order ASC";

				if ( ($result = $db->sql_query($sql)) ) {							
				
					while ( $question = $db->sql_fetchrow($result) ) {					
					
						if ( $question['qtype'] == MULTIPLECHOICE ) {
						
							$points = explode ( "#", $question['points']);
							array_pop($points); // last element will always be empty bcos the points seperated by # and also end with #
							arsort($points);
							reset($points);
							$correct_answer_point = current($points) != 0 ? current($points) : 0 ; // max points is considered a correct answer

//							print_r($points);		echo "&nbsp;&nbsp;&nbsp;&nbsp;".$correct_answer_point."<br>";
							
							$count = 0 ; // tracks # of records updated
							
							foreach ($points as $key => $point ) {
								if ( ($point == $correct_answer_point) && ($point != 0) ) { // max points, so corect answer
								
									$sql = "UPDATE ".QUIZ_RESPONSES_TABLE." SET grade = '1' , point = ". $point . " 
												WHERE quiz_id = ".$qid." AND answer = ".($key+1)." AND question_id = ".$question['ques_id'];

									$update_grade = $db->sql_query($sql);
									$count = ( $count + $db->sql_affectedrows() ) ;
									
								}
								else { // not officially correct, but given partial credit
									$sql = "UPDATE ".QUIZ_RESPONSES_TABLE." SET point = ". $point . " 
												WHERE quiz_id = ".$qid." AND answer = ".($key+1)." AND question_id = ".$question['ques_id'];								
									$update_grade = $db->sql_query($sql);
									$count = ( $count + $db->sql_affectedrows() ) ;																					
								}

								if ( $count == $total_students) { // updated records for all students
																	// no need to run updates for other choices bocs noone has answered them
									break;
								}
							
							}
						}						
					
					} // eof question while
				
				} // eof question resultset
				
				$sql = " UPDATE ". QUIZ_TABLE . " SET graded_on = " . time(). " WHERE quiz_id = ". $qid;
				$r = $db -> sql_query($sql);
				
				// Calculate the total points for each student
				$sql = " SELECT user_id FROM ".QUIZ_ATTEMPTS_TABLE. " WHERE quiz_id = ".$qid ." ORDER BY user_id";
				if ( $result = $db->sql_query($sql) )	 {

					while( $course_user = $db->sql_fetchrow($result)) {

						$sqltxt ="SELECT SUM(POINT) AS grade FROM ".QUIZ_TEXT_RESPONSES_TABLE." WHERE user_id = ".$course_user['user_id']." AND quiz_id = ".$qid ;
		
						if ( $resulttxt = $db->sql_query($sqltxt) )	 {		
							 $user_point_txt = $db->sql_fetchrow($resulttxt);
						}//added by SMQ to handle text-based test - SMQ

						$sql2 ="SELECT SUM(POINT) AS grade FROM ".QUIZ_RESPONSES_TABLE." WHERE user_id = ".$course_user['user_id']." AND quiz_id = ".$qid ;
		
							if ( $result2 = $db->sql_query($sql2) )	 {		
								if( $user_point = $db->sql_fetchrow($result2)) {
	
								$student_points[$course_user['user_id']] = ($user_point['grade'] + $user_point_txt['grade']) ;
								$total_score = $total_score + ($user_point['grade'] + $user_point_txt['grade']);
								$sql5 = " UPDATE ".QUIZ_ATTEMPTS_TABLE . " SET grade  = ".($user_point['grade'] + $user_point_txt['grade']) ." WHERE user_id = ".$course_user['user_id']." AND quiz_id = ".$qid;
								$db->sql_query($sql5);
							}
						}
					}
					$total_students = $db->sql_numrows($result);
				}

// start of statistics update

arsort($student_points); // sorts the points in descending order
reset($student_points);

$cutoff = round($total_students/4);
$counter = 0 ;
$upper_25_ids = array();   $lower_25_ids = array();

foreach ($student_points as $key => $value){
	if ( ($counter > $cutoff) && ($upper_cutoff_point == $value) ){
		array_push($upper_25_ids, $key);	
		$counter = $counter + 1; 		
	}
	if ($counter <= $cutoff) {
		array_push($upper_25_ids, $key);	
		$counter = $counter + 1; 
		$upper_cutoff_point = $value;	
	}

}

//print_r($upper_25_ids);

asort($student_points); // sorts the points in ascending order
reset($student_points);

$counter = 0 ;

foreach ($student_points as $key => $value){
	if ( ($counter > $cutoff) && ($lower_cutoff_point == $value) ){
		array_push($lower_25_ids, $key);	
		$counter = $counter + 1; 		
	}

	if ($counter <= $cutoff) {
		array_push($lower_25_ids, $key);	
		$counter = $counter + 1; 
		$lower_cutoff_point = $value;	
	}
}

//print_r($lower_25_ids);
//echo "<br>Lower cut off point &nbsp;".$lower_cutoff_point."<br>"; echo "Upper cut off point &nbsp;".$upper_cutoff_point."<br>";

$mean_score = ( $total_score / count($student_points) ); 

// calculate total test variance
$total_var = 0.00 ;
foreach ($student_points as $key => $value){
	$total_var = $total_var + ( ( $value - $mean_score ) * ( $value - $mean_score ) ) ;
}
$test_var = ( $total_var / ( count($student_points)  - 1 ) ) ;

//echo "mean ".$mean_score."<br>"; echo "var".$test_var."<br>"; echo "SD".sqrt($test_var)."<br>";

//$sql3 = "SELECT ques_id FROM " .QUIZ_QUESTIONS_TABLE ." WHERE quiz_id = ".$qid ." AND ques_id = 24 ORDER BY ques_order ";
$sql3 = "SELECT ques_id, points FROM " .QUIZ_QUESTIONS_TABLE ." WHERE quiz_id = ".$qid ." ORDER BY ques_order";

if ( $result3 = $db->sql_query($sql3)) {

	$pq = 0.0 ;
	
	while($quiz_questions = $db->sql_fetchrow($result3)) {
		
		$ans_arr = explode("#", $quiz_questions['points']);
		$ans_letters = array('A','B','C','D','E');
		for($i=0; $i<(count($ans_arr)); $i++) {
			if($ans_arr[$i] >= 1) {
				$corr_ans .= $ans_letters[$i]. " ";
			}
		}
			
		
		$sql4 = "SELECT user_id, grade, answer FROM ".QUIZ_RESPONSES_TABLE." WHERE quiz_id = ".$qid." AND question_id = ".$quiz_questions['ques_id']." ORDER BY question_id"; 

		if ( $result4 = $db->sql_query($sql4)) {
			
			$correct_ids[$quiz_questions['ques_id']] = array(); // list of users ids who answered the question i correctly
			$correct_ids[$quiz_questions['ques_id']]['upper25'] = 0 ;
			$correct_ids[$quiz_questions['ques_id']]['lower25'] = 0 ;
			$correct_ids[$quiz_questions['ques_id']]['total'] = 0 ;
			$correct_ids[$quiz_questions['ques_id']]['1'] = 0 ;$correct_ids[$quiz_questions['ques_id']]['2'] = 0 ;$correct_ids[$quiz_questions['ques_id']]['3'] = 0 ;
			$correct_ids[$quiz_questions['ques_id']]['4'] = 0 ;$correct_ids[$quiz_questions['ques_id']]['5'] = 0 ;
			$test_score_correct_sum = 0.0;
					
			while($ids = $db->sql_fetchrow($result4)) {
				if ($ids['grade'] == 1) {
					if (in_array($ids['user_id'],$upper_25_ids)) {
						$correct_ids[$quiz_questions['ques_id']]['upper25'] = $correct_ids[$quiz_questions['ques_id']]['upper25'] + 1;
//						echo "**".$correct_ids[$quiz_questions['ques_id']]['upper25']."<br>";
//						echo "**".$ids['user_id']."<br>";
					}
					else if (in_array($ids['user_id'],$lower_25_ids)) {
						$correct_ids[$quiz_questions['ques_id']]['lower25'] = $correct_ids[$quiz_questions['ques_id']]['lower25'] + 1 ;
					}
					$correct_ids[$quiz_questions['ques_id']]['total']++;
					$test_score_correct_sum = $test_score_correct_sum + $student_points[$ids['user_id']];
//					array_push($correct_ids[$quiz_questions['ques_id']], $ids['user_id']);
					$correct_ids[$quiz_questions['ques_id']][$ids['answer']] = $correct_ids[$quiz_questions['ques_id']][$ids['answer']] + 1 ;
				}
				else { // answer not correct
					$correct_ids[$quiz_questions['ques_id']][$ids['answer']] = $correct_ids[$quiz_questions['ques_id']][$ids['answer']] + 1 ;				
				}
			} // eof while ids
			
			$p = $correct_ids[$quiz_questions['ques_id']]['total'] / count($student_points) ;
			$pq = $pq + ($p*(1-$p));
			if ($correct_ids[$quiz_questions['ques_id']]['total'] == 0) {
				$mean_test_score_correct = 0;
			} else {
				$mean_test_score_correct = $test_score_correct_sum / $correct_ids[$quiz_questions['ques_id']]['total'] ;
			}

//			echo "asd".$correct_ids[$quiz_questions['ques_id']]['total'];
			if ($test_var == 0 ){
				$discr = '0.00';
			} else {
				$discr = ( ($p == 1) ? '0.00' : ( ( ($mean_test_score_correct - $mean_score ) / sqrt($test_var) ) * (sqrt($p/(1-$p)))) );
			}
//			echo "<br><br>Discrim ".$discr;
//			echo "<br>Mean Test Score ".$mean_test_score_correct;
//			echo "<br>upper 25%".(($correct_ids[$quiz_questions['ques_id']]['upper25']/count($upper_25_ids))* 100);	
//			echo "<br>lower 25%".(($correct_ids[$quiz_questions['ques_id']]['lower25']/(count($lower_25_ids)))* 100);					
//			echo "<br>Whole".(($correct_ids[$quiz_questions['ques_id']]['total']/($total_students))* 100);
			
			$sql3 = " REPLACE INTO ".STATISTICS_TABLE. " (quiz_id, course_id, question_id, year, total, whole, correct, upper25, lower25, discri, f1, f2, f3, f4, f5) VALUES 
														(".$qid.", ".$cid.", ".$quiz_questions['ques_id'].",'".$year."',".$total_students.", "
														.round(($correct_ids[$quiz_questions['ques_id']]['total']/($total_students))* 100).", '".$corr_ans."', "
														.round(($correct_ids[$quiz_questions['ques_id']]['upper25']/count($upper_25_ids))* 100).","
														.round(($correct_ids[$quiz_questions['ques_id']]['lower25']/(count($lower_25_ids)))* 100).", "
														.round($discr,2) .", "
														.$correct_ids[$quiz_questions['ques_id']]['1'].", "	.$correct_ids[$quiz_questions['ques_id']]['2'].", "
														.$correct_ids[$quiz_questions['ques_id']]['3'].", " .$correct_ids[$quiz_questions['ques_id']]['4'].", "
														.$correct_ids[$quiz_questions['ques_id']]['5']." )";
		//	echo "<br>".$sql3;												
			$db->sql_query($sql3);
			
			unset($correct_ids);
			$corr_ans = '';
		} // eof result4 if
	} // eof while quiz_questions
	
	$tq  = $db->sql_numrows($result3) ;
//	echo "PQ". $pq;
//	echo "<br>var".$test_var;
	$kr20 = ( ($tq/($tq-1) ) * ( (1-($pq/$test_var)) ) ) ;
	
	$sql = "UPDATE ".QUIZ_TABLE." SET kuder = ".$kr20." WHERE quiz_id = ".$qid." AND course_id = ".$cid;
	$db->sql_query($sql);
	
}// eof result3 if

unset ($student_points);	


// eof stats update


				redirect(append_sid('quiz/report.php?action=all&ARG1='.$cid.'&ARG2='.$qid, true));							
			} // eof grading
			
			else {
				if (!empty($course_quiz['graded_on'] )) {
					$message = create_date($course_quiz['graded_on']);
				}
				if (( $course_quiz['access_level'] == DIRECTOR ) || ( $userdata['user_level'] == ADMIN )) {
					$grade_now = '&nbsp;&nbsp;&nbsp;<input type="button" value="Grade Multiple Choice" onclick="javascript:window.location=\''.append_sid('report.php?action=grade&ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$course_quiz['year_used']).'\'">';
					$grade_now .= '&nbsp;&nbsp;&nbsp;<input type="button" value="Grade Written Responses" onclick="javascript:window.location=\''.append_sid('written_sel.php?action=view&ARG1='.$cid.'&ARG2='.$qid.'&ARGyr='.$course_quiz['year_used']).'\'">';
				}
			
				$template->assign_block_vars('quiz_report',array('Q_ACTION' => 'Report'));			
				$template->assign_block_vars('quiz_report.info',array('Q_INFO' => "Quiz was Last graded on &nbsp;&nbsp;".$message.$grade_now, 'Q_INPUT' => ''));			
	
				$template->assign_block_vars('quiz_report',array('Q_ACTION' => 'Statistics'	));
				$template->assign_block_vars('quiz_report.info',array('Q_INFO' => '<input type="button" value="&nbsp;Test&nbsp;" onclick="popUp(\''.append_sid('test_stats.php?ARG1='.$cid.'&ARG2='.$qid).'\', 800,500,1,1)">&nbsp;&nbsp;
					<input type="button" value="&nbsp;Charts&nbsp;" onclick="popUp(\''.append_sid('chart.php?ARG1='.$cid.'&ARG2='.$qid).'\', 800,500,1,1)">&nbsp;&nbsp;
					<input type="button" value="Students" onclick="popUp(\''.append_sid('student_report.php?ARG1='.$cid.'&ARG2='.$qid.'&ARG3=0').'\', 800,500,1,1)">&nbsp;&nbsp;
		<input type="button" value="Multiple Choice Questions" onclick="popUp(\''.append_sid('question_report.php?ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$course_quiz['year_used']).'\', 660,510,1,1)">&nbsp;&nbsp;
		<input type="button" value="Score Sheet" onclick="popUp(\''.append_sid('student_score.php?ARG1='.$cid.'&ARG2='.$qid.'&ARG3=0').'\', 600,550,1,1)">&nbsp;&nbsp;'
																					, 'Q_INPUT' => ''));	
	
//				$template->assign_block_vars('quiz_report',array('Q_ACTION' => 'Download Stats'));			
//				$template->assign_block_vars('quiz_report.info',array('Q_INFO' => '<input type="button" value="Excel Format" onclick="javascript:window.location=\''.append_sid('report.php?action=excel&cid='.$cid.'&qid='.$qid).'\'">&nbsp;&nbsp;<input type="button"value="XML Format"  onclick="javascript:window.location=\''.append_sid('report.php?action=xml&cid='.$cid.'&qid='.$qid).'\'">', 'Q_INPUT' => ''));	
			}
		
		}
	
	
	}
	

	$template->assign_vars(array(
				'S_ROOTDIR' => $somCBT_root_path,
				'S_NAV' => $nav_path,
				'Q_POST_ACTION' => append_sid('report.php') )
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
