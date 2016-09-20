<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$qid =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : 0) ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$ca =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
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
				'body' => 'questions/preview.tpl')
			);

	if  ( $userdata['user_level'] == TEACHER )  {
		$sql = "SELECT c.*, cu.access_level FROM " . COURSE_USERS_TABLE . " cu, ".COURSE_TABLE." c WHERE c.course_id = cu.course_id AND cu.course_id = ".$cid."  AND cu.user_id = " . $userdata['session_user_id'] ." LIMIT 1";

		if ( $result = $db->sql_query($sql) ) {
	
			$courses = $db->sql_fetchrow($result) ;

			if ( ( $courses['access_level'] == FACULTY ) || ( $courses['access_level'] == DIRECTOR )  ) {

				$template->assign_block_vars('hide_question',array());
				
			}
		}
		
	}
	
	if ( $userdata['user_level'] == ADMIN ) { 
		$sql = "SELECT media_dir FROM ". COURSE_TABLE. " WHERE course_id = ".$cid;

		if ( $result1 = $db->sql_query($sql) ) {
	
			$courses = $db->sql_fetchrow($result1) ;
		}
		
		$template->assign_block_vars('hide_question',array());	
	}

if ($lock=='y') {
	$sql = "SELECT * FROM ".QUIZ_QUESTIONS_TABLE." WHERE quiz_id = ".$qzid." AND ques_id = ".$qid." LIMIT 1";
}else{
	$sql = "SELECT * FROM ".QUESTIONS_TABLE. " WHERE question_id = ".$qid." LIMIT 1";
}
	
	if ( ($result = $db->sql_query($sql) ) && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) ) {
				
		if ($question = $db->sql_fetchrow($result) ) {

			if ( trim($question['media_name']) != '' ) {
				$media_array = explode(",",$question['media_name']);
				if (substr($media_array[0], -3) == 'mov') {
					//print_r(getimagesize($somCBT_root_path.'media/'.$courses['media_dir'].$question['media_name']));
					$media = '<center><object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab"  width="'.$media_array[1].'" height="'.($media_array[2]+16).'">';
					$media .= '<param name="SRC" value="'.$somCBT_root_path.'media/'.$courses['media_dir'].$media_array[0].'">';
					$media .= '<param name="AUTOPLAY" value="true"> <param name="CONTROLLER" value="true">';
					$media .= '<embed src="'.$somCBT_root_path.'media/'.$courses['media_dir'].$media_array[0].'" autoplay="true" width="'.$media_array[1].'" height="'.($media_array[2]+16).'" controller="true" pluginspage="http://www.apple.com/quicktime/download/"></embed>'; 
					$media .= '</object></center>';

				}
				else {
					$media='<center><img src="'.$somCBT_root_path.'media/'.$courses['media_dir'].$media_array[0].'" border="0" alt="media"></center>';
				}
			}

			$template->assign_block_vars('question',array('qno' => $i, 'qid' => $question['question_id'],
											'NAME' => $question['ques_name'],
											'STEM' => nl2br($question['stem'])."<br>",
											'MEDIA' => $media."<br>",
											'FEED' => $question['feedback']."<br>"));
			$ca = $question['cat_id'];
			switch ($question['qtype']) {
				
					case MULTIPLECHOICE :
					{
						$letters = array("A.","B.","C.","D.","E.", "F.");
						$points = explode ("#", $question['points'] );
						for ( $z = 0; $z < 6; $z++) {
							if (!empty($question['choice'.($z+1)])) {
							
								$ques_options =$question['choice'.($z+1)].'&nbsp;&nbsp;<span class="helptext">('.$points[$z]." point ) </span>";
								$template->assign_block_vars('question.options',array( 'ATTRIBUTES' => $ques_options, 'OPTION_ID' => $letters[$z] ));
							
							}					
						}	
						break;
					}
				} // eof switch

		}// eof if question
	}	// eof resultset

	$template->assign_vars(array(
				'QUESTION' => append_sid('questions.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'STATS' => append_sid('statistics.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),				
				'MISC' => append_sid('misc.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'COMMENTS' => append_sid('comments.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),
				'USMLE' => append_sid('usmle.php?ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$qid.'&lck='.$lock.'&QUIZ='.$qzid),															
				'S_ROOTDIR' => $somCBT_root_path,
				'S_NAV' => 'Preview Question')
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

/*
<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="270" height="196" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
			    <param name="SRC" value="http://www.anatomy.wright.edu/ntv/TC2/TF17/TF79stlegS17.mov">
				<param name="AUTOPLAY" value="true">
			    <param name="CONTROLLER" value="true">
				<embed src="http://www.anatomy.wright.edu/ntv/TC2/TF17/TF79stlegS17.mov" width="270" height="196" autoplay="true" controller="true" pluginspage="http://www.apple.com/quicktime/download/"> 
				</embed> </object>
*/				
?>
