<table width="100%" cellpadding="5" cellspacing="0" border="0" align="center"> <tr>    <td align="left" valign="top" width="100%">	<table width="100%" cellpadding="0" cellspacing="0" border="1"  class="bodyline">	<tr>		<td  height="240"  valign="top">
			<table width="100%"  cellpadding="5" cellspacing="0" border="0">
			<form name="report" action="{Q_POST_ACTION}" method="POST"> 
<!-- BEGIN quiz_report -->
			<tr>				<td class="row3" height="25">					<span class="cattitle">{quiz_report.Q_ACTION}</span>				</td>			</tr>
			<tr>				<td height="23" valign="middle"> 
					
						<table width="80%"  cellpadding="5" cellspacing="0" border="0" align="left">
<!-- BEGIN info -->
						<tr>
							<td class="cattitle" align="left" valign="middle"> Quiz Name: </td><td class="gen" align="left" valign="middle">{quiz_report.info.Q_NAME}</td>
						</tr>
						<tr>
							<td class="cattitle" align="left" valign="middle">&nbsp;</td><td class="cattitle" align="left" valign="middle">&nbsp;</td>
						</tr>
							<td class="cattitle" align="left" valign="middle"> Current Quiz Year: </td><td class="gen" align="left" valign="middle">{quiz_report.info.OLD_YEAR}</td>
						</tr>
						<tr>
							<td class="cattitle" align="left" valign="middle">&nbsp;</td><td class="cattitle" align="left" valign="middle">&nbsp;</td>
						</tr>
						</tr>
							<td class="cattitle" align="left" valign="middle"> New Quiz Year: </td><td class="gen" align="left" valign="middle">{quiz_report.info.Q_YEAR}</td>
						</tr>
						<tr>
							<td class="cattitle" align="left" valign="middle">{quiz_report.info.MSG1}</td><td class="cattitle" align="left" valign="middle">{quiz_report.info.MSG2}</td>
						</tr>
						<tr>
							<td class="gen" align="left" valign="middle">{quiz_report.info.HIDDEN}{quiz_report.info.SAVE}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{quiz_report.info.CANCEL}</td>
						</tr>
<!-- END info -->
						</table>
							
				</td>			 </tr>
<!-- END quiz_report -->
			</form>
			</table>

		</td>	</tr>	</table>  </td></tr></table><br>
