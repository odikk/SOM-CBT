<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$qid =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : 0) ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$ca =  ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : ( ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : 0) ;
$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$lock = ( isset($HTTP_GET_VARS['lck']) ) ? ($HTTP_GET_VARS['lck']) : ( ( isset($HTTP_POST_VARS['lck']) ) ? ($HTTP_POST_VARS['lck']) : 'n') ;
$qzid = ( isset($HTTP_GET_VARS['QUIZ']) ) ? ($HTTP_GET_VARS['QUIZ']) : ( ( isset($HTTP_POST_VARS['QUIZ']) ) ? ($HTTP_POST_VARS['QUIZ']) : 0) ;
//
// Start session management
//

$userdata = session_pagestart($user_ip, PAGE_QUIZ_CREATE);
init_userprefs($userdata);
//
// End session management

if( ( $userdata['session_logged_in'] ) && ( ($userdata['user_level'] == ADMIN) || ($userdata['user_level'] == TEACHER )) ){

	include($somCBT_root_path . 'includes/page_header.php');

	$template->set_filenames(array(
				'body' => 'questions/misc.tpl')
			);

	if  ( $userdata['user_level'] == TEACHER )  {
		$sql = "SELECT c.*, cu.user_id, cu.access_level FROM " . COURSE_USERS_TABLE . " cu, ".COURSE_TABLE." c WHERE c.course_id = cu.course_id AND cu.course_id = ".$cid."  AND cu.user_id = " . $userdata['session_user_id'] ." LIMIT 1";

		if ( $result = $db->sql_query($sql) ) {
	
		$courses = $db->sql_fetchrow($result) ;
			
			if ( ( $courses['access_level'] == FACULTY ) || ( $courses['access_level'] == DIRECTOR )  ) {

				$template->assign_block_vars('hide_question',array());
				
			}

		}
		
	}
	if ( $userdata['user_level'] == ADMIN ) {
		$template->assign_block_vars('hide_question',array());	
	}

	if ($mode == 'save') {
			
		$sql = 'UPDATE '.QUESTIONS_TABLE. " SET allow_edit = '".$HTTP_POST_VARS['edit']. "', cat_id = ".$ca.",
					keywords = '". $HTTP_POST_VARS['keywords']."', rating = '". $HTTP_POST_VARS['rating']."', flag = '".$HTTP_POST_VARS['flagit']."', createdby = ". $HTTP_POST_VARS['creator']."  
					WHERE question_id = ".$qid;

		if ($db->sql_query($sql)) {
			$message = '&nbsp;&nbsp;<span class="generror">Question saved</span>';
		}else {
			$message = '&nbsp;&nbsp;<span class="generror">Question NOT saved</span>';
		}

	}

	//edited by SMQ 
	$sql = "SELECT createdby, lastedited_by, lastedited_date, allow_edit, source, keywords, rating, flag FROM ".QUESTIONS_TABLE. " WHERE question_id = ".$qid." LIMIT 1";


	if ( ($result = $db->sql_query($sql) ) && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) ) {
		//The following if/else conditional added by SMQ to trap problems concerning empty createdby field		
		if ($question = $db->sql_fetchrow($result) ) {
			$sql = "SELECT u.user_id, u.username, u.user_fname, u.user_lname, cu.access_level FROM ". USERS_TABLE. " u, ". COURSE_USERS_TABLE ." cu WHERE cu.course_id = " .$cid ." AND cu.user_id = u.user_id AND (u.user_level = '1' OR u.user_level = '2')";

			if ($result1 = $db->sql_query($sql) ) {
				$select_crtor = '<select name="creator">';
				
				while($user = $db->sql_fetchrow($result1) )	{
					if($question['createdby']==$user['user_id']) {
						$createdby=$user['user_fname']." ".$user['user_lname'];
						$select_crtor .= '<option value="'.$user['user_id'].'" selected="selected">'.$user['user_fname'].' '. $user['user_lname'].'</option>';
					}else{
						$select_crtor .= '<option value="'.$user['user_id'].'">'.$user['user_fname'].' '. $user['user_lname'].'</option>';
					}
					if($question['lastedited_by']==$user['user_id']) {
						$editedby=$user['user_fname']." ".$user['user_lname'];
					}
				}
			$select_crtor .= '</select>';
			} // eof usernames
			
			$template->assign_block_vars('question',array('FORM_ACTION' => append_sid('misc.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid) ));
		
			if ( $question['allow_edit'] == 1) {
				$allow_edit = '<input type="radio" name="edit" value="0"> No &nbsp;&nbsp; <input type="radio" name="edit" checked value="1" > Yes';				
			} elseif($quiz['allow_edit'] == 0) {
				$allow_edit = '<input type="radio" name="edit" checked value="0"> No &nbsp;&nbsp; <input type="radio" name="edit" value="1"> Yes';				
			}

			if ( $question['flag'] == 'a') {
				$flagthis = '<input type="radio" name="flagit" value="b"> No &nbsp;&nbsp; <input type="radio" name="flagit" value="a" checked> Yes';				
			} elseif ($question['flag'] == 'b') {
				$flagthis = '<input type="radio" name="flagit" value="b" checked> No &nbsp;&nbsp; <input type="radio" name="flagit" value="a"> Yes';				
			}


			$template->assign_block_vars('question.options',array('NAME' => ' Author', 'VALUE' => $createdby));
			$template->assign_block_vars('question.options',array('NAME' => ' Last Edited By', 'VALUE' => $editedby));
			$template->assign_block_vars('question.options',array('NAME' => ' Last Edited on', 'VALUE' => create_date($question['lastedited_date']) ));			
			$template->assign_block_vars('question.options',array('NAME' => ' Source', 'VALUE' => $question['source']));

			if ( ( $userdata['user_level'] == ADMIN ) || ( $courses['access_level'] == DIRECTOR )  ) {
				$select_option = '<select name="rating">';
				for ( $k = 0 ; $k < 6 ; $k++ ) {
				
					if ( $k == $question['rating']) {
						$select_option .= '<option value="'.$k.'" selected>'.$k.'</option>';
					}
					else {
						$select_option .= '<option value="'.$k.'">'.$k.'</option>';
					}
				}
				$select_option .= '</select>';

				// Get the List of categories
				$sql = "SELECT cat_id, cat_name FROM " . CATEGORY_TABLE . " WHERE course_id = " . $cid . " ORDER BY cat_id";

				if ( ($result = $db->sql_query($sql)) ) {
					
					$cat_option='<select name="ARG2">';
					$cat_valid = 0; // to check category id is a valid id or not

					while( $category = $db->sql_fetchrow($result) )  {			

						if ($category['cat_id'] == $ca) {
							$cat_valid = 1;
							$cat_option .= '<option value="'.$category['cat_id'].'" selected>';
						} else {
							$cat_option .= '<option value="'.$category['cat_id'].'">';
						}
					
						$cat_option .= str_replace('#', '&nbsp;', substr(str_pad($category['cat_name'],18,'#'), 0, 20)).'</option>';
					}
					$cat_option .= '</select>';
				} // eof category list
				
				$template->assign_block_vars('question.options',array('NAME' => 'Author (change)', 'VALUE' => $select_crtor));
				$template->assign_block_vars('question.options',array('NAME' => ' Allow Edit by Creator', 'VALUE' => $allow_edit));
				$template->assign_block_vars('question.options',array('NAME' => ' Rating ', 'VALUE' => $select_option));
				$template->assign_block_vars('question.options',array('NAME' => ' Flag Question ', 'VALUE' => $flagthis));
				$template->assign_block_vars('question.options',array('NAME' => ' Move To Category', 'VALUE' => $cat_option));				
				$template->assign_block_vars('question.options',array('NAME' => ' Keyword', 'VALUE' => '<textarea name="keywords" rows="3">'.$question['keywords'].'</textarea>'));
				$template->assign_block_vars('question.options',array('NAME' => '<a href="javascript:void(0);"  onclick="return submit_form(document.ques_misc,\'save\');" class="action">&nbsp;Save&nbsp;</a>', 'VALUE' => $message));
			}						
			unset($createdby, $editedby, $select_option);
		
	

		}// eof if question
	}	// eof resultset

	$template->assign_vars(array(
				'QUESTION' => append_sid('questions.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'STATS' => append_sid('statistics.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'PREVIEW' => append_sid('preview.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'COMMENTS' => append_sid('comments.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),																											
				'MISC' => append_sid('misc.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'USMLE' => append_sid('usmle.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),											
				'S_ROOTDIR' => $somCBT_root_path,
				'S_NAV' => 'Question Properties')
			);

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

$template->pparse('overall_header');

$template->pparse('body');

include($somCBT_root_path . 'includes/page_tail.php');
?>
