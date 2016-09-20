<!-- DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" -->
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}"  />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>Question Browser </title>

</head>

<body bgcolor="#FFFFFF" text="#000000" link="#006699" vlink="#5493B4">
<table width="100%" cellpadding ="0" cellspacing ="0" border="0" align="center" > <tr>     <td valign="top">	<table width="100%" cellpadding ="0" cellspacing ="1" border="0">
	<form name="dirform" method="post" action="{ACTION}">

	<input type="hidden" name="question_order">
<!-- BEGIN category -->
	<tr>
		<td width="27" class="row3" height="18"> {category.CHECK_BOX}</td>
		<td class="row3">&nbsp;<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/{category.IMAGE}" border="0" alt="Folder Img">{category.C_NAME}</td>
	</tr>
<!-- BEGIN questions -->
	<tr>
		<td width="27">&nbsp;</td>
		<td class="{category.questions.CLASS}">
			<span class="genmed">&nbsp;&nbsp;&nbsp;&nbsp;{category.questions.CHECK_BOX}&nbsp;{category.questions.QUES_NAME}</a>
		</td>
	</tr>
<!-- END questions -->
<!-- END category -->
<!-- BEGIN response -->
	<tr>
		<td class="cattitle" align="center"><br>Total Questions Added Now {response.TQ_NOW}</td>
	</tr>
	<tr>
		<td class="cattitle" align="center"><br>Total Questions in Quiz {response.TQ}</td>
	</tr>
	<tr>
		<td class="catHead" align="center"><br><a href="javascript:void(0);" class="action" onClick="parent.window.close();">Close Window</a></td>
	</tr>
	<script>parent.window.opener.location.reload(false) ; parent.window.close();</script>
<!-- END response -->
	</form>	</table>   </td>   </tr></table><br>
</body>
<script src="browser.js" language="JavaScript" type="text/javascript"></script>
<link rel="stylesheet" href="{S_ROOTDIR}templates/{T_STYLESHEET}/{T_HEAD_STYLESHEET}" type="text/css">
</html>
