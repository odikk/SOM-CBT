<table width="100%" cellpadding="0" cellspacing="0" border="1" align="center"> <tr>    <td align="center" valign="top" width="83%">
<!-- BEGIN password -->
     	<form action="{password.FORM_ACTION}" method="post" name="pwdchange" onsubmit="return chkpwd();">
	<input type="hidden" name="action">
	{password.FORM_HIDDEN}

			<table width="50%" cellpadding="4" cellspacing="10" border="0" class="bodyline">
			<tr>
				<td width="25%" nowrap height="30"><span class="genmed"><b>Old Password : </b></span></td>
				<td nowrap><span class="genmed"><input type="password" name="opwd" value="" size="15"></span></td>
			</tr>
			<tr>
				<td width="25%" nowrap height="30"><span class="genmed"><b>New Password : </b></span></td>
				<td nowrap><span class="genmed"><input type="password" name="newpwd" value="" size="15"></span></td>
			</tr>
			<tr>
				<td width="25%" nowrap height="30"><span class="genmed"><b>Re- enter Password : </b></span></td>
				<td nowrap><span class="genmed"><input type="password" name="rnewpwd" value="" size="15"></span></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="submit" value="Change Password"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><span class="generror"><b>{password.MESSAGE}</b></span></td>
			</tr>
			</table>

	</form>
<!-- END category -->
  </td></tr></table><script>
function chkpwd(){	if ((document.pwdchange.newpwd.value=="")||(document.pwdchange.rnewpwd.value=="")||(document.pwdchange.opwd.value==""))	{		alert("Passwords should not be empty");		return false;	}	if (document.pwdchange.newpwd.value==document.pwdchange.rnewpwd.value)	{		return true;	}	else	{		alert("Your new passwords doesnot match each oher");		return false;	}}  
</script>