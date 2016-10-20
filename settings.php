<?php

/* Runtime settings for better security 
 *  since we don't have access to the php.ini file using cPanel
 */
 
	ini_set('display_errors', 'Off');
	ini_set('expose_php', 'Off');
	ini_set('display_startup_errors', 'Off');
	ini_set('allow_url_fopen', 'Off');
	ini_set('allow_url_include', 'Off');
	ini_set('allow_webdav_methods', 'Off');
	ini_set('session.cookie_lifetime', '0');
	ini_set('session.cookie_httponly', '1');
	ini_set('session.use_only_cookies', '1');
	ini_set('session.entropy_file', '/dev/urandom');
	
?>








