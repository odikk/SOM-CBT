<?phpdefine('IN_somCBT', true);$phpEx = 'php';$somCBT_root_path = './../';include($somCBT_root_path . 'common.php');$cid =  ( isset($HTTP_GET_VARS['cid']) ) ? ($HTTP_GET_VARS['cid']) : ( ( isset($HTTP_POST_VARS['cid']) ) ? ($HTTP_POST_VARS['cid']) : 0) ;$qid =  ( isset($HTTP_GET_VARS['qid']) ) ? ($HTTP_GET_VARS['qid']) : ( ( isset($HTTP_POST_VARS['qid']) ) ? ($HTTP_POST_VARS['qid']) : 0) ;$total_ques =  ( isset($HTTP_GET_VARS['total']) ) ? ($HTTP_GET_VARS['total']) : ( ( isset($HTTP_POST_VARS['total']) ) ? ($HTTP_POST_VARS['total']) : 0) ;$status =   ( isset($HTTP_POST_VARS['status'])  ? ($HTTP_POST_VARS['status']) : -1 ) ;$ques =   ( isset($HTTP_POST_VARS['ques'])  ? ($HTTP_POST_VARS['ques']) : 0 ) ;//// Start session management//$userdata = session_pagestart($user_ip, PAGE_QUIZ_CREATE);init_userprefs($userdata);//// End session managementif( $userdata['session_logged_in'] ) {	include($somCBT_root_path . 'includes/page_header.'.$phpEx);	$template->set_filenames(array(		'body' => 'quiz/status.tpl')		);		$sql = "SELECT ipfrom, ipto, timeopen, timeclose FROM ". QUIZ_TABLE. " WHERE timeopen <= ".time(). " AND timeclose >= ".time()." AND quiz_id = ". $qid . " AND course_id = ".$cid." LIMIT 1";		if ($result = $db->sql_query($sql) ) {		if ($quiz = $db->sql_fetchrow($result)) {			if (isIPInRange(decode_ip($userdata['session_ip']), decode_ip($quiz['ipfrom']), decode_ip($quiz['ipto'])) ) {							for ($count = 0; $count < $total_ques; $count++ ) {					if ($count % 5 == 0 ) {						$template->assign_block_vars('status', array());					}					$template->assign_block_vars('status.question',array('QNO' => ( $count + 1)));				} // eof count questions					// saving or marking the answer	 2 -> saved 4 -> marked								$sql = "REPLACE INTO ". QUIZ_RESPONSES_TABLE . " (quiz_id, question_id, user_id, answer, status) VALUES (". 								$qid .", ". $ques. ", ". $userdata['session_user_id'].", ". $HTTP_POST_VARS['ans'].", '". $status."')";								$r = $db->sql_query($sql);																/*				if  ( ($status == 2) || ($status == 4) ){					$sql = "UPDATE ".QUIZ_RESPONSES_TABLE. " SET ans = " . $HTTP_POST_VARS['ans']. " status = ". $status."WHERE quiz_id = ".$qid. " AND question_id = ".$ques."									AND user_id = ".$userdata['session_user_id'];					$r = $db->sql_query($sql);				}				else if ($status == 1) {					$sql = "INSERT INTO ". QUIZ_RESPONSES_TABLE . " (quiz_id, question_id, user_id, answer) VALUES (".								$qid .", ". $ques. ", ". $userdata['session_user_id'].", ". $HTTP_POST_VARS['ans'].")";					$r = $db->sql_query($sql);												}	*/			} // eof IP in range		} // eof quiz fetch row	} // eof quiz resultset	$template->assign_vars(array(			'CID' => $cid,			'QID' => $qid,			'FINISH_ACTION' => append_sid('submit.php'),			'S_ROOTDIR' => $somCBT_root_path,			'S_NAV' => $nav_path)		);}else {	redirect(append_sid("login.$phpEx", true));}//// Generate the page//$template->pparse('overall_header');$template->pparse('body');include($somCBT_root_path . 'includes/page_tail.'.$phpEx);?>