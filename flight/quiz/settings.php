<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
$lock = ( isset($HTTP_GET_VARS['lck']) ) ? ($HTTP_GET_VARS['lck']) : ( ( isset($HTTP_POST_VARS['lck']) ) ? ($HTTP_POST_VARS['lck']) : 'n') ;
$setid =  ( isset($HTTP_GET_VARS['ARG5']) ) ? ($HTTP_GET_VARS['ARG5']) : ( ( isset($HTTP_POST_VARS['ARG5']) ) ? ($HTTP_POST_VARS['ARG5']) : 0) ;
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_INDEX);
init_userprefs($userdata);
//
// End session management

if( ( $userdata['session_logged_in'] ) &&  ($userdata['user_level'] == ADMIN ) ) {

	include($somCBT_root_path . 'includes/page_header.php');	
	
	$template->set_filenames(array(	'body' => 'quiz/quiz_settings.tpl')	);

	$nav_path = '<a href="'.append_sid($somCBT_root_path.'index.php').'" class="nav">Home</a> -  ' ;
				
					
	if ( ($mode == 'edit' ) && ( $userdata['user_level'] == ADMIN ) )   { 
	
		$sql = "SELECT qu.*, qs.inst_name, qs.timeopen, qs.timeclose, qs.ipfrom, qs.ipto, qs.passwd, co.course_shortname FROM ". QUIZ_TABLE . " qu, ".QUIZ_SETTINGS_TABLE." qs, ". COURSE_TABLE ." co WHERE qu.quiz_id = ". $qid. " AND qu.course_id = ".$cid. " AND qs.set_id=".$setid." AND co.course_id = ".$cid." AND qu.quiz_id = qs.quiz_id LIMIT 1";
	
		if ( ($result = $db->sql_query($sql)) ) {
				
			if( $quiz = $db->sql_fetchrow($result) )
			{
			
				$release_quiz_options = explode("#", $quiz['release_quiz']);
				
				$show_quiz = array();
				$bs = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

				$show_quiz[0] = ( $release_quiz_options[0] == 1 ) ? ('<input type="checkbox" name="quiz" value="1" checked  onClick="click_quiz()"> <span class="genmed">Release Test</span><br>') : ( '<input type="checkbox" name="quiz" value="0" onClick="click_quiz()"> <span class="genmed">Release Test</span><br>') ;
				$show_quiz[1] = ( $release_quiz_options[1] == 1 ) ? ('<input type="checkbox" name="seq" value="1" checked  onClick="click_seq()"> <span class="genmed">Sequential</span><br>') : ('<input type="checkbox" name="seq" value="0" onClick="click_seq()"> <span class="genmed">Sequential</span><br>') ;
				$show_quiz[2] = ( $release_quiz_options[2] == 1 ) ? ('<input type="checkbox" name="rand" value="1" checked  onClick="click_random()"> <span class="genmed">Randomize</span><br>') : ('<input type="checkbox" name="rand" value="0" onClick="click_random()"> <span class="genmed">Randomize</span><br>') ;

				$show_quiz[3] = ( $release_quiz_options[3] == 1 ) ? ('<input type="checkbox" name="review" value="1"  onClick="click_review()" checked > <span class="genmed">Release Review</span><br>') : ( '<input type="checkbox" name="review" value="0" onClick="click_review()"> <span class="genmed">Release review</span><br>') ;
				$show_quiz[4] = ( $release_quiz_options[4] == 1 ) ? ('<input type="checkbox" name="incorrect" value="1" onClick="click_inc()" checked > <span class="genmed">Show Incorrect Questions only</span><br>') : ('<input type="checkbox" name="incorrect" value="0" onClick="click_inc()"> <span class="genmed">Show Incorrect Questions only</span><br>') ;
				$show_quiz[5] = ( $release_quiz_options[5] == 1 ) ? ('<input type="checkbox" name="r_all" value="1" onClick="click_all()" checked > <span class="genmed">Show All Questions</span><br>') : ('<input type="checkbox" name="r_all" value="0" onClick="click_all()"> <span class="genmed">Show All Questions</span><br>') ;
				$show_quiz[6] = '&nbsp;Duration : &nbsp;<input type="text" name="rtime" value="'.$quiz['review_time'].'" size="6"> &nbsp;&nbsp;<span class="helptext">mins</span><br>';
				$show_quiz[7] = '<a href="javascript:void(0);" onClick="return popUp(\''.append_sid('review_dates.php?ARG1='.$cid.'&ARG2='.$qid.'&ARG5='.$setid).'\',550,260,1,0);">Review Dates</a><br>';
				
				$month_name = array();
				for ($i=1; $i<=12; $i++) {
					$month_name[$i] = strftime("%B",mktime(12,0,0,$i,1,2004)) ;
				}
							
				$temp1 = explode(" ",create_date($quiz['timeopen']));		$temp2 = explode (":", $temp1[3]); 	$temp1 = array_merge($temp1, $temp2);
				$temp3 = explode(" ",create_date($quiz['timeclose']));		$temp4 = explode (":", $temp3[3]); 	$temp3 = array_merge($temp3, $temp4);
				$temp5 = explode(" ",create_date(time(),1,"d F Y G:i"));	$temp6 = explode (":", $temp5[3]); 
				$temp6[1] = intval($temp6[1]); $temp6[0] = intval($temp6[0]); $temp5[0] = intval($temp5[0]); // hrs,minutes,date are with leading zeros(05), to strip the first 0 using intval
				$temp5 = array_merge($temp5, $temp6);  
				
				$temp5[1] = array_search( $temp5[1], $month_name); // changing year to number format
				$temp5 = implode(",",$temp5);

				$template->assign_block_vars('quiz_settings', array('QUIZ_NAME' => $quiz['quiz_name'],
																'FORM_ACTION' => append_sid('settings.php'),
																'FORM_CANCEL' => append_sid('index.php?action=show&ARG1='.$cid),
																'COURSE_NAME' => $quiz['course_shortname'],
																'CID' => $cid, 'QID' => $qid, 'SETID' => $setid, 'TIME' => $temp5));

				$template->assign_block_vars('quiz_settings.members', array('NAME' => 'Basic Settings'));
				$template->assign_block_vars('quiz_settings.members.details', array('NAME' => 'Test Name', 'VALUE' => '<input type="text" name="qname" value="'.$quiz['quiz_name'].'">'));
				$template->assign_block_vars('quiz_settings.members.details', array('NAME' => 'Year Used', 'VALUE' => '<select name="qyear" size="10">
																													<option selected>'.$quiz['year_used'].'</option>
																													<option>0001</option>
																													<option>0102</option>
																													<option>0203</option>
																													<option>0304</option>
																													<option>0405</option>
																													<option>0506</option>
																													<option>0607</option>
																													<option>0708</option>
																													<option>0809</option>
																													<option>0910</option>
																													</select>'));//fourth (final) template NAME/VALUE array pair assignment created by SMQ to allow selection 
																																//of year_used value by user.				
						
				$template->assign_block_vars('quiz_settings.members', array('NAME' => 'Availability'));
				$template->assign_block_vars('quiz_settings.members.details', array('NAME' => 'Available After', 'VALUE' => date_selector('quiz_open', $temp1).'&nbsp;<a href="javascript:void(0);" class="action" onclick="allow_now(\'quiz_open_\');">&nbsp;Allow access Now&nbsp;</a>'));
				$template->assign_block_vars('quiz_settings.members.details', array('NAME' => 'Available Until', 'VALUE' => date_selector('quiz_close', $temp3).'&nbsp;<a href="javascript:void(0);" class="action" onclick="allow_now(\'quiz_close_\');">&nbsp;Deny access Now&nbsp;</a>'));				

				$template->assign_block_vars('quiz_settings.members', array('NAME' => 'Security'));
				$template->assign_block_vars('quiz_settings.members.details', array('NAME' => 'Password', 'VALUE' => '<input type="text" name="qpwd" value="'.$quiz['passwd'].'">'));				
				$template->assign_block_vars('quiz_settings.members.details', array('NAME' => 'IP Address From', 'VALUE' => '<input type="text" name="ipfrom" value="'.decode_ip($quiz['ipfrom']).'">'));
				$template->assign_block_vars('quiz_settings.members.details', array('NAME' => 'IP Address To', 'VALUE' => '<input type="text" name="ipto" value="'.decode_ip($quiz['ipto']).'"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;130A = 130.108.168.30-89<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5N1 = 130.108.168.90-147<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;rm232 = 130.108.168.157-159<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MA = 130.108.168.141<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SQ = 130.108.168.95'));												
				
				$template->assign_block_vars('quiz_settings.members', array('NAME' => 'Release'));
				$template->assign_block_vars('quiz_settings.members.details', array('NAME' => 'Test : ', 'VALUE' => $show_quiz[0].$bs.$show_quiz[1].$bs.$show_quiz[2]));				
				$template->assign_block_vars('quiz_settings.members.details', array('NAME' => 'Review : ', 'VALUE' => $show_quiz[3].$bs.$show_quiz[4].$bs.$show_quiz[5].$bs.$show_quiz[6].$bs.$show_quiz[7]));				


				unset($temp1, $temp2, $temp3, $temp4, $temp5, $temp6, $show_quiz);
				
				$course_name = $quiz['course_shortname'];
			} // not a valid quiz and course id
		} // eof resultset
	} // eof edit settings
	elseif ( ($mode == 'save' ) && ( $userdata['user_level'] == ADMIN ) )  {
	
		$temp['open'] = create_date( sprintf($HTTP_POST_VARS['quiz_open_hour'] . ", " . $HTTP_POST_VARS['quiz_open_min'] .", 0 , " . $HTTP_POST_VARS['quiz_open_date'] . ", " .$HTTP_POST_VARS['quiz_open_month'].", ".$HTTP_POST_VARS['quiz_open_year']), 0);
		$temp['close'] = create_date(  sprintf($HTTP_POST_VARS['quiz_close_hour'] . ", " . $HTTP_POST_VARS['quiz_close_min'] .", 0 , " . $HTTP_POST_VARS['quiz_close_date'] . ", " .$HTTP_POST_VARS['quiz_close_month'].", ".$HTTP_POST_VARS['quiz_close_year']), 0);			

		$release = ( isset($HTTP_POST_VARS['quiz']) ) ? "1#" : "0#" ;
		$release .= ( isset($HTTP_POST_VARS['seq']) ) ? "1#" : "0#" ;
		$release .= ( isset($HTTP_POST_VARS['rand']) ) ? "1#" : "0#" ;
		$release .= ( isset($HTTP_POST_VARS['review']) ) ? "1#" : "0#" ;
		$release .= ( isset($HTTP_POST_VARS['incorrect']) ) ? "1#" : "0#" ;
		$release .= ( isset($HTTP_POST_VARS['r_all']) ) ? "1" : "0" ;
		
		$sql= "UPDATE " .QUIZ_TABLE. " SET quiz_name = '" .$HTTP_POST_VARS['qname']. "', release_quiz = '".$release."', review_time = ".$HTTP_POST_VARS['rtime'].", year_used = '".$HTTP_POST_VARS['qyear']."' WHERE quiz_id = " .$qid . " AND course_id = ".$cid;
					
		if ( !$db->sql_query($sql) )
		{
			$message = 'Error in Updating Test &nbsp;&nbsp;';
		}
		else {
			$message = 'Test Settings have been Updated &nbsp;&nbsp;';
		}

		$sql2= "UPDATE " .QUIZ_SETTINGS_TABLE. " SET timeopen = ".$temp['open'].", timeclose = ". $temp['close'] .", ipfrom = '".encode_ip($HTTP_POST_VARS['ipfrom']) ."', ipto = '".encode_ip($HTTP_POST_VARS['ipto']) ."', passwd = '".$HTTP_POST_VARS['qpwd'] ."' WHERE set_id = " .$setid." AND quiz_id = " .$qid . " AND course_id = ".$cid;
					
		if ( !$db->sql_query($sql2) )
		{
			$message .= '<br><br>Error in Updating Test Instance Settings &nbsp;&nbsp;';
		} else {
			$message .= '<br><br>Test Instance Settings have been Updated &nbsp;&nbsp;';
		}
		$course_name = $HTTP_POST_VARS['cname'];
		$template->assign_block_vars('quiz_response', array('QUIZ_NAME' => $HTTP_POST_VARS['qname'],
										'VALUE' => $message
					));
		$template->assign_block_vars('quiz_response.buttons', array('NAME' => 'Test Home', 'VALUE' => append_sid('index.php?action=show&ARG1='.$cid)));
		$template->assign_block_vars('quiz_response.buttons', array('NAME' => 'Test Instances', 'VALUE' => append_sid('index.php?action=instance&ARG1='.$cid.'&ARG2='.$qid.'&ARG5='.$setid)));		

		unset($temp);
				
	}	// eof of save
	
	$nav_path .= '<a href="'.append_sid($somCBT_root_path.'course.php?ARG1='.$cid).'" class="nav">'.$course_name.'</a> -  <a href="'.append_sid('index.php?action=show&ARG1='.$cid).'" class="nav">'.Test.'</a> - Settings' ;			
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

$template->assign_vars(array(
			'S_ROOTDIR' => $somCBT_root_path,
			'SCRIPT' => '<script src="'.$somCBT_root_path.'scripts/quiz.js" language="JavaScript" type="text/javascript"></script>',
			'S_NAV' => $nav_path)
		);

$template->pparse('overall_header');

$template->pparse('body');

include($somCBT_root_path . 'includes/page_tail.php');

/*
release field 

	1#2#3#4#5#6

1 -> release quiz
2 -> seq release of questions
3 -> scramble questions
4 -> release review
5 -> preview only incorrect
6 -> preview all questions

*/
?>
