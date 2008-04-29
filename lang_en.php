<?php

// LMB^Box FilePress Lang_en.php File
// Lang: English

//	define('', '');

define('IMAGIC_ERROR', 'ERROR: Unable To Execute - %s - With Error - %s - Returned Code - %s - !<br />');																// sprintf(, cmd, output, result)!

// path_info
define('PATH_INFO_NON_IMAGE_THUMB_NOT_EXIST', 'ERROR: Non-Image Thumbnail Does Not Exist Or Is Not An Image File!');
define('PATH_INFO_THUMB_NOT_EXIST', 'ERROR: Could Not Find Thumbnail Or Thumbnail Is Not An Image File!');


// create browse page results / info on files
define('BROWSE_PATH_NO_FILES', 'No Files Found!');
define('BROWSE_PATH_NO_FILES_ALLOWED', 'No Files Found That Are Allowed!');


// Create Folder / Thumbnail Folder
define('CREATE_FOLDER_DONE', 'Create Folder - %s => DONE!<br />');																										// sprintf(, folder)!
define('CREATE_FOLDER_DONE_THUMB', 'Create Thumbnail Folder - %s => DONE!<br />');																						// sprintf(, folder)!
define('CREATE_FOLDER_EMPTY', 'ERROR: New Folder Name Empty!<br />');
define('CREATE_FOLDER_EMPTY_THUMB', 'No Thumbnail Folder To Create ...<br />');
define('CREATE_FOLDER_EXISTS', 'ERROR: Folder Already Exists!<br />');
define('CREATE_FOLDER_EXISTS_THUMB', 'ERROR: Thumbnail Folder Already Exists!<br />');
define('CREATE_FOLDER_FAILED', 'Create Folder - %s => FAILED!<br />');																									// sprintf(, folder)!
define('CREATE_FOLDER_FAILED_THUMB', 'Create Thumbnail Folder - %s => FAILED!<br />');																					// sprintf(, folder)!
define('CREATE_FOLDER_NEW_NAME_INCORRECT', 'ERROR: New Folder Name Reserved - Thumbnail Folder!<br />');
define('CREATE_FOLDER_NEW_NAME_INCORRECT_THUMB', 'ERROR: New Thumbnail Folder Name Wrong - Not Thumbnail Folder!<br />');


// Rename Folder
define('RENAME_FOLDER_DONE', 'Rename Folder - %s -> To -> %s => DONE!<br />');																							// sprintf(, file)!
define('RENAME_FOLDER_EMPTY', 'ERROR: No Folder To Rename!<br />');
define('RENAME_FOLDER_EXISTS', 'ERROR: New Folder Already Exists!<br />');
define('RENAME_FOLDER_FAILED', 'Rename Folder - %s -> To -> %s => FAILED!<br />');																						// sprintf(, file)!
define('RENAME_FOLDER_NEW_NAME_EMPTY', 'ERROR: New Folder Name Empty!<br />');
define('RENAME_FOLDER_NEW_NAME_INCORRECT', 'ERROR: New Folder Name Reserved - Thumbnail Folder!<br />');
define('RENAME_FOLDER_NEW_NAME_SAME', 'ERROR: New Folder Name Same As Folder To Rename!<br />');
define('RENAME_FOLDER_NOT_EXIST', 'ERROR: Folder To Rename Does Not Exist!<br />');


// Move Folder

// Copy Folder

// Delete Folder
define('DELETE_FOLDER_CHECK', 'Checking Folder - %s ...<br />');																										// sprintf(, folder)!
define('DELETE_FOLDER_CHECK_THUMB', 'Checking Thumbnail Folder - %s ...<br />');																						// sprintf(, folder)!
define('DELETE_FOLDER_DONE', 'Delete Folder - %s => DONE!<br />');																										// sprintf(, folder)!
define('DELETE_FOLDER_DONE_THUMB', 'Delete Thumbnail Folder - %s => DONE!<br />');																						// sprintf(, folder)!
// Using DELETE_FILE_DONE && DELETE_FILE_DONE_THUMB
define('DELETE_FOLDER_EMPTY', 'ERROR: No Folder To Delete!<br />');
define('DELETE_FOLDER_EMPTY_THUMB', 'ERROR: No Thumbnail Folder To Delete!<br />');
define('DELETE_FOLDER_FAILED', 'Delete Folder - %s => FAILED!<br />');																									// sprintf(, folder)!
define('DELETE_FOLDER_FAILED_THUMB', 'Delete Thumbnail Folder - %s => FAILED!<br />');																					// sprintf(, folder)!
// Using DELETE_FILE_FAILED && DELETE_FILE_FAILED_THUMB
define('DELETE_FOLDER_NOT_EMPTY', 'ERROR: Folder Not Empty! Not Forcing Deletion!<br />');
define('DELETE_FOLDER_NOT_EMPTY_THUMB', 'ERROR: Thumbnail Folder Not Empty! Not Forcing Deletion!<br />');
define('DELETE_FOLDER_NOT_EMPTY_FORCE', 'Folder Not Empty ... Forcing Deletion!<br />');
define('DELETE_FOLDER_NOT_EMPTY_FORCE_THUMB', 'Thumbnail Folder Not Empty ... Forcing Deletion!<br />');
define('DELETE_FOLDER_SUB', 'Deleting Sub-Folder(s) ...<br />');
define('DELETE_FOLDER_SUB_THUMB', 'Deleting Sub-Thumbnail-Folder(s) ...<br />');
define('DELETE_FOLDER_SUB_DONE', 'Deleting Sub-Folder(s) ... DONE!<br />');
define('DELETE_FOLDER_SUB_DONE_THUMB', 'Deleting Sub-Thumbnail-Folder(s) ... DONE!<br />');
define('DELETE_FOLDER_SUB_FILE', 'Deleting File(s) ...<br />');
define('DELETE_FOLDER_SUB_FILE_THUMB', 'Deleting Thumbnail File(s) ...<br />');
define('DELETE_FOLDER_SUB_FILE_DONE', 'Deleting File(s) ... DONE!<br />');
define('DELETE_FOLDER_SUB_FILE_DONE_THUMB', 'Deleting Thumbnail File(s) ... DONE!<br />');


// Image Manipulation Functions - PHP GD/GD2
// Which PHP GD/GD2 Functions To Use For File Extension Type
define('WHICH_GD_FUNC_FAILED', 'ERROR: Unable To Manipulate Image Type - %s - Using PHP\'s GD/GD2 Support, Please Try Using ImageMagic If You Have It!<br />');			// sprintf(, file_ext)!
define('WHICH_GD_FUNC_INCORRECT_CALL', 'ERROR: which_gd_functions() Called Incorrectly! $extension Is Required!<br />');
define('WHICH_GD_FUNC_NOT_LOADED', 'ERROR: %s Function Does Not Exist!<br />');																							// sprintf(, function)!
define('WHICH_GD_FUNC_NOT_LOADED2', 'ERROR: %s And %s Function Does Not Exist!<br />');																					// sprintf(, function)!
// Resize Image With PHP GD/GD2
define('RESIZE_IMAGE_GD_INCORRECT_CALL', 'ERROR: resize_image_gd() Called Incorrectly! $file, $target, $extension, And $width Or $height Are Required!<br />');
// Rotate Image With PHP GD/GD2
define('ROTATE_IMAGE_GD_INCORRECT_CALL', 'ERROR: rotate_file_gd() Called Incorrectly! $file, $target, $extension, And $degrees Are Required!<br />');


// Create Thumbnail File
define('CREATE_THUMB_FILE_DONE', 'Create Thumbnail File - %s => DONE!<br />');																							// sprintf(, file)!
define('CREATE_THUMB_FILE_EMPTY', 'ERROR: No File To Create Thumbnail For!<br />');
define('CREATE_THUMB_FILE_FAILED', 'Create Thumbnail File - %s => FAILED!<br />');																						// sprintf(, file)!
define('CREATE_THUMB_FILE_FOLDER_PREFIX_EMPTY', 'ERROR: No Thumbnail Folder And Thumbnail Prefix Set! Can Not Create Thumbnail!<br />');
define('CREATE_THUMB_FILE_NOT_IMAGE', 'Can Not Create Thumbnail From This File ...<br />');
define('CREATE_THUMB_FILE_WIDTH_HEIGHT_EMPTY', 'ERROR: Thumbnail Width And Height Are Not Set! Can Not Create Thumbnail!<br />');


// Upload File
define('UPLOAD_FILE_DONE', 'Upload File - %s => DONE!<br />');																											// sprintf(, file)!
define('UPLOAD_FILE_EMPTY', 'ERROR: No File Uploaded!<br />');
define('UPLOAD_FILE_EXCEEDS_MAX_FILE_SIZE', 'ERROR: File Upload FAILED! File Uploaded Exceeds "MAX_FILE_SIZE" Form Directive!<br />');
define('UPLOAD_FILE_EXCEEDS_UPLOAD_MAX_FILESIZE', 'ERROR: File Upload FAILED! File Uploaded Exceeds "upload_max_filesize" PHP Directive!<br />');
define('UPLOAD_FILE_EXCEEDS_MAX_SIZE', 'ERROR: File Size - %s - Too Big! Max File Size is - %s - !<br />');																// sprintf(, upload_size, max_size)!
define('UPLOAD_FILE_EXISTS', 'ERROR: File - %s - Already Exists!<br />');																								// sprintf(, file)!
define('UPLOAD_FILE_FAILED', 'ERROR: Upload File - %s => FAILED!<br />');																								// sprintf(, file)!
define('UPLOAD_FILE_INCORRECT_CALL', 'ERROR: upload_file() Called Incorrectly!<br />');
define('UPLOAD_FILE_NOT_ALLOWED', 'ERROR: File Type - %s - NOT Allowed!<br />');																						// sprintf(, file_type)!
define('UPLOAD_FILE_PARTIALLY', 'ERROR: File Upload FAILED! File Was Partially Uploaded!<br />');
define('UPLOAD_FILE_UNKNOWN_ERROR', 'ERROR: Unknown Error Occurred!<br />');
// Fetch File
define('FETCH_FILE_DONE', 'Fetched File - %s => DONE!<br />');																											// sprintf(, file)!
define('FETCH_FILE_EMPTY', 'ERROR: No File To Fetch!<br />');
define('FETCH_FILE_EXISTS', 'ERROR: File - %s - Already Exists!<br />');																								// sprintf(, file)!
define('FETCH_FILE_FAILED', 'ERROR: Fetched File - %s => FAILED!<br />');																								// sprintf(, file)!
define('FETCH_FILE_NOT_ALLOWED', 'ERROR: File Type - %s - NOT Allowed!<br />');																							// sprintf(, file_type)!
define('FETCH_FILE_NOT_EXIST', 'ERROR: File Was Not Located! Are You Sure The Url - %s - Is Correct?<br />');															// sprintf(, file_url)!
// Fetch File cURL
define('FETCH_FILE_CURL_FAILED', 'ERROR: cURL File Transfer FAILED! Returned Error => %s!<br />');																		// sprintf(, error)!
define('FETCH_FILE_CURL_MIME_EXT_MISMATCH', 'ERROR: File Extention Does Not Match File Mime!<br />');
define('FETCH_FILE_CURL_NOT_EXIST', 'ERROR: File Was Not Located! HTTP Request Returned Bad HTTP Code - %s!<br />');													// sprintf(, http_code)!
define('FETCH_FILE_CURL_NOT_LOADED', 'ERROR: cURL PHP Extension Not Loaded! This Feature Requires cURL To Be Enabled!<br />');
define('FETCH_FILE_CURL_UNKNOWN_ERROR', 'ERROR: Unknown Error Occurred During cURL Call, Returned Error - %s!<br />');													// sprintf(, error)!


// Create File

// Edit File


// Rename File
define('RENAME_FILE_DONE', 'Rename File - %s -> To -> %s => DONE!<br />');																								// sprintf(, from, to)!
define('RENAME_FILE_DONE_THUMB', 'Rename Thumbnail File - %s -> To -> %s => DONE!<br />');																				// sprintf(, from, to)!
define('RENAME_FILE_EMPTY', 'ERROR: No File To Rename!<br />');
define('RENAME_FILE_EMPTY_THUMB', 'No Thumbnail File To Rename ... Thumbnail Folder And Thumbnail Prefix Not Set!<br />');
define('RENAME_FILE_EXISTS', 'ERROR: New File Already Exists!<br />');
define('RENAME_FILE_EXISTS_THUMB', 'ERROR: New Thumbnail File Already Exists!<br />');
define('RENAME_FILE_FAILED', 'Rename File - %s -> To -> %s => FAILED!<br />');																							// sprintf(, from, to)!
define('RENAME_FILE_FAILED_THUMB', 'Rename Thumbnail File - %s -> To -> %s => FAILED!<br />');																			// sprintf(, from, to)!
define('RENAME_FILE_NEW_NAME_EMPTY', 'ERROR: New File Name Empty!<br />');
define('RENAME_FILE_NEW_NAME_EMPTY_THUMB', 'ERROR: New Thumbnail File Name Empty! Thumbnail Folder And Thumbnail Prefix Not Set!<br />');
define('RENAME_FILE_NEW_NAME_INCORRECT', 'ERROR: New File Name Reserved - Thumbnail File!<br />');
define('RENAME_FILE_NEW_NAME_INCORRECT_THUMB', 'ERROR: New Thumbnail File Name Wrong - Not Thumbnail File!<br />');
define('RENAME_FILE_NEW_NAME_SAME', 'ERROR: New File Name Same As File To Rename!<br />');
define('RENAME_FILE_NEW_NAME_SAME_THUMB', 'ERROR: New Thumbnail File Name Same As Thumbnail File To Rename!<br />');
define('RENAME_FILE_NOT_EXIST', 'ERROR: File To Rename Does Not Exist!<br />');
define('RENAME_FILE_NOT_EXIST_THUMB', 'No Thumbnail File To Rename ...<br />');


// Resize File
define('RESIZE_FILE_DONE', 'Resized File - %s => DONE!<br />');																											// sprintf(, file)!
define('RESIZE_FILE_EMPTY', 'ERROR: No File To Resize!<br />');
define('RESIZE_FILE_FAILED', 'Resized File - %s => FAILED!<br />');																										// sprintf(, file)!
define('RESIZE_FILE_NOT_IMAGE', 'Can Not Resize This File ... Not An Image File!<br />');
define('RESIZE_FILE_WIDTH_HEIGHT_EMPTY', 'ERROR: New Width And Height Empty!<br />');
define('RESIZE_FILE_WIDTH_HEIGHT_SAME', 'ERROR: New Width And Height Same As File To Resize!<br />');
/*
define('RESIZE_FILE_EMPTY_THUMB', 'No Thumbnail File To Resize ... Thumbnail Folder And Thumbnail Prefix Not Set!<br />');
define('RESIZE_FILE_NOT_IMAGE_THUMB', 'No Thumbnail File To Resize ...<br />');
define('RESIZE_FILE_WIDTH_HEIGHT_SAME_THUMB', 'ERROR: New Width And Height Same As Thumbnail File To Resize!<br />');
define('RESIZE_FILE_FAILED_THUMB', 'Resized Thumbnail File - %s => FAILED!<br />');																						// sprintf(, file)!
define('RESIZE_FILE_DONE_THUMB', 'Resized Thumbnail File - %s => DONE!<br />');																							// sprintf(, file)!
*/

// Rotate File
define('ROTATE_FILE_DEGREES_EMPTY', 'ERROR: Degrees To Rotate Empty!<br />');
define('ROTATE_FILE_DONE', 'Rotated File - %s => DONE!<br />');																											// sprintf(, file)!
define('ROTATE_FILE_EMPTY', 'ERROR: No File To Rotate!<br />');
define('ROTATE_FILE_FAILED', 'Rotated File - %s => FAILED!<br />');																										// sprintf(, file)!
define('ROTATE_FILE_NOT_IMAGE', 'Can Not Rotate This File ... Not An Image File!<br />');
/*
define('ROTATE_FILE_EMPTY_THUMB', 'No Thumbnail File To Rotate ... Thumbnail Folder And Thumbnail Prefix Not Set!<br />');
define('ROTATE_FILE_NOT_IMAGE_THUMB', 'No Thumbnail File To Rotate ...<br />');
define('ROTATE_FILE_FAILED_THUMB', 'Rotated Thumbnail File - %s => FAILED!<br />');																						// sprintf(, file)!
define('ROTATE_FILE_DONE_THUMB', 'Rotated Thumbnail File - %s => DONE!<br />');																							// sprintf(, file)!
*/

// Delete File
define('DELETE_FILE_DONE', 'Delete File - %s => DONE!<br />');																											// sprintf(, file)!
define('DELETE_FILE_DONE_THUMB', 'Delete Thumbnail File - %s => DONE!<br />');																							// sprintf(, file)!
define('DELETE_FILE_EMPTY', 'ERROR: No File To Delete!<br />');
define('DELETE_FILE_EMPTY_THUMB', 'No Thumbnail File To Delete ... Thumbnail Folder And Thumbnail Prefix Not Set!<br />');
define('DELETE_FILE_FAILED', 'Delete File - %s => FAILED!<br />');																										// sprintf(, file)!
define('DELETE_FILE_FAILED_THUMB', 'Delete Thumbnail File - %s => FAILED!<br />');																						// sprintf(, file)!
define('DELETE_FILE_NOT_EXIST', 'ERROR: File To Delete Does Not Exist!<br />');
define('DELETE_FILE_NOT_EXIST_THUMB', 'No Thumbnail File To Delete ...<br />');


?>
