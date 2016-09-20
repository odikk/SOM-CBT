<?php

define('IN_somCBT', true);
$phpEx = 'php';
define('QUESTIONS_PER_PAGE', 25);
$somCBT_root_path = './../';

include($somCBT_root_path . 'common.php');

$mode = ( isset($HTTP_GET_VARS['action']) ) ? ($HTTP_GET_VARS['action']) : ( ( isset($HTTP_POST_VARS['action']) ) ? ($HTTP_POST_VARS['action']) : '') ;
$cid =  ( isset($HTTP_GET_VARS['ARG1']) ) ? ($HTTP_GET_VARS['ARG1']) : ( ( isset($HTTP_POST_VARS['ARG1']) ) ? ($HTTP_POST_VARS['ARG1']) : -1) ;
$ca =  ( isset($HTTP_GET_VARS['ARG2']) ) ? ($HTTP_GET_VARS['ARG2']) : ( ( isset($HTTP_POST_VARS['ARG2']) ) ? ($HTTP_POST_VARS['ARG2']) : -1) ;

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_QUIZ_INDEX);
init_userprefs($userdata);
//
// End session management

if( ( $userdata['session_logged_in'] ) && ( ($userdata['user_level'] == ADMIN) || ($userdata['user_level'] == TEACHER )) ){

	include($somCBT_root_path . 'includes/page_header.php');

	$template->set_filenames(array(	'body' => 'questions/index.tpl') );						
		
	$nav_path = '<a href="'.append_sid($somCBT_root_path.'index.php').'" class="nav">Home</a>' ;
			
	// Find whether the user has access
	if ($userdata['user_level'] == ADMIN) {
		$sql = "SELECT * FROM ".COURSE_TABLE." WHERE course_id = ".$cid."  LIMIT 1";		
	}
	else if  ( $userdata['user_level'] == TEACHER ) {
		$sql = "SELECT c.*, cu.access_level FROM " . COURSE_USERS_TABLE . " cu, ".COURSE_TABLE." c WHERE c.course_id = cu.course_id AND cu.course_id = ".$cid."  AND cu.user_id = " . $userdata['session_user_id'] ." LIMIT 1";
	}


	if ( $result = $db->sql_query($sql) ) {
	
		$courses = $db->sql_fetchrow($result) ;
	}
	
	if ( ( $cid == $courses['course_id']) && ( ( $userdata['user_level'] == ADMIN ) || ( $userdata['user_level'] == TEACHER ) ) )  {
	
		$nav_path .= ' -  <a href="'.append_sid($somCBT_root_path.'course.php?ARG1='.$cid).'" class="nav">'.$courses['course_shortname'].'</a> -  <a href="'.append_sid($somCBT_root_path.'questions/index.php?action=show&ARG1='.$cid).'" class="nav">'.Questions.'</a>' ;
		
		// Get the List of categories
		$sql = "SELECT cat_id, cat_name FROM " . CATEGORY_TABLE . " WHERE course_id = " . $cid . " ORDER BY cat_id";

		if ( ($result = $db->sql_query($sql)) ) {
				
			$cat_option='<select name="ARG2">';
			$cat_valid = 0; // to check category id is a valid id or not

			while( $category = $db->sql_fetchrow($result) )  {			

				if ($category['cat_id'] == $ca) {
					$cat_valid = 1;
					$cat_option .= '<option value="'.$category['cat_id'].'" selected>';
					$nav_path .= ' - ' . $category['cat_name'];
				} else {
					$cat_option .= '<option value="'.$category['cat_id'].'">';
				}
					
				$cat_option .= str_replace('#', '&nbsp;', substr(str_pad($category['cat_name'],18,'#'), 0, 20)).'</option>';
			}
			$cat_option .= '</select>';
			
		} // eof category list
			
			
		$template->assign_block_vars('ques_options',array('TH_NAME' => 'Category', 'ACTION' => append_sid('category.php'), 
											'FORM_NAME' => 'category', 'FORM_HIDDEN' => '<input type="hidden" name="ARG1" value="'.$cid.'">',	
										));

		$template->assign_block_vars('ques_options.links',array('VALUE' => $cat_option));			
			

		if (  ($userdata['user_level'] == ADMIN) || ($courses['access_level'] == DIRECTOR) || ($courses['access_level'] == FACULTY) )  {  // reviewer cannot create/edit/delete category
			$template->assign_block_vars('ques_options.links',array('VALUE' => '&nbsp;<a href="javascript:submit_form(document.category ,\'view\')" class="action">view</a>
												&nbsp;<a href="javascript:submit_form(document.category ,\'edit\')" class="action">Edit</a>'));
												
												//add these back if needed - SMQ &nbsp;<a href="javascript:submit_form(document.category ,\'upload\')" class="action">Upload Questions</a>
												//&nbsp;<a href="javascript:submit_form(document.category ,\'images\')" class="action">Upload Images</a>'
		
			$template->assign_block_vars('ques_options.links',array('VALUE' => '<a href="'.append_sid('category.php?action=new&ARG1='.$cid).'" class="action">Create New Category</a>'));	

			$template->assign_block_vars('ques_options',array('TH_NAME' => 'Questions', 'ACTION' => append_sid('questions.php'),  
											'FORM_NAME' => 'questions',	'FORM_HIDDEN' => '<input type="hidden" name="ARG1" value="'.$cid.'">',	
										));
			$template->assign_block_vars('ques_options.links',array('VALUE' => '<a href="javascript:void(0);" class="action" onclick = "window.location=\''.append_sid('index.php?action=dosearch&ARG1='.$cid).'\'; return false;">Search Questions</a>'));			
			
		}
		else if ($courses['access_level'] == REVIEWER) { // reviewer can only view questions in the category
			$template->assign_block_vars('ques_options.links',array('VALUE' => '&nbsp;<a href="javascript:submit_form(document.category ,\'view\')" class="action">view</a>'));		
		}
		
		

		if ( ($cat_valid) && ( ($userdata['user_level'] == ADMIN) || ($courses['access_level'] == DIRECTOR) || ($courses['access_level'] == FACULTY) ) ) { 
				$template->assign_block_vars('ques_options.links',array('VALUE' => '<a href="javascript:popUp2(\''.append_sid('questions.php?action=type&ARG1='.$cid.'&ARG2='.$ca).'\')" class="action">Create New Question</a>'));
		}
				if ( ($cat_valid) && ( ($userdata['user_level'] == ADMIN) || ($courses['access_level'] == DIRECTOR) || ($courses['access_level'] == FACULTY) ) ) { 
				$template->assign_block_vars('ques_options.links',array('VALUE' => '<a href="javascript:popUp2(\''.append_sid('list_image.php?action=type&ARG1='.$cid.'&ARG2='.$ca).'\')" class="action">List Course Images</a>'));
		}
			
		unset($cat_option);
		
//Not default on first page visit - sent on URL when "view" is clicked - SMQ
		if ( ($mode == 'view' ) && ($cat_valid) ){

				$start =  ( isset($HTTP_GET_VARS['start']) ) ? $HTTP_GET_VARS['start'] :  0 ;
				$ordfield =  ( isset($HTTP_GET_VARS['ord']) ) ? ($HTTP_GET_VARS['ord']) : ( ( isset($HTTP_POST_VARS['ord']) ) ? ($HTTP_POST_VARS['ord']) : 'ques.question_id') ;
				$user_sort = ( isset($HTTP_GET_VARS['orduser']) ) ? ($HTTP_GET_VARS['orduser']) : ( ( isset($HTTP_POST_VARS['orduser']) ) ? ($HTTP_POST_VARS['orduser']) : '') ;
				
				$sql = "SELECT ca.cat_name, count(question_id) AS total_ques FROM ". CATEGORY_TABLE . " ca LEFT OUTER JOIN ".QUESTIONS_TABLE." ques 
							ON ques.cat_id = ca.cat_id WHERE ca.cat_id = ".$ca."  GROUP BY ca.cat_id LIMIT 1";

				if ( ($result1 = $db->sql_query($sql)) ) {
					$cat_details = $db->sql_fetchrow($result1);
				}

				$sql = " SELECT ca.cat_name, ques.question_id, ques.ques_name, ques.createdby, ques.lastedited_by, ques.lastedited_date, ques.allow_edit, ques.source, ques.rating, ques.flag, ques.qtype FROM ". CATEGORY_TABLE . " ca, ".QUESTIONS_TABLE." ques 
							WHERE ca.cat_id = ".$ca." AND ques.cat_id = ".$ca." ORDER BY ".$ordfield." ASC ";

				if ( ($result = $db->sql_query($sql)) ) {
				
					$template->assign_block_vars('questions',array(	'ACTION' => append_sid('index.php'), 
									'FORM_NAME' => 'questions',
									'PAGINATION' => generate_pagination( intval($cat_details['total_ques'] ), QUESTIONS_PER_PAGE, $start , append_sid("index.php")."&action=view&ARG1=".$cid."&ARG2=".$ca."&start=", 'bodyBlue12'),
									'CAT_NAME' => "Category : ".$cat_details['cat_name'],
									'FLAG' => '<a href="'.append_sid('index.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ord=flag&start='.$start).'">Flag</a>',
									'FORM_HIDDEN' => '<input type="hidden" name="ARG1" value="'.$cid.'"><input type="hidden" name="ARG2" value="'.$ca.'"><input type="hidden" name="ord" value="'.$ordfield.'">',	
								    'FIELD1' => '&nbsp;&nbsp;<a href="'.append_sid('index.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ord=ques_name&start='.$start).'">Ques. Name</a>',
									'FIELD2' => '<a href="'.append_sid('index.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&orduser=sort1&start='.$start).'">Author</a>',
									'FIELD3' => '<a href="'.append_sid('index.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&orduser=sort2&start='.$start).'">Last Edited By</a>',
									'FIELD4' => '<a href="'.append_sid('index.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ord=allow_edit&start='.$start).'">Allow Edit</a>',
									'FIELD5' => '<a href="'.append_sid('index.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ord=rating&start='.$start).'">Rating</a>',
									'FIELD6' => '<a href="'.append_sid('index.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ord=qtype&start='.$start).'">type</a>',
									'FIELD7' => '<a href="'.append_sid('index.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ord=lastedited_date&start='.$start).'">Last Edited On</a>'
									));
		
					$ques_found = $db->sql_numrows($result); // # of questions returned by the query
					for ( $k = 0 ; $k<$ques_found ; $k++)
					{		
						$question = $db->sql_fetchrow($result);
						$sqlu = " SELECT * FROM ".USERS_TABLE." WHERE user_level='1' OR user_level='2' ";
						if ( ($result1 = $db->sql_query($sqlu)) ) {
							while($user = $db->sql_fetchrow($result1) )	{
								if ($user['user_id']==$question['createdby']) {
									$creator = $user['user_lname'];
								}elseif ($question['createdby']==0) {
									$creator = "N/A";
								}
								if ($user['user_id']==$question['lastedited_by']) {
									$editor = $user['user_lname'];
								}elseif ($question['lastedited_by']==0) {
									$editor="N/A";
								}
							}
						}
								
						if ( $k % 2 ) {	$color = '#EFEFEF'; }else {$color = '#FFFFFF';	}
						if ($question['flag']=='a') {
							$flagimage = '<a href="javascript:void(0);" onClick="popUp2(\''.append_sid('comments.php?ARG1='.$cid.'&ARG3='.$question['question_id']).'\')"><img src="./../templates/default/images/flag.gif" border="0" alt="flag Img" align="absmiddle"></a>'; 
						}else{
							$flagimage = '';
						}
						
						if ( ($userdata['user_level'] == ADMIN) || ($courses['access_level'] == DIRECTOR ) || ( ($userdata['session_user_id'] == $question['createdby']) && $question['allow_edit'] == 1)) {
							// eve though i am the creator of question, if director disabled allow edit then dont show question
							$question_click = 'javascript:popUp2(\''.append_sid('questions.php?action=view&ARG1='.$cid.'&ARG2='.$ca.'&ARG3='.$question['question_id']).'\')';
						}
						else {
							$question_click = 'popUp2(\''.append_sid('preview.php?ARG1='.$cid.'&ARG3='.$question['question_id']).'\')';
						}
		
						$template->assign_block_vars('questions.details',array('NUM' => ($k+1),	
																'QUES_ID' => $question['question_id'],	
																'QUES_NAME' => $question['ques_name'],
																'QUES_CRTR' => $creator,
																'FLG' => $flagimage,
																'QUES_EDIT' => $editor,
																'QUES_DATE' => create_date($question['lastedited_date']),
																'CAT_NAME' => $question['allow_edit'],
																'QUES_RAT' => $question['rating'],
																'QUES_TYPE' => $question['qtype'],
																'BGCOLOR' => $color,
																'Q_PREVIEW_CLICK' => 'popUp2(\''.append_sid('preview.php?ARG1='.$cid.'&ARG3='.$question['question_id']).'\')',
																'Q_STATS' => 'popUp2(\''.append_sid('retro_stats.php?ARG2='.$cid.'&ARG3='.$question['question_id']).'\')',
																'CLICK' => $question_click
									)); 
				
					} // eof for loop
					
				}// eof question resultset				

			}// eof view
			if ($mode == 'dosearch' ){


				$ordfield =  ( isset($HTTP_GET_VARS['ord']) ) ? ($HTTP_GET_VARS['ord']) : ( ( isset($HTTP_POST_VARS['ord']) ) ? ($HTTP_POST_VARS['ord']) : 'ques.question_id') ;
				$template->assign_block_vars('questions',array(	'ACTION' => append_sid('index.php'), 
									'FORM_NAME' => 'search',	'PAGINATION' => '',	'CAT_NAME' => 'Search ',
									'FORM_HIDDEN' => '<input type="hidden" name="action" value="search"><input type="hidden" name="ARG1" value="'.$cid.'"><input type="hidden" name="ord" value="'.$ordfield.'">'	
								));
                
				$select_function = '<select name="func[]"><option value="like">LIKE</option><option value="=">=</option></select>';
				$select_rating = '<select name="fields[]"><option value=""></option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>';
				
				$template->assign_block_vars('questions.search',array('NAME' => 'Question Title','FUNC' => $select_function,'TEXTFIELD' => '<input type="text" name="fields[]" size="30" class="textfield" />'));
				$template->assign_block_vars('questions.search',array('NAME' => 'Question Stem','FUNC' => $select_function,'TEXTFIELD' => '<input type="text" name="fields[]" size="30" class="textfield" />'));
				$template->assign_block_vars('questions.search',array('NAME' => 'Keyword','FUNC' => $select_function,'TEXTFIELD' => '<input type="text" name="fields[]" size="30" class="textfield" />'));
				$template->assign_block_vars('questions.search',array('NAME' => 'Rating','FUNC' => '<input type="hidden" name="func[]" value="=">','TEXTFIELD' => $select_rating));				
				$template->assign_block_vars('questions.search',array('NAME' => '<input type="submit" value="search">','FUNC' => '','TEXTFIELD' => ''));				
				
				unset($select_rating, $select_function);
			} // eof dosearch
			if ( ($mode == 'search' ) ){

				$start =  ( isset($HTTP_POST_VARS['start']) ) ? $HTTP_POST_VARS['start'] :  0 ;
				
				$query = 'SELECT question_id, cat_id, ques_name, createdby, lastedited_by, lastedited_date, allow_edit, source, qtype FROM '.QUESTIONS_TABLE. ' WHERE course_id = '.$cid;
		        $cnt_fields = count($HTTP_POST_VARS['fields']);
				$names = array('ques_name', 'stem', 'keywords', 'rating');
		        for ($i = 0; $i < $cnt_fields; $i++) {
					
				    if ( (count($HTTP_POST_VARS['fields'])>0) && $HTTP_POST_VARS['fields'][$i] != '') {
					
                		    $quot     = '\'';
							$wild_char = ( ($HTTP_POST_VARS['func'][$i] == 'like') ? '%' : '' ) ;
							$query .= ' AND '. $names[$i] .' '. $HTTP_POST_VARS['func'][$i].' ' . $quot .$wild_char. $HTTP_POST_VARS['fields'][$i].$wild_char.$quot ;
	    	        } // end if
    	    	} // end for


				if ( ($result1 = $db->sql_query($query)) ) {
					$cat_details = $db->sql_numrows($result1);
				}

				$query = $query;

				if ($result = $db->sql_query($query)) {
					for ($x = 0 ; $x < 4 ; $x++ ) {
						$fo_hidden .= '<input type="hidden" name="func[]" value="'.$HTTP_POST_VARS['func'][$x].'">' ;
						$fo_hidden .= '<input type="hidden" name="fields[]" value="'.$HTTP_POST_VARS['fields'][$x].'">' ;
					}

					$pagination = 'Page : <select name="start" onChange = this.form.submit() >';
					for ($x = 0 ; $x < ($cat_details/QUESTIONS_PER_PAGE) ; $x++ ) {
						$pagination .=  (($start == ($x*QUESTIONS_PER_PAGE) ) ? '<option value='.($x*QUESTIONS_PER_PAGE).' selected>'.($x+1).'</option>' : '<option value='.($x*QUESTIONS_PER_PAGE).'>'.($x+1).'</option>' );
					}
					$pagination .= '</select>';
//					
					$template->assign_block_vars('questions',array(	'ACTION' => append_sid('index.php'), 
									'FORM_NAME' => 'questions',
									'PAGINATION' => $pagination,
									'CAT_NAME' => 'Search Results',
								    'FIELD1' => 'Ques. Name',
									'FIELD2' => 'Author',
									'FIELD3' => 'Last Edited By',
									'FIELD7' => 'Last Edited On',
									'FORM_HIDDEN' => '<input type="hidden" name="action" value="search"><input type="hidden" name="ARG1" value="'.$cid.'">'.$fo_hidden
								));
		
					$ques_found = $db->sql_numrows($result); // # of questions returned by the query

					for ( $k = 0 ; $k<$ques_found ; $k++)
					{		
						$question = $db->sql_fetchrow($result);

						$sqlu = " SELECT * FROM ".USERS_TABLE." WHERE user_level='1' OR user_level='2' ORDER BY user_id";
						if ( ($result1 = $db->sql_query($sqlu)) ) {
							while($user = $db->sql_fetchrow($result1) )	{
								if ($user['user_id']==$question['createdby']) {
									$creator = $user['user_lname']; 
								}elseif ($question['createdby']==0) {
									$creator = "Anderson";
								}
								if ($user['user_id']==$question['lastedited_by']) {
									$editor = $user['user_lname'];
								}elseif ($question['lastedited_by']==0) {
									$editor="Anderson";
								}
							}
						}
								
						if ( $k % 2 ) {	$color = '#EFEFEF'; } else {$color = '#FFFFFF';	}
						
						if ( ($userdata['user_level'] == ADMIN) || ($courses['access_level'] == DIRECTOR ) || ( ($userdata['session_user_id'] == $question['createdby']) && $question['allow_edit'] == 1)) {
							// eve though i am the creator of question, if director disabled allow edit then dont show question
							$question_click = 'javascript:popUp2(\''.append_sid('questions.php?action=view&ARG1='.$cid.'&ARG2='.$question['cat_id'].'&ARG3='.$question['question_id']).'\')';
						}
						else {
							$question_click = 'popUp2(\''.append_sid('preview.php?ARG1='.$cid.'&ARG3='.$question['question_id']).'\')';
						}
		
					$template->assign_block_vars('questions.details',array('NUM' => ($k+1), 'QUES_ID' => $question['question_id'], 'QUES_NAME' => $question['ques_name'],
																'QUES_CRTR' => $creator,
																'QUES_EDIT' => $editor,
																'QUES_DATE' => create_date($question['lastedited_date']),
																'BGCOLOR' => $color,
																'Q_PREVIEW_CLICK' => 'popUp2(\''.append_sid('preview.php?ARG1='.$cid.'&ARG2='.$question['cat_id'].'&ARG3='.$question['question_id']).'\')',
																'CLICK' => $question_click
									)); 
				
					} // eof for loop
					
					if ($cat_details <= 0 ) { $template->assign_block_vars('questions.search',array('TEXTFIELD' => '<span class="generror">No matching questions</span>' )); }
					
				}// eof question resultset	
			
			}// eof search
		
	} // eof valid course




	$template->assign_vars(array(
				'S_ROOTDIR' => $somCBT_root_path,
				'S_NAV' => $nav_path)
			);

	

}
else {
	if ( $userdata['user_level'] == STUDENT ) {
		redirect(append_sid("index.php", true));	
	} else {
		redirect(append_sid("login.php", true));
	}
}
//
// Generate the page
//

$template->pparse('overall_header');

$template->pparse('body');

include($somCBT_root_path . 'includes/page_tail.php');
?>