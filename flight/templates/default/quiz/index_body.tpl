<table width="100%" cellpadding="5" cellspacing="0" border="0"  align="center"> <tr>    <td align="left" valign="top" width="95%">	<table width="100%" cellpadding="0" cellspacing="0" border="1"  class="bodyline">	<tr>		<td  height="240"  valign="top">

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
<!-- BEGIN quiz --> 
	<tr>		<td>			<table width="100%"  cellpadding="0" cellspacing="0" border="0">			<th align="left" class="catHead">
					&nbsp;Test  s&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					{quiz.NEW}
			</th>

			<tr>
				<td>
					<table width="90%"  cellpadding="3" cellspacing="0" border="0" align="center">
<!-- BEGIN info -->
					<tr>
						<td align="left" valign="middle" class="nav">
							{quiz.info.Q_NAME}
						</td>
					</tr>	
					<tr>
						<td align="left" valign="middle" class="genmed">&nbsp;&nbsp;
							 &nbsp {quiz.info.SET_VAL}&nbsp{quiz.info.LOCK}
						</td>
					</tr>				
					<tr>
						<td align="left" valign="middle" class="genmed">&nbsp;&nbsp;
							Availability : &nbsp {quiz.info.AVAIL}
						</td>
					</tr>
					<tr>
						<td align="left" valign="middle">
							<table width="90%"  cellpadding="2" cellspacing="0" border="0" align="left">
							<tr>
								<td width="4">&nbsp;&nbsp;&nbsp&nbsp;</td>
								<td>
<!-- BEGIN options -->
									<a href="javascript:void(0);" class= "action" onClick="{{quiz.info.options.VALUE}}">{quiz.info.options.NAME}</a>&nbsp;&nbsp;
<!-- END options -->
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr><td height="12"></td></tr>			
<!-- END info -->
					</table>
	

				</td>			</tr>			</table>		</td>	</tr>
<!-- END quiz -->
<!-- BEGIN quiz_form --> 
	<tr>		<td>			<table width="100%"  cellpadding="0" cellspacing="0" border="0">			<th align="left" class="catHead">
				{quiz_form.HEAD}&nbsp;&nbsp;&nbsp;
			</th>
			<tr>
				<td>
					<form action="{quiz_form.ACTION}" method="post" name="quiz"> 
					{quiz_form.HIDDEN}
					<input type="hidden" name="action">
					<table width="98%"  cellpadding="3" cellspacing="5" border="0" align="center">
<!-- BEGIN info -->
					<tr> 
						<td class="cattitle" width="20%">{quiz_form.info.NAME}</td>
						<td class="gen">{quiz_form.info.VALUE}</td>
					</tr>
					<tr> 
						<td class="cattitle" width="20%">{quiz_form.info.NAME2}</td>
						<td class="gen">{quiz_form.info.VALUE2}</td>
					</tr>

<!-- END info -->
					<tr>
						<td colspan="2">
			&nbsp;&nbsp;<a href="{quiz_form.FORM_SUBMIT}" class="action">{quiz_form.LABEL}</a> &nbsp;&nbsp; &nbsp;&nbsp;
			<a href="{quiz_form.FORM_CANCEL}"  class="action">{quiz_form.CANCEL_LABEL}</a>

						</td>
					</tr>
					</table>
					</form>
				</td>			</tr>			</table>		</td>	</tr>
<!-- END quiz -->	

	<tr>		<td height="12"></td>	</tr>
	</table>

		</td>	</tr>	</table>  </td></tr></table><br>
