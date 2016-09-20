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
$cid =  ( isset($HTTP_GET_VARS['cid']) ) ? ($HTTP_GET_VARS['cid']) : ( ( isset($HTTP_POST_VARS['cid']) ) ? ($HTTP_POST_VARS['cid']) : 0) ;
$gid =    ( isset($HTTP_POST_VARS['gid']) ) ? ($HTTP_POST_VARS['gid']) : 0 ;


if(  $userdata['session_logged_in'] ) {

	if( $userdata['user_level'] == ADMIN ) {

		include($somCBT_root_path . 'includes/page_header.php');

		$template->set_filenames(array(
			'body' => 'users/index_body.tpl')
		);
	
		$nav_path = '<a href="'.append_sid($somCBT_root_path.'index.php').'" class="nav">'.Home.'</a> - <a href="'.append_sid('index.php').'" class="nav">'.Users.'</a>';

		if  ( $userdata['user_level'] == ADMIN)
		{
			$template->assign_block_vars('user_admin',array('TH_NAME' => '&nbsp;&nbsp;Users - Admin'));

			$template->assign_block_vars('user_admin.links', array('A_NAME' => 'Add User(s)','A_LINK' => append_sid('index.php?action=add')));
			$template->assign_block_vars('user_admin.links', array('A_NAME' => 'Groups','A_LINK' =>  "javascript:popUp('".append_sid('groups.php')."', 630,330,1,0)"  ));
			$template->assign_block_vars('user_admin.links', array('A_NAME' => 'Edit User','A_LINK' => append_sid('index.php?action=edit')));
			$template->assign_block_vars('user_admin.links', array('A_NAME' => 'List Users',	'A_LINK' => append_sid('index.php?action=list')) );			
			$template->assign_block_vars('user_admin.links', array('A_NAME' => 'Assign',	'A_LINK' => append_sid('index.php?action=assign')) );
			$template->assign_block_vars('user_admin.links', array('A_NAME' => 'Remove',	'A_LINK' => append_sid('index.php?action=remove')) );	
			$template->assign_block_vars('user_admin.links', array('A_NAME' => 'New Test',	'A_LINK' => append_sid('index_new.php')) );									
		}


		if ( ($mode == 'add' ) && (  $userdata['user_level'] == ADMIN ) ){

			$nav_path .= ' - Add New User';	
			
			$sql = " SELECT * FROM ".GROUPS_TABLE." WHERE group_id >= 3";
			
			if ($result_gp = $db->sql_query($sql) ) {
				while ($groups = $db->sql_fetchrow($result_gp)) {
					$gp_select_option .= '<option value="'.$groups['group_id'].'">'.$groups['group_name'].'</option>';
				}
			}
//following block added by smq to deal with uploading list of directors/faculty
			$sql = " SELECT * FROM ".COURSE_TABLE." WHERE course_id > 0";
			
			if ($result_cs = $db->sql_query($sql) ) {
				while ($courses = $db->sql_fetchrow($result_cs)) {
					$cs_select_option .= '<option value="'.$courses['course_id'].'">'.$courses['course_fullname'].'</option>';
				}
			}
				
				$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => 'Add New User'));
			
				$template -> assign_block_vars('user.info', array('C_INFO' => 'First Name', 'C_INPUT' => '<input type="text" size="30" name="fname">'));
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Last Name', 'C_INPUT' => '<input type="text" size="30" name="lname">'));
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Username ', 'C_INPUT' => '<input type="text" size="30" name="uname">&nbsp;&nbsp;(Login id)'));
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Email', 'C_INPUT' => '<input type="text" size="30" name="uemail">'));
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Level', 'C_INPUT' => '<select name="level"><option value="5">Student</option><option value="2">Director/Faculty/Reviewer</option><option value="1">Admin</option></select>'));
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Group', 'C_INPUT' => '<select name="group">'.$gp_select_option.'</select>&nbsp;&nbsp;<span class="helptext"><font size="-5">only for students</font></span>'));
				$template -> assign_block_vars('user.info', array('C_INFO' => '<input type="hidden" name="action" value="addresp"><input type="submit" value="Add New">', 'C_INPUT' => ''));		

				$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => 'Import Students from File'));

				$template -> assign_block_vars('user.info', array('C_INFO' => 'File Name', 'C_INPUT' => '<input type="file" name="user_file">'));
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Group', 'C_INPUT' => '<select name="group">'.$gp_select_option.'</select>'));				
				$template -> assign_block_vars('user.info', array('C_INFO' => '<input type="hidden" name="action" value="addresp_file"><input type="submit" value="Import">', 'C_INPUT' => ''));

				$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => 'Import Directors/Faculty from File'));

				$template -> assign_block_vars('user.info', array('C2_INFO' => 'File Name', 'C2_INPUT' => '<input type="file" name="user_file2">'));
				$template -> assign_block_vars('user.info', array('C2_INFO' => 'Course', 'C2_INPUT' => '<select name="user_course">'.$cs_select_option.'</select>'));				
				$template -> assign_block_vars('user.info', array('C2_INFO' => '<input type="hidden" name="action" value="addresp_file2"><input type="submit" value="Import">', 'C_INPUT' => ''));				

			} // eof add	
			elseif ( ($mode == 'addresp' ) && (  $userdata['user_level'] == ADMIN ) ){	

				$nav_path .= ' - Add New User - Response';
				
				$sql = " SELECT user_id, username FROM ".USERS_TABLE. " WHERE username = '". $HTTP_POST_VARS['uname'] ."'";
				
				if ( $result = $db->sql_query($sql) )
				{
					
					if ( $db->sql_numrows($result) >= 1 ) { // User already exists
						$temp = $db->sql_fetchrow($result);
						$message = 'User Already Exists in the Database &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.append_sid('index.php?action=edit&uname='.$temp['username']).'&getUser">Edit User Details</a>';
					}
					else {
						$user_group = ( $HTTP_POST_VARS['level'] == 5 ) ? $HTTP_POST_VARS['group'] : ($HTTP_POST_VARS['level'] == 1 ? 1 : ($HTTP_POST_VARS['level'] == 2 ? 2 :  $HTTP_POST_VARS['group'] ) );
						$sql =" INSERT INTO ". USERS_TABLE ." (username, user_password, user_fname, user_lname, user_level, user_email, user_group) VALUES " . "
									('".$HTTP_POST_VARS['uname']."', '".md5($HTTP_POST_VARS['uname'])."', '".$HTTP_POST_VARS['fname']."', '".$HTTP_POST_VARS['lname']."',
									'".$HTTP_POST_VARS['level']."', '".$HTTP_POST_VARS['uemail']."',".$user_group.")";

						if ( !$db->sql_query($sql) )
						{
							$message = 'Error in Adding New User';
						}
						else {
							$message = 'New User has been Added';
						}
					}
				}

				$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => 'Add New User - Response'));			
				$template -> assign_block_vars('user.info', array('C_INFO' => $message, 'C_INPUT' => ''));		

				unset($message);				
					
			} // eof add response
			elseif ( ($mode == 'addresp_file' ) && (  $userdata['user_level'] == ADMIN ) ){
	
				$nav_path .= ' - Add New User - Response';

				$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => ' Import Students - Response'));			
//				$template -> assign_block_vars('user.info', array('C_INFO' => $message, 'C_INPUT' => ''));		
					
				$file_name = $_FILES['user_file']['tmp_name'];

				@ $fp = fopen($file_name,"r");

				if($fp){

					$filearray = file($file_name);
					$avail_users = array();
	
					$number_of_elements = count($filearray);
					for ($i=0; $i< ($number_of_elements); $i++){
					
						$user_details = array();
						$user_details = explode(",", $filearray[$i]);
						$sql = " SELECT user_id, username, user_fname, user_lname FROM ".USERS_TABLE. " WHERE username = '". $user_details['0'] ."' LIMIT 1";

						if ( $result = $db->sql_query($sql) )
						{
							if ( $db->sql_numrows($result) == 1 ) { // User already exists
								$temp = $db->sql_fetchrow($result);
								array_push($user_details,$temp['user_fname'], $temp['user_lname']);
								array_push($avail_users,$user_details);	
							}
							else {	
							
							// username#firstname# lastname# email					
							
								$sql =" INSERT INTO ". USERS_TABLE ." (username, user_password, user_fname, user_lname, user_level, user_email, user_group) VALUES " . "
											('".$user_details[0]."', '".md5($user_details[1])."', '".$user_details[2]."', '".$user_details[3]."',
											'5', '".$user_details[4]."',".$HTTP_POST_VARS['group'].")";
								$r = $db->sql_query($sql) ;
								
								//echo $sql."<br>";
							}
						}
					} // eof for number_of_elements

					$template -> assign_block_vars('user.list', array('C_INFO1' => 'Total Added', 'C_INFO2' => (count($filearray)-count($avail_users)), 'C_INFO3' => '', 'C_INFO4' =>'', 'C_INFO5' =>'', 'C_INFO6' =>''));
					if (count($avail_users) > 0 ) { // duplicate users found
						$template -> assign_block_vars('user.list', array('C_INFO1' => '<br><span class="generror">Duplicates</span>', 'C_INFO2' => '', 'C_INFO3' => '', 'C_INFO4' =>'', 'C_INFO5' =>'', 'C_INFO6' =>''));
						$template -> assign_block_vars('user.list', array('C_INFO1' => '<center>Username</center>', 'C_INFO2' => '<center>Current Name</center>', 'C_INFO3' => '<center>Existing Name</center>', 'C_INFO4' =>'', 'C_INFO5' =>'', 'C_INFO6' =>''));
						for ($i = 0 ; $i < count($avail_users) ; $i++) {
							$template -> assign_block_vars('user.list', array('C_INFO1' => '<center>'.$avail_users[$i][0].'</center>', 'C_INFO2' => '<center>'.$avail_users[$i][1]." ".$avail_users[$i][2].'</center>', 'C_INFO3' => '<center>'.$avail_users[$i][3]." ".$avail_users[$i][4].'</center>', 'C_INFO4' =>'', 'C_INFO5' =>'', 'C_INFO6' =>''));
						}
					}

					unset($user_details, $avail_users);
				} // eof file open error
				unset($filearray);
							
			} // eof addresp_file
			elseif ( ($mode == 'addresp_file2' ) && (  $userdata['user_level'] == ADMIN ) ){
	
				$nav_path .= ' - Add New User - Response';

				$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => ' Import Directors/Faculty - Response'));			
//				$template -> assign_block_vars('user.info', array('C_INFO' => $message, 'C_INPUT' => ''));		
					
				$file_name = $_FILES['user_file2']['tmp_name'];

				@ $fp = fopen($file_name,"r");

				if($fp) {

					$filearray = file($file_name);
					$avail_users = array();
	
					$number_of_elements = count($filearray);
					for ($i=0; $i< ($number_of_elements); $i++){
					
						$user_details = array();
						$user_details = explode(",", $filearray[$i]);
						
						$sql = " SELECT * FROM ".USERS_TABLE. " WHERE username = '". $user_details['0'] ."' LIMIT 1";
						if ( $result = $db->sql_query($sql) )
						{
							if ( $db->sql_numrows($result) == 1 ) { // User already exists
								$curruser = $db->sql_fetchrow($result);
								$sqleval = "SELECT * FROM ".COURSE_USERS_TABLE." WHERE user_id=".$curruser['user_id'];
								if ($evaluser = $db->sql_query($sqleval)) { //user is in user's table, evaluate whether they are in a course - SMQ
									if ( $db->sql_numrows($evaluser) > 0) { //User has been assigned to a course - SMQ
										while ($evalcourse = $db->sql_fetchrow($evaluser)) { //evaluate user's course assignment - SMQ
											if($evalcourse['course_id']==$HTTP_POST_VARS['user_course'] ) { //user is assigned to this course - SMQ
												if($evalcourse['access_level']==$user_details[5]) { //determine whether to change user's access level if it is different - SMQ
													array_push($user_details,$temp['user_fname'], $temp['user_lname']);
								                	array_push($avail_users,$user_details);
												}else{ //change access level for current user - SMQ
													$sql2=" UPDATE ".COURSE_USERS_TABLE." SET access_level = '".$user_details[5]."' WHERE user_id=".$curruser['user_id'];
												}
											}else{ //user has not been assigned to this course, so assign them and give access level - SMQ
												$sql2=" INSERT INTO ".COURSE_USERS_TABLE." (user_id, course_id, access_level) VALUES (".$curruser['user_id'].", ".$HTTP_POST_VARS['user_course'].", '".$user_details[5]."')";
											}
											$p = $db->sql_query($sql2) ;
										} //eof database record loop - SMQ
									}else{
										$sql2=" INSERT INTO ".COURSE_USERS_TABLE." (user_id, course_id, access_level) VALUES (".$curruser['user_id'].", ".$HTTP_POST_VARS['user_course'].", '".$user_details[5]."')";
										$p = $db->sql_query($sql2) ; 
									}
								}
							}else{ //user is not in user's table, so add them - SMQ
								$sql =" INSERT INTO ". USERS_TABLE ." (username, user_password, user_fname, user_lname, user_level, user_email, user_group) VALUES " . "
											('".$user_details[0]."', '".md5($user_details[1])."', '".$user_details[2]."', '".$user_details[3]."',
											'2', '".$user_details[4]."', 2)";
								$r = $db->sql_query($sql) ;
								$sql2=" INSERT INTO ".COURSE_USERS_TABLE." (user_id, course_id, access_level) VALUES (".$curruser['user_id'].", ".$HTTP_POST_VARS['user_course'].", '".$user_details[5]."')";
								$p = $db->sql_query($sql2) ; 
							}
						}
					} // eof for number_of_elements

					$template -> assign_block_vars('user.list', array('C_INFO1' => 'Total Added', 'C_INFO2' => (count($filearray)-count($avail_users)), 'C_INFO3' => '', 'C_INFO4' =>'', 'C_INFO5' =>'', 'C_INFO6' =>''));
					if (count($avail_users) > 0 ) { // duplicate users found
						$template -> assign_block_vars('user.list', array('C_INFO1' => '<br><span class="generror">Duplicates</span>', 'C_INFO2' => '', 'C_INFO3' => '', 'C_INFO4' =>'', 'C_INFO5' =>'', 'C_INFO6' =>''));
						$template -> assign_block_vars('user.list', array('C_INFO1' => '<center>Username</center>', 'C_INFO2' => '<center>Current Name</center>', 'C_INFO3' => '<center>Existing Name</center>', 'C_INFO4' =>'', 'C_INFO5' =>'', 'C_INFO6' =>''));
						for ($i = 0 ; $i < count($avail_users) ; $i++) {
							$template -> assign_block_vars('user.list', array('C_INFO1' => '<center>'.$avail_users[$i][0].'</center>', 'C_INFO2' => '<center>'.$avail_users[$i][1]." ".$avail_users[$i][2].'</center>', 'C_INFO3' => '<center>'.$avail_users[$i][3]." ".$avail_users[$i][4].'</center>', 'C_INFO4' =>'', 'C_INFO5' =>'', 'C_INFO6' =>''));
						}
					}

					unset($user_details, $avail_users);
				} // eof file open error
				unset($filearray);
							
			} // eof addresp_file2
			elseif ( ($mode == 'edit' ) && (  $userdata['user_level'] == ADMIN ) ){

				$nav_path .= ' - Edit User';
				
				$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => 'Edit User'));			
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Username <input type="hidden" name= "action" value="edit">', 'C_INPUT' => '<input type="text" size="20" name="uname">&nbsp;&nbsp;&nbsp;<input type="submit" name ="getUser" value="Get User">'));
				$template -> assign_block_vars('user.info', array('C_INFO' => '', 'C_INPUT' => ''));				
				$template -> assign_block_vars('user.info', array('C_INFO' => '', 'C_INPUT' => ''));								

				if ((isset($HTTP_POST_VARS['getUser']))||(isset($HTTP_GET_VARS['getUser']))) { // username entered
				
				//$template->assign_block_vars('user',array('C_ACTION' => 'User Details'));
								
					$username = ( isset($HTTP_GET_VARS['uname']) ) ? ($HTTP_GET_VARS['uname']) : ( ( isset($HTTP_POST_VARS['uname']) ) ? ($HTTP_POST_VARS['uname']) : '') ;
					
					$sql = " SELECT * FROM ". USERS_TABLE . " WHERE username = '" . $username . "' LIMIT 1";
					
					if ( $result = $db->sql_query($sql) )
					{
					
						if ( $user = $db->sql_fetchrow($result) ) { 
						
							// Find the list of courses the user has access to
							$sql = "SELECT cu.*, c.course_fullname FROM " . COURSE_USERS_TABLE . " cu, ".COURSE_TABLE." c WHERE cu.course_id = c.course_id AND user_id = " . $user['user_id'];

							if ( ($result2 = $db->sql_query($sql)) ) {
	
								$course  = array();      
			
								while( $courses = $db->sql_fetchrow($result2) )
								{
									array_push($course, $courses['course_fullname'] );
								}
							} // eof course list	
						
							// courses select box
							$courses_select_option = '<select>';
							
							for ($k = 0 ; $k < count($course) ; $k++) {
									$courses_select_option .= '<option>'.$course[$k].'</option>';
							}							
							$courses_select_option .= '</select>';
													
							$level_select_option = ($user['user_level'] == 1 ) ? 'Admin' : ($user['user_level'] == 5 ? 'Student' : 'Director/Faculty/Reviewer');
							
							$template -> assign_block_vars('user.info', array('C_INFO' => 'First Name', 'C_INPUT' => '<input type="text" size="30" name="fname" value="'.$user['user_fname'].'">'));
							$template -> assign_block_vars('user.info', array('C_INFO' => 'Last Name', 'C_INPUT' => '<input type="text" size="30" name="lname" value="'.$user['user_lname'].'">'));
							$template -> assign_block_vars('user.info', array('C_INFO' => 'Username ', 'C_INPUT' => '<input type="text" size="30" name="unames" value="'.$user['username'].'">'));
							$template -> assign_block_vars('user.info', array('C_INFO' => 'Password ', 'C_INPUT' => '<input type="text" size="30" name="upwd" value="">'));							
							$template -> assign_block_vars('user.info', array('C_INFO' => 'Email', 'C_INPUT' => '<input type="text" size="30" name="uemail" value="'.$user['user_email'].'">'));
							$template -> assign_block_vars('user.info', array('C_INFO' => 'Level', 'C_INPUT' => $level_select_option));
							$template -> assign_block_vars('user.info', array('C_INFO' => 'Courses', 'C_INPUT' => $courses_select_option));														
							$template -> assign_block_vars('user.info', array('C_INFO' => '<input type="submit" name = "action" value="Save">', 'C_INPUT' => '<input type="submit" name = "action" value="Delete"><input type="hidden" name="uid" value='.$user['user_id'].'>'));									
						
							unset($arr, $level_select_option, $courses_select_option, $username);							
						}
						else {
							$template -> assign_block_vars('user.info', array('C_INFO' => 'No User Matched', 'C_INPUT' =>''));																				
						}
		
					}			
				}			
			} // eof edit
			elseif ( (strcasecmp($mode, 'save') == 0 ) && (  $userdata['user_level'] == ADMIN ) ){
	

				$nav_path .= ' - Save User Details';
			
				if (empty($HTTP_POST_VARS['upwd'])) {
					$sql = "UPDATE ". USERS_TABLE ." SET user_fname = '".$HTTP_POST_VARS['fname']."', user_lname='".$HTTP_POST_VARS['lname']."', 
								username ='".$HTTP_POST_VARS['unames']."', user_email='".$HTTP_POST_VARS['uemail']."'  
								WHERE user_id = ".$HTTP_POST_VARS['uid'];
				} else { // update password too
					$sql = "UPDATE ". USERS_TABLE ." SET user_fname = '".$HTTP_POST_VARS['fname']."', user_lname='".$HTTP_POST_VARS['lname']."', 
								username ='".$HTTP_POST_VARS['unames']."', user_email='".$HTTP_POST_VARS['uemail']."', user_password = md5('".$HTTP_POST_VARS['upwd']."')    
								WHERE user_id = ".$HTTP_POST_VARS['uid'];				
				}
				if ( !$db->sql_query($sql) )
				{
					$message = 'Error in Updating User Details';
				} else {
					$message = 'User Details has been Updated';
				}								
				
				$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => 'Update User - Response'));			
				$template -> assign_block_vars('user.info', array('C_INFO' => $message, 'C_INPUT' => ''));		

				unset($message);				
					
			} // eof save
			elseif ( ($mode == 'assign' ) && (  $userdata['user_level'] == ADMIN ) ){
			
				$nav_path .= ' - Assign Course to Users';					

				$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => 'Assign Course '));
				
				$sql = "SELECT course_id, course_fullname FROM ". COURSE_TABLE ;
				
				$course_select = '<select name="cid">';
				if ( ($result2 = $db->sql_query($sql)) ) {
			
					while( $courses = $db->sql_fetchrow($result2) )
					{
						$course_select .= '<option value="'.$courses['course_id'].'">'.$courses['course_fullname'].'</option>';

					}
				} // eof course list	
				$course_select .= '</select>';
				
				$sql = "SELECT group_id, group_name FROM ". GROUPS_TABLE ." WHERE group_id >= 3";
				$group_select = '<select name="gid">';
				if ( ($result2 = $db->sql_query($sql)) ) {

					while( $groups = $db->sql_fetchrow($result2) )
					{
						$group_select .= '<option value="'.$groups['group_id'].'">'.$groups['group_name'].'</option>';
					}	
				} // eof group list	
				$group_select .= '</select>';					

											
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Assign', 'C_INPUT' => '<select name="level"><option value="5">Student</option><option value="2">Director</option><option value="3">Faculty</option><option value="4">Reviewer</option></select>'));												
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Course', 'C_INPUT' => $course_select));
				$template -> assign_block_vars('user.info', array('C_INFO' => 'By', 'C_INPUT' => '<input type="radio" name="which" value="1"> Groups&nbsp;&nbsp;<input type="radio" name="which" value="2"> Usernames'));
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Group', 'C_INPUT' => $group_select));				
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Usernames', 'C_INPUT' => '(seperate by commas)'));
				$template -> assign_block_vars('user.info', array('C_INFO' => '', 'C_INPUT' => '<textarea name="unames" rows="6" cols="40"></textarea>'));				
				$template -> assign_block_vars('user.info', array('C_INFO' => '<input type="hidden" name="action" value="assignresp"><input type="submit" value="Assign">', 'C_INPUT' => ''));		

				unset($course_select, $group_select);			
			
			} // eof assign
			elseif ( ($mode == 'assignresp' ) && (  $userdata['user_level'] == ADMIN ) ){
			
				$nav_path .= ' - Assign Course to Users Response';					

				$template->assign_block_vars('user',array('C_ACTION' => 'Following users are given access'));

				if ($HTTP_POST_VARS['which'] == 1) { // by groups
					$sql = " SELECT user_id, username, user_level FROM ".USERS_TABLE. " WHERE user_group = ".$HTTP_POST_VARS['gid']; 

				}
				else if ($HTTP_POST_VARS['which'] == 2) { // by username
					$user_names = explode(",", $HTTP_POST_VARS['unames']);
								
					array_walk($user_names,create_function('&$v', '$v="\'".trim($v)."\'";') ); // added quotes for each user name like 'kpg'
					
					$sql = " SELECT user_id, username, user_level FROM ".USERS_TABLE. " WHERE username IN (" .implode (",",  $user_names ). ")"; 

				}
								
				if ( ($result3 = $db->sql_query($sql)) ) {
					$assigned_users = array();
					while( $users = $db->sql_fetchrow($result3) )
					{
						$sql = " REPLACE INTO ".COURSE_USERS_TABLE. " (user_id, course_id, access_level) VALUES 
										(".$users['user_id'].",".$HTTP_POST_VARS['cid'].", '".$HTTP_POST_VARS['level']."')";
										
						// if one is added as a student then the level is always a student
						if ( ($users['user_level'] == 5 ) && ( $HTTP_POST_VARS['level'] == 5 ) ) { 
							array_push($assigned_users, $users['username']);
							$db->sql_query($sql);					
						} else if ($users['user_level'] != 5 ){
							array_push($assigned_users, $users['username']);
							$db->sql_query($sql);					
						}						
							
					} // eof while users
				} // eof resultset
										
				if (count($assigned_users) == 0 ) {
					$template -> assign_block_vars('user.info', array('C_INFO' => '<span class="generror">Sorry no User has been added to the course</span>&nbsp;&nbsp;&nbsp;&nbsp;', 'C_INPUT' => ''));								
				}
				for( $k = 0 ; $k < (count($assigned_users)/6 ); $k++)				
				{
					unset($temp);
					for ( $z=0;  $z < 6 ; $z++ ) {
						$temp[$z] = '&nbsp;<a href="'.append_sid('index.php?action=edit&uname='.$assigned_users[(($k*6)+$z)].'&getUser').'" class="gensmall">'.$assigned_users[(($k*6)+$z)].'</a>';
					}
							
					$template -> assign_block_vars('user.list', array(
											'C_INFO1' => $temp[0],											
											'C_INFO2' => $temp[1],
											'C_INFO3' => $temp[2],
											'C_INFO4' => $temp[3],
											'C_INFO5' => $temp[4],
											'C_INFO6' => $temp[5],
							));
										
					unset ($temp);
				} // eof for			
		
//				$template -> assign_block_vars('user.info', array('C_INFO' => 'Number of Users added to the course&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;'.count($avail_names), 'C_INPUT' => ''));				
				
				unset($temp, $avail_names, $user_names);

			}// eof assign response
			elseif ( ($mode == 'remove' ) && (  $userdata['user_level'] == ADMIN ) ){
			
				$nav_path .= ' - Remove access';					

				$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => 'Remove Course access '));
				
				$sql = "SELECT course_id, course_fullname FROM ". COURSE_TABLE ;
				
				$course_select = '<select name="cid">';
				if ( ($result2 = $db->sql_query($sql)) ) {
			
					while( $courses = $db->sql_fetchrow($result2) )
					{
						$course_select .= '<option value="'.$courses['course_id'].'">'.$courses['course_fullname'].'</option>';

					}
				} // eof course list	
				$course_select .= '</select>';

				
				$sql = "SELECT group_id, group_name FROM ". GROUPS_TABLE ." WHERE group_id >= 3";
				$group_select = '<select name="gid">';
				if ( ($result2 = $db->sql_query($sql)) ) {

					while( $groups = $db->sql_fetchrow($result2) )
					{
						$group_select .= '<option value="'.$groups['group_id'].'">'.$groups['group_name'].'</option>';
					}	
				} // eof group list	
				$group_select .= '</select>';					

											
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Course', 'C_INPUT' => $course_select));
				$template -> assign_block_vars('user.info', array('C_INFO' => 'By', 'C_INPUT' => '<input type="radio" name="which" value="1"> Groups&nbsp;&nbsp;<input type="radio" name="which" value="2"> Usernames'));
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Group', 'C_INPUT' => $group_select));								
				$template -> assign_block_vars('user.info', array('C_INFO' => 'Usernames', 'C_INPUT' => '(seperate by commas)'));
				$template -> assign_block_vars('user.info', array('C_INFO' => '', 'C_INPUT' => '<textarea name="unames" rows="6" cols="40"></textarea>'));				
				$template -> assign_block_vars('user.info', array('C_INFO' => '<input type="hidden" name="action" value="removeresp"><input type="submit" value="Remove">', 'C_INPUT' => ''));		


				unset($course_select, $group_select);			
			
			} // eof remove
			elseif ( ($mode == 'removeresp' ) && (  $userdata['user_level'] == ADMIN ) ){
			
				$nav_path .= ' - Remove Course Access';					

				$template->assign_block_vars('user',array('C_ACTION' => 'Remove course access Response'));

				if ($HTTP_POST_VARS['which'] == 1) { // by groups
					$sql = " SELECT user_id, username FROM ".USERS_TABLE. " WHERE user_group = ".$HTTP_POST_VARS['gid']; 

				}
				else if ($HTTP_POST_VARS['which'] == 2) { // by username
					$user_names = explode(",", $HTTP_POST_VARS['unames']);
								
					array_walk($user_names,create_function('&$v', '$v="\'".trim($v)."\'";') ); // added quotes for each user name like 'kpg'
					
					$sql = " SELECT user_id, username FROM ".USERS_TABLE. " WHERE username IN (" .implode (",",  $user_names ). ")"; 

				}
				
				$avail_id = array();
												
				if ( ($result2 = $db->sql_query($sql)) ) {

					while( $course_users = $db->sql_fetchrow($result2) )
					{
						array_push($avail_id, $course_users['user_id']);

					}
				} // eof course list				


				$sql = " DELETE FROM ". COURSE_USERS_TABLE . " where course_id = ". $HTTP_POST_VARS['cid'] ." AND user_id IN(".implode (",",  $avail_id ).")";

				$db->sql_query($sql);

				$template -> assign_block_vars('user.info', array('C_INFO' => 'Number of Access revoked &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;'.count($avail_id), 'C_INPUT' => ''));				

				unset($avail_id, $user_names);
				
				
			}// eof remove response
			elseif ( ($mode == 'list' ) && (  $userdata['user_level'] == ADMIN ) ){
			
				$nav_path .= ' - List';
				
				if( $gid || $cid ) {
				
					if ($gid) {
						$sql = 'SELECT user_id, username  FROM '. USERS_TABLE. " WHERE user_group = " .$gid." ORDER BY username" ;
					}elseif ($cid) {
						$sql = 'SELECT u.user_id, u.username, cu.access_level FROM '. USERS_TABLE. " u, ". COURSE_USERS_TABLE ." cu WHERE  cu.course_id = " .$cid ." AND cu.user_id = u.user_id ORDER BY u.username" ;
					}

					if ( ($result2 = $db->sql_query($sql)) ) {
					
						$template->assign_block_vars('user',array(
											'C_POST_ACTION' => append_sid('index.php'), 
											'C_ACTION' => 'User List &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
										));
						
						for( $k = 0 ; $k < ($db->sql_numrows($result2) /6 ); $k++)				

						{
							unset($temp);

							for ( $z=0;  $z < 6 ; $z++ ) {
								if ( $courses =  $db->sql_fetchrow($result2) ) 
								{
									$x = ($courses['access_level'] == DIRECTOR) ? 'gensmallgreen' : ( ($courses['access_level'] == FACULTY) ? 'gensmallpink' : (($courses['access_level'] == REVIEWER) ? 'gensmallgrey' : 'gensmall' ));
									$temp[$z] = '&nbsp;<a href="'.append_sid('index.php?action=edit&uname='.$courses['username'].'&getUser').'" class="'.$x.'">'.$courses['username'].'</a>';
								}
								
							}
							
							$template -> assign_block_vars('user.list', array(
											'C_INFO1' => $temp[0],											
											'C_INFO2' => $temp[1],
											'C_INFO3' => $temp[2],
											'C_INFO4' => $temp[3],
											'C_INFO5' => $temp[4],
											'C_INFO6' => $temp[5],
										));
										
							unset ($temp);
						} // eof for
/*						
						if ($cid == -1 ) { // listing all users
							$template -> assign_block_vars('user.list', array(	
											'C_INFO1' => '<Input type="submit" value="Delete" onClick = "return cbSelect(document.user, \'unames\')">',
											'C_INFO2' => '<input type="hidden" name="unames" value=""><input type="hidden" name="action" value="delete">'
									));
						
						} else {
							$template -> assign_block_vars('user.list', array(	
											'C_INFO1' => '<Input type="submit" value="Remove" onClick = "return cbSelect(document.user, \'unames\')"><input type="hidden" name="cid" value="'.$cid.'">',
											'C_INFO2' => '<input type="hidden" name="unames" value=""><input type="hidden" name="action" value="removeresp">'
									));
						}
*/						
					}
					
				}
				else { // display course/group list if courseid/groupid is not set
					
					$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => 'List Users by Course'));
				
					$sql = "SELECT course_id, course_fullname FROM ". COURSE_TABLE ;
				
					$course_select = '<select name="cid">';
					if ( ($result2 = $db->sql_query($sql)) ) {

						while( $courses = $db->sql_fetchrow($result2) )
						{
							$course_select .= '<option value="'.$courses['course_id'].'">'.$courses['course_fullname'].'</option>';
						}	
					} // eof course list	
					$course_select .= '</select>';
											
					$template -> assign_block_vars('user.info', array('C_INFO' => 'Course', 'C_INPUT' => $course_select.'&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="List">'));
					$template -> assign_block_vars('user.info', array('C_INFO' => '<input type="hidden" name="action" value="list">', 'C_INPUT' => ''));		
					
					$template->assign_block_vars('user',array('C_POST_ACTION' => append_sid('index.php'), 'C_ACTION' => 'List Users by Groups'));
					
					$course_select = '';
					$sql = "SELECT group_id, group_name FROM ". GROUPS_TABLE ;
					$course_select = '<select name="gid">';
					if ( ($result2 = $db->sql_query($sql)) ) {

						while( $groups = $db->sql_fetchrow($result2) )
						{
							$course_select .= '<option value="'.$groups['group_id'].'">'.$groups['group_name'].'</option>';
						}	
					} // eof course list	
					$course_select .= '</select>';					

					$template -> assign_block_vars('user.info', array('C_INFO' => 'Groups', 'C_INPUT' => $course_select.'&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="List">'));					
					$template -> assign_block_vars('user.info', array('C_INFO' => '<input type="hidden" name="action" value="list">', 'C_INPUT' => ''));		
					
				
				} // eof list no cid selected
				
			} // eof list
			/**
				* Permanent Delete of the user
				* Delete all the related records associated with the user
			**/
			elseif ( (strcasecmp($mode, 'delete') == 0 ) && (  $userdata['user_level'] == ADMIN ) ){ 
			
				$nav_path .= ' - Delete User';					

				$template->assign_block_vars('user',array('C_ACTION' => 'Deleting Users'));
				
				$user_names = explode(",", $HTTP_POST_VARS['unames']);
								
				array_walk($user_names,create_function('&$v', '$v="\'".trim($v)."\'";') ); // added quotes for each user name like 'kpg'
				
				$avail_id = array();
				
				$sql = " SELECT user_id FROM ".USERS_TABLE. " WHERE username IN (" .implode (",",  $user_names ). ")"; 
				
				if ( ($result2 = $db->sql_query($sql)) ) {

					while( $course_users = $db->sql_fetchrow($result2) )
					{
						array_push($avail_id, $course_users['user_id']);

					}
				} // eof userid list				
				


				$sql = " DELETE FROM ". USERS_TABLE . " where  user_id IN(".implode (",",  $avail_id ).")";
				$db->sql_query($sql);
				$sql = " DELETE FROM ". COURSE_USERS_TABLE . " where  user_id IN(".implode (",",  $avail_id ).")";
				$db->sql_query($sql);
//				echo $sql;
				$sql = " DELETE FROM ". QUIZ_ATTEMPTS_TABLE . " where  user_id IN(".implode (",",  $avail_id ).")";
				$db->sql_query($sql);
//				echo $sql;
				$sql = " DELETE FROM ". QUIZ_RESPONSES_TABLE . " where  user_id IN(".implode (",",  $avail_id ).")";
				$db->sql_query($sql);
				$sql = " DELETE FROM ". QUIZ_TEXT_RESPONSES_TABLE . " where  user_id IN(".implode (",",  $avail_id ).")";
				$db->sql_query($sql);
//				echo $sql;

				$template -> assign_block_vars('user.info', array('C_INFO' => 'Number of users Deleted &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;'.count($avail_id), 'C_INPUT' => ''));				
				unset($user_names, $avail_id);
				
				
			}// eof delete
	
	
		$template->assign_vars(array(
			'S_ROOTDIR' => $somCBT_root_path,
			'S_NAV' => $nav_path
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

$template->pparse('body');

include($somCBT_root_path . 'includes/page_tail.php');
?>
