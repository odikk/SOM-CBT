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

    <td bgcolor="#006600" width="6" align="right"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_left.jpg" width="6" height="24" border="0"></td>
    <td bgcolor="#006600" nowrap width="80"  class="whitemed"><b>Statistics</b></td>
    <td bgcolor="#006600" width="6" align="left"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/top_right.jpg" width="6" height="24"></td>
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
			<table cellpadding="3" cellspacing="0" border="0" width="99%" align="center">
			<tr><td colspan="11" height="10"></td>
			<tr>
				<th rowspan="2" width="30" class="helptext" valign="middle">Quiz ID#</th>
				<th rowspan="2" width="30" class="helptext" valign="middle">Year Used</th>
				<th ALIGN="center" ROWSPAN=2 width=35 class="helptext" valign="middle">N</th>
				<th COLSPAN=3 valign=top class="helptext" width="305">% Correct Of:</th>
				<th VALIGN="middle" ROWSPAN=2 class="helptext" width=40>Discrimination</th>
				<th VALIGN="middle" ROWSPAN=2 class="helptext" width=40>Correct Answer:</th>
				<th COLSPAN=7 class="helptext">Frequency</th>
			</tr>
			<tr>
				<th align="center" valign="middle" class="helptext" width=50>Whole Group</th>
				<th align="center" valign="middle" class="helptext" width=50>Upper 25%</th>
				<th align="center" valign="middle" class="helptext" width=50>Lower 25%</th>
				<th width=30 class="helptext">A</th>
				<th width=30 class="helptext">B</th>
				<th width=30 class="helptext">C</th>
				<th width=30 class="helptext">D</th>
				<th width=30 class="helptext">E</th>
			</tr> 

<!-- BEGIN stats -->
			<tr>
				<td class="genmed" align="center" height="30" nowrap>{stats.QZ_NAME}</td>
				<td class="genmed" align="center" height="30" nowrap>{stats.YEAR}</td>
				<td class="genmed" align="center"> {stats.N} </td>
				<td class="genmed" align="center"> {stats.WHOLE} </td>
				<td class="genmed" align="center"> {stats.U25} </td>
				<td class="genmed" align="center"> {stats.L25} </td>
				<td class="genmed" align="center"> {stats.DISCRI} </td>
				<td class="genmed" align="center"> {stats.CRCT} </td>
				<td class="genmed" align="center"> {stats.F1} </td>
				<td class="genmed" align="center"> {stats.F2} </td>
				<td class="genmed" align="center"> {stats.F3} </td>
				<td class="genmed" align="center"> {stats.F4} </td>
				<td class="genmed" align="center"> {stats.F5} </td>
			</tr>

<!-- END stats -->
			</table>
		</td>
	</tr>

	</table>
  </td>
</tr>

</table>
</td></tr>
<tr><td>

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="borderline" align="left">
 <tr>
   <td align="left" class="helptext">Historical Statistics from WebCT</td>
 </tr>
 <tr> 
   <td align="left" valign="top">
	<table width="100%" cellpadding="0" cellspacing="0" border="0"  class="bodyline">
	<tr>
		<td  height="240" valign="top">
			<table cellpadding="3" cellspacing="0" border="0" width="99%" align="center">
			<tr><td colspan="11" height="10"></td>
			<tr>
				<th rowspan="2" width="10" class="helptext" valign="middle">Quiz ID#</th>
				<th rowspan="2" width="10" class="helptext" valign="middle">Year Used</th>
				<th ALIGN="center" ROWSPAN=2 width=35 class="helptext" valign="middle">N</th>
				<th COLSPAN=3 valign=top class="helptext" width="305">% Correct Of:</th>
				<th VALIGN="middle" ROWSPAN=2 class="helptext" width=40>Discrimination</th>
				<th VALIGN="middle" ROWSPAN=2 class="helptext" width=40>Correct Answer:</th>
				<th COLSPAN=7 class="helptext">Frequency</th>
			</tr>
			<tr>
				<th align="center" valign="middle" class="helptext" width=50>Whole Group</th>
				<th align="center" valign="middle" class="helptext" width=50>Upper 25%</th>
				<th align="center" valign="middle" class="helptext" width=50>Lower 25%</th>
				<th width=30 class="helptext">A</th>
				<th width=30 class="helptext">B</th>
				<th width=30 class="helptext">C</th>
				<th width=30 class="helptext">D</th>
				<th width=30 class="helptext">E</th>
			</tr> 

<!-- BEGIN stats -->
			<tr>
				<td class="genmed" align="center" height="30" width="15">{stats.QZ_NAME2}</td>
				<td class="nav" align="center" height="30" width="15">{stats.YEAR2}</td>
				<td class="genmed" align="center"> {stats.N2} </td>
				<td class="genmed" align="center"> {stats.WHOLE2} </td>
				<td class="genmed" align="center"> {stats.U252} </td>
				<td class="genmed" align="center"> {stats.L252} </td>
				<td class="genmed" align="center" width="20"> {stats.DISCRI2} </td>
				<td class="genmed" align="center"> {stats.CRCT2} </td>
				<td class="genmed" align="center" width="5"> {stats.F12} </td>
				<td class="genmed" align="center" width="5"> {stats.F22} </td>
				<td class="genmed" align="center" width="5"> {stats.F32} </td>
				<td class="genmed" align="center" width="5"> {stats.F42} </td>
				<td class="genmed" align="center" width="5"> {stats.F52} </td>
			</tr>
<!-- END stats -->
			</table>
		</td>
	</tr>

	</table>
  </td>
</tr>

</table>
</td></tr>
</table>
<br>
