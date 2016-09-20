<table width="100%" cellpadding="5" cellspacing="0" border="0" align="center"> <tr>     <td width="180" valign="top">	<table width="100%" cellpadding="0" cellspacing="0" border="0">
<!-- BEGIN ques_options -->
	<form action="{ques_options.ACTION}" name="{ques_options.FORM_NAME}" method="post">
	{ques_options.FORM_HIDDEN}
	<input type="hidden" name="action" value="">
	<tr>		<td>			<table width="100%"  cellpadding="0" cellspacing="0" border="1" class="bodyline">			<tr>				<td>					<table width="100%"  cellpadding="5" cellspacing="0" border="0">								 	<tr>						<td class="row3" height="25">							<span class="cattitle">{ques_options.TH_NAME} </span>						</td>					</tr>
<!-- BEGIN links -->
					<tr>			   			<td height="28" valign="middle" nowrap>  
							<span  class="genmed">&nbsp;{ques_options.links.VALUE}</span>
						</td>					 </tr>
<!-- END links -->
					</table>				</td>			</tr>			</table>		</td>	</tr>
	<tr>		<td height="12"></td>	</tr>
	</form>
<!-- END ques_options -->	
	</table>   </td>   <td align="left" valign="top">	<table width="100%" cellpadding="0" cellspacing="0" border="1"  class="bodyline">	<tr>		<td  height="240" valign="top"  align="left">
<!-- BEGIN questions -->
		<form name="{questions.FORM_NAME}" action="{questions.ACTION}" method="post">
		{questions.FORM_HIDDEN}
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<th align="left" width="75%" class="catHead">{questions.CAT_NAME}</th>
		</table>
		</td>
		</tr>	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th align="center" bgcolor="#EFEFEF" width="5%">{questions.FLAG}</th><th align="center" bgcolor="#EFEFEF" width="5%">Ques#</th><th align="center" bgcolor="#EFEFEF" width="5%">DB Rec.#</th><th align="left" bgcolor="#EFEFEF" width="20%">{questions.FIELD1}</th><th align="center" bgcolor="#EFEFEF" width="10%">{questions.FIELD2}</th><th align="center" bgcolor="#EFEFEF" width="15%">{questions.FIELD3}</th><th align="center" bgcolor="#EFEFEF" width="10%">{questions.FIELD4}</th><th align="center" bgcolor="#EFEFEF" width="5%">{questions.FIELD5}</th><th align="center" bgcolor="#EFEFEF" width="5%">{questions.FIELD6}</th><th align="center" bgcolor="#EFEFEF" width="20%">{questions.FIELD7}</th>
		</tr>
		
<!-- BEGIN details -->
		<table width="100%" border="0" cellpadding="3" cellspacing="0">
		<tr bgcolor="{questions.details.BGCOLOR}">
			<td class="nav" height="22" align="left" width="5%" >{questions.details.FLG}</td>
			<td class="nav" height="22" align="left" width="5%" >{questions.details.NUM}</td>
			<td class="nav" height="22" align="center" width="5%" >{questions.details.QUES_ID}</td>
			<td class="nav" align="left" width="20%" >
				<a href="javascript:void(0);" onClick="{questions.details.Q_PREVIEW_CLICK}"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/preview.gif" border="0" alt="Preview Img" align="absmiddle"></a> 
				<a href="javascript:void(0)" class="nav" onclick="{questions.details.CLICK}">{questions.details.QUES_NAME}</a>
				<a href="javascript:void(0);" onClick="{questions.details.Q_STATS}"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/stats.gif" border="0" alt="Preview Img" align="absmiddle"></a> 
			</td>
			<td class="nav" align="center" width="10%">{questions.details.QUES_CRTR}</td>
			<td class="nav" align="center" width="15%">{questions.details.QUES_EDIT}</td>
			<td class="nav" align="center" width="10%">{questions.details.CAT_NAME}</td>
			<td class="nav" align="center" width="5%">{questions.details.QUES_RAT}</td>
			<td class="nav" align="center" width="5%">{questions.details.QUES_TYPE}</td>
			<td class="nav" align="center" width="20%">{questions.details.QUES_DATE}</td>

	</tr>
<!-- END details -->
<!-- BEGIN search -->
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="5" cellspacing="2">
				<tr>
					<td class="cattitle" width="120">&nbsp;&nbsp;{questions.search.NAME}</td>
					<td class="cattitle" width="70">&nbsp;{questions.search.FUNC}</td>
					<td class="cattitle">&nbsp;&nbsp;&nbsp;&nbsp;{questions.search.TEXTFIELD}</td>
				</tr>
				</table>
			</td>
		</tr>
<!-- END search -->
		</table>
		</form>
<!-- END questions -->		
		</td>	</tr>	</table>  </td></tr><tr><td height="12" colspan="2"></td></tr></table><br>
