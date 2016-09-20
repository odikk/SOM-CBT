<?php /*   *  Get Userdata, $user can be username or user_id. If force_str is true, the username will be forced.  */function get_userdata($user, $force_str = false){	global $db;	if (intval($user) == 0 || $force_str)	{		$user = trim(htmlspecialchars($user));		$user = substr(str_replace("\\'", "'", $user), 0, 25);		$user = str_replace("'", "\\'", $user);	}	else	{		$user = intval($user);	}	$sql = "SELECT *		FROM " . USERS_TABLE . " 		WHERE ";	$sql .= ( ( is_integer($user) ) ? "user_id = $user" : "username = '" .  $user . "'" ) . " AND user_id <> " . ANONYMOUS;	if ( !($result = $db->sql_query($sql)) )	{		die('Tried obtaining data for a non-existent user');	}	return ( $row = $db->sql_fetchrow($result) ) ? $row : false;}//// Initialise user settings on page loadfunction init_userprefs($userdata){	global  $CBT_config, $theme, $images;	global $template, $lang, $phpEx, $somCBT_root_path;	global $nav_links;	$CBT_config['default_lang'] = 'english';		 	$theme = setup_style( $CBT_config['default_style']);	return;}/* *  At present there is only on style named default *  later different styles can be added  *  user can have his preference */function setup_style($style){	global $db, $CBT_config, $template, $images, $somCBT_root_path;/*	$sql = "SELECT *		FROM " . THEMES_TABLE . "		WHERE themes_id = $style";	if ( !($result = $db->sql_query($sql)) )	{		message_die(CRITICAL_ERROR, 'Could not query database for theme info');	}	if ( !($row = $db->sql_fetchrow($result)) )	{		message_die(CRITICAL_ERROR, "Could not get theme data for themes_id [$style]");	}*/	$row['template_name'] = 'default';	$row['style_name'] = 'default';	$row['head_stylesheet'] = 'default.css';	$row['body_bgcolor'] = 'FFFFFF';	$template_path = 'templates/' ;	$template_name = $row['template_name'] ;	$template = new Template($somCBT_root_path . $template_path . $template_name);	if ( $template )	{		$current_template_path = $template_path . $template_name;		@include($somCBT_root_path . $template_path . $template_name . '/' . $template_name . '.cfg');		if ( !defined('TEMPLATE_CONFIG') )		{			message_die(CRITICAL_ERROR, "Could not open $template_name template config file", '', __LINE__, __FILE__);		}/*		$img_lang = ( file_exists(@phpbb_realpath($somCBT_root_path . $current_template_path . '/images/lang_' .  $CBT_config['default_lang'])) ) ?  $CBT_config['default_lang'] : 'english';		while( list($key, $value) = @each($images) )		{			if ( !is_array($value) )			{				$images[$key] = str_replace('{LANG}', 'lang_' . $img_lang, $value);			}		}*/	}	return $row;}/*  * Encoding ip address  * converting to a number to store in the database *  */ function encode_ip($dotquad_ip){	$ip_sep = explode('.', $dotquad_ip);	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);}/*  * De-coding ip address  */ function decode_ip($int_ip){	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);}// Checks whether the given IP addres is within the given rangefunction IsIPInRange($currentIp, $startIp, $endIp) {	$startIp = sprintf("%u", ip2long($startIp));	$endIp = sprintf("%u", ip2long($endIp));	$currentIp = sprintf("%u", ip2long($currentIp));	return ( ($currentIp <= $endIp) && ($currentIp >= $startIp) )  ? 1 :  0 ;}/* *  Create date/time from format and timezone * */function create_date( $gmepoch, $unix_stamp = 1, $format= "d F Y G:i", $tz=-5){	if ($unix_stamp) {		return @date($format, intval($gmepoch));	}	else {		$gmepoch = explode(",", $gmepoch);		return mktime(intval($gmepoch[0]), intval($gmepoch[1]), intval($gmepoch[2]), intval($gmepoch[4]), intval($gmepoch[3]), intval($gmepoch[5]));	}}//// Pagination routine, generates// page number sequence//function generate_pagination($num_items, $per_page, $start_item, $base_url='', $span_class='', $add_prevnext_text = TRUE){	$begin_end = 4;	$from_middle = 2;/*	By default, $begin_end is 3, and $from_middle is 1, so on page 6 in a 12 page view, it will look like this:	a, d = $begin_end = 3	b, c = $from_middle = 1 "begin"        "middle"           "end"    |              |                 |    |     a     b  |  c     d        |    |     |     |  |  |     |        |    v     v     v  v  v     v        v    1, 2, 3 ... 5, 6, 7 ... 10, 11, 12	Change $begin_end and $from_middle to suit your needs appropriately*/	$total_pages = ceil($num_items/$per_page);	if ( $total_pages == 1 )	{		return '';	}	$on_page = floor($start_item / $per_page) + 1;	$page_string = '';	if ( $total_pages > ((2*($begin_end + $from_middle)) + 2) )	{		$init_page_max = ( $total_pages > $begin_end ) ? $begin_end : $total_pages;		for($i = 1; $i < $init_page_max + 1; $i++)		{			$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' .  $base_url. ( ( $i - 1 ) * $per_page )  . ' " class = "'.$span_class.'">' . $i . '</a>';			if ( $i <  $init_page_max )			{				$page_string .= ", ";			}		}		if ( $total_pages > $begin_end )		{			if ( $on_page > 1  && $on_page < $total_pages )			{				$page_string .= ( $on_page > ($begin_end + $from_middle + 1) ) ? ' ... ' : ', ';				$init_page_min = ( $on_page > ($begin_end + $from_middle) ) ? $on_page : ($begin_end + $from_middle + 1);				$init_page_max = ( $on_page < $total_pages - ($begin_end + $from_middle) ) ? $on_page : $total_pages - ($begin_end + $from_middle);				for($i = $init_page_min - $from_middle; $i < $init_page_max + ($from_middle + 1); $i++)				{					$page_string .= ($i == $on_page) ? '<b>' . $i . '</b>' : '<a href="' . $base_url.( ( $i - 1 ) * $per_page )  . '" class = "'.$span_class.'">' . $i . '</a>';					if ( $i <  $init_page_max + $from_middle )					{						$page_string .= ', ';					}				}				$page_string .= ( $on_page < $total_pages - ($begin_end + $from_middle) ) ? ' ... ' : ', ';			}			else			{				$page_string .= ' ... ';			}			for($i = $total_pages - ($begin_end - 1); $i < $total_pages + 1; $i++)			{				$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>'  : '<a href="' . $base_url. ( ( $i - 1 ) * $per_page )  . '" class = "'.$span_class.'">' . $i . '</a>';				if( $i <  $total_pages )				{					$page_string .= ", ";				}			}		}	}	else	{		for($i = 1; $i < $total_pages + 1; $i++)		{			$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . $base_url. ( ( $i - 1 ) * $per_page )  . '" class = "'.$span_class.'">' . $i . '</a>';			if ( $i <  $total_pages )			{				$page_string .= ', ';			}		}	}//	$page_string = 'GOTO ' . ' ' . $page_string;	return $page_string;}//// This does exactly what preg_quote() does in PHP 4-ish// If you just need the 1-parameter preg_quote call, then don't bother using this.//function phpbb_preg_quote($str, $delimiter){	$text = preg_quote($str);	$text = str_replace($delimiter, '\\' . $delimiter, $text);		return $text;}//// Obtain list of naughty words and build preg style replacement arrays for use by the// calling script, note that the vars are passed as references this just makes it easier// to return both sets of arrays//function obtain_word_list(&$orig_word, &$replacement_word){	global $db;	//	// Define censored word matches	//	$sql = "SELECT word, replacement		FROM  " . WORDS_TABLE;	if( !($result = $db->sql_query($sql)) )	{		message_die(GENERAL_ERROR, 'Could not get censored words from database', '', __LINE__, __FILE__, $sql);	}	if ( $row = $db->sql_fetchrow($result) )	{		do 		{			$orig_word[] = '#\b(' . str_replace('\*', '\w*?', phpbb_preg_quote($row['word'], '#')) . ')\b#i';			$replacement_word[] = $row['replacement'];		}		while ( $row = $db->sql_fetchrow($result) );	}	return true;}//// This is general replacement for die(), allows templated// output in users (or default) language, etc.//// $msg_code can be one of these constants://// GENERAL_MESSAGE : Use for any simple text message, eg. results // of an operation, authorisation failures, etc.//// GENERAL ERROR : Use for any error which occurs _AFTER_ the // common.php include and session code, ie. most errors in // pages/functions//// CRITICAL_MESSAGE : Used when basic config data is available but // a session may not exist, eg. banned users//// CRITICAL_ERROR : Used when config data cannot be obtained, eg// no database connection. Should _not_ be used in 99.5% of cases//function message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = ''){	die($msg_code);/*	global $db, $template,  $CBT_config, $theme, $lang, $phpEx, $somCBT_root_path, $nav_links, $gen_simple_header, $images;	global $userdata, $user_ip, $session_length;	global $starttime;	if(defined('HAS_DIED'))	{		die("message_die() was called multiple times. This isn't supposed to happen. Was message_die() used in page_tail.php?");	}		define(HAS_DIED, 1);		$sql_store = $sql;		//	// Get SQL error if we are debugging. Do this as soon as possible to prevent 	// subsequent queries from overwriting the status of sql_error()	//	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )	{		$sql_error = $db->sql_error();		$debug_text = '';		if ( $sql_error['message'] != '' )		{			$debug_text .= '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];		}		if ( $sql_store != '' )		{			$debug_text .= "<br /><br />$sql_store";		}		if ( $err_line != '' && $err_file != '' )		{			$debug_text .= '</br /><br />Line : ' . $err_line . '<br />File : ' . $err_file;		}	}	if( empty($userdata) && ( $msg_code == GENERAL_MESSAGE || $msg_code == GENERAL_ERROR ) )	{		$userdata = session_pagestart($user_ip, PAGE_INDEX);		init_userprefs($userdata);	}	//	// If the header hasn't been output then do it	//	if ( !defined('HEADER_INC') && $msg_code != CRITICAL_ERROR )	{		if ( empty($lang) )		{			if ( !empty( $CBT_config['default_lang']) )			{				include($somCBT_root_path . 'language/lang_' .  $CBT_config['default_lang'] . '/lang_main.'.$phpEx);			}			else			{				include($somCBT_root_path . 'language/lang_english/lang_main.'.$phpEx);			}		}		if ( empty($template) )		{			$template = new Template($somCBT_root_path . 'templates/' .  $CBT_config['board_template']);		}		if ( empty($theme) )		{			$theme = setup_style( $CBT_config['default_style']);		}		//		// Load the Page Header		//		if ( !defined('IN_ADMIN') )		{			include($somCBT_root_path . 'includes/page_header.'.$phpEx);		}		else		{			include($somCBT_root_path . 'admin/page_header_admin.'.$phpEx);		}	}	switch($msg_code)	{		case GENERAL_MESSAGE:			if ( $msg_title == '' )			{				$msg_title = $lang['Information'];			}			break;		case CRITICAL_MESSAGE:			if ( $msg_title == '' )			{				$msg_title = $lang['Critical_Information'];			}			break;		case GENERAL_ERROR:			if ( $msg_text == '' )			{				$msg_text = $lang['An_error_occured'];			}			if ( $msg_title == '' )			{				$msg_title = $lang['General_Error'];			}			break;		case CRITICAL_ERROR:			//			// Critical errors mean we cannot rely on _ANY_ DB information being			// available so we're going to dump out a simple echo'd statement			//			include($somCBT_root_path . 'language/lang_english/lang_main.'.$phpEx);			if ( $msg_text == '' )			{				$msg_text = $lang['A_critical_error'];			}			if ( $msg_title == '' )			{				$msg_title = 'phpBB : <b>' . $lang['Critical_Error'] . '</b>';			}			break;	}	//	// Add on DEBUG info if we've enabled debug mode and this is an error. This	// prevents debug info being output for general messages should DEBUG be	// set TRUE by accident (preventing confusion for the end user!)	//	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )	{		if ( $debug_text != '' )		{			$msg_text = $msg_text . '<br /><br /><b><u>DEBUG MODE</u></b>' . $debug_text;		}	}	if ( $msg_code != CRITICAL_ERROR )	{		if ( !empty($lang[$msg_text]) )		{			$msg_text = $lang[$msg_text];		}		if ( !defined('IN_ADMIN') )		{			$template->set_filenames(array(				'message_body' => 'message_body.tpl')			);		}		else		{			$template->set_filenames(array(				'message_body' => 'admin/admin_message_body.tpl')			);		}		$template->assign_vars(array(			'MESSAGE_TITLE' => $msg_title,			'MESSAGE_TEXT' => $msg_text)		);		$template->pparse('message_body');		if ( !defined('IN_ADMIN') )		{			include($somCBT_root_path . 'includes/page_tail.'.$phpEx);		}		else		{			include($somCBT_root_path . 'admin/page_footer_admin.'.$phpEx);		}	}	else	{		echo "<html>\n<body>\n" . $msg_title . "\n<br /><br />\n" . $msg_text . "</body>\n</html>";	}	exit; */}//// This function is for compatibility with PHP 4.x's realpath()// function.  In later versions of PHP, it needs to be called// to do checks with some functions.  Older versions of PHP don't// seem to need this, so we'll just return the original value.// dougk_ff7 <October 5, 2002>function phpbb_realpath($path){	global $somCBT_root_path, $phpEx;	return (!@function_exists('realpath') || !@realpath($somCBT_root_path . 'includes/functions.'.$phpEx)) ? $path : @realpath($path);}function redirect($url){	global $db,  $CBT_config;	if (!empty($db))	{		$db->sql_close();	}	$server_protocol = ( $CBT_config['cookie_secure']) ? 'https://' : 'http://';	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim( $CBT_config['server_name']));	$server_port = ( $CBT_config['server_port'] <> 80) ? ':' . trim( $CBT_config['server_port']) : '';	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim( $CBT_config['script_path']));	$script_name = ($script_name == '') ? $script_name : '/' . $script_name;	$url = preg_replace('#^\/?(.*?)\/?$#', '/\1', trim($url));	// Redirect via an HTML form for PITA webservers	if (@preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')))	{		header('Refresh: 0; URL=' . $server_protocol . $server_name . $server_port . $script_name . $url);		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $server_protocol . $server_name . $server_port . $script_name . $url . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $server_protocol . $server_name . $server_port . $script_name . $url . '">HERE</a> to be redirected</div></body></html>';		exit;	}	// Behave as per HTTP/1.1 spec for others	header('Location: ' . $server_protocol . $server_name . $server_port . $script_name . $url);	exit;}// To find the script start and end timefunction timer($starttime = 0, $end = 0) {	$mtime = microtime ();    $mtime = explode (' ', $mtime);	$mtime = $mtime[1] + $mtime[0];	if (!$end) {		return $mtime;	} else {		if ($starttime) {			$endtime = round(($mtime - $starttime), 5);			return $endtime;		}		else {			return 0;		}	}}// calulates the difference between two timesfunction calculateDateDiff($date1, $date2) {	$diff = abs ($date2-$date1);		$seconds = 0;  $hours = 0; $minutes = 0;	if ($diff % 86400 > 0) {		$rest = ($diff % 86400)	;		$days = ($diff - $rest) / 86400 ;		if ($rest % 3600 > 0 )  {			$rest1 = ($rest % 3600) ;				$hours = ($rest - $rest1) / 3600;			if ($rest1 % 60 > 0) {				$rest2 = ($rest1%60);				$minutes = ($rest1- $rest2) / 60;				$seconds = $rest2;			} else {				$minutes = $rest1 / 60;			}					} else {			$hours = $rest / 3600;		}	} else {		$days = $diff / 86400 ;	}	return array("days" => $days, "hours"=>$hours, "minutes"=>$minutes, "seconds" => $seconds);}// create a select boxes for date,month,uear,hours,min with the passed name// option selected if it is in the val_arrayfunction date_selector($selector_name, $val_array=array()) {	unset($selector_str);//	print_r($val_array);	$selector_str= '<Select name = "'.$selector_name.'_date">';    for ($i=1; $i<=31; $i++) {		if (intval($val_array[0]) == $i) {			$selector_str .= '<option value="'.$i.'" selected>'.$i.'</option>';		} else {			$selector_str .= '<option value="'.$i.'">'.$i.'</option>';		}    }		$selector_str .= '</select> &nbsp;&nbsp; ';		$selector_str .= '<Select name = "'.$selector_name.'_month">';    for ($i=1; $i<=12; $i++) {		$month_name = strftime("%B",mktime(12,0,0,$i,1,2004)) ;			if (strcasecmp($month_name, $val_array[1])==0) {			$selector_str .=  '<option value="'.$i.'" selected>'.$month_name.'</option>';		}		else {			$selector_str .=  '<option value="'.$i.'">'.$month_name.'</option>';		}    }		$selector_str .= '</select> &nbsp;&nbsp; ';	$selector_str .= '<Select name = "'.$selector_name.'_year">';    for ($i=2004; $i<=2020; $i++) {		if (intval($val_array[2]) == $i) {			$selector_str .= '<option value="'.$i.'" selected>'.$i.'</option>';		} else {			$selector_str .= '<option value="'.$i.'">'.$i.'</option>';		}    }	$selector_str .= '</select> &nbsp;&nbsp; ';		$selector_str .= '<Select name = "'.$selector_name.'_hour">';		for ($i=0; $i<=23; $i++) {		if (intval($val_array[4]) == $i) {			$selector_str .= '<option value="'.$i.'" selected>'.sprintf("%02d",$i).'</option>';		} else {			$selector_str .= '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';		}    }		$selector_str .= '</select> &nbsp;&nbsp; ';			$selector_str .= '<Select name = "'.$selector_name.'_min">';		for ($i=0; $i<=59; $i++) {		if (intval($val_array[5]) == $i) {				$selector_str .= '<option value="'.$i.'" selected>'.sprintf("%02d",$i).'</option>';		} else {			$selector_str .= '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';		}    }		$selector_str .= '</select> &nbsp;&nbsp; ';			return $selector_str;}?>