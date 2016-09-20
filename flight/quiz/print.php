<?php require_once('mysql_connect.php'); ?>
<?php
define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

//var created to determine the behavior of the page: in other words, which form to show. Initially set to 'SHOW' - SMQ 11/9/05																																					   
$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
//grab the course ID from URL parameter or form submission - SMQ 11/8/05
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;
//grab the quiz Id - SMQ 11/9/05
$qid =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : 0) ;
$lock = ( isset($HTTP_GET_VARS['lck']) ) ? ($HTTP_GET_VARS['lck']) : ( ( isset($HTTP_POST_VARS['lck']) ) ? ($HTTP_POST_VARS['lck']) : 'n') ;
$root_path = '/flight/media/';

//include($somCBT_root_path . 'common.php');

$year = ( isset($HTTP_GET_VARS['ARGyr']) ) ? ($HTTP_GET_VARS['ARGyr']) : ( ( isset($HTTP_POST_VARS['ARGyr']) ) ? ($HTTP_POST_VARS['ARGyr']) : 0);

//
// Start session management
//
//$userdata = session_pagestart($user_ip, PAGE_QUIZ_INDEX);
//init_userprefs($userdata);
//
// End session management
//10
//if ( $userdata['session_logged_in'] ) {

require_once('mysql_connect.php');
//include($somCBT_root_path . 'includes/page_header.'.$phpEx);
$query = "SELECT media_dir FROM course WHERE course_id = " .$cid." LIMIT 1";
$res = @mysql_query($query);
$media = mysql_result($res, 0, "media_dir");
$media = addslashes($media);
//Here, we are joining the quiz, quiz_questions, and questions tables in order to have a single recordset with all of the information that we will need to 
//post on the print page. This is required in order to ensure that we are only dealing with a single test for a single course - SMQ
if($lock=='y') {  
$query1 = "SELECT * FROM quiz, quiz_questions WHERE quiz.quiz_id=".$qid." AND quiz.course_id=".$cid." AND quiz.quiz_id=quiz_questions.quiz_id AND quiz.course_id=quiz_questions.course_id ORDER BY quiz_questions.ques_order" ;
}else{
$query1 = "SELECT quiz.quiz_name, quiz.year_used, quiz_questions.ques_order, quiz_questions.ques_id, questions.* FROM quiz, quiz_questions, questions WHERE quiz.quiz_id=".$qid." AND quiz.course_id=".$cid." AND quiz.quiz_id=quiz_questions.quiz_id AND quiz_questions.ques_id=questions.question_id ORDER BY quiz_questions.ques_order" ;
}
$result=mysql_query($query1);
//Count the number of records returned from the SQL query, and use this to tell the loop when to stop iterating through the associative array created from the 
//database query - SMQ
$num=mysql_num_rows($result);
mysql_close();
//print_r($result);
$med = $root_path.$media;
//}else{
//	break();
//}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Print Test</title>
</head>

<body>
<p><a href="javascript:history.back();"><strong>return</strong></a></p>
<table width="100%" border="0">
  <!--before entering the loop, grab the test name, qtype, and year_used from the array and write these to the table at the top - SMQ -->
  <?php $quizname=mysql_result($result, 0, "quiz_name");?>
  <?php $year=mysql_result($result, 0, "year_used");?>
  <tr>
    <td width="30%"><strong>Quiz Name:</strong> <?php echo $quizname;?></td>
    <td width="70%"><div align="center"><strong>Quiz Year:</strong> <?php echo $year;?></div></td>
  </tr>
<!--Start looping through the array and grabbing the pertinent fields from each row we encounter. Next, write these variables to the table - SMQ -->
<?php $i=0; ?>
<?php while($i < $num) {?>
<?php $imgfl=''; ?>
<?php $dbno=mysql_result($result, $i, "ques_id");?>
<?php $qtitle=mysql_result($result, $i, "ques_name");?>
<?php $qstem=mysql_result($result, $i, "stem");?>
<?php $c1=mysql_result($result, $i, "choice1");?>
<?php $c2=mysql_result($result, $i, "choice2");?>
<?php $c3=mysql_result($result, $i, "choice3");?>
<?php $c4=mysql_result($result, $i, "choice4");?>
<?php $c5=mysql_result($result, $i, "choice5");?>
<?php $imgfl=mysql_result($result, $i, "media_name");?>
<?php $feed=mysql_result($result, $i, "feedback");?>
<?php $opt=mysql_result($result, $i, "points");?>
<?php $type=mysql_result($result, $i, "qtype");?>
<?php $qnum = $i+1; ?>
<?php $opt_arr = explode("#", $opt);?>
<?php $qimage = $med.$imgfl;?>
  <tr>
    <td colspan="3"><hr />
	&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><strong>Question #: <?php echo $qnum;?></strong> </td>
  </tr>
  <tr>
    <td colspan="3"><strong>DB Rec.#: <?php echo $dbno;?></strong> </td>
  </tr>
  <tr>
    <td colspan="3"><strong>Title: <?php echo $qtitle;?></strong> </td>
  </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
    <td colspan="3"><?php if($imgfl=='') { echo $qstem; }else{ echo $qstem.'<br><br><img src = "'.$qimage.'">'; }?> </td>
  </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
	<?php if($type =='1') {?>
    <tr>
    <td colspan="3"><strong>A.</strong> <?php echo $c1;?> </td>
  </tr>
    <tr>
    <td colspan="3"><strong>B.</strong> <?php echo $c2;?> </td>
  </tr>
    <tr>
    <td colspan="3"><strong>C.</strong> <?php echo $c3;?> </td>
  </tr>
    <tr>
    <td colspan="3"><strong>D.</strong> <?php echo $c4;?> </td>
  </tr>
    <tr>
    <td colspan="3"><strong>E.</strong> <?php echo $c5;?> </td>
  </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
	<?php for ($j=0; $j < (count($opt_arr)-1); $j++) {?>
	<?php if($j==0) {$ans="A";}elseif($j==1) {$ans="B";}elseif($j==2) {$ans="C";}elseif($j==3) {$ans="D";}else{$ans="E";}?>
	<?php if($opt_arr[$j] == 1) {?> 
    <tr>
      
    <td colspan="3"><strong>Correct Answer:</strong> <?php echo $ans;?></td>
    </tr>
	<?php } ?>
	<?php } ?>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
	<?php } ?>
    <tr>
      <td colspan="3"><strong>Feedback: </strong><?php echo $feed;?></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
  <?php $i++;?>
  <?php } ?>
</table>
</body>