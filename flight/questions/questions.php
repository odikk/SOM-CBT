<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');
include($somCBT_root_path . 'questions/question.php');

$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
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

if( $userdata['session_logged_in'] && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) || ( $userdata['user_level'] == REVIEWER)) ) {

	$sql = "SELECT c.course_id, ca.* FROM " . COURSE_TABLE ." c, ".CATEGORY_TABLE ." ca  WHERE c.course_id = " . $cid ." AND ca.cat_id = ".$ca. " LIMIT 1" ;

	if ($valid = $db->sql_query($sql) ) {
	
		if( $db -> sql_numrows($valid) == 1) 	{ // only if it is a valid course & category number
		
			$course_cat = $db->sql_fetchrow($valid);
			
			$nav_path = $course_cat['cat_name'] ." - " ;

			include($somCBT_root_path . 'includes/page_header.'.$phpEx);

			$template->set_filenames(array(
				'body' => 'questions/questions.tpl')
				);
								
			// Find the list of courses the user teaches 
			if($lock == 'y') {
				$sql = "SELECT * FROM " . COURSE_USERS_TABLE . " WHERE user_id = " . $userdata['session_user_id']." AND access_level='2'" ;
			}else{
				$sql = "SELECT * FROM " . COURSE_USERS_TABLE . " WHERE user_id = " . $userdata['session_user_id'] ;
			}
			if ( ($result = $db->sql_query($sql)) ) {

				$course['teaches']  = array();  			
				
				while( $courses = $db->sql_fetchrow($result) )
				{
			
					array_push($course['teaches'], $courses['course_id'] );
				}

			}
//FYI - Grabs selected question from DB, and if QUESTION tab is selected, pulls from question.php and is 
//handled there by the EDIT case-select section. From there it sources multichoice.php where it pulls the actual form field content - SMQ
			if ( ($mode == 'view' ) &&( ( $userdata['user_level'] == ADMIN ) || ( in_array($cid, $course['teaches'] ) )) ){
				if($lock=='n') {
					$sql = "SELECT * FROM ".QUESTIONS_TABLE." WHERE question_id = ".$qid ." LIMIT 1";
				}else{
					$sql = "SELECT * FROM ".QUIZ_QUESTIONS_TABLE." WHERE course_id = ".$cid." AND quiz_id = ".$qzid." AND ques_id = ".$qid ." LIMIT 1";
				}				
				if ( ($result = $db->sql_query($sql))) {
								
					if ($row = $db->sql_fetchrow($result)) {
					
						$template->assign_block_vars('hide_options',array());
					
						$nav_path .= $row['ques_name'];
					
						$question = new question();
						$question -> setIDs($cid,$ca,$row['qtype'], $userdata['session_user_id'], $qid, $qzid, $lock);
						
						$question_values = array();
						$question -> setValue($row);
	
						$template->assign_block_vars('question', array('ACTION' => append_sid('questions.php?ARG1='.$cid.'&ARG2='.$ca), 
											'FORM_NAME' => 'questions',
											'FORM_HIDDEN' => '<input type="hidden" name="ARG3" value="'.$qid.'">
															  <input type="hidden" name="lck" value="'.$lock.'">
															  <input type="hidden" name="QUIZ" value="'.$qzid.'">',
											'CONTENTS' => $question -> operation('edit')
										));

					} // eof question
				}// eof resultset
			}// eof view
			elseif ( ($mode == 'save' ) && ( ( $userdata['user_level'] == ADMIN ) || ( in_array($cid, $course['teaches'] ) )) ){

				$question = new question();
				$question -> setIDs($cid,$ca,$HTTP_POST_VARS['qtype'], $userdata['session_user_id'], $qid, $qzid, $lock);
					
				$question_values = array();

				$question_values['qstem'] =  (isset($HTTP_POST_VARS['ques_stem']) ? $HTTP_POST_VARS['ques_stem'] : '') ;
				$question_values['qname'] =  (isset($HTTP_POST_VARS['ques_name']) ? $HTTP_POST_VARS['ques_name'] : '') ;					
				$question_values['qch1'] =  (isset($HTTP_POST_VARS['ques_ch1']) ? $HTTP_POST_VARS['ques_ch1'] : '') ;
				$question_values['qch2'] =  (isset($HTTP_POST_VARS['ques_ch2']) ? $HTTP_POST_VARS['ques_ch2'] : '') ;
				$question_values['qch3'] =  (isset($HTTP_POST_VARS['ques_ch3']) ? $HTTP_POST_VARS['ques_ch3'] : '') ;
				$question_values['qch4'] =  (isset($HTTP_POST_VARS['ques_ch4']) ? $HTTP_POST_VARS['ques_ch4'] : '') ;
				$question_values['qch5'] =  (isset($HTTP_POST_VARS['ques_ch5']) ? $HTTP_POST_VARS['ques_ch5'] : '') ;
				$question_values['media_name'] =  (isset($HTTP_POST_VARS['media_name']) ? $HTTP_POST_VARS['media_name'] : '') ;
				$question_values['feedback'] =  (isset($HTTP_POST_VARS['feedback']) ? $HTTP_POST_VARS['feedback'] : '') ;
				$question_values['points'] ='';
				
				for ( $i=1; $i<6; $i++) {
					$question_values['points'] .= (empty($HTTP_POST_VARS["point$i"]) ?  0 :($HTTP_POST_VARS["point$i"])) ."#";
				}
				$question_values['qtype'] =  (isset($HTTP_POST_VARS['qtype']) ? intval($HTTP_POST_VARS['qtype']) : 1) ;
																																							
				$question -> setValue($question_values);
				if($lock=='n') {	
					$sql = $question -> operation('save');
				}else{
					$sql = $question -> operation('save_pnts');//added by SMQ to deal with update of point values on a locked test question - SMQ
				}	
				if ( !$db->sql_query($sql) )
				{
					$message = 'Error in Updating Question';
				}
				else {
					$message = '&nbsp;&nbsp;Question has been Updated';
				}
				$template->assign_block_vars('hide_options',array());
				
				$nav_path .= $question_values['qname'];

				$template->assign_block_vars('question',array('ACTION' => '', 
											'FORM_NAME' => 'questions',
											'FORM_HIDDEN' => '',
											'CONTENTS' => '<br><br><span class="catHead">'.$message.'</span>&nbsp;&nbsp;<a href="'.append_sid('questions.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid).'" class="action" >Return</a><br><br>'
										));

				unset($question_values);					
			}// eof save
			elseif ( ($mode == 'del' ) && ( ( $userdata['user_level'] == ADMIN ) || ( in_array ($cid, $course['teaches'] ) )) ){
				
				//$sql = "DELETE FROM ".QUIZ_QUESTIONS_TABLE." WHERE ques_id = ".$qid;
				//$db->sql_query($sql);
				
				$sql = "DELETE FROM ".QUESTION_COMMENTS_TABLE." WHERE question_id = ".$qid;
				$db->sql_query($sql);

				//$sql = "DELETE FROM ".STATISTICS_TABLE." WHERE question_id = ".$qid;
				//$db->sql_query($sql);
				
				//$sql = "DELETE FROM ".QUIZ_RESPONSES_TABLE." WHERE question_id = ".$qid;
				//$db->sql_query($sql);

				$sql = "DELETE FROM ".QUESTIONS_TABLE." WHERE question_id = ".$qid;
		
				if ( !$db->sql_query($sql) )
				{
					$message = 'Error in Deleting Question';
				}
				else {
					$message = '&nbsp;&nbsp;Question has been Deleted';
				}

				$nav_path .= $HTTP_POST_VARS['ques_name'];

				$template->assign_block_vars('question',array('ACTION' => '', 
											'FORM_NAME' => 'questions',
											'FORM_HIDDEN' => '',
											'CONTENTS' => '<br><br><span class="catHead">'.$message.'</span>&nbsp;&nbsp;<a href="javascript:void(0);" class="action" onClick="window.close()">Close Window</a><br><br>'
										));

			} // eof del
			if ( ($mode == 'type' ) &&( ( $userdata['user_level'] == ADMIN ) || ( in_array ($cid, $course['teaches'] ) )) ){
	
				$contents = '<br><br><table width="45%"  cellpadding="5" cellspacing="0" border="0" align="center">';
				$contents .= '<tr>';
				$contents .= '<td class="cattitle" align="left" valign="middle">Question Type</td>';
				$contents .= '<td class="cattitle" align="left" valign="middle"><select name="qtype"><option value="1">Multiple Choice</option><option value="2">Written Response</option></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
				$contents .= '</tr>';
				$contents .= '<tr>';
				$contents .= '<td class="cattitle" align="center" valign="middle" colspan="2" height="40"><input type="hidden" name="action">';
				$contents .= '<a href="javascript:void(0);" class="action" onclick="return submit_form(document.questions, \'add\');">&nbsp;Create New Question&nbsp;</a></td>';
				$contents .= '</tr>';
				$contents .= '</table>';
	
				$template->assign_block_vars('question',array('ACTION' => append_sid('questions.php?ARG1='.$cid.'&ARG2='.$ca), 
											'FORM_NAME' => 'questions',
											'FORM_HIDDEN' => '',
											'CONTENTS' => $contents
										));

			}// eof question type selection
			if ( ($mode == 'add' ) &&( ( $userdata['user_level'] == ADMIN ) || ( in_array ($cid, $course['teaches'] ) )) ) {
			
					$question = new question();
					$question -> setIDs($cid,$ca,$HTTP_POST_VARS['qtype'], $userdata['session_user_id']);
					
					$template->assign_block_vars('question',array('ACTION' => append_sid('questions.php?ARG1='.$cid.'&ARG2='.$ca), 
											'FORM_NAME' => 'questions',
											'FORM_HIDDEN' => '',
											'CONTENTS' => $question -> operation('add')
										));
										

			} // eof add
			elseif ( ($mode == 'addresp' ) &&( ( $userdata['user_level'] == ADMIN ) || ( in_array ($cid, $course['teaches'] ) )) ){

				$question = new question();
				$question -> setIDs($cid,$ca,$HTTP_POST_VARS['qtype'], $userdata['session_user_id'], $qid, $qzid, $lock);
					
				$question_values = array();
				if($lock=='n') {
					$question_values['qstem'] =  (isset($HTTP_POST_VARS['ques_stem']) ? $HTTP_POST_VARS['ques_stem'] : '') ;
					$question_values['qname'] =  (isset($HTTP_POST_VARS['ques_name']) ? $HTTP_POST_VARS['ques_name'] : '') ;					
					$question_values['qch1'] =  (isset($HTTP_POST_VARS['ques_ch1']) ? $HTTP_POST_VARS['ques_ch1'] : '') ;
					$question_values['qch2'] =  (isset($HTTP_POST_VARS['ques_ch2']) ? $HTTP_POST_VARS['ques_ch2'] : '') ;
					$question_values['qch3'] =  (isset($HTTP_POST_VARS['ques_ch3']) ? $HTTP_POST_VARS['ques_ch3'] : '') ;
					$question_values['qch4'] =  (isset($HTTP_POST_VARS['ques_ch4']) ? $HTTP_POST_VARS['ques_ch4'] : '') ;
					$question_values['qch5'] =  (isset($HTTP_POST_VARS['ques_ch5']) ? $HTTP_POST_VARS['ques_ch5'] : '') ;
					$question_values['media_name'] =  (isset($HTTP_POST_VARS['media_name']) ? $HTTP_POST_VARS['media_name'] : '') ;				
					$question_values['feedback'] =  (isset($HTTP_POST_VARS['feedback']) ? $HTTP_POST_VARS['feedback'] : '') ;
				}
				$question_values['points'] ='';
				
				for ( $i=1; $i<6; $i++) {
					$question_values['points'] .= (empty($HTTP_POST_VARS["point$i"]) ?  0 :($HTTP_POST_VARS["point$i"])) ."#";
				}
				$question_values['qtype'] =  (isset($HTTP_POST_VARS['qtype']) ? intval($HTTP_POST_VARS['qtype']) : 1) ;
																																							
				$question -> setValue($question_values);
					
				$sql = $question -> operation('addresp');

				if ( !$db->sql_query($sql) )
				{
					$message = 'Error in Creating Question';
				}
				else {
					$message = '&nbsp;&nbsp;Question has been Created';
				}

				$nav_path .= $question_values['qname'];

				$template->assign_block_vars('question',array('ACTION' => '', 
											'FORM_NAME' => 'questions',
											'FORM_HIDDEN' => '',
											'CONTENTS' => '<br><br><span class="catHead">'.$message.'</span>&nbsp;&nbsp;<a href="javascript:void(0);" class="action" onClick="window.close()">Close Window</a><br><br>'
										));

				unset($question_values);					
			}// eof addresp

	

		} // eof of course & cat validity
	}
	

	$template->assign_vars(array(
				'QUESTION' => append_sid('questions.php?&ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'STATS' => append_sid('statistics.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'PREVIEW' => append_sid('preview.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'MISC' => append_sid('misc.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'COMMENTS' => append_sid('comments.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),	
				'USMLE' => append_sid('usmle.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'IMPORT' => append_sid('question_get.php?ARG1='.$cid.'&ARG2='.$ca),																									
				'S_ROOTDIR' => $somCBT_root_path,
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
