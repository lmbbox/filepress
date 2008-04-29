<?php
/*
LMB^Box FilePress
http://aboutme.lmbbox.com/lmbbox-plugins/lmbbox-filepress/
!New Description Needed! -> FilePress allows you to browse and upload files on the write tab of WordPress. There will be a new buttons in the quicktags toolbar, 'FilePress'. They will enable you to upload new files, create thumbnails of images, link to files, link to images, include thumbnails / images / certain files, and also include thumbnails / images / certain files with links to the orginal file.
Version 1.0 Beta, 2005-12-14 <img src="http://aboutme.lmbbox.com/plugins-updates.php?plugin=lmbbox-filepress&amp;version=1.0" alt="Checking For Updates ..." title="Checking For Updates ..." />
By Thomas Montague
http://aboutme.lmbbox.com/
*/

// get settings and functions
// neat little test to find the wp-config.php file in the root directory
// from Owen Winkler's Exhibit http://www.asymptomatic.net/wp-hacks/
$config_file = 'wp-config.php';
$c = 0;
while(!is_file($config_file)) {
	$config_file = '../' . $config_file;
	$c++;
	if($c == 15)
		exit('Could not find wp-config.php!');
}
require_once($config_file);
require_once('lang_en.php');

// Start of Main Code
$lmbbox_filepress->path_abs = $lmbbox_filepress->path_secure($_REQUEST['path'], true, false);

// Page Header
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name') ?> &rsaquo; LMB^Box FilePress</title>
<link type="text/css" rel="stylesheet" href="styles.css" />
<script type="text/javascript" language="javascript">var path = '<?php echo addslashes($lmbbox_filepress->path_abs); ?>';</script>
<script type="text/javascript" language="javascript" src="scripts.js"></script>
<!--
<script type="text/javascript" language="javascript" src="jscookmenu.js"></script>
<script type="text/javascript" language="javascript" src="menu_theme/theme.js"></script>
<link type="text/css" rel="stylesheet" href="menu_theme/theme.css" />
<script type="text/javascript" language="javascript" src="menu_theme/menu.js"></script>
//-->
</head>
<body>

<?php
// Start Content Code
get_currentuserinfo();

if ($user_level == '') { // Checks to see if user has logged in
	_e('You need to login!');
} elseif ($user_level < $lmbbox_filepress->options['min_use_level']) { // Checks to see if user's level is high enough
	_e('Ask the administrator to promote you.');
/*
} elseif (!get_settings('use_fileupload')) { // Checks if file upload is enabled in the config
	_e('The admin has disabled this function');
} elseif ($user_level < get_settings('fileupload_minlevel')) { // Checks to see if user's level is high enough
	_e('Ask the administrator to promote you.');
*/
} elseif (!is_writable($lmbbox_filepress->options['home_abs'])) {
	_e('<p>It doesn\'t look like you can use the file upload feature at this time because the directory you have specified (<code>' . $lmbbox_filepress->options['home_abs'] . '</code>) doesn\'t appear to be writable by WordPress. Check the permissions on the directory and for typos.</p>');
} else {
	switch ($_REQUEST['action']) {
		case 'manage_folder':
			$lmbbox_filepress->manage_folder($_REQUEST['manage_folder_action'], $_REQUEST['folder'], $_REQUEST['target'], $_REQUEST['force_delete']);
			break;
		case 'manage_file':
			$lmbbox_filepress->manage_file($_REQUEST['manage_file_action'], $_REQUEST['file'], $_REQUEST['upload_type'], $_REQUEST['file_url'], $_REQUEST['target'], $_REQUEST['width'], $_REQUEST['height']);
			break;
		case 'browse':
		default:
			$lmbbox_filepress->browse_page();
			break;
	} // end switch
} // end else

// Page Footer
?>
<script type="text/javascript" language="javascript">
<!--
	document.getElementById('logo').innerHTML = 'Loaded In <?php timer_stop(1); ?> Seconds With <?php echo $wpdb->num_queries; ?> Queries. ' + document.getElementById('logo').innerHTML;
//-->
</script>
</body>
</html>
