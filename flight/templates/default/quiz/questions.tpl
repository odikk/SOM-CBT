<table width="100%" cellpadding="5" cellspacing="0" border="0"  align="center"> <tr>     <td width="150" valign="top">	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<form name="admin_options">
<!-- BEGIN quiz_admin -->
	<tr>		<td>			<table width="100%"  cellpadding="0" cellspacing="0" border="1" class="bodyline">			<tr>				<td>					<table width="100%"  cellpadding="5" cellspacing="0" border="0">								 	<tr>						<td class="row3" height="25">							<span class="cattitle">{quiz_admin.TH_NAME} </span>						</td>					</tr>
<!-- BEGIN links -->
					<tr>			   			<td height="25" valign="middle" nowrap>  
							<span  class="genmed">{quiz_admin.links.VALUE}</span>
						</td>					 </tr>
<!-- END links -->
					</table>				</td>			</tr>			</table>		</td>	</tr>
	<tr>		<td height="12"></td>	</tr>
<!-- END quiz_admin -->
	</form>	</table>   </td>   <td align="left" valign="top" >	<table width="100%" cellpadding="0" cellspacing="0" border="1"  class="bodyline">	<tr>		<td  height="350"  valign="top">

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
<!-- BEGIN quiz --> 
	<form name="questions" action="{quiz.ACTION}" method="POST">
	<input type="hidden" name="question_order" value="">
	<tr>		<td>			<table width="100%"  cellpadding="0" cellspacing="0" border="0" class="bodyline">			<tr>				<td>					<table width="100%"  cellpadding="0" cellspacing="1" border="0">
					<tr>
						<td align="center" width="18"  >&nbsp;{quiz.LCKIMG}</td>
						<td width="40" class="row3" align="center"><span class="cattitle">No.</span></td>
						<td width="40" class="row3" align="center"><span class="cattitle">DB Rec.#</span></td>
						<td width="40" class="row3" align="center"><span class="cattitle">Source Category</span></td>
						<td align="left" class="row3" > 
							<table width="100%"  cellpadding="0" cellspacing="0" border="0">
								<th align="left"><span class="cattitle">&nbsp;&nbsp;Questions&nbsp;&nbsp;</span></th>
								<!-- <th align="right">{quiz.PAGINATION}&nbsp;&nbsp;</th> -->
							</table>
						 </td>
					</tr>
<!-- BEGIN quiz_questions -->
					<tr>
						<td align="center" class="{quiz.quiz_questions.CLASS}">{quiz.quiz_questions.C_BOX}</td>
						<td align="center" class="{quiz.quiz_questions.CLASS}"><span class="gen">{quiz.quiz_questions.Q_NO}</span></td>
						<td align="center" class="{quiz.quiz_questions.CLASS}"><span class="gen">{quiz.quiz_questions.DB_NO}</span></td>
						<td align="center" class="{quiz.quiz_questions.CLASS}"><span class="gen">{quiz.quiz_questions.CAT}</span></td>						<td valign="middle" class="{quiz.quiz_questions.CLASS}" align="left">&nbsp;
							<a href="javascript:void(0);" onClick="{quiz.quiz_questions.Q_PREVIEW_CLICK}"><img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/preview.gif" border="0" alt="Preview Img" align="absmiddle"></a> 
							&nbsp;<a href="javascript:void(0);" onClick="{quiz.quiz_questions.CLICK}" class="nav">{quiz.quiz_questions.Q_NAME}</a>
						</td>					 </tr>
<!-- END quiz_questions -->

					</table>				</td>			</tr>			</table>		</td>	</tr>
	<input type="hidden" name="action">
	<input type="hidden" name="offset" value="1">
	</form>
<!-- END quiz -->	
	<tr>		<td height="12"></td>	</tr>
	</table>

		</td>	</tr>	</table>  </td></tr></table><br>
