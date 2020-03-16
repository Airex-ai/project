<?php
//Web site upgrading
	$OJ_UPGRADE = false;

// OJ Info
	$OJ_NAME = "WIT Online Judge"; // Name of this OJ, e.g. , [WITOJ]

// Data Path Setting
	$OJ_PROBLEM_DATA = "/home/judge/data"; //Path to problem data floder. e.g. [/home/judge/data], this path will NOT work IF you are running on SAE or OpenShift
	$OJ_UPLOAD_DATA = "/home/judge/judge/src/web/uploads/"; // Any file or image will be upload here. e.g. [/var/www/html/BLumiaOJ/imguploads/]
	$OJ_WWW_UPLOAD_PATH = "uploads"; // Img can be visit at http://your.site/path/to/folder/ , u should fill [path/to/folder]

// Submit Setting
	$OJ_SUBMIT_DELTATIME = 10; // allowed submit frequence. (seconds)
	$OJ_LANGMASK = 65460; //1mC 2mCPP 4mPascal 8mJava 16mRuby 32mBash 65520 for security reason to mask all other language, see `common_const.inc.php` for more details. default 65520
	
// Page Setting
	$PAGE_ITEMS = 50;// Show how many comments/posts in one pages?
	
// Solution Setting
	$SOLUTION_WA_INFO = false; // Show WA result compare?
	$SOLUTION_SHARE = false; // Can people view the source if he/she Accepted that problem?
	
// Contest Setting
	$OJ_LOCKRANK = false; // Default Lock Ranklist Mod
	$OJ_LOCKRANK_PERCENT = 0.2; // 0~1. eg. 0.2: a 5 hours contest will lock one hour.
	$OJ_CE_PENALTY = false; // 	// ACM WF punish no ce
	$OJ_LARGE_CONTEST_MODE = false; // Enable it will disable discuss forum, private mailbox and enable login filter(see next variable).
	$OJ_CONTEST_CID = Array();
	$OJ_LOGIN_FILTER = false; // Login filter will only allow administrator, and users who is not administrator but his/her user_id match the given prefix to login. set it to false (boolean, not string) if you wish disable login filter so that anyone registed can login, login filter is only enable if $OJ_LARGE_CONTEST_MODE is true and $OJ_LOGIN_FILTER is not set to false.
	
// Community forum (Discuss board) Setting
	$FORUM_ENABLED = true; // Experimental feature, if you need a forum, change it to [true].
	$FORUM_SUBMIT_DELTATIME = 10; // allowed submit frequence. (seconds)
	$FORUM_ENHAUNCEMENT = false; // Need import extra sql struct into your database.

//document.php?f=about

// Search Engine Optimization
	$OJ_ENABLE_SEO = true;
	$SEO_KEYWORD = "WIT,witacm,acmwit,acm-wit,武汉工程大学OJ,ACM,ICPC";
	$SEO_DESC = "欢迎来到武汉工程大学在线评测系统，武汉工程大学ACM校队成立于2016年，是一支充满青春活力的队伍。";

// DB setting

	$SQL_DB_NAME = "jol";	//Your DB Name
	$SQL_DB_HOST = "127.0.0.1";//Your DB Host
	$SQL_DB_PORT = "80";//Your DB Host
	$SQL_DB_USER = "witacm";//Your DB Login Username
	$SQL_DB_PASS = "witacm";//Your DB Management Password

// Use memcache
	$OJ_MEMCACHE=true;
	$OJ_MEMSERVER="127.0.0.1";
	$OJ_MEMPORT=11211;
	
// Developer Setting
	$DEV_DISPLAY_ERRORS =true; // Display Error Messages of PHP display_errors
?>
