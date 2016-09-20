<!-- BEGIN info -->
<table cellpadding="3" cellspacing="0" border="0" width="98%" align="center">
<tr><td class="gen"><b>Student Name: {info.NAME}</b></td></tr>
<tr><td class="gen"><b>Date/Time Finished: {info.DATE}</b></td></tr>
<tr>
	<td class="gen">
		<b>Grade: {info.GRADE}%</b>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>
<!-- END info -->
<!-- BEGIN question -->
<table cellpadding="3" cellspacing="0" border="0" width="98%" align="center">
<tr><td class="gen"><b>Question {question.QNO}</b></td></tr>
<tr><td class="gen">{question.STEM}<p></p></td></tr>
<tr>
	<td class="gen">
		{question.ATTRIBUTES}
	</td>
</tr>
<tr>
	<td align="center" background="{S_ROOTDIR}templates/{T_STYLESHEET}/images/dotlinelrg.gif" height="5"></td>
</tr>
<tr>
	<td class="gen" height="35"> 
		<table cellpadding="3" cellspacing="0" border="0" width="98%" align="center">
		<tr class="gen">
			<td><b>Student Response : </b><i class="nav">&nbsp;{question.STU_ANS}</i></td>
		</tr>
		<tr class="gen">
			<td><b>Correct Response : </b><i class="nav">&nbsp;{question.ANSWER}{question.ANSWER_TXT}</i></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center" background="{S_ROOTDIR}templates/{T_STYLESHEET}/images/dotlinelrg.gif" height="5"></td>
</tr>
<tr> <td height="6"></td></tr>
<tr>
	<td class="gen" height="35"> 
		<table cellpadding="3" cellspacing="0" border="0" width="98%" align="center">
		<tr>
			<td align="center" width="23%" nowrap>
				<a href="javascript:void(0);" class="action" onClick = "window.location='{question.PREV_OFFSET}; return false;'" onmouseover="window.status='Previous Question'; return true;" onmouseout="window.status=''; return true;" title="Previous Question">{question.PREVIOUS}</a>
			</td>
			<td align="center" nowrap>
				{question.QUES_SELECT}
			</td>
			<td align="center" width="23%" nowrap>
				<a href="javascript:void(0);" class="action" onClick = "window.location='{question.NEXT_OFFSET}; return false;'" onmouseover="window.status='Next Question'; return true;" onmouseout="window.status=''; return true;" title="NEXT Question">{question.NEXT}</a>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center" background="{S_ROOTDIR}templates/{T_STYLESHEET}/images/dotlinelrg.gif" height="5"></td>
</tr>
</table>
<!-- END question -->