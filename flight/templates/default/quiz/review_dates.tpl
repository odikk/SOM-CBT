<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center"> <tr>    <td align="left" valign="top" width="100%">	<table width="100%" cellpadding="0" cellspacing="0" border="1"  class="bodyline">	<tr>		<td  height="150"  valign="top">
			<table width="100%"  cellpadding="2" cellspacing="0" border="0">
			<form name="review" action="{Q_POST_ACTION}" method="POST"> 
			<input type="hidden" name="time_now" value="{TIME}">
			<input type="hidden" name="count" value="{COUNT}">
			<input type="hidden" name="action">
			<tr>				<td class="row3" height="25">					<span class="cattitle">Review Slots</span>				</td>			</tr>
			<tr>				<td height="23" valign="middle"> 					
						<table width="95%"  cellpadding="5" cellspacing="0" border="0" align="center">
<!-- BEGIN review -->
						<tr>
							<td class="cattitle" align="left" valign="middle">{review.COUNT}</td>
							<td class="cattitle" align="center" valign="middle" height="35">{review.SLOT}</td>
							<td class="cattitle" align="left" valign="middle">{review.NOW}</td>
						</tr>
<!-- END review -->
						</table>
							
				</td>			 </tr>
			</form>
			</table>

		</td>	</tr>	</table>  </td></tr></table><script language="javascript">
function allow_now(which) {	var form = window.document.review ;	var result = form.time_now.value ;	result = result.split(",");	select_array_index_by_value(form[(which+"date")], result[0]);
	select_array_index_by_value(form[(which+"month")], result[1]);
	select_array_index_by_value(form[(which+"year")], result[2]);
	select_array_index_by_value(form[(which+"hour")], result[4]);
	select_array_index_by_value(form[(which+"min")], result[5]);}  
function select_array_index_by_value(arr, val){	for (i = 0; i < arr.length; i++)    	if (arr[i].value == val)      		arr[i].selected = true;}  
</script>
