<table width="100%" cellpadding="2" cellspacing="3" border="0"  align="center"> <tr>    <td align="center" valign="top" width="83%">	<table width="100%" cellpadding="0" cellspacing="0" border="1"  class="bodyline">	<tr>		<td  valign="top">

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" height="240">

<!-- BEGIN quiz_settings -->
     	<form action="{quiz_settings.FORM_ACTION}" method="POST" name="settings">
	<input type="hidden" name="action">
	<input type="hidden" name="ARG1" value="{quiz_settings.CID}">
	<input type="hidden" name="ARG2" value="{quiz_settings.QID}">
	<input type="hidden" name="ARG5" value="{quiz_settings.SETID}">
	<input type="hidden" name="cname" value="{quiz_settings.COURSE_NAME}">
	<input type="hidden" name="time_now" value="{quiz_settings.TIME}">
	<table width="100%" cellpadding="4" cellspacing="0" border="0" class="bodyline">	
	<tr>
		<th class="catHead" align="left">Test   settings : {quiz_settings.QUIZ_NAME}</th>
	</tr>

	<tr>
		<td width="100%">
<!-- BEGIN members -->
			<table width="100%" cellpadding="0" cellspacing="7" border="0" class="bodyline">
			<tr>
				<td class="row1" colspan="2"><span class="helptext">&nbsp;<b>{quiz_settings.members.NAME}</b></span></td>
			</tr>
<!-- BEGIN details -->
			<tr>
				<td width="140" nowrap valign="top"><span class="cattitle">&nbsp;&nbsp;&nbsp;{quiz_settings.members.details.NAME}</span></td>
				<td nowrap><span class="genmed">{quiz_settings.members.details.VALUE}</span></td>
			</tr>
<!-- END details -->
			</table>

<!-- END members -->
		</td>
	</tr>
	<tr>
		<td class="catHead" valign="top">
			&nbsp;&nbsp;<a href="javascript:void(0);" onClick="return check_quiz_review();" class="action">Update</a> &nbsp;&nbsp; &nbsp;&nbsp;
			<a href="{quiz_settings.FORM_CANCEL}" class="action">Cancel</a>

		</td>
	</tr>
	</form>	</table>
<!-- END quiz_settings -->
<!-- BEGIN quiz_response -->

			<table width="100%" cellpadding="3" cellspacing="0" border="0" class="bodyline">
			<tr>
				<td class="row2"><span class="cattitle">Test   settings :&nbsp;{quiz_response.QUIZ_NAME}</span></td>
			</tr>
			<tr>
				<td nowrap>
					<span class="genmed">&nbsp;<b>&nbsp;&nbsp;{quiz_response.VALUE}</b></span>&nbsp;&nbsp;&nbsp;
<!-- BEGIN buttons -->
					<a href="{quiz_response.buttons.VALUE}" class="action">{quiz_response.buttons.NAME}</a>&nbsp;&nbsp;&nbsp;
<!-- END buttons -->			
				</td>
			</tr>
			</table>
<!-- END quiz_response -->
		</td>
	</tr>
	</table>

		</td>	</tr>	</table>  </td></tr></table>

<br>