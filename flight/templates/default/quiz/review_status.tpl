<table border="0" cellspacing="0" cellpadding="3" border="1" width="100%" bgcolor="#EEEEEE">
<tr class="cattitle">
</tr>
<tr class="cattitle">
</tr>
<tr class="cattitle">
</tr>
<tr class="cattitle">
</tr>
<tr class="cattitle">
</tr>

</table>
<!-- BEGIN status -->
<tr>
<!-- BEGIN question -->
	<td class="nav" align="center">
		<a href='javascript:void(0);' onClick ="parent.questions.location='{status.question.SRC}'; return false;">
			{status.question.QNO}<br><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/notAnswered.gif" alt="Question {status.question.QNO}" name="img_{status.question.QNO}" border="0">
		</a>
	</td>
<!-- END question -->
<tr>
<!-- END status -->
</table>
<form name="finish" action="{FINISH_ACTION}" method="POST" target="_top">
<input type="hidden" name="cid" value={CID}>
<input type="hidden" name="qid" value={QID}>
<input type="hidden" name="setid" value={SETID}>
<input type="hidden" name="finish" value="finished">
</form>

<script language="javascript">
answered_image = new Image();
incorrect_image = new Image();
mark_answered_image = new Image();
mark_incorrect_image = new Image();
longtext_image = new Image();

  q_num = (i - 4);
  } else if (parent.answered[q_num] == 5)
  else {
    document.images[i].src = incorrect_image.src

function doFinish(flag) {
  var changed='';

  if (flag == 1 ){
  	if ( changed !='' ) {
		confirm_str = confirm("Some questions have not been answered:  \n\nDo you want to proceed?")
			document.finish.submit();
   	}else {
  
		alert("Congratulations .. You have completed the Test ");
		document.finish.submit();
       		
  	}
 }
 if (flag == 0 ) {
   document.finish.submit();
 }
}

function showscore(grade) {
	alert("You scored " + grade);
}