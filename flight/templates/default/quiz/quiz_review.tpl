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
			<td width="50%"><b>Student Response : </b><i class="nav"><font color="#006600">&nbsp;{question.STU_ANS}</font></i></td>
			<td width="30%"><b>{question.LABEL2} </b><i class="nav"><font color="#990000">&nbsp;{question.COMMENT}</font></i></td>
		</tr>
		<tr class="gen">
			<td><b>{question.LABEL1} </b><b><font color="#990000">&nbsp;{question.STU_PNTS}</font></b><b>{question.TOT_PTS}</b></td>
			<td><b>{question.LABEL} </b><i class="nav"><font color="#990000">&nbsp;{question.ANSWER}</font></i></td>
		</tr>
		</table>
	</td>
</tr>
<!-- BEGIN feedback -->
<tr><td class="gen" height="28" valign="bottom"><b>Feedback/Correct Response : </b></td></tr>
<tr><td class="gen"><blockquote>{question.feedback.FEEDBACK}</blockquote></td></tr>
<tr><td class="gen"><b>Enter Comments Below:</b></td></tr>
<tr><td class="gen"><form action="{Q_FORM_ACTION}">
  <p>
    <textarea name="comments" cols="75" rows="10"></textarea>
    <input type="hidden" name="ARG1" value="{COURSE_ID}" />
    <input type="hidden" name="ARG2" value="{QUIZ_ID}" />
    <input type="hidden" name="ARG3" value="{QUES_ID}" />
    <input type="hidden" name="set" value="{SET_ID}" />
	<input type="hidden" name="comment" value="{CMMT}" />
  </p>
  <p>
    <input type="submit" name="Submit" value="Submit" />
</p>
</form></td></tr>
<!-- END feedback -->
<tr>
	<td align="center" background="{S_ROOTDIR}templates/{T_STYLESHEET}/images/dotlinelrg.gif" height="5"></td>
</tr>
<tr> <td height="6"></td></tr>

</table>
<!-- END question -->

<!-- BEGIN denied -->
<table cellpadding="3" cellspacing="0" border="0" width="98%" align="center">
<tr><td class="gen" height="30">&nbsp;</td></tr>
<tr>
	<td class="gen" align="center">
		<br><p class="generror">No Permissions<br><br>You are allowed to review only Incorrect questions.</p>
	</td>
</tr>
<tr> <td height="6"></td></tr>

</table>
<!-- END denied -->