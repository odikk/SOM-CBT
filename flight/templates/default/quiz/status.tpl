<table border="0" cellspacing="0" cellpadding="3" border="1" width="100%" bgcolor="#EEEEEE">
</tr>
<tr class="cattitle">
</tr>
<tr class="cattitle">
</tr>
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

<script language="javascript">
answered_image = new Image();
marked_image = new Image();
  q_num = i - 2;
  if (parent.answered[q_num] == 2)
    document.images[i].src = answered_image.src
  if (parent.answered[q_num] == 4)
    document.images[i].src = marked_image.src


function doFinish(flag) {
  var changed='';

  if (flag == 1 ){
  	if ( changed !='' ) {
		confirm_str = confirm("Some questions have not been answered:  \n\nDo you want to proceed?")
			needReview();
   	}else {
  
		confirm_str = confirm("This will submit your responses and complete the test. \n\nDo you want to proceed?");
		if (confirm_str){
			needReview();
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
}