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

    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left_inact.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#D9E1EF" nowrap width="80"><a class="nav" href="{PREVIEW}"><b>Preview</b></a></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right_inact.jpg" width="6" height="24"></td>
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>

    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left_inact.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#D9E1EF" nowrap width="80"><a class="nav" href="{STATS}"><b>Statistics</b></a></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right_inact.jpg" width="6" height="24"></td>
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>			

    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left_inact.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#D9E1EF" nowrap width="80"><a class="nav" href="{MISC}"><b>Misce..</b></a></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right_inact.jpg" width="6" height="24"></td>
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>
   		
    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left_inact.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#D9E1EF" nowrap width="80"><font size="2"><a class="nav" href="{COMMENTS}"><b>Comments</b></a></font></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right_inact.jpg" width="6" height="24"></td>
    <td bgcolor="#FFFFFF" width="11">&nbsp;</td>
	
	<td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#006600" nowrap width="80"  class="whitemed"><b>USMLE</b></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right.jpg" width="6" height="24"></td>
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
		<td  height="240"valign="top">
<!-- BEGIN usmle -->
			<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
			<tr>
  				<td>
					<iframe frameborder="1" name ="myIFrame" scrolling="auto" width="100%" height="240" align="middle" src="{usmle.SRC}"></iframe>
  				</td>
			</tr>
			<tr>
  				<td align="left" valign="bottom" class="gen" height="105">
					<form name="ques_usmle" method="post" action="{usmle.FORM_ACTION}">
						<input type="hidden" name="action">
						&nbsp;Click here to browse and select USMLE entities:<br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="action" onClick="{usmle.LINK}"> USMLE Controlled Vocabulary </a> &nbsp;&nbsp;
					</form>
  				</td>
			</tr>
			</table>
<!-- END usmle -->			
		</td>
	</tr>

	</table>
  </td>
</tr>

</table>
</td></tr>
</table>
<br>
