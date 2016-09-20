<?php

// Display the list of files that are uploaded for the course

define('IN_somCBT', true);
$phpEx = 'php';

$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : 0) ;

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_INDEX);
init_userprefs($userdata);
//
// End session management


if( ( $userdata['session_logged_in'] ) && ( ($userdata['user_level'] == ADMIN) || ($userdata['user_level'] == TEACHER )) ){

	$display  = 1;
	$nav_path = 'File Browser' ;

	include($somCBT_root_path . 'includes/page_header.php');

	$template->set_filenames(array(	'body' => 'questions/list_image.tpl') );


	if (  $display ) {

		$sql = "SELECT course_fullname, media_dir FROM " .COURSE_TABLE." WHERE course_id = ".$cid."  LIMIT 1";

		if ( $result = $db->sql_query($sql) ) {
	
			$course = $db->sql_fetchrow($result) ;

			$dir = $somCBT_root_path.'media/'.$course['media_dir'] ;

			if (is_dir($dir) ) {
			
				$course_name = $course['course_fullname'];
				$class = 'row1';
				
				// list all the files from the corresponding directory
				if ( $dh = opendir($dir) ) {
					while ( ($file = readdir($dh)) != false ) {
						if ( ( $file != '.' ) && ( $file != '..' ) ) { // dont show system file
							$class = ( strcmp($class,"row1") == 0 ) ? "" : "row1" ;
							$template->assign_block_vars('files',array('FILE_NAME' => 'javascript:popUp(\''.append_sid($somCBT_root_path.'questions/img_preview.php?name='.$file.'&ARG1='.$dir).'\',800,600,1)',
																		'LABEL' => $file,
																		'CHECK_BOX' => '&nbsp;',
																		'FILE_SIZE' => filesize($dir.$file),
																		'FILE_DATE' => create_date(filemtime($dir.$file)),
																		'CLASS' => $class));					
						}


					}
					closedir($dh);
				}
			}

		}


	} // eof display check
	
	


	$template->assign_vars(array(
				'COURSE_NAME' => $course_name ,
				'S_ROOTDIR' => $somCBT_root_path,
				'ACTION' => append_sid('iframe.php?action=addsel&cid='.$cid.'&qid='.$qid),
				'S_NAV' => $nav_path)
			);

	$template->pparse('body');	

}
else {
	redirect(append_sid("login.$phpEx", true));
}

?>
<?php

function extract_cat($value) {

	if ( (strcmp(substr($value,0,4),"cat_") ) == 0 ) {
		return true;
	}else {
		return false;
	}	
}

function get_id( &$item1) {
	echo substr($item1, ( strrpos($item1,"_")+1) );
//	print_r( explode("_",$item1));
	echo "<br>";
//	$item1 =  substr($item1,4);
}

?>
