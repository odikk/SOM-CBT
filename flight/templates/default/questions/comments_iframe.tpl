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
<link rel="stylesheet" href="{S_ROOTDIR}templates/{T_STYLESHEET}/{T_HEAD_STYLESHEET}" type="text/css">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<!-- BEGIN postrow -->
	<tr>
		<td class="row1"><span class="cattitle"><b>{postrow.POSTER_NAME}</b></span></td>
		<td class="row1" width="30"><a href="{postrow.DEL_LINK}">{postrow.POST_DEL}</a></td>
		<td class="row1"  align="right"><span class="helptext">{postrow.POST_TIME}</span></td>
	</tr>
	<tr>
		<td height="28" valign="top" colspan="3"><span  class="genmed"><blockquote>{postrow.POST}</blockquote></span></td>
	</tr>
	<tr><td height="10"></td></tr>

<!-- END postrow -->
</table>
</body>
</html>
