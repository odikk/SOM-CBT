<table width="100%" cellpadding="5" cellspacing="0" border="0" align="center"> <tr>     <td width="25%" valign="top">	<table width="100%" cellpadding="0" cellspacing="0" border="0">
<!-- BEGIN user_admin -->
	<tr>		<td>			<table width="100%"  cellpadding="0" cellspacing="0" border="1" class="bodyline">			<tr>				<td>					<table width="100%"  cellpadding="0" cellspacing="0" border="0">
				 	<tr>						<td class="row3" height="25">							<span class="cattitle">{user_admin.TH_NAME} </span>						</td>					</tr>
<!-- BEGIN links -->
					<tr>			   			<td height="23" valign="middle">  
							<span  class="cattitle">&nbsp;<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/course.gif" alt="course_ing" align="top">&nbsp;<a href="{user_admin.links.A_LINK}" class="cattitle" >{user_admin.links.A_NAME}</a>&nbsp;</span>										</td>					 </tr>
<!-- END links --> 
					</table>				</td>			</tr>			</table>		</td>	</tr>
<!-- END user_admin -->	
	<tr>		<td height="12"></td>	</tr>	</table>   </td>   <td align="left" valign="top" width="83%">	<table width="100%" cellpadding="0" cellspacing="0" border="1"  class="bodyline">	<tr>		<td  height="140" valign="top">

			<table width="100%" cellpadding="0" cellspacing="0" border="0">
<!-- BEGIN user --> 
			<tr>				<td>					<table width="100%"  cellpadding="0" cellspacing="0" border="0" class="bodyline">					<tr>						<td>							<table width="100%"  cellpadding="5" cellspacing="0" border="0">								 			<tr>								<td class="row3" height="25">									<span class="cattitle">{user.C_ACTION} </span>								</td>							</tr>

							<tr>			   					<td height="23" valign="middle"> 
									<form name="group" action={user.C_POST_ACTION} method="POST" enctype="multipart/form-data"  > 
									<table width="97%"  cellpadding="5" cellspacing="0" border="0" align="left">
<!-- BEGIN info -->
									<tr>
										<td class="cattitle" align="left" valign="middle">{user.info.C_INFO}</td>
										<td class="cattitle" align="left" valign="middle">{user.info.C_INPUT}</td>	
									</tr>
<!-- END info -->
									</table>
									</form>		
								</td>					 		</tr>

							</table>						</td>					</tr>					</table>				</td>			</tr>
<!-- END user -->	
			<tr>				<td height="12"></td>			</tr>
			</table>
		</td>	</tr>	</table>  </td></tr><tr><td height="12" colspan="2"></td></tr></table>