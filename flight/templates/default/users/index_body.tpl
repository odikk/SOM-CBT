<table width="100%" cellpadding="5" cellspacing="0" border="0" align="center"> <tr>     <td width="17%" valign="top">	<table width="100%" cellpadding="0" cellspacing="0" border="0">
<!-- BEGIN user_admin -->
	<tr>		<td>			<table width="100%"  cellpadding="0" cellspacing="0" border="1" class="bodyline">			<tr>				<td>					<table width="100%"  cellpadding="0" cellspacing="0" border="0">
				 	<tr>						<td class="row3" height="25">							<span class="cattitle">{user_admin.TH_NAME} </span>						</td>					</tr>
<!-- BEGIN links -->
					<tr>			   			<td height="23" valign="middle">  
							<span  class="cattitle">&nbsp;<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/course.gif" alt="course_ing" align="top">&nbsp;<a href="{user_admin.links.A_LINK}" class="cattitle" >{user_admin.links.A_NAME}</a>	</span>										</td>					 </tr>
<!-- END links --> 
					</table>				</td>			</tr>			</table>		</td>	</tr>
<!-- END user_admin -->	
	<tr>		<td height="12"></td>	</tr>	</table>   </td>   <td align="left" valign="top" width="83%">	<table width="100%" cellpadding="0" cellspacing="0" border="1"  class="bodyline">	<tr>		<td  height="240" valign="top">

			<table width="100%" cellpadding="0" cellspacing="0" border="0">
<!-- BEGIN user --> 
			<tr>				<td>					<table width="100%"  cellpadding="0" cellspacing="0" border="0" class="bodyline">					<tr>						<td>							<table width="100%"  cellpadding="5" cellspacing="0" border="0">								 			<tr>								<td class="row3" height="25">									<span class="cattitle">{user.C_ACTION} </span>								</td>							</tr>

							<tr>			   					<td height="23" valign="middle"> 
									<form name="user" action={user.C_POST_ACTION} method="POST" enctype="multipart/form-data"  > 
									<table width="97%"  cellpadding="5" cellspacing="0" border="0" align="left">
<!-- BEGIN list -->
									<tr>
										<td class="cattitle" align="left" valign="middle">{user.list.C_INFO1}</td>
										<td class="cattitle" align="left" valign="middle">{user.list.C_INFO2}</td>
										<td class="cattitle" align="left" valign="middle">{user.list.C_INFO3}</td>
										<td class="cattitle" align="left" valign="middle">{user.list.C_INFO4}</td>
										<td class="cattitle" align="left" valign="middle">{user.list.C_INFO5}</td>
										<td class="cattitle" align="left" valign="middle">{user.list.C_INFO6}</td>
									</tr>
<!-- END list -->
<!-- BEGIN info -->
									<tr>
										<td class="cattitle" align="left" valign="middle">{user.info.C_INFO}</td>
										<td class="cattitle" align="left" valign="middle">{user.info.C_INPUT}</td>	
									</tr>
									<tr>
										<td class="cattitle" align="left" valign="middle">{user.info.C2_INFO}</td>
										<td class="cattitle" align="left" valign="middle">{user.info.C2_INPUT}</td>	
									</tr>
<!-- END info -->
									</table>
									</form>		
								</td>					 		</tr>

							</table>						</td>					</tr>					</table>				</td>			</tr>
<!-- END user -->	
			<tr>				<td height="12"></td>			</tr>
			</table>
		</td>	</tr>	</table>  </td></tr><tr><td height="12" colspan="2"></td></tr></table><br>
