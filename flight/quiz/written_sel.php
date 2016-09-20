<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';
define('QUESTIONS_PER_PAGE', 30);

include($somCBT_root_path . 'common.php');
//include($somCBT_root_path . 'includes/question.php');

$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : -1) ;
$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : -1) ;
$quesid =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : 0) ;
$start =  ( isset($HTTP_GET_VARS['start']) ) ? ($HTTP_GET_VARS['start']) : ( ( isset($HTTP_POST_VARS['start']) ) ? ($HTTP_POST_VARS['start']) : 0) ;
$year = ( isset($HTTP_GET_VARS['ARGyr']) ) ? ($HTTP_GET_VARS['ARGyr']) : ( ( isset($HTTP_POST_VARS['ARGyr']) ) ? ($HTTP_POST_VARS['ARGyr']) : '0') ;
$lock = ( isset($HTTP_GET_VARS['lck']) ) ? ($HTTP_GET_VARS['lck']) : ( ( isset($HTTP_POST_VARS['lck']) ) ? ($HTTP_POST_VARS['lck']) : 'n') ;

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_CREATE);
init_userprefs($userdata);
//
// End session management

if( $userdata['session_logged_in'] && ( ( $userdata['user_level'] == ADMIN) || ( $userdata['user_level'] == TEACHER) ) ) {

	$nav_path = '<a href="'.append_sid($somCBT_root_path.'index.php').'" class="nav">Home</a> ' ;

	include($somCBT_root_path . 'includes/page_header.php');

	$template->assign_vars(array(
				'S_ROOTDIR' => $somCBT_root_path,
				'S_NAV' => '')
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


//include($somCBT_root_path . 'includes/page_tail.'.$phpEx);
?>
<table width="100%"  cellpadding="5" cellspacing="0" border="0" align="left">
<tr><td bgcolor="#99CCCC" class="cattitle"><?php echo '<a href="'.append_sid('report.php?action=all&ARG1='.$cid.'&ARG2='.$qid).'" class="nav"> Return to Report </a>';?></td></tr>
<tr><td bgcolor="#99CCCC" class="cattitle">&nbsp;</td></tr>
<tr><td bgcolor="#99CCCC" class="cattitle">&nbsp;</td></tr>
<tr><td class="cattitle">Question Title:</td></tr>
<?php 
if($mode=='view') {
	$sql = " SELECT * FROM ".QUIZ_QUESTIONS_TABLE." WHERE quiz_id = ".$qid." AND course_id = ".$cid." AND qtype = '2' ORDER BY ques_id";
	if ( ($result = $db->sql_query($sql)) ) {
		while( $row = $db->sql_fetchrow($result) ) 	{
			$lnktxt = 'javascript:window.location=\''.append_sid('written_sel.php?action=select&ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$row['ques_id']).'\'';
?>
<tr><td class="nav"><a href="javascript:void(0);" onClick="<?php echo $lnktxt;?>"><?php echo $row['ques_name'];?></a></td></tr>
<?php	}
	}?>
<?php
} else if($mode=='select') {
	$sql = " SELECT * FROM ".QUIZ_QUESTIONS_TABLE." WHERE quiz_id = ".$qid." AND course_id = ".$cid." AND qtype = '2' ORDER BY ques_id";
	if ( ($result = $db->sql_query($sql)) ) {
		while( $row = $db->sql_fetchrow($result) ) 	{
			if($row['ques_id']==$quesid) { 
?>
<tr><td class="cattitle"><font color="#FF3300"><?php echo $row['ques_name'];?></font></td></tr>
<tr><td><table cellpadding="5" cellspacing="0" border="0" align="left">
		<tr>
    	<td class="cattitle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Student:</td>
    	<td class="cattitle" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Question Graded:</td>
  		</tr>
<?php 
				$sql2 = " SELECT resp.*, u.username, u.user_id FROM ".QUIZ_TEXT_RESPONSES_TABLE." resp, ".USERS_TABLE." u WHERE resp.quiz_id = ".$qid." AND resp.question_id = ".$quesid." AND resp.user_id = u.user_id ORDER BY question_id";
				if ( ($result2 = $db->sql_query($sql2)) ) {
					while( $row2 = $db->sql_fetchrow($result2) ) 	{
					$lnktxt =  'javascript:popUp(\''.$somCBT_root_path.'quiz/written_question.php?action=view&ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$row2['question_id'].'&user='.$row2['user_id'].'\',850,700,1,1)';?>
			<tr>
			<td class="nav">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onClick="<?php echo $lnktxt;?>"><?php echo $row2['username'];?></a></td><td class="nav" align="center"><?php echo $row2['point'];?></td>
  			</tr>
<?php		
			}
		}
?>
</table></td></tr>
<?php
			}else{
				$lnktxt =  'javascript:window.location=\''.append_sid('written_sel.php?action=select&ARG1='.$cid.'&ARG2='.$qid.'&ARG3='.$row['ques_id']).'\'';
?>
<tr><td class="nav"><a href="javascript:void(0);" onClick="<?php echo $lnktxt;?>"><?php echo $row['ques_name'];?></a></td></tr>
<?php		}
		}
	}
}?>
</table>
<?php
include($somCBT_root_path . 'includes/page_tail.'.$phpEx);
?>