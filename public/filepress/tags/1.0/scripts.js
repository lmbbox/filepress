//
// LMB^Box FilePress 'scripts.js' File
//
/*
LMB^Box FilePress
http://aboutme.lmbbox.com/lmbbox-plugins/lmbbox-filepress/
FilePress allows you to browse and upload files on the write tab of WordPress. There will be two new buttons in the quicktags toolbar, one 'Browse' and the other 'Upload'. They will enable you to upload new files, create thumbnails of images, link to files, link to images, include thumbnails / images / certain files, and also include thumbnails / images / certain files with links to the orginal file.
Version 1.0, 2005-08-31
By Thomas Montague
http://aboutme.lmbbox.com/
*/

function panel_toggle(id) {
	if (document.getElementById(id).style.display == 'none') {
		document.cookie = id + '_toggle=collapse';
		document.getElementById(id).style.display = '';
		document.getElementById(id + '_toggle').src = 'images/collapse.gif';
	} else {
		document.cookie = id + '_toggle=expand';
		document.getElementById(id).style.display = 'none';
		document.getElementById(id + '_toggle').src = 'images/expand.gif';
	}
}

function get_file_name(field, value) {
	re = /^.+[\/\\]+?(.+)$/;
	field.value = value.replace(re, "$1");
}

function check_manage_dir_fields() {
	if (!document.manage_dir_form.manage_dir_action[0].checked && !document.manage_dir_form.manage_dir_action[1].checked) {
		alert('You need to choose an action to do!');
		return false;
	} else if (document.manage_dir_form.manage_dir_action[0].checked && !document.manage_dir_form.target_name.value) {
		alert('You need to add a name for the new directory!');
		return false;
	} else if (document.manage_dir_form.manage_dir_action[1].checked && !document.manage_dir_form.target_directory.value) {
		alert('You can not remove your root directory, you need to select a directory to remove!');
		return false;
	} else {
		if (document.manage_dir_form.manage_dir_action[1].checked) {
			return confirm('Do you really want to remove the "' + document.manage_dir_form.target_directory.value + '" directory?');
		} else {
			return true;
		}
	}
}

function check_upload_file_fields() {
	if (document.upload_form.fileurl.value && document.upload_form.userfile.value) {
		alert('You can not have a value in both "Fetch A URL" and "File Upload" fields! Please clear one or the other!');
		return false;
	} else if (!document.upload_form.fileurl.value && !document.upload_form.userfile.value) {
		alert('You can not leave both "Fetch A URL" and "File Upload" fields blank! Please fill in one or the other!');
		return false;
	} else {
		return true;
	}
}

function rename_file() {
	
}

function load_manage_file_fields(manage_file_action) {
	if (manage_file_action == 'edit_file') {
		document.manage_file_form.manage_file_action[0].click();
	} else if (manage_file_action == 'rename_file') {
		document.manage_file_form.manage_file_action[1].click();
	} else if (manage_file_action == 'delete_file') {
		document.manage_file_form.manage_file_action[2].click();
	} else if (manage_file_action == 'copy_file') {
		document.manage_file_form.manage_file_action[3].click();
	} else if (manage_file_action == 'move_file') {
		document.manage_file_form.manage_file_action[4].click();
	}
}

function check_manage_file_fields(file_name) {
	if (document.manage_file_form.manage_file_action[1].checked && document.manage_file_form.target_name.value == file_name) {
		alert('There is no point to rename the file with its current name!');
		return false;
	} else if (document.manage_file_form.manage_file_action[1].checked && document.manage_file_form.target_name.value == '') {
		alert('You need to enter a new name for the file! It can not be blank!');
		return false;
	} else {
		return true;
	}
}

//
// working below!
//

var files_listing = new Array();
// files_listing[id] = 'type', 'url_path', 'width', 'height', 'ext', 'mime', 'size', 'last_mod', 'thumb_url', 'align', 'linkable', 'open_to', 'left', 'top', 'center', 'status_bar', 'menu_bar', 'location_bar', 'tool_bar', 'scroll_bars', 'resizable', 'focus_after_add', 'close_after_add';
var id = null;
var previous_id = null;

function load_info(new_id) {
	if (new_id) { id = new_id; }
	if (previous_id != null && previous_id == id) {
		document.getElementById(previous_id).style.background = '#F2F2F2';
		document.getElementById('generated_details').style.display = 'none';
		document.getElementById('add_post_form').style.display = 'none';
		document.getElementById('default_details').style.display = '';
		document.getElementById('default_add_post').style.display = '';
		switch_display_tasks('default_tasks');
		id = null;
		previous_id = null;
	} else if (id) {
		if (previous_id != null) { document.getElementById(previous_id).style.background = '#F2F2F2'; }
		document.getElementById(id).style.background = '#F0F8FF';
		previous_id = id;
		generate_info();
	}
}

function load_default_action(new_id) {
	if (id == null) { load_info(new_id); } 
	if (files_listing[id][0] == 'folder' || files_listing[id][0] == 'previous_folder') {
		load_action('open_folder');
	} else if (files_listing[id][0] == 'image' || files_listing[id][0] == 'non_image') {
		load_action('view_file');
	} else { alert('ERROR: No Default Action!'); }
}

function switch_display_tasks(display_id) {
	switch (display_id) {
	// action_tasks
		case 'previous_folder_tasks':
			document.getElementById('default_tasks').style.display = 'none';
			document.getElementById('forms_tasks').style.display = 'none';
			document.getElementById('folder_tasks').style.display = 'none';
			document.getElementById('image_tasks').style.display = 'none';
			document.getElementById('non_image_tasks').style.display = 'none';
			document.getElementById('previous_folder_tasks').style.display = '';
			document.getElementById('actions_tasks').style.display = '';
			break;
		case 'folder_tasks':
			document.getElementById('default_tasks').style.display = 'none';
			document.getElementById('forms_tasks').style.display = 'none';
			document.getElementById('previous_folder_tasks').style.display = 'none';
			document.getElementById('image_tasks').style.display = 'none';
			document.getElementById('non_image_tasks').style.display = 'none';
			document.getElementById('folder_tasks').style.display = '';
			document.getElementById('actions_tasks').style.display = '';
			break;
		case 'image_tasks':
			document.getElementById('default_tasks').style.display = 'none';
			document.getElementById('forms_tasks').style.display = 'none';
			document.getElementById('previous_folder_tasks').style.display = 'none';
			document.getElementById('folder_tasks').style.display = 'none';
			document.getElementById('non_image_tasks').style.display = 'none';
			document.getElementById('image_tasks').style.display = '';
			document.getElementById('actions_tasks').style.display = '';
			break;
		case 'non_image_tasks':
			document.getElementById('default_tasks').style.display = 'none';
			document.getElementById('forms_tasks').style.display = 'none';
			document.getElementById('previous_folder_tasks').style.display = 'none';
			document.getElementById('folder_tasks').style.display = 'none';
			document.getElementById('image_tasks').style.display = 'none';
			document.getElementById('non_image_tasks').style.display = '';
			document.getElementById('actions_tasks').style.display = '';
			break;
	// forms_tasks
		case 'generated_tasks':
			document.getElementById('default_tasks').style.display = 'none';
			document.getElementById('actions_tasks').style.display = 'none';
			document.getElementById('create_folder_tasks').style.display = 'none';
			document.getElementById('create_file_tasks').style.display = 'none';
			document.getElementById('upload_file_tasks').style.display = 'none';
			document.getElementById('generated_tasks').style.display = '';
			document.getElementById('forms_tasks').style.display = '';
			break;
		case 'create_folder_tasks':
			document.getElementById('default_tasks').style.display = 'none';
			document.getElementById('actions_tasks').style.display = 'none';
			document.getElementById('generated_tasks').style.display = 'none';
			document.getElementById('create_file_tasks').style.display = 'none';
			document.getElementById('upload_file_tasks').style.display = 'none';
			document.getElementById('create_folder_tasks').style.display = '';
			document.getElementById('forms_tasks').style.display = '';
			break;
		case 'create_file_tasks':
			document.getElementById('default_tasks').style.display = 'none';
			document.getElementById('actions_tasks').style.display = 'none';
			document.getElementById('generated_tasks').style.display = 'none';
			document.getElementById('create_folder_tasks').style.display = 'none';
			document.getElementById('upload_file_tasks').style.display = 'none';
			document.getElementById('create_file_tasks').style.display = '';
			document.getElementById('forms_tasks').style.display = '';
			break;
		case 'upload_file_tasks':
			document.getElementById('default_tasks').style.display = 'none';
			document.getElementById('actions_tasks').style.display = 'none';
			document.getElementById('generated_tasks').style.display = 'none';
			document.getElementById('create_folder_tasks').style.display = 'none';
			document.getElementById('create_file_tasks').style.display = 'none';
			document.getElementById('upload_file_tasks').style.display = '';
			document.getElementById('forms_tasks').style.display = '';
			break;
		case 'default_tasks':
		default:
			document.getElementById('actions_tasks').style.display = 'none';
			document.getElementById('forms_tasks').style.display = 'none';
			document.getElementById('default_tasks').style.display = '';
			break;
	}
}

function generate_info() {
	if (files_listing[id][0] == 'previous_folder') {
		document.getElementById('generated_details').innerHTML = '<strong>Previous Folder</strong>';
		document.getElementById('default_details').style.display = 'none';
		document.getElementById('add_post_form').style.display = 'none';
		document.getElementById('generated_details').style.display = '';
		document.getElementById('default_add_post').style.display = '';
		switch_display_tasks('previous_folder_tasks');
	} else if (files_listing[id][0] == 'folder') {
		document.getElementById('generated_details').innerHTML = '<strong>[' + id + ']</strong><br />'
																	+ '- folder -<br />'
																	+ 'Size: ' + files_listing[id][6] + '<br />'
																	+ 'Date Modified: ' + files_listing[id][7]
																;
		document.getElementById('default_details').style.display = 'none';
		document.getElementById('add_post_form').style.display = 'none';
		document.getElementById('generated_details').style.display = '';
		document.getElementById('default_add_post').style.display = '';
		switch_display_tasks('folder_tasks');
	} else if (files_listing[id][0] == 'image') {
		document.getElementById('generated_details').innerHTML = '<strong>' + id + '</strong><br />'
																	+ '- ' + files_listing[id][5] + ' -<br />'
																	+ 'Dimensions: ' + files_listing[id][2] + ' x ' + files_listing[id][3] + '<br />'
																	+ 'Size: ' + files_listing[id][6] + '<br />'
																	+ 'Date Modified: ' + files_listing[id][7]
																;
		add_post_load_fields('reset');
		document.getElementById('default_details').style.display = 'none';
		document.getElementById('default_add_post').style.display = 'none';
		document.getElementById('generated_details').style.display = '';
		document.getElementById('add_post_form').style.display = '';
		switch_display_tasks('image_tasks');
	} else if (files_listing[id][0] == 'non_image') {
		document.getElementById('generated_details').innerHTML = '<strong>' + id + '</strong><br />'
																	+ '- ' + files_listing[id][5] + ' -<br />'
																	+ 'Size: ' + files_listing[id][6] + '<br />'
																	+ 'Date Modified: ' + files_listing[id][7]
																;
		add_post_load_fields('reset');
		document.getElementById('default_details').style.display = 'none';
		document.getElementById('default_add_post').style.display = 'none';
		document.getElementById('generated_details').style.display = '';
		document.getElementById('add_post_form').style.display = '';
		switch_display_tasks('non_image_tasks');
	} else {
		document.getElementById('generated_details').style.display = 'none';
		document.getElementById('add_post_form').style.display = 'none';
		document.getElementById('default_details').style.display = '';
		document.getElementById('default_add_post').style.display = '';
		switch_display_tasks('default_tasks');
		id = null;
		previous_id = null;
		alert('ERROR: An Unknown Error Has Occured! Please Try Reloading The Page.');
	}
}

function load_action(action) {
	switch (action) {
		case 'create_folder':
			switch_display_tasks('create_folder_tasks');
			break;
		case 'create_file':
			switch_display_tasks('create_file_tasks');
			break;
		case 'upload_file':
			switch_display_tasks('upload_file_tasks');
			break;
		default:
			if (id) {
				switch (action) {
					case 'open_folder':
						window.location.assign('?action=browse&path=' + files_listing[id][1]);
						break;
					case 'rename_folder':
						document.getElementById('generated_tasks').innerHTML = '<form name="manage_folder_rename" id="manage_folder_rename" action="" method="post" onsubmit="return confirm(\'Do you really want to Rename Folder - \\\'' + id + '\\\' ?\');">'
																					+ '<input type="hidden" name="action" value="manage_folder" />'
																					+ '<input type="hidden" name="path" value="' + path + '" />'
																					+ '<input type="hidden" name="manage_folder_action" value="rename" />'
																					+ '<input type="hidden" name="folder" value="' + id + '" />'
																					+ '<h2>Rename Folder</h2>'
																					+ '<label>Rename Folder <strong>' + id + '</strong> To: <input type="text" name="target" id="target" value="' + id + '" /></label><br />'
																					+ '<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks(\'folder_tasks\');" /> <input type="submit" name="submit" value="Rename Folder &raquo;" />'
																				+ '</form>'
																			;
						switch_display_tasks('generated_tasks');
						break;
					case 'move_folder':
					/*
						document.getElementById('generated_tasks').innerHTML = '<form name="manage_folder_move" id="manage_folder_move" action="" method="post">'
																					+ '<input type="hidden" name="action" value="manage_folder" />'
																					+ '<input type="hidden" name="path" value="' + path + '" />'
																					+ '<input type="hidden" name="manage_folder_action" value="move" />'
																					+ '<input type="hidden" name="folder" value="' + id + '" />'
																					+ 'Move Folder <strong>' + id + '</strong><br />'
																					+ '<label>Rename Folder To: <input type="text" name="target" id="target" value="' + id + '" /></label><br />'
																					+ '<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks(\'folder_tasks\');" /> <input type="submit" name="submit" value="Rename Folder &raquo;" />'
																				+ '</form>'
																			;
						switch_display_tasks('generated_tasks');
					*/
						alert('Not Realy Yet! Sorry ...');
						break;
					case 'copy_folder':
					//	switch_display_tasks('generated_tasks');
						alert('Not Realy Yet! Sorry ...');
						break;
					case 'delete_folder':
						document.getElementById('generated_tasks').innerHTML = '<form name="manage_folder_delete" id="manage_folder_delete" action="" method="post" onsubmit="return confirm(\'Do you really want to Delete Folder - \\\'' + id + '\\\' ? There is no turning back ...\');">'
																					+ '<input type="hidden" name="action" value="manage_folder" />'
																					+ '<input type="hidden" name="path" value="' + path + '" />'
																					+ '<input type="hidden" name="manage_folder_action" value="delete" />'
																					+ '<input type="hidden" name="folder" value="' + id + '" />'
																					+ '<h2>Delete Folder</h2>'
																					+ 'Delete Folder <strong>' + id + '</strong> ?<br />'
																					+ '<label title="Check This To Force Delection Of Any Folders/Files Under This Folder"><input type="checkbox" name="force_delete" value="1" /> : Force Delection</label><br />'
																					+ '<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks(\'folder_tasks\');" /> <input type="submit" name="submit" value="Delete Folder &raquo;" />'
																				+ '</form>'
																			;
						switch_display_tasks('generated_tasks');
						break;
				// File
					case 'view_file':
					// consider some other way!
						document.getElementById('generated_tasks').innerHTML = '<strong>' + id + '</strong><br />'
																				+ '<input type="button" value="&laquo; Go Back" onclick="document.getElementById(\'generated_listing\').style.display = \'none\'; switch_display_tasks(\'' + files_listing[id][0] + '_tasks\'); document.getElementById(\'browse_listing\').style.display = \'\';" />'
																			;
						document.getElementById('generated_listing').innerHTML = '<iframe src="' + files_listing[id][1] + '" title="' + id + ' - ' + files_listing[id][1] + '" style="padding: 3px; border: solid 1px #000000;" width="99%" height="550px" scrolling="yes"></iframe>';
						document.getElementById('browse_listing').style.display = 'none';
						switch_display_tasks('generated_tasks');
						document.getElementById('generated_listing').style.display = '';
						break;
					case 'edit_file':
					//	switch_display_tasks('generated_tasks');
						alert('Not Realy Yet! Sorry ...');
						break;
					case 'rename_file':
						document.getElementById('generated_tasks').innerHTML = '<form name="manage_file_rename" id="manage_file_rename" action="" method="post" onsubmit="return confirm(\'Do you really want to Rename File - \\\'' + id + '\\\' ?\');">'
																					+ '<input type="hidden" name="action" value="manage_file" />'
																					+ '<input type="hidden" name="path" value="' + path + '" />'
																					+ '<input type="hidden" name="manage_file_action" value="rename" />'
																					+ '<input type="hidden" name="file" value="' + id + '" />'
																					+ '<h2>Rename File</h2>'
																					+ '<label>Rename File <strong>' + id + '</strong> To: <input type="text" name="target" id="target" value="' + id + '" /></label><br />'
																					+ '<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks(\'' + files_listing[id][0] + '_tasks\');" /> <input type="submit" name="submit" value="Rename File &raquo;" />'
																				+ '</form>'
																			;
						switch_display_tasks('generated_tasks');
						break;
					case 'resize_image':
						document.getElementById('generated_tasks').innerHTML = '<form name="manage_file_resize" id="manage_file_resize" action="" method="post" onsubmit="return confirm(\'Do you really want to Resize Image - \\\'' + id + '\\\' ?\');">'
																					+ '<input type="hidden" name="action" value="manage_file" />'
																					+ '<input type="hidden" name="path" value="' + path + '" />'
																					+ '<input type="hidden" name="manage_file_action" value="resize" />'
																					+ '<input type="hidden" name="file" value="' + id + '" />'
																					+ '<h2>Resize Image File</h2>'
																					+ 'Resize Image File <strong>' + id + '</strong> To:<br />'
																					+ '<label><input type="text" name="width" id="width" size="5" value="" /> : Width</label><br />'
																					+ '<label><input type="text" name="height" id="height" size="5" value="" /> : Height</label><br />'
																					+ '<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks(\'' + files_listing[id][0] + '_tasks\');" /> <input type="submit" name="submit" value="Resize Image &raquo;" />'
																				+ '</form>'
																			;
						switch_display_tasks('generated_tasks');
						break;
					case 'rotate_cw_image':
						document.getElementById('generated_tasks').innerHTML = '<form name="manage_file_rotate_cw" id="manage_file_rotate_cw" action="" method="post" onsubmit="return confirm(\'Do you really want to Rotate Image CW - \\\'' + id + '\\\' ?\');">'
																					+ '<input type="hidden" name="action" value="manage_file" />'
																					+ '<input type="hidden" name="path" value="' + path + '" />'
																					+ '<input type="hidden" name="manage_file_action" value="rotate_cw" />'
																					+ '<input type="hidden" name="file" value="' + id + '" />'
																					+ '<h2>Resize Image File</h2>'
																					+ 'Rotate Image CW <strong>' + id + '</strong> ?<br />'
																					+ '<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks(\'' + files_listing[id][0] + '_tasks\');" /> <input type="submit" name="submit" value="Rotate Image CW &raquo;" />'
																				+ '</form>'
																			;
						switch_display_tasks('generated_tasks');
						break;
					case 'rotate_ccw_image':
						document.getElementById('generated_tasks').innerHTML = '<form name="manage_file_rotate_ccw" id="manage_file_rotate_ccw" action="" method="post" onsubmit="return confirm(\'Do you really want to Rotate Image CCW - \\\'' + id + '\\\' ?\');">'
																					+ '<input type="hidden" name="action" value="manage_file" />'
																					+ '<input type="hidden" name="path" value="' + path + '" />'
																					+ '<input type="hidden" name="manage_file_action" value="rotate_ccw" />'
																					+ '<input type="hidden" name="file" value="' + id + '" />'
																					+ '<h2>Resize Image File</h2>'
																					+ 'Rotate Image CCW <strong>' + id + '</strong> ?<br />'
																					+ '<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks(\'' + files_listing[id][0] + '_tasks\');" /> <input type="submit" name="submit" value="Rotate Image CCW &raquo;" />'
																				+ '</form>'
																			;
						switch_display_tasks('generated_tasks');
						break;
					case 'move_file':
					//	switch_display_tasks('generated_tasks');
						alert('Not Realy Yet! Sorry ...');
						break;
					case 'copy_file':
					//	switch_display_tasks('generated_tasks');
						alert('Not Realy Yet! Sorry ...');
						break;
					case 'delete_file':
						document.getElementById('generated_tasks').innerHTML = '<form name="manage_file_delete" id="manage_file_delete" action="" method="post" onsubmit="return confirm(\'Do you really want to Delete File - \\\'' + id + '\\\' ? There is no turning back ...\');">'
																					+ '<input type="hidden" name="action" value="manage_file" />'
																					+ '<input type="hidden" name="path" value="' + path + '" />'
																					+ '<input type="hidden" name="manage_file_action" value="delete" />'
																					+ '<input type="hidden" name="file" value="' + id + '" />'
																					+ '<h2>Delete File</h2>'
																					+ 'Delete File <strong>' + id + '</strong> ?<br />'
																					+ '<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks(\'' + files_listing[id][0] + '_tasks\');" /> <input type="submit" name="submit" value="Delete File &raquo;" />'
																				+ '</form>'
																			;
						switch_display_tasks('generated_tasks');
						break;
					default:
						alert('ERROR: An Unknown Error Has Occured! Please Try Reloading The Page.');
						break;
				}
			} else { alert('ERROR: An Unknown Error Has Occured! Please Try Reloading The Page.'); }
			break;
	}
}

function add_post_load_fields(action) {
	var form = document.forms['add_post_form'];
	switch (action) {
		case '0': // Add Thumbnail Image!
		case '1': // Add Full Image!
			document.getElementById('add_post_form_make_linkable').style.display = '';
			if (form.make_linkable.checked) {
				document.getElementById('add_post_form_open_to').style.display = '';
				if (form.open_to[2].checked) { document.getElementById('add_post_form_open_popup').style.display = ''; }
				form.make_linkable.value = 'not_make_linkable';
			} else {
				document.getElementById('add_post_form_open_popup').style.display = 'none';
				document.getElementById('add_post_form_open_to').style.display = 'none';
				form.make_linkable.value = 'make_linkable';
			}
			break;	
		case '2': // Add Image Link! has to have link!
			document.getElementById('add_post_form_make_linkable').style.display = '';
			document.getElementById('add_post_form_open_to').style.display = '';
			form.make_linkable.value = 'must_make_linkable';
			form.make_linkable.checked = true;
			if (form.open_to[2].checked) { document.getElementById('add_post_form_open_popup').style.display = ''; }
			break;	
		case '3': // Add Non-Image Thumbnail with Link!
		case '4': // Add File Link!
			document.getElementById('add_post_form_make_linkable').style.display = 'none';
			document.getElementById('add_post_form_open_to').style.display = '';
			form.make_linkable.checked = false;
			if (form.open_to[2].checked) { document.getElementById('add_post_form_open_popup').style.display = ''; }
			break;	
		case '5': // Embed File!
			alert('NOT YET! Sorry ... ');
			break;	

	// different actions to take!
		case 'make_linkable':
			document.getElementById('add_post_form_open_to').style.display = '';
			if (form.open_to[2].checked) { document.getElementById('add_post_form_open_popup').style.display = ''; }
			form.make_linkable.value = 'not_make_linkable';
			break;
		case 'not_make_linkable':
			document.getElementById('add_post_form_open_popup').style.display = 'none';
			document.getElementById('add_post_form_open_to').style.display = 'none';
			form.make_linkable.value = 'make_linkable';
			break;
		case 'must_make_linkable':
			alert('With this option, you must make a link!');
			form.make_linkable.checked = true;
			break;
		case 'open_same':
			document.getElementById('add_post_form_open_popup').style.display = 'none';
			break;
		case 'open_new':
			document.getElementById('add_post_form_open_popup').style.display = 'none';
			break;
		case 'open_popup':
			document.getElementById('add_post_form_open_popup').style.display = '';
			break;

	// default call that will reset the fields / form
		case 'reset':
		default:
			document.getElementById('add_post_form_make_linkable').style.display = 'none';
			document.getElementById('add_post_form_open_to').style.display = 'none';
			document.getElementById('add_post_form_open_popup').style.display = 'none';
			document.getElementById('add_post_form_embeded').style.display = 'none';
			if (files_listing[id][0] == 'image') {
				document.getElementById('add_post_form_image').style.display = '';
				document.getElementById('add_post_form_non_image').style.display = 'none';
				form.make_linkable.checked = files_listing[id][10];
				form.width.value = files_listing[id][2] + 30;
				form.height.value = files_listing[id][3] + 30;
			} else if (files_listing[id][0] == 'non_image') {
				document.getElementById('add_post_form_image').style.display = 'none';
				document.getElementById('add_post_form_non_image').style.display = '';
				form.width.value = files_listing[id][2];
				form.height.value = files_listing[id][3];
			} else { alert('Error: Problem loading page! Make sure that you are not accessing this page directly!'); return false; }
			form.action[0].checked = false;
			form.action[1].checked = false;
			form.action[2].checked = false;
			form.action[3].checked = false;
			form.action[4].checked = false;
			form.action[5].checked = false;
			if (files_listing[id][11]) { form.open_to[files_listing[id][11]].checked = true; }
			form.left.value = files_listing[id][12];
			form.top.value = files_listing[id][13];
			if (files_listing[id][14]) { form.center.click(); }
			form.status_bar.checked = files_listing[id][15];
			form.menu_bar.checked = files_listing[id][16];
			form.location_bar.checked = files_listing[id][17];
			form.tool_bar.checked = files_listing[id][18];
			form.scroll_bars.checked = files_listing[id][19];
			form.resizable.checked = files_listing[id][20];
			form.discription.value = id;
			form.focus_after_add.checked = files_listing[id][21];
			form.close_after_add.checked = files_listing[id][22];
			break;
	}
}

function add_post_create_code() {
// defind vars
	var form = document.forms['add_post_form'];
	var code = '';
	var discrip;
	var x;
	var action;
	var open_to;
	var popup_settings = new Array();

// Discription
	if (form.discription.value) { discrip = form.discription.value } else { discrip = id; }

// Get Code Options
	for (x = 0; x < form.action.length; x++) {
		if (form.action[x].checked) { action = form.action[x].value; }
	}

// Open To Option
	for (x = 0; x < form.open_to.length; x++) {
		if (form.open_to[x].checked) { open_to = form.open_to[x].value; }
	}

// Get Popup Settings  NOTE Add location bar!
	x = 0; 
	if (form.width.value) { popup_settings[x] = 'width=' + form.width.value + ',innerWidth=' + form.width.value; x++; }
	if (form.height.value) { popup_settings[x] = 'height=' + form.height.value + ',innerHeight=' + form.height.value; x++; }
	if (form.left.value) { popup_settings[x] = 'left=' + form.left.value + ',screenX=' + form.left.value; x++; }
	if (form.top.value) { popup_settings[x] = 'top=' + form.top.value + ',screenY=' + form.top.value; x++; }
	if (form.status_bar.checked) { popup_settings[x] = 'status=yes'; x++; }
	if (form.menu_bar.checked) { popup_settings[x] = 'menubar=yes'; x++; }
	if (form.location_bar.checked) { popup_settings[x] = 'location=yes'; x++; }
	if (form.tool_bar.checked) { popup_settings[x] = 'toolbar=yes'; x++; }
	if (form.scroll_bars.checked) { popup_settings[x] = 'scrollbars=yes'; x++; }
	if (form.resizable.checked) { popup_settings[x] = 'resizable=yes'; x++; }

	switch (action) {
		case '0': // Add Thumbnail Image!
			if (form.make_linkable.checked) {
				code = '<a href="' + files_listing[id][1] + '" title="' + discrip + '"';
				if (!open_to) {
					alert('Error:  You must select where to open the link!');
					return false;	
				} else if (open_to == 'open_same') {
					code += ' target="_self"'; 
				} else if (open_to == 'open_new') {
					code += ' target="_blank"';
				} else if (open_to == 'open_popup') {
					code += ' onclick="window.open(\'' + files_listing[id][1] + '\', \'popup_image\', \'';
					for (x = 0; x < popup_settings.length; x++) {
						if (x == popup_settings.length -1) {
							code += popup_settings[x];
						} else {
							code += popup_settings[x] + ',';
						}
					}
					code += '\'); return false;"';
				}
				code += '><img class="' + files_listing[id][9] + '" src="' + files_listing[id][8] + '" alt="' + discrip + '" title="' + discrip + '" /></a>';
			} else { code = '<img class="' + files_listing[id][9] + '" src="' + files_listing[id][8] + '" alt="' + discrip + '" title="' + discrip + '" />'; }
			break;
		case '1': // Add Full Image!
			if (form.make_linkable.checked) {
				code = '<a href="' + files_listing[id][1] + '" title="' + discrip + '"';
				if (!open_to) {
					alert('Error:  You must select where to open the link!');
					return false;	
				} else if (open_to == 'open_same') {
					code += ' target="_self"'; 
				} else if (open_to == 'open_new') {
					code += ' target="_blank"';
				} else if (open_to == 'open_popup') {
					code += ' onclick="window.open(\'' + files_listing[id][1] + '\', \'popup_image\', \'';
					for (x = 0; x < popup_settings.length; x++) {
						if (x == popup_settings.length -1) {
							code += popup_settings[x];
						} else {
							code += popup_settings[x] + ',';
						}
					}
					code += '\'); return false;"';
				}
				code += '><img class="' + files_listing[id][9] + '" src="' + files_listing[id][1] + '" alt="' + discrip + '" title="' + discrip + '" /></a>';
			} else { code = '<img class="' + files_listing[id][9] + '" src="' + files_listing[id][1] + '" alt="' + discrip + '" title="' + discrip + '" />'; }
			break;
		case '2': // Add Image Link! has to have link!
		// Make Linkable Option
			if (form.make_linkable.checked) {
				code = '<a href="' + files_listing[id][1] + '" title="' + discrip + '"';
				if (!open_to) {
					alert('Error:  You must select where to open the link!');
					return false;	
				} else if (open_to == 'open_same') {
					code += ' target="_self"'; 
				} else if (open_to == 'open_new') {
					code += ' target="_blank"';
				} else if (open_to == 'open_popup') {
					code += ' onclick="window.open(\'' + files_listing[id][1] + '\', \'popup_image\', \'';
					for (x = 0; x < popup_settings.length; x++) {
						if (x == popup_settings.length -1) {
							code += popup_settings[x];
						} else {
							code += popup_settings[x] + ',';
						}
					}
					code += '\'); return false;"';
				}
				code += '>' + discrip + '</a>';
			} else { alert('Error: Something went wrong!'); return false; } // end make_linkable if
			break;

// Non-Image Cases!
		case '3': // Add Non-Image Thumbnail with Link!
			code = '<a href="' + files_listing[id][1] + '" title="' + discrip + '"';
			if (!open_to) {
				alert('Error:  You must select where to open the link!');
				return false;	
			} else if (open_to == 'open_same') {
				code += ' target="_self"'; 
			} else if (open_to == 'open_new') {
				code += ' target="_blank"';
			} else if (open_to == 'open_popup') {
				code += ' onclick="window.open(\'' + files_listing[id][1] + '\', \'popup_image\', \'';
				for (x = 0; x < popup_settings.length; x++) {
					if (x == popup_settings.length -1) {
						code += popup_settings[x];
					} else {
						code += popup_settings[x] + ',';
					}
				}
				code += '\'); return false;"';
			}
			code += '><img class="' + files_listing[id][9] + '" src="' + files_listing[id][8] + '" alt="' + discrip + '" title="' + discrip + '" /></a>';
			break;
		case '4': // Add File Link!
			code = '<a href="' + files_listing[id][1] + '" title="' + discrip + '"';
			if (!open_to) {
				alert('Error:  You must select where to open the link!');
				return false;	
			} else if (open_to == 'open_same') {
				code += ' target="_self"'; 
			} else if (open_to == 'open_new') {
				code += ' target="_blank"';
			} else if (open_to == 'open_popup') {
				code += ' onclick="window.open(\'' + files_listing[id][1] + '\', \'popup_image\', \'';
				for (x = 0; x < popup_settings.length; x++) {
					if (x == popup_settings.length -1) {
						code += popup_settings[x];
					} else {
						code += popup_settings[x] + ',';
					}
				}
				code += '\'); return false;"';
			}
			code += '>' + discrip + '</a>';
			break;
		case '5': // Embed File!
			alert('Coming Soon');
			return false;
			break;
		default:
			alert('Error: You did not select an option to display! Please select one now!');
			return false;
			break;
	}

// Start code to add to content textarea!
	var my_field;
	if (window.opener.document.getElementById('content') && window.opener.document.getElementById('content').type == 'textarea') {
		my_field = window.opener.document.getElementById('content');
	} else { alert('Error: Something went wrong!');	return false; }
	if (my_field.selectionStart || my_field.selectionStart == '0') {
		var startPos = my_field.selectionStart;
		var endPos = my_field.selectionEnd;
		var cursorPos = endPos;
		my_field.value = my_field.value.substring(0, startPos)
				  + code
				  + my_field.value.substring(endPos, my_field.value.length);
		cursorPos += code.length;
		my_field.focus();
		my_field.selectionStart = cursorPos;
		my_field.selectionEnd = cursorPos;
	} else {
		my_field.value += code;
		my_field.focus();
	}
	if (form.focus_after_add.checked) { window.opener.focus(); }
	if (form.close_after_add.checked) { window.close(); }
}
