<!-- DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" -->
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}"  />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link rel="stylesheet" href="{S_ROOTDIR}templates/{T_STYLESHEET}/{T_HEAD_STYLESHEET}" type="text/css">
{META}
<title>{SITENAME}</title>
<script type="text/javascript">var sel_elem;//myField accepts an object reference, myValue accepts the text strint to addfunction insertatcursor(myValue) {myField=sel_elem;//IE supportif (document.selection) {myField.focus();//in effect we are creating a text range with zero//length at the cursor location and replacing it//with myValuesel = document.selection.createRange();sel.text = myValue;}//Mozilla/Firefox/Netscape 7+ supportelse if (myField.selectionStart || myField.selectionStart == '0') {//Here we get the start and end points of the//selection. then we create substrings up to the//start of the selection and from the end point//of the selection to the end of the field value.//then we concatenate the first substring, myValue,//and the second substring to get the new value.var startPos = myField.selectionStart;var endPos = myField.selectionEnd;myField.value = myField.value.substring(0, startPos)+ myValue+ myField.value.substring(endPos, myField.value.length);} else {myField.value += myValue;}}</script>  
</head>
<body bgcolor="{T_BODY_BGCOLOR}">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
  <tr> 
	<td valign="top">
		<span class="bluebold11">{S_NAV}</span>
	</td>
		<td align="right" valign="top" height="28">
			<!-- BEGIN switch_user_logged_in -->
				<span class="gensmall">
					<a href="{U_LOGIN_LOGOUT}" class="nav">{L_LOGIN_LOGOUT}</a>
				</span>
			<!-- END switch_user_logged_in -->
		</td>
	
  </tr>
</table>