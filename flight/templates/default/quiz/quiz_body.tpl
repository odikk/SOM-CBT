<!-- BEGIN question -->
<form name="question_{OFFSET}" method="post" action="{Q_FORM_ACTION}" target="bottom">
<input type="hidden" name="ARG2" value="{QUIZ_ID}"><input type="hidden" name="ARG1" value="{COURSE_ID}">
<input type="hidden" name="ARG5" value="{question.QID}">
<input type="hidden" name="set" value="{SET_ID}">
<input type="hidden" name="ARG3" value="{TOTAL}">
<input type="hidden" name="status">
<table cellpadding="3" cellspacing="0" border="0" width="98%" align="center">
<tr><td colspan="2" class="gen"><b>Question {OFFSET}</b>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="stat" {question.CHKBOX}>&nbsp;</td></tr><tr><td colspan="2" class="gen">{question.STEM}<p></p></td></tr><tr>
	<td colspan="2" class="gen">		{question.ATTRIBUTES}
	</td>
</tr>
<tr> <td colspan="2" height="6"></td></tr>

</table>
</form>
<!-- END question -->
<script>
// 1 not saved
// 2 saved
// 4 marked

function dosave(form, q_num) {
  var curr_change = "";  var i;
  register_change(q_num);  if (!parent.answered      || (parent.answered[q_num] != 1          && parent.answered[q_num] != 2
	  && parent.answered[q_num] != 4))  {    alert("Error: The question has not been answered yet."+parent.answered[q_num] );    return;  }
  form.stat.disabled= false;
  if (form.stat.checked) {
    parent.answered[q_num] = 4;
    form.status.value = 4;
  } else {
    parent.answered[q_num] = 2;
    form.status.value = 2;  }  form.submit();}

function domark(form, q_num) {
   var curr_change = "";  var i;
  register_change(q_num);  if (!parent.answered      || (parent.answered[q_num] != 1          && parent.answered[q_num] != 2
	  && parent.answered[q_num] != 4))  {    alert("Error: The question has not been answered yet.");    return;  }

  form.stat.disabled= false;
  parent.answered[q_num] = 4;
  form.status.value = 4;  if (form.stat.checked) {  	form.submit();
  } else {
    dosave(form,q_num);
  }}

function register_change(q_num) {
  if (!parent.answered      || (parent.answered[q_num] != 2
	  && parent.answered[q_num] != 4))  {    parent.answered[q_num] = 1;  }}
</script>