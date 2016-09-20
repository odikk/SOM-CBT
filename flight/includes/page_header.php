<?php


if ( !defined('IN_somCBT') )
{
	die("Hacking attempt");
}

define('HEADER_INC', TRUE);

//
// gzip_compression
//
$do_gzip_compress = FALSE;
if ( $CBT_config['gzip_compress'] )
{
	$phpver = phpversion();

	$useragent = (isset($HTTP_SERVER_VARS["HTTP_USER_AGENT"]) ) ? $HTTP_SERVER_VARS["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;

	if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
	{
		if ( extension_loaded('zlib') )
		{
			ob_start('ob_gzhandler');
		}
	}
	else if ( $phpver > '4.0' )
	{
		if ( strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') )
		{
			if ( extension_loaded('zlib') )
			{
				$do_gzip_compress = TRUE;
				ob_start();
				ob_implicit_flush(0);

				header('Content-Encoding: gzip');
			}
		}
	}
}

//
// Parse and show the overall header.
//

$template->set_filenames(array(
	'overall_header' => 'header.tpl')
);


//
// Generate logged in/logged out status
//
if ( $userdata['session_logged_in'] )
{
	$u_login_logout = $somCBT_root_path.'login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];
	$l_login_logout = 'Logout' . ' [ ' . $userdata['username'] . ' ]';
}
else
{
	$u_login_logout = 'login.php';
	$l_login_logout = $lang['Login'];
}

// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
$l_timezone = explode('.', $CBT_config['board_timezone']);
$l_timezone = (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0) ? $lang[sprintf('%.1f', $CBT_config['board_timezone'])] : $lang[number_format($CBT_config['board_timezone'])];
//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//
$template->assign_vars(array(
	'SITENAME' => $CBT_config['sitename'],
	'SITE_DESCRIPTION' => $CBT_config['site_desc'],
	'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], $s_last_visit),
	'CURRENT_TIME' => sprintf($lang['Current_time'], create_date($CBT_config['default_dateformat'], time(), $CBT_config['board_timezone'])),
	'TOTAL_USERS_ONLINE' => $l_online_users,
	'LOGGED_IN_USER_LIST' => $online_userlist,
	'RECORD_USERS' => sprintf($lang['Record_online_users'], $CBT_config['record_online_users'], create_date($CBT_config['default_dateformat'], $CBT_config['record_online_date'], $CBT_config['board_timezone'])),

	'S_LOGIN_ACTION' => append_sid('login.'.$phpEx),

	'L_LOGIN_LOGOUT' => $l_login_logout,
	'L_WHOSONLINE_ADMIN' => sprintf($lang['Admin_online_color'], '<span style="color:#' . $theme['fontcolor3'] . '">', '</span>'),
	'L_WHOSONLINE_MOD' => sprintf($lang['Mod_online_color'], '<span style="color:#' . $theme['fontcolor2'] . '">', '</span>'),
	
	'U_LOGIN_LOGOUT' => append_sid($u_login_logout),

	'T_STYLESHEET' => $theme['template_name'],
	'T_HEAD_STYLESHEET' => $theme['head_stylesheet'],
	'T_BODY_BACKGROUND' => $theme['body_background'],
	'T_BODY_BGCOLOR' => '#'.$theme['body_bgcolor'],
	'T_BODY_TEXT' => '#'.$theme['body_text'],
	'T_BODY_LINK' => '#'.$theme['body_link'],
	'T_BODY_VLINK' => '#'.$theme['body_vlink'],
	'T_BODY_ALINK' => '#'.$theme['body_alink'],
	'T_BODY_HLINK' => '#'.$theme['body_hlink'],

	'NAV_LINKS' => $nav_links_html)
);

//
// Login box?
//

if ( !$userdata['session_logged_in'] )
{
	$template->assign_block_vars('switch_user_logged_out', array());
}
else
{
	$template->assign_block_vars('switch_user_logged_in', array());
}

// Add no-cache control for cookies if they are set
//$c_no_cache = (isset($HTTP_COOKIE_VARS[$CBT_config['cookie_name'] . '_sid']) || isset($HTTP_COOKIE_VARS[$CBT_config['cookie_name'] . '_data'])) ? 'no-cache="set-cookie", ' : '';

// Work around for "current" Apache 2 + PHP module which seems to not
// cope with private cache control setting
if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
{
	header ('Cache-Control: no-cache, pre-check=0, post-check=0');
}
else
{
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
header ('Expires: 0');
header ('Pragma: no-cache');

?>