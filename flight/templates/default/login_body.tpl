 
<form action="{S_LOGIN_ACTION}" method="post" target="_top">


<table width="400" cellpadding="4" cellspacing="0" border="0" class="borderline" align="center">
  <tr> 
	<th height="25" class="thHead" nowrap="nowrap">Login</th>
  </tr>

  <tr> 
	<td class="row1"><table border="0" cellpadding="3" cellspacing="1" width="100%">
		<tr>
			<td colspan="2" height="30" valign="middle" align="center">
			<!-- BEGIN switch_user_login_error -->
				<span class="generror  ">Login Credentials are not Valid  </span>
			<!-- END switch_user_login_error -->
			</td>
		</tr>
		  <tr> 
			<td width="45%" align="right"><span class="gen">User Name:</span></td>
			<td> 
			  <input type="text" name="username" size="25" maxlength="40" value="{USERNAME}" />
			</td>
		  </tr>
		  <tr> 
			<td align="right"><span class="gen">Password:</span></td>
			<td> 
			  <input type="password" name="password" size="25" maxlength="32"/>
			</td>
		  </tr>
		  <tr align="center"> 
			<td colspan="2">{S_HIDDEN_FIELDS}<input type="submit" name="login" class="mainoption" value="Login"></td>
		  </tr>

		</table></td>
  </tr>
</table>

</form>
