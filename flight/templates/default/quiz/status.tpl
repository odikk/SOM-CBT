<table border="0" cellspacing="0" cellpadding="3" border="1" width="100%" bgcolor="#EEEEEE"><th class="catHead" colspan="2" align="left" nowrap>Question Status &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="action" onclick=" return doFinish(1);">Finish</a>&nbsp;&nbsp;&nbsp;</th><tr class="cattitle">	<td nowrap="nowrap">&nbsp;&nbsp;		<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/notAnswered.gif" alt="Unanswered question" border="0" align="absmiddle" vspace="2">&nbsp;Unanswered	</td>
</tr>
<tr class="cattitle">	<td nowrap="nowrap">&nbsp;&nbsp;		<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/answered.gif" alt="Answered question" border="0" align="absmiddle" vspace="2">&nbsp;Answered	</td>
</tr>
<tr class="cattitle">	<td nowrap="nowrap">&nbsp;&nbsp;		<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/marked.gif" alt="Marked question" border="0" align="absmiddle" vspace="2">&nbsp;Marked	</td>
</tr></table><table cellpadding="2" cellspacing="1" border="2" width="100%" align="center" bgcolor="#EEEEEE" bordercolor="#000000">
<!-- BEGIN status -->
<tr>
<!-- BEGIN question -->
	<td class="nav" align="center">
		<a href='javascriipt:void(0);' onClick ="void(top.navigation.Updateframes({status.question.QNO})); return false;">
			{status.question.QNO}<br><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/notAnswered.gif" alt="Question {status.question.QNO}" name="img_{status.question.QNO}" border="0">
		</a>
	</td>
<!-- END question -->
<tr>
<!-- END status -->
</table>
<form name="finish" action="{FINISH_ACTION}" method="POST" target="_top">
<input type="hidden" name="ARG1" value={CID}>
<input type="hidden" name="ARG2" value={QID}>
<input type="hidden" name="ARG3" value="0">
</form>

<script language="javascript">var toanswer = "1, 2";function flag_saved(q_num) {  if (!parent.answered      || (parent.answered[q_num] != 1          && parent.answered[q_num] != 2          && parent.answered[q_num] != 3))  {    parent.answered[q_num] = 2;  }}unsaved_image = new Image();unsaved_image.src = '{S_ROOTDIR}templates/{T_STYLESHEET}/images/notAnswered.gif';
answered_image = new Image();answered_image.src = '{S_ROOTDIR}templates/{T_STYLESHEET}/images/answered.gif';
marked_image = new Image();marked_image.src = '{S_ROOTDIR}templates/{T_STYLESHEET}/images/marked.gif';for (i = 3; i < document.images.length; i++) {
  q_num = i - 2;  if (parent.answered[q_num] == 1      || parent.answered[q_num] == 3)  {    document.images[i].src = unsaved_image.src  }
  if (parent.answered[q_num] == 2)  {
    document.images[i].src = answered_image.src  }
  if (parent.answered[q_num] == 4)  {
    document.images[i].src = marked_image.src  }
}

function doFinish(flag) {
  var changed=''; for (i = 0; i < parent.answered.length; i++) {   if ( (parent.answered[i] == 1 ) || (!parent.answered[i]) ) {      changed = i;     }   }

  if (flag == 1 ){
  	if ( changed !='' ) {
		confirm_str = confirm("Some questions have not been answered:  \n\nDo you want to proceed?")          	if (confirm_str){
			needReview();             		          	}
   	}else {
  
		confirm_str = confirm("This will submit your responses and complete the test. \n\nDo you want to proceed?");
		if (confirm_str){
			needReview();             		          	}
  	}
 }
/* Time out */
 if (flag == 0 ) {
	needReview();
 }
}

function needReview() {

	document.finish.ARG3.value = 2;

 	document.finish.submit();
}</script>