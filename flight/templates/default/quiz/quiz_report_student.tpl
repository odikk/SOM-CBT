<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td height="12" colspan="2" align="right">{QUESTION_LINK}</td></tr>
 <tr> 
    <td width="100%" valign="top">
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="1">
			<tr>
				<td class="cattitle" nowrap width="105" align="center" valign="middle">Student Id</td>
				<td class="cattitle" align="center"> Question # (DB Rec. No.)<br>
					<table width="100%" cellspacing="2" border="0">
					<tr>
<!-- BEGIN total_ques -->
						<td class="cattitle" align="center"  width="10">{total_ques.qno}</td>
<!-- END total_ques -->
					<tr>
					</table>
				
				</td>
			</tr>

<!-- BEGIN student -->
			<tr>
				<td class="cattitle" nowrap width="105" align="center" valign="middle"  bgcolor="{student.bgcolor}">{student.id}</td>
				<td class="cattitle" align="center"  bgcolor="{student.bgcolor}"> 
					<table cellspacing="2" border="0"  width="100%">					  
					<tr>
<!-- BEGIN student_ques -->
						<td align="center" width="10" class="cattitle">{student.student_ques.grade}</td>
<!-- END student_ques -->
					<tr>
					</table>
				
				</td>
			</tr>
<!-- END student -->
			</table>
		</td>
	</tr>
	</table>
   </td>
</tr>

<tr><td height="12" colspan="2"></td></tr>
</table>

<br>

<table width="100%"  cellpadding="5" cellspacing="0" border="0">
<!-- BEGIN report_download -->
<tr>
	<td class="row3" height="25">
		<span class="cattitle">Download Statistics</span>
	</td>
</tr>
<tr>
	<td height="23" valign="middle"> 	
		<table width="200"  cellpadding="5" cellspacing="0" border="0" align="left">
		<tr>
<!-- BEGIN info -->
			<td class="cattitle" align="left" valign="middle">{report_download.info.Q_INFO}</td>
<!-- END info -->
		</tr>
		</table>		
	</td>
</tr>
<!-- END report_download -->
</table>