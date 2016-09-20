<br><br><br>
<form action="{Q_FORM_ACTION}" name="quiz" method="POST">
<input type="hidden" name="ARG2" value="{Q_QUIZ_ID}">
<input type="hidden" name="ARG1" value="{COURSE_ID}">
<input type="hidden" name="total" value="{Q_TOTAL_QUES}">
<input type="hidden" name="set" value="{SET_ID}">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<!-- BEGIN password -->
<tr>
    <td width="100%" valign="middle" height="150">	<table width="40%" cellpadding="3" cellspacing="2" border="0" class="borderline" align="center">
	<tr>
		<td class="generror" align="center" colspan="2" height = "30">{password.message}</td>
	</tr>
	<tr>
		<td class="cattitle" align="center">Password&nbsp;&nbsp;</td>
		<td class="cattitle" align="center"><input type="text" name = "qpwd" size="8" value=""></td>
	</tr>
	<tr>
		<td class="cattitle" align="center" colspan="2"><input type="submit" name="chal" value="Go"></td>
	</tr>
	</table>  </td>
</tr>
<!-- END password -->
<tr><td height="12"></td></tr></table></form>