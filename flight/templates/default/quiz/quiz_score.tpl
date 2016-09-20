<table width="100%" cellpadding="2" cellspacing="3" border="0"  align="center"> <tr>    <td align="center" valign="top" width="83%">
	<table width="100%" cellpadding="2" cellspacing="0" border="1" class="bodyline" align="center">	
	<tr>
		<th class="cattitle" align="center" width="130">Username</th>
		<th class="cattitle" align="center" width="200" nowrap>Student Name</th>
		<th class="cattitle" align="center" width="50">%</th>
		<th class="cattitle" align="center" width="50">Score ({POINT_TOTAL})</th>
		<th class="cattitle" align="center">Time Taken</th>
	</tr>
<!-- BEGIN quiz_attempts -->
	<tr bgcolor='{quiz_attempts.BGCOLOR}' >
		<td nowrap align="center" height="26"><span class="genmed">&nbsp;<b>&nbsp;{quiz_attempts.USERNAME}</b></span>&nbsp;</td>
		<td><span class="genmed">&nbsp;<b>&nbsp;{quiz_attempts.NAME}</b></span>&nbsp;</td>
		<td align="center"><span class="genmed">&nbsp;<b>&nbsp;&nbsp;{quiz_attempts.PERCENT}</b></span>&nbsp;</td>
		<td align="center"><span class="genmed">&nbsp;<b>&nbsp;&nbsp;{quiz_attempts.SCORE}</b></span>&nbsp;</td>
		<td align="center"><span class="genmed">&nbsp;<b>&nbsp;&nbsp;{quiz_attempts.TIME}</b></span>&nbsp;</td>
	</tr>
<!-- END quiz_attempts -->
	</table>
  </td></tr></table><br>
