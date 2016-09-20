<table width="100%" cellpadding="5" cellspacing="10" border="0" align="center"> <tr>    <td align="center" valign="top" width="83%">	<table width="100%" cellpadding="0" cellspacing="0" border="1"  class="bodyline">	<tr>		<td  valign="top">

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" height="240">
<!-- BEGIN category -->
     	<form action="{category.FORM_ACTION}" method="post" name="settings">
	<input type="hidden" name="action">
	{category.FORM_HIDDEN}
	<table width="100%" cellpadding="4" cellspacing="0" border="0" class="bodyline">	
	<tr>
		<td class="row2" valign="top"><span class="catHead">{category.HEAD}</span></td>
	</tr>

	<tr>
		<td width="100%">
			<table width="50%" cellpadding="0" cellspacing="7" border="0" class="bodyline">

<!-- BEGIN members -->
			<tr>
				<td width="25%" nowrap><span class="genmed">{category.members.NAME}</span></td>
				<td nowrap><span class="genmed">{category.members.VALUE}</span></td>
			</tr>
<!-- END members -->
			<tr>
				<td colspan="2">
<!-- BEGIN buttons -->
					<a href="javascript:void(0);" class="action" onClick="{category.buttons.VALUE} return false;">{category.buttons.NAME}</a>&nbsp;&nbsp;&nbsp;
<!-- END buttons -->	
				</td>
			</tr>
			</table>

		</td>
	</tr>
	</form>	</table>
<!-- END category -->

		</td>
	</tr>
	</table>

		</td>	</tr>	</table>  </td></tr></table><br>
