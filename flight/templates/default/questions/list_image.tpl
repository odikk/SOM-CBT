<!-- DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" -->
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
<html dir="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}"  />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>File Browser</title>

</head>

<body bgcolor="#FFFFFF" text="#000000" link="#006699" vlink="#5493B4">
<table width="100%" cellpadding ="0" cellspacing ="0" border="0" align="center" >
 <tr> 
    <td valign="top">
	<table width="100%" cellpadding ="0" cellspacing ="1" border="0">
	
		<th class="row2" align="left"><span class="cattitle">&nbsp;Name</span></th>
		<th class="row2" align="center" width="90"><span class="cattitle">Size (bytes) </span></th>
		<th class="row2" align="center" width="160"><span class="cattitle">Date</span></th>

	<form name="dirform" method="post" action="{ACTION}">

	<tr>
		<td class="row3" valign="middle" colspan="3">&nbsp;<img src="{S_ROOTDIR}templates/{T_STYLESHEET}/images/openfolder.gif" border="0" alt="Folder Img" align="absmiddle"><span class="cattitle">&nbsp;{COURSE_NAME}</span></td>
	</tr>
<!-- BEGIN files -->
	<tr>
		<td class="{files.CLASS}">
			<span class="genmed">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{files.CHECK_BOX}&nbsp;&nbsp;<a href="javascript:void(0);" style="color:#660033" onClick="{files.FILE_NAME}">{files.LABEL}</span>
		</td>
		<td class="{files.CLASS}" align="center"><span class="genmed">&nbsp;{files.FILE_SIZE}&nbsp;</span></td>
		<td class="{files.CLASS}" align="center"><span class="genmed">&nbsp;{files.FILE_DATE}&nbsp;</span></td>
	</tr>
<!-- END files -->

	</form>
	</table>
   </td>
   </tr>

</table>

<br>
</body>
<script src="browser.js" language="JavaScript" type="text/javascript"></script>
<script src="{S_ROOTDIR}scripts/cbt.js" language="JavaScript" type="text/javascript"></script>
<link rel="stylesheet" href="{S_ROOTDIR}templates/{T_STYLESHEET}/{T_HEAD_STYLESHEET}" type="text/css">
</html>
