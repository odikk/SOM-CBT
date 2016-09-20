<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');
//include($somCBT_root_path . 'includes/question.php');

$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : -1) ;
$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : -1) ;
$quesid =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : 0) ;
$start =  ( isset($HTTP_GET_VARS['start']) ) ? ($HTTP_GET_VARS['start']) : ( ( isset($HTTP_POST_VARS['start']) ) ? ($HTTP_POST_VARS['start']) : 0) ;
$year = ( isset($HTTP_GET_VARS['ARGyr']) ) ? ($HTTP_GET_VARS['ARGyr']) : ( ( isset($HTTP_POST_VARS['ARGyr']) ) ? ($HTTP_POST_VARS['ARGyr']) : '') ;
$lock = ( isset($HTTP_GET_VARS['lck']) ) ? ($HTTP_GET_VARS['lck']) : ( ( isset($HTTP_POST_VARS['lck']) ) ? ($HTTP_POST_VARS['lck']) : 'n') ;
$uid = ( isset($HTTP_GET_VARS['user']) ) ? ($HTTP_GET_VARS['user']) : ( ( isset($HTTP_POST_VARS['user']) ) ? ($HTTP_POST_VARS['user']) : 0) ;
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
	
	if( $mode=='view') {

		$user_info = "SELECT * FROM ".USERS_TABLE." WHERE user_id = ".$uid;
		if($info = $db->sql_query($user_info)) {
			$name = $db->sql_fetchrow($info);
			$namef = $name['user_fname'];
			$namel = $name['user_lname'];
		}
?>
<br>
  <table width="80%"  cellpadding="5" cellspacing="0" border="1" bordercolor="#999999" align="left">
	<form action="written_question.php" method="post">
<?php
	$sql = "SELECT * FROM ".QUIZ_QUESTIONS_TABLE." WHERE quiz_id = ".$qid." AND course_id = ".$cid." AND ques_id = ".$quesid." LIMIT 1";
	if ( ($result = $db->sql_query($sql)) ) {
		$row = $db->sql_fetchrow($result);
		$sql2 = " SELECT * FROM ". QUIZ_TEXT_RESPONSES_TABLE." WHERE quiz_id = ".$qid." AND question_id = ".$quesid." AND user_id = ".$uid." LIMIT 1";
		if ( ($result2 = $db->sql_query($sql2)) ) {
			$row2 = $db->sql_fetchrow($result2);
		}
	}?>
	<tr>
	<td class="cattitle" bgcolor="#333333" colspan="2">&nbsp;</td> 
	</tr>
	<tr>
	<td class="cattitle" bgcolor="#CCCCCC" width="30%"><b>User ID: </b></td><td class="gen"><?php echo $row2['user_id'];?></td> 
	</tr>
	<tr>
	  <td class="cattitle" bgcolor="#FFFFCC"><strong>User First Name: </strong></td>
      <td class="gen"><?php echo $namef;?></td> 
	</tr>
	<tr>
	  <td class="cattitle" bgcolor="#CCCCCC"><strong>User Last Name: </strong></td>
      <td class="gen"><?php echo $namel;?></td> 
	</tr>
	<tr>
	  <td bgcolor="#333333" colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  <td class="cattitle" bgcolor="#FFFFCC"><strong>Question Title: </strong></td>
      <td class="gen"><?php echo $row['ques_name'];?></td> 
	</tr>
	<tr>
	  <td class="cattitle" bgcolor="#CCCCCC"><strong>Question Stem: </strong></td>
      <td class="gen"><?php echo $row['stem'];?></td> 
	</tr>
	<tr>
	  <td class="cattitle" bgcolor="#FFFFCC"><strong>Student Response: </strong></td>
      <td class="gen"><font color="#006600"><?php echo $row2['answer'];?></font></td> 
	</tr>
	<tr>
	  <td class="cattitle" bgcolor="#CCCCCC"><strong>Grade Comments: </strong></td>
      <td class="gen"><textarea name="grade_resp" cols="60" rows="10"><?php echo $row2['grade_resp'];?></textarea></td> 
	</tr>
	<tr>
	  <td class="cattitle" bgcolor="#FFFFCC"><strong>Correct Response: </strong></td>
      <td class="gen"><font color="#990000"><?php echo $row['feedback'];?></font></td> 
	</tr>
<?php 
	$pts = $row['points'];
	$arr_pts = explode("#", $pts);
	$maxpts = $arr_pts[4];
	$expts = $row2['point']?>
	<tr>
	  <td class="cattitle" bgcolor="#CCCCCC"><strong>Grade: </strong></td>
      <td class="gen"><select name="points" size="5">
          <?php for($i=0;$i <= $maxpts;$i++) { ?>
				<?php if($expts==$i) {?><option selected><?php echo $i;?></option><?php } else { ?><option><?php echo $i;?></option><?php } ?>
				<?php } ?>
        </select></td> 
	</tr>
	<tr>
	<td bgcolor="#CCCCCC">&nbsp;</td><td bgcolor="#CCCCCC"><input name="action" type="hidden" value="grade"><input name="ARG1" type="hidden" value="<?php echo $cid;?>"><input name="ARG2" type="hidden" value="<?php echo $qid;?>"><input name="ARG3" type="hidden" value="<?php echo $quesid;?>"><input name="user" type="hidden" value="<?php echo $uid;?>"></td>
	</tr>
	<tr>
	<td bgcolor="#333333">&nbsp;</td><td bgcolor="#333333"><input name="done" type="submit" value="Submit Grade">
        <input type="button" name="quit" value="Cancel" onClick="javascript:window.close();"></td>
	</tr>
	</form>
</table>
<?php

	}else if($mode=='grade') {

		$sql = "UPDATE ".QUIZ_TEXT_RESPONSES_TABLE." SET grade_resp = '".$HTTP_POST_VARS['grade_resp']."' , point = ". $HTTP_POST_VARS['points'] . " 
		WHERE quiz_id = ".$qid." AND question_id = ".$quesid." AND user_id = ".$uid;

		$update_grade = $db->sql_query($sql);
?>
		 <table width="60%"  cellpadding="5" cellspacing="0" border="0" align="left">
	<form action="written_grade.php" method="post">
		<tr>
		<td class="cattitle">Question has been successfully graded!</td>
		<td><input type="button" name="done" value="Done" onClick="javascript:window.close();"></td>
		</tr>
	</form>
		</table>
<?php
	}
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

include($somCBT_root_path . 'includes/page_tail.'.$phpEx);
?>