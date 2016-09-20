<?php


if ( !defined('IN_somCBT') )
{
	die("Hacking attempt");
}


// User Levels <- Do not change the values of USER or ADMIN
define('DELETED', -1);
define('ANONYMOUS', -1);
//the following are used to denote user 'access_level' in the course_users table - SMQ
define('ADMIN', 1);
define('DIRECTOR', 2);
define('FACULTY', 3);
define('REVIEWER', 4);
define('STUDENT', 5);
define('EVALUATOR', 6);
//the following is only used to denote 'user_level' in the users table - SMQ
define('TEACHER', 2); // Director, faculty, reviewer used only in users table

// Page numbers for session handling
define('PAGE_INDEX', 0);
define('PAGE_LOGIN', -1);
define('PAGE_COURSE', -2);
define('PAGE_QUIZ_INDEX', -3);
define('PAGE_QUIZ_CREATE', -4);
define('PAGE_QUIZ_QUIZ', -5);
define('PAGE_QUIZ_SUBMIT', -6);
define('PAGE_QUIZ_REPORT', -7);
define('PAGE_USERS', -8);

// Session parameters - not used
define('SESSION_METHOD_COOKIE', 100);
define('SESSION_METHOD_GET', 101);

// SQL codes - not used
define('BEGIN_TRANSACTION', 1);
define('END_TRANSACTION', 2);

//Question types
define('MULTIPLECHOICE', 1);
define('DESCRIPTION', 2);
define('TRUEFALSE', 3);



// Table names
define('USERS_TABLE', 'users');
define('SESSIONS_TABLE', 'sessions');
define('CONFIG_TABLE', 'config');
define('THEMES_TABLE', 'themes');
define('COURSE_TABLE', 'course');
define('CATEGORY_TABLE', 'category');
define('GROUPS_TABLE', 'groups');
define('COURSE_USERS_TABLE', 'course_users');
define('QUIZ_TABLE', 'quiz');
define('QUESTIONS_TABLE', 'questions');
define('QUESTION_STATS_TABLE', 'question_stats');
define('WEBCT_STATS_TABLE', 'webct_stats');
define('QUESTION_COMMENTS_TABLE', 'question_comments');
define('QUIZ_QUESTIONS_TABLE', 'quiz_questions');
define('QUIZ_RESPONSES_TABLE', 'quiz_responses');
define('QUIZ_TEXT_RESPONSES_TABLE', 'quiz_text_responses');
define('QUIZ_ATTEMPTS_TABLE', 'quiz_attempts');
define('STATISTICS_TABLE', 'question_stats');
define('TEST_LOG_TABLE', 'test_log');
define('DICTIONARY_TABLE', 'dictionary');
define('QUIZ_SETTINGS_TABLE', 'quiz_settings');
define('USMLE_TABLE', 'usmle_vocab');
define('VOC_XREF_TABLE', 'voc_xref');

?>