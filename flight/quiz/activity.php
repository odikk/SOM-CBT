<?phpdefine('IN_somCBT', true);$phpEx = 'php';$somCBT_root_path = './../';include($somCBT_root_path . 'common.php');$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;$course_name =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : '') ;$uid =  ( isset($HTTP_GET_VARS['ARG4']) ) ? ($HTTP_GET_VARS['ARG4']) : 0 ;//// Start session management//$userdata = session_pagestart($user_ip, PAGE_QUIZ_INDEX);init_userprefs($userdata);//// End session managementif( ( $userdata['session_logged_in'] ) &&  ($userdata['user_level'] == ADMIN ) ) {	include($somCBT_root_path . 'includes/page_header.php');			$template->set_filenames(array(	'body' => 'quiz/quiz_activity.tpl')	);	if ( ($mode == 'review') && ( $uid != 0 ) ) {		$sql = "UPDATE ".QUIZ_ATTEMPTS_TABLE. " SET reviewed = '2' WHERE user_id = ".$uid." AND quiz_id = ".$qid;		$db->sql_query($sql);	}else if ( ($mode == 'quiz') && ( $uid != 0 ) ) {		$sql = "UPDATE ".QUIZ_ATTEMPTS_TABLE. " SET timefinish = 0 WHERE user_id = ".$uid." AND quiz_id = ".$qid;		$db->sql_query($sql);	}else if ( ($mode == 'reset') && ( $uid != 0 ) ) {		$sql = "DELETE FROM ".QUIZ_ATTEMPTS_TABLE. " WHERE user_id = ".$uid." AND quiz_id = ".$qid; 		$db->sql_query($sql);		$sql = "DELETE FROM ".QUIZ_RESPONSES_TABLE. " WHERE user_id = ".$uid." AND quiz_id = ".$qid;		$db->sql_query($sql);		$sql = "DELETE FROM ".QUIZ_TEXT_RESPONSES_TABLE. " WHERE user_id = ".$uid." AND quiz_id = ".$qid;		$db->sql_query($sql);	}	$nav_path = '<a href="'.append_sid($somCBT_root_path.'index.php').'" class="nav">Home</a> -  ' ;	$sql = "SELECT u.user_id, username, user_fname, user_lname, timefinish, reviewed FROM ".USERS_TABLE." u, ".COURSE_USERS_TABLE." cu, ".QUIZ_ATTEMPTS_TABLE." qa WHERE cu.course_id = ".$cid." AND cu.user_id = u.user_id AND cu.access_level = '5' AND qa.user_id = u.user_id AND qa.quiz_id = ".$qid . " ORDER BY user_lname";	if ( ($result = $db->sql_query($sql)) ) {		$c =1;		while( $quiz_attempts = $db->sql_fetchrow($result) )		{			if ( $c % 2) { $color = "#FFFFD1";$c=0;} else { $color ="#D4D4D4" ;$c=1;}						if ($quiz_attempts['reviewed'] == 2) {				$review = '<span class="generror">& &nbsp;</span>'; 			} else if ($quiz_attempts['reviewed'] == 3)  {				$review .= '<a href="javascript:void(0);" onclick="window.location=\''.append_sid('activity.php?action=review&ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$course_name.'&ARG4='.$quiz_attempts['user_id']).'\'; return false">Allow</a>';						} else {				$review .= '<span class="generror">@&nbsp;</span>'.'<a href="javascript:void(0);" onclick="window.location=\''.append_sid('activity.php?action=review&ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$course_name.'&ARG4='.$quiz_attempts['user_id']).'\'; return false">Allow</a>';						}			$reset = '<a href="javascript:void(0);" onclick="do_confirm(\'reset\',\''.append_sid('activity.php?action=reset&ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$course_name.'&ARG4='.$quiz_attempts['user_id']).'\');">Reset</a>';						$template->assign_block_vars('quiz_attempts', array('NAME' => $quiz_attempts['user_fname'].' '.$quiz_attempts['user_lname'],																'USERNAME' => $quiz_attempts['username'],																'QUIZ' => ( ($quiz_attempts['timefinish'] == 0) ? '' : '<a href="javascript:void(0);" onclick="window.location=\''.append_sid('activity.php?action=quiz&ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$course_name.'&ARG4='.$quiz_attempts['user_id']).'\'; return false">Allow</a> / '.$reset ),																'REVIEW' => $review,																'SUBMIT' => ( ($quiz_attempts['timefinish'] == 0) ? '<a href="javascript:void(0);" onClick="javascript:popUp(\''.append_sid('submit_activity.php?ARG1='.$cid.'&ARG2='.$qid.'&ARG3=1&ARG4='.$quiz_attempts['user_id']).'\',550,450,1,1); return false; ">User not finished</a>' : ''),																'FINISH' => ( ($quiz_attempts['timefinish'] == 0) ? '':'<a href="javascript:void(0);" onClick="javascript:popUp(\''.append_sid('test_log.php?ARG1='.$quiz_attempts['user_id'].'&ARG2='.$qid).'\',550,450,1,1); return false; ">'.create_date($quiz_attempts['timefinish']).'</a>'),																'BGCOLOR' => $color										));			$review = '';		}	}	$nav_path .= '<a href="'.append_sid($somCBT_root_path.'course.php?ARG1='.$cid).'" class="nav">'.$course_name.'</a> -  <a href="'.append_sid('index.php?action=show&ARG1='.$cid).'" class="nav">'.Test.'</a> - <a href="'.append_sid('activity.php?ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$course_name).'" class="genmed" >Activity</a>' ;			}else {	if ( $userdata['user_level'] == STUDENT ) {		redirect(append_sid("index.php", true));		} else {		redirect(append_sid("login.php", true));	}}//// Generate the page//$template->assign_vars(array(			'S_ROOTDIR' => $somCBT_root_path,			'SCRIPT' => '<script src="'.$somCBT_root_path.'scripts/quiz.js" language="JavaScript" type="text/javascript"></script>',			'S_NAV' => $nav_path)		);$template->pparse('overall_header');$template->pparse('body');include($somCBT_root_path . 'includes/page_tail.php');/*	@ -> Did not sign up for review	& - Signed up for review */?>