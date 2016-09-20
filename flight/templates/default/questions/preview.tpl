<table  border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center" width="100%">
<tr>
<td width="100%">
<table  border="0" cellspacing="0" cellpadding="0" bgcolor="#639CCEE" align="left">
<tr align="center"> 
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>
<!-- BEGIN hide_question -->
    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left_inact.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#D9E1EF" nowrap width="80"><font size="2"><a class="nav" href="{QUESTION}"><b>Question</b></a></font></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right_inact.jpg" width="6" height="24"></td>
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>

<!-- END hide_question -->

    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#006600" nowrap width="80" class="whitemed"><b>Preview</b></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right.jpg" width="6" height="24"></td>
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>

    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left_inact.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#D9E1EF" nowrap width="80"><font size="2"><a class="nav" href="{STATS}"><b>Statistics</b></a></font></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right_inact.jpg" width="6" height="24"></td>
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>			

    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left_inact.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#D9E1EF" nowrap width="80"><font size="2"><a class="nav" href="{MISC}"><b>Misce..</b></a></font></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right_inact.jpg" width="6" height="24"></td>
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>

    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left_inact.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#D9E1EF" nowrap width="80"><font size="2"><a class="nav" href="{COMMENTS}"><b>Comments</b></a></font></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right_inact.jpg" width="6" height="24"></td>
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>
		
    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left_inact.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#D9E1EF" nowrap width="80"><font size="2"><a class="nav" href="{USMLE}"><b>USMLE</b></a></font></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right_inact.jpg" width="6" height="24"></td>
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>
</tr>
</table>
</td></tr>
<tr><td>

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="borderline" align="center">
 <tr> 
   <td align="left" valign="top">
	<table width="100%" cellpadding="0" cellspacing="0" border="0"  class="bodyline">
	<tr>
		<td  height="240" valign="top">
<!-- BEGIN question -->
			<form name="" action="" method="post">
			<table cellpadding="3" cellspacing="0" border="0" width="98%" align="center">
			<tr>
				<td width="20">&nbsp;</td>
				<td>{question.NAME}</td>
			</tr>
			<tr><td colspan="2" class="gen">{question.STEM}<p></p>{question.MEDIA}</td></tr>
<!-- BEGIN options -->
			<tr>
				<td class="gen" align="center">{question.options.OPTION_ID}</td>
				<td class="gen">{question.options.ATTRIBUTES}</td>
			</tr>
<!-- END options -->
			</table>
	<table width="100%" cellpadding="3" cellspacing="0" border="0"  class="bodyline">
			<tr>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
			</tr>
			<tr><td class="gen">Feedback:<br><br>{question.FEED}</td></tr>
			</table>
			</form>
<!-- END question -->		
		</td>
	</tr>
	
	</table>
  </td>
</tr>

</table>
</td></tr>
</table>
<br>
