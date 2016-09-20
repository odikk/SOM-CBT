<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
 <tr> 
    <td width="100%" valign="top">
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<table width="100%" cellpadding="3" cellspacing="0" border="1">
				<tr valign="top">
					<th colspan="12">Total Questions:&nbsp;&nbsp;{count}</th>
				</tr>
				<tr valign="top">
					<th rowspan="2" valign="middle">Ques#</th>
					<th rowspan="2" valign="middle">Title</th>
					<th rowspan="2" valign="middle">DB Rec.#</th>
					<th colspan="3">% Correct Of:</th>
					<th rowspan="2" valign="middle" width="60">Discrim</th>
					<th colspan="5" width=""175>Frequency</th>
					
				</tr>
				<tr>
					<th width="50">Whole<br>Group</th>
					<th width="50">Upper<br>25%</th>
					<th width="50">Lower<br>25%</th>
					<th>a</th>
					<th>b</th>
					<th>c</th>
					<th>d</th>
					<th>e</th>
					<th>N</th>
				</tr>
<!-- BEGIN stats -->
				<tr bgcolor="{stats.BGCOLOR}">
					<td class="genmed"><b>{stats.QNO}</b></td>
					<td class="genmed"><b>{stats.QTITLE}</b></td>
					<td class="genmed"><b>{stats.QDBNO}</b></td>
					<td class="gen" align="center">{stats.WHOLE}</td>
					<td class="gen" align="center">{stats.UPPER}</td>
					<td class="gen" align="center">{stats.LOWER}</td>
					<td class="gen" align="center">{stats.DISCRIM}</td>
					<td class="genmed" align="center" width="35">{stats.AFREQ}</td>
					<td class="genmed" align="center" width="35">{stats.BFREQ}</td>
					<td class="genmed" align="center" width="35">{stats.CFREQ}</td>
					<td class="genmed" align="center" width="35">{stats.DFREQ}</td>
					<td class="genmed" align="center" width="35">{stats.EFREQ}</td>
					<td class="genmed" align="center" width="35">{stats.SUM}</td>
				</tr>
<!-- END stats -->
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