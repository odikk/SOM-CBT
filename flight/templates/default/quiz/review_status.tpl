<table border="0" cellspacing="0" cellpadding="3" border="1" width="100%" bgcolor="#EEEEEE"><th class="catHead" colspan="2" align="left" nowrap>&nbsp;<a href="javascript:void(0);" onClick="javascript:showscore('{SCORE}');">Your Score</a></th>
<tr class="cattitle">	<td nowrap="nowrap">&nbsp;&nbsp;		<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/correct.gif" alt="Correct question" border="0" align="absmiddle" vspace="2">&nbsp;Answered Correct	</td>
</tr>
<tr class="cattitle">	<td nowrap="nowrap">&nbsp;&nbsp;		<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/notcorrect.gif" alt="Incorrect question" border="0" align="absmiddle" vspace="2">&nbsp;Answered Incorrect	</td>
</tr>
<tr class="cattitle">	<td nowrap="nowrap">&nbsp;&nbsp;		<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/marked_correct.gif" alt="Marked Correct question" border="0" align="absmiddle" vspace="2">&nbsp;Answered Correct, Marked	</td>
</tr>
<tr class="cattitle">	<td nowrap="nowrap">&nbsp;&nbsp;		<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/marked_notcorrect.gif" alt="Marked Incorrect question" border="0" align="absmiddle" vspace="2">&nbsp;Answered Incorrect, Marked	</td>
</tr>
<tr class="cattitle">	<td nowrap="nowrap">&nbsp;&nbsp;		<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/longtext.gif" alt="Long Text question" border="0" align="absmiddle" vspace="2">&nbsp;Long Answer Question	</td>
</tr>

</table><table cellpadding="2" cellspacing="1" border="2" width="100%" align="center" bgcolor="#EEEEEE" bordercolor="#000000">
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

<script language="javascript">var toanswer = "1, 2";function flag_saved(q_num) {  if (!parent.answered      || (parent.answered[q_num] != 1          && parent.answered[q_num] != 2          && parent.answered[q_num] != 3))  {    parent.answered[q_num] = 2;  }}
answered_image = new Image();answered_image.src = '{S_ROOTDIR}templates/{T_STYLESHEET}/images/correct.gif';
incorrect_image = new Image();incorrect_image.src = '{S_ROOTDIR}templates/{T_STYLESHEET}/images/notcorrect.gif';
mark_answered_image = new Image();mark_answered_image.src = './../templates/default/images/marked_correct.gif';
mark_incorrect_image = new Image();mark_incorrect_image.src = '{S_ROOTDIR}templates/{T_STYLESHEET}/images/marked_notcorrect.gif';
longtext_image = new Image();longtext_image.src = '{S_ROOTDIR}templates/{T_STYLESHEET}/images/longtext.gif';
for (i = 5; i < document.images.length; i++) {
  q_num = (i - 4);  if (parent.answered[q_num] == 1)  {    document.images[i].src = answered_image.src  } else if (parent.answered[q_num] == 3)  {    document.images[i].src = mark_answered_image.src  } else if (parent.answered[q_num] == 4)  {    document.images[i].src = mark_incorrect_image.src
  } else if (parent.answered[q_num] == 5)  {    document.images[i].src = longtext_image.src  }
  else {
    document.images[i].src = incorrect_image.src  }}

function doFinish(flag) {
  var changed=''; for (i = 0; i < parent.answered.length; i++) {   if ( (parent.answered[i] == 1 ) || (!parent.answered[i]) ) {      changed = i;     }   }

  if (flag == 1 ){
  	if ( changed !='' ) {
		confirm_str = confirm("Some questions have not been answered:  \n\nDo you want to proceed?")          	if (confirm_str){
			document.finish.submit();             		          	}
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
} </script>