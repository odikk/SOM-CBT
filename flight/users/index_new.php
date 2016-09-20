<?php

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_USERS);
init_userprefs($userdata);
//
// End session management

$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;

if(  $userdata['session_logged_in'] ) {

	if( $userdata['user_level'] == ADMIN ) {

		include($somCBT_root_path . 'includes/page_header.php');
		
		$access_level = array('Director', 'Faculty', 'Reviewer', 'Student', 'Evaluator');
	
		$nav_path = '<a href="'.append_sid($somCBT_root_path.'index.php').'" class="nav">'.Home.'</a> - <a href="'.append_sid('index.php').'" class="nav">'.Users.'</a>';

		$sql=" SELECT * FROM ".COURSE_TABLE." WHERE course_id > 0 ORDER BY course_id";
		if ( ($result = $db->sql_query($sql)) ) {
?>
<table width="80%" align="center" border="0" bgcolor="#DDEDF3" >
<tr bgcolor="#336699" bordercolor="#336699">
<th colspan="5" bgcolor="#336699" bordercolor="#336699">Users</th>
</tr>
<tr bordercolor="#D2EDFF">
<th bordercolor="#D2EDFF" align="left"><b>User ID</b></th>
<th bordercolor="#D2EDFF" align="left"><b>UserName</b></th>
<th bordercolor="#D2EDFF" align="left"><b>First Name</b></th>
<th bordercolor="#D2EDFF" align="left"><b>Last Name</b></th>
<th bordercolor="#D2EDFF" align="left"><b>Last Visit</b></th>
</tr>
<?php 	
			while ($info = $db->sql_fetchrow($result)) { ?>
<tr bordercolor="#7FB77E" bgcolor="#7FB77E">
	<td colspan="5" bordercolor="#D2EDFF">&nbsp;</td>
</tr>
<tr bordercolor="#F9D3C1" bgcolor="#F9D3C1">
	<td bordercolor="#F9D3C1" bgcolor="#B6D2DF" colspan="5" align="center"><b><font color="#4B846B" size="-1"><?php echo $info['course_fullname'];?></font></b></td>
</tr>
<tr bordercolor="#7FB77E" bgcolor="#7FB77E">
	<td bordercolor="#D2EDFF" colspan="5">&nbsp;</td>
</tr>
<?php 	
				for($i=2;$i<7;$i++) {
					$sql2=" SELECT u.*, cu.access_level FROM ".USERS_TABLE." u, ".COURSE_USERS_TABLE." cu WHERE cu.course_id = ".$info['course_id']." AND cu.user_id = u.user_id AND cu.access_level = '".$i."'";
					if ( ($result2 = $db->sql_query($sql2)) ) {
						 ?>
<tr bordercolor="#95C9E1">
<td colspan="5" bordercolor="#95C9E1" bgcolor="#95C9E1"><b><font color="#4A5C8C" size="-2"><?php echo $access_level[($i-2)];?></font></b></td>
</tr>
<?php while ($info2 = $db->sql_fetchrow($result2)) { ?>
<tr bordercolor="#D2EDFF">
	<td bordercolor="#D2EDFF"><b><font color="#971612" size="-3">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $info2['user_id'];?></font></b></td>
	<td bordercolor="#D2EDFF"><b><font color="#666666" size="-3"><?php echo $info2['username'];?></font></b></td>
	<td bordercolor="#D2EDFF"><b><font color="#175686" size="-3"><?php echo $info2['user_fname'];?></font></b></td>
	<td bordercolor="#D2EDFF"><b><font color="#175686" size="-3"><?php echo $info2['user_lname'];?></font></b></td>
	<td bordercolor="#D2EDFF"><b><font color="#660033" size="-3"><?php echo date('m/d/Y', $info2['user_lastvisit']);?></font></b></td>
</tr>

<?php 	
						}
					}
				}
			}
 ?>
</table>
<?php
		}
				$template->assign_vars(array(
				'S_ROOTDIR' => $somCBT_root_path,
				'S_NAV' => ''
				));
	}
	else {
		redirect(append_sid("index.php", true));
	}

}
else {
	redirect(append_sid("login.php", true));
}
//
// Generate the page
//

$template->pparse('overall_header');


include($somCBT_root_path . 'includes/page_tail.php');
?>