<?php
/* 
 * Comments can be posted by other faculties regarding a question
 * Course Director can edit/delete any comments
 * Others can only edit their own posts
 */

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$qid =  ( isset($HTTP_GET_VARS['ARG3']) ) ? ($HTTP_GET_VARS['ARG3']) : ( ( isset($HTTP_POST_VARS['ARG3']) ) ? ($HTTP_POST_VARS['ARG3']) : 0) ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
$ca =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$lock = ( isset($HTTP_GET_VARS['lck']) ) ? ($HTTP_GET_VARS['lck']) : ( ( isset($HTTP_POST_VARS['lck']) ) ? ($HTTP_POST_VARS['lck']) : 'n') ;
$qzid = ( isset($HTTP_GET_VARS['QUIZ']) ) ? ($HTTP_GET_VARS['QUIZ']) : ( ( isset($HTTP_POST_VARS['QUIZ']) ) ? ($HTTP_POST_VARS['QUIZ']) : 0) ;
$currlev1 = ( isset($HTTP_POST_VARS['level1']) ) ? ($HTTP_POST_VARS['level1']) : 0) ;
$currlev2 = ( isset($HTTP_POST_VARS['level2']) ) ? ($HTTP_POST_VARS['level2']) : 0) ;
$currlev3 = ( isset($HTTP_POST_VARS['level3']) ) ? ($HTTP_POST_VARS['level3']) : 0) ;
$currlev4 = ( isset($HTTP_POST_VARS['level4']) ) ? ($HTTP_POST_VARS['level4']) : 0) ;
$currlev5 = ( isset($HTTP_POST_VARS['level5']) ) ? ($HTTP_POST_VARS['level5']) : 0) ;

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_CREATE);
init_userprefs($userdata);
//
// End session management

include($somCBT_root_path . 'includes/page_header.php');

$template->pparse('overall_header');


//include($somCBT_root_path . 'includes/page_tail.'.$phpEx);

?>
<body>
<br>
<table width="40%"  cellpadding="5" cellspacing="0" border="0" align="left">
<form action="list_entities.php" method="post" name="ent">
<tr>
<td>
  <font font-style:weight="bold">Level 1</font>&nbsp;&nbsp;  <select name="level1" onChange="javascript:document.ent.submit();">
      <?php 
$sql = "SELECT * FROM ".USMLE_TABLE." WHERE level_2 = ".$lev1;
$result = $db->sql_query($sql);
while ($level1 = $db->sql_fetchrow($result)) {
	if($level1['level_1']==$level1?>
      <option value="<?php echo $level1['level_1'];?>"><?php echo $level1['element'];?></option>
      <?php } ?>
    </select>
</td>
</tr>
      <?php 
$sql = "SELECT * FROM ".USMLE_TABLE." WHERE level_1 = ".$currlev1." AND level_3 = 0";
$result = $db->sql_query($sql);
while ($level2 = $db->sql_fetchrow($result)) {?>
<tr>
<td>
 <font font-style:weight="bold">Level 2</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <select name="level2">
      <option><?php echo $level1['element'];?></option>
    </select>
</td>
</tr>
<?php } ?>
<?php 
$sql = "SELECT * FROM ".USMLE_TABLE." WHERE level_1 = ".$currlev1." AND level_2 = ".$currlev2." AND level_4 = 0";
$result = $db->sql_query($sql);
while ($level3 = $db->sql_fetchrow($result)) {?>
<tr>
<td>
<font font-style:weight="bold">Level 3</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <select name="level3">
      <option><?php echo $level1['element'];?></option>
    </select>
</td>
</tr>
<?php } ?>
      <?php 
$sql = "SELECT * FROM ".USMLE_TABLE." WHERE level_1 = ".$currlev1." AND level_2 = ".$currlev2." AND level_3 = ".$currlev3." AND level_5 = 0";
$result = $db->sql_query($sql);
while ($level4 = $db->sql_fetchrow($result)) {?>
<tr>
<td>
  <font font-style:weight="bold">Level 4</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <select name="level4">
      <option><?php echo $level1['element'];?></option>
    </select>
</td>
</tr>
<?php } ?>
      <?php 
$sql = "SELECT * FROM ".USMLE_TABLE." WHERE level_5 > 0";
$result = $db->sql_query($sql);
while ($level5 = $db->sql_fetchrow($result)) {?>
<tr>
<td>
 <font font-style:weight="bold">Level 5</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <select name="level5">
      <option><?php echo $level1['element'];?></option>
    </select>
</td>
</tr>
      <?php } ?>
 <tr>
<td>
    <input type="hidden" name="ARG1" value="<?php echo $qid;?>"><input type="hidden" name="ARG3" value="<?php echo $cid;?>"><input type="hidden" name="ARG3" value="<?php echo $cid;?>">
    <input type="submit" name="action" value="Add">
    <input type="button" name="cancel" value="Cancel" onClick="javascript:history.back()">
</td>
</tr>
</form>
</table>
<?php
include($somCBT_root_path . 'includes/page_tail.'.$phpEx);
?>