<?php
/*
AlienPlorer
Alien-X-plorer
FilePlorer
File-X-Plore
FileBox || File Box
FileCube || File Cube
LimaBox || Lima Box

LMB^Box Lima Curo/Procurator

LMB^Box FilePress Class
http://aboutme.lmbbox.com/lmbbox-plugins/lmbbox-filepress/
!New Description Needed! -> FilePress allows you to browse and upload files on the write tab of WordPress. There will be a new buttons in the quicktags toolbar, 'FilePress'. They will enable you to upload new files, create thumbnails of images, link to files, link to images, include thumbnails / images / certain files, and also include thumbnails / images / certain files with links to the orginal file.
Version 1.0 Beta, 2005-12-14 <img src="http://aboutme.lmbbox.com/plugins-updates.php?plugin=lmbbox-filepress&amp;version=1.0" alt="Checking For Updates ..." title="Checking For Updates ..." />
By Thomas Montague
http://aboutme.lmbbox.com/
*/

/*
ToDo List:
	Upload Progress Bar <= Need To Find Better Way, Finish Everything Else First!
	Folder Functions
		Move Folder
		Copy Folder
	File Functions
		Create File
		Edit File
		Move File
		Copy File
	FTP Versions Of Folder/File Functions
	Create To Be Standalone File Manager <= In Alpha Stage!
	Create Flash Interface
	Try Adding Support For Running Downloads From Other Web Access Sites

Completed:
	Thumb Folder
	Focus After Add
	Close After Add
	Width/Height Thumbnailer
	True File Size Limits
	Folder Functions
		Create Folder -> Create Thumbnail Folder <= May Need Some More Work! <= Update: All DONE!
		Rename Folder
		Delete Folder
	File Functions
		Get/Upload File -> Creates Thumbnail File
		Rename File -> Rename Thumbnail File
		Resize File <= Do I Want To Update Thumbnail Also?! <= Calls create_thumbnail_file() And Creates New Thumbnail File: All DONE!
		Rotate Image CW & CCW -> Creates New Thumbnail File
		Delete File -> Delete Thumbnail File
*/

// BEGIN - Class lmbbox_filepress_class
class lmbbox_filepress_class {
	var $dir_sep;
//	var $info_message;
	var $options;
	var $path_abs;

//	__constructor()
	function lmbbox_filepress_class () {
		// Directory Seperator
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$this->dir_sep = '\\';
		} else {
			$this->dir_sep = '/';
		}
// Temp!
//		$this->dir_sep = '/';

		// set some defaults that are overridden by previously stored stuff
		$this->options = array (
			'home_abs'				=> dirname(__FILE__) . $this->dir_sep . 'files' . $this->dir_sep,
			'home_url'				=> 'files/',
			'max_size'				=> '2M', // 0 == unlimited, bytes!
			'allowed_types'			=> array(''), // array empty == all types!

			'use_magick'			=> false,
			'convert_path'			=> '/bin/convert',
			'thumb_folder'			=> 'thumbs',
			'thumb_prefix'			=> 'thumb_',
			'thumb_width'			=> 120,
			'thumb_height'			=> 120, // 0 == auto adjust to other setting, if both 0 == error!
			'align'					=> 'centered',

		// add to content options
			'make_linkable'			=> false,
			'open_to'				=> 2,
			'non_image_width'		=> 500,
			'non_image_height'		=> 400,
//			'left'					=> 10,
//			'top'					=> 10,
			'center'				=> true,
			'status_bar'			=> true,
			'menu_bar'				=> false,
			'location_bar'			=> false,
			'tool_bar'				=> false,
			'scroll_bars'			=> true,
			'resizable'				=> true,
			'focus_after_add'		=> false,
			'close_after_add'		=> false,

/*
		// album settings
			'library'				=>  false,
			'library_name'			=> '?fp_library=1',
			'library_columns'		=> '2',
			'library_postfix'		=> '&fp_file=',
			'cat_postfix'			=> '&fp_cat=',
*/

		// File type to thumb image array!
			'default_thumb_path'		=> dirname(__FILE__) . $this->dir_sep . 'default_thumbs' . $this->dir_sep,
			'default_thumb_path_url'	=> 'default_thumbs/',
			'default_thumb'				=> 'default.gif',
			'default_thumbs'			=> array(
												// images
													'jpg'		=> 'jpg.gif',
													'jpeg'		=> 'jpg.gif',
													'gif'		=> 'gif.gif',
													'png'		=> 'png.gif',
													'emf'		=> 'image.jpg',
													'wmf'		=> 'image.jpg',
													'wbmp'		=> 'image.jpg',
													'bmp'		=> 'bmp.gif',

												// audio
													'aiff'		=> 'audio.jpg',
													'aif'		=> 'audio.jpg',
													'wav'		=> 'wav.gif',
													'wave'		=> 'wav.gif',
													'mp3'		=> 'mp3.gif',
													'midi'		=> 'midi.gif',
													'mid'		=> 'midi.gif',
													'qcp'		=> 'audio.jpg',
													'snd'		=> 'audio.jpg',
													'wma'		=> 'wma.gif',
													'qcp'		=> 'audio.jpg',

												// video
													'mp2'		=> 'video.jpg',
													'mpg'		=> 'video.jpg',
													'mpeg'		=> 'video.jpg',
													'avi'		=> 'video.jpg',
													'mov'		=> 'video.jpg',
													'qt'		=> 'video.jpg',
													'rv'		=> 'video.jpg',
													'wmv'		=> 'wmv.gif',
													'rm'		=> 'video.jpg',
													'ra'		=> 'video.jpg',
													'ram'		=> 'video.jpg',
													'3g2'		=> 'video.jpg',
													'3gp'		=> 'video.jpg',

												// documents
													'pdf'		=> 'pdf.gif',
													'doc'		=> 'doc.gif',
													'rtf'		=> 'doc.jpg',
													'xlm'		=> 'doc.jpg',
													'xlb'		=> 'doc.jpg',
													'xll'		=> 'doc.jpg',
													'xla'		=> 'doc.jpg',
													'xlw'		=> 'doc.jpg',
													'xlc'		=> 'doc.jpg',
													'xls'		=> 'doc.jpg',
													'xlt'		=> 'doc.jpg',
													'ppt'		=> 'doc.jpg',
													'pps'		=> 'doc.jpg',

												//text -> displaying as a doc!
													'xsl'		=> 'doc.jpg',
													'xslt'		=> 'doc.jpg',
													'xml'		=> 'doc.jpg',
													'wsdl'		=> 'doc.jpg',
													'xsd'		=> 'doc.jpg',
													'txt'		=> 'txt.gif',

												// code
													'html'		=> 'html.gif',
													'htm'		=> 'html.gif',
													'php'		=> 'code.jpg',
													'phps'		=> 'code.jpg',
													'asp'		=> 'code.jpg',
													'sql'		=> 'code.jpg',
												// code -> java
													'jar'		=> 'code.jpg',

												// flash
													'swf'		=> 'flash.jpg',

												// archive
													'zip'		=> 'archive.gif',
													'tar'		=> 'archive.gif',
													'tgz'		=> 'archive.gif',
													'gz'		=> 'archive.gif',
													'rar'		=> 'archive.gif',

												// exe
													'exe'		=> 'exe.gif'
												) // Last entry should not have a ',' at the end of the line!
		);
	}

	// display path locations / folders
//	protected
	function parse_path($output_mode, $path = '', $home_abs = false, $pattern = '/.*/', $match = true, $selected = '', $depth = 0) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }
		if ($handle = @opendir($home_abs . $path)) {
			while (($file = @readdir($handle)) !== false) {
				if ($file != '.' && $file != '..' && preg_match($pattern, $file) == $match) {
					switch($output_mode) {
						case 'whole_path':
							if (is_dir($home_abs . $path . $file . $this->dir_sep)) {
								$listing[$file] = $this->parse_path($output_mode, $path . $file . $this->dir_sep, $home_abs, $pattern, $match);
							} elseif (is_file($home_abs . $path . $file)) {
								$listing[] = $file;
							}
							break;
						case 'folders_files':
							if (is_dir($home_abs . $path . $file . $this->dir_sep)) {
								$listing['folders'][] = $file;
							} elseif (is_file($home_abs . $path . $file)) {
								$listing['files'][] = $file;
							}
							break;
						case 'folders':
							if (is_dir($home_abs . $path . $file . $this->dir_sep)) {
								$listing['folders'][] = $file;
							}
							break;
						case 'folders_all':
							if (is_dir($home_abs . $path . $file . $this->dir_sep)) {
								$listing['folders'][] = $file;
								$listing = $listing + $this->parse_path($output_mode, $path . $file . $this->dir_sep, $home_abs, $pattern, $match);
							}
							break;
						case 'folders_select':
							if (is_dir($home_abs . $path . $file . $this->dir_sep)) {
								$listing .= '<option ' . ($selected == $path . $file . $this->dir_sep ? 'selected="selected" ' : '') . 'value="' . $path . $file . $this->dir_sep . '">[' . str_repeat('&#8212; ', $depth) . $file . ']</option>' . "\n";
								$listing .= $this->parse_path($output_mode, $path . $file . $this->dir_sep, $home_abs, $pattern, $match, $selected, $depth++);
							}
							break;
						case 'files':
							if (is_file($home_abs . $path . $file)) {
								$listing['files'][] = $file;
							}
							break;
						default:
							break;
					}
				}
			}
			closedir($handle);
		}
		return $listing;
	}

	// create browse directory menu
//	protected
	function folder_menu($path){
		$menu = '<a href="?path=" title="[root]">[root]</a> ' . $this->dir_sep;
		$path = explode($this->dir_sep, $path);
		if (is_array($path)) {
			foreach ($path as $value) {
				if (!empty($value)) {
					$current_path .= $value . $this->dir_sep;
					$menu .= ' <a href="?path=' . $current_path . '" title="[' . $current_path . ']">[' . $value . ']</a> ' . $this->dir_sep;
				}
			}
		}
		return $menu;
	}

	// find the mime for file
//	protected
	function guess_file_mime($extension) {
		// No Need For 'break;' After Each Case Because Of The Return
		switch (strtolower($extension)) {
		// Image
			case 'jpg': case 'jpeg': return 'image/jpeg';
			case 'emf': return 'image/x-emf';
			case 'wmf': return 'image/x-wmf';
			case 'gif': return 'image/gif';
			case 'png': return 'image/png';
			case 'bmp': return 'image/bmp';
			case 'wbmp': return 'image/vnd.wap.wbmp';
		// Audio
			case 'aiff': case 'aif': return 'audio/x-aiff';
			case 'wav': case 'wave': return 'audio/x-wav';
			case 'mp3': return 'audio/x-mpeg3';
			case 'midi': case 'mid': return 'audio/x-midi';
			case 'qcp': return 'audio/vnd.qcelp';
			case 'snd': return 'audio/basic';
			case 'wma': return 'audio/x-ms-wma';
			case 'qcp': return 'audio/vnd.qcelp';
		// Video
			case 'mp2': case 'mpg': case 'mpeg': return 'video/x-mpeg';
			case 'avi': return 'video/x-msvideo';
			case 'mov': case 'qt': return 'video/x-quicktime';
			case 'rv': return 'video/vnd.rn-realvideo';
			case 'wmv': return 'video/x-ms-wmv';
			case '3g2': case '3gp': return 'video/3gpp';
		// Text
			case 'html': case 'htm': return 'text/html';
			case 'xsl': case 'xslt': case 'xml': case 'wsdl': case 'xsd': return 'text/xml';
			case 'txt': return 'text/plain';
			case 'gcd': return 'text/x-pcs-gcd';
		// Application
			case 'pdf': return 'application/pdf';
			case 'doc': return 'application/msword';
			case 'rtf': return 'application/rtf';
			case 'xlm': case 'xlb': case 'xll': case 'xla': case 'xlw': case 'xlc': case 'xls': case 'xlt': return 'application/vnd.ms-excel';
			case 'ppt': case 'pps': return 'application/vnd.ms-powerpoint';
			case 'zip': return 'application/zip';
			case 'tar': return 'application/x-tar';
			case 'tgz': case 'gz': return 'application/x-gzip';
			case 'jar': return 'application/java-archive';
			case 'swf': return 'application/x-shockwave-flash';
			case 'rm': case 'ra': case 'ram': return 'application/vnd.rn-realaudio';
			case 'ogg': case 'ogm': return 'application/ogg';
			case 'pmd': return 'application/x-pmd';
			case 'mms': return 'application/vnd.wap.mms-message';
			case 'jad': return 'text/vnd.sun.j2me.app-descriptor';
			case 'exe': return 'application/octet-stream';
		// Default
			default: return 'application/octet-stream';
		}
	}

	// extract file info
//	protected
	function parse_file_name($file) {
		// returns ['dirname'], ['basename'], ['extension'], ['mime'], if(image) { ['width'], ['height'] }
		$file_name_info = pathinfo($file);
		$file_name_info['extension'] = strtolower($file_name_info['extension']);
		$temp = @getimagesize($file);
		if (is_array($temp)) {
			$file_name_info['mime'] = $temp['mime'];
			$file_name_info['width'] = $temp[0];
			$file_name_info['height'] = $temp[1];
		} else {
			$file_name_info['mime'] = $this->guess_file_mime($file_name_info['extension']);
		}
		return $file_name_info;
	}

	// edit the filenames or paths
// 1)make abs paths fully correct
// 2)make url paths fully correct
// 3)secure folder/file names
//	public
	function path_secure($path, $secure_abs = false, $secure_url = false) {
		if ($secure_abs === true) {
			return preg_replace('@([\\\\/]+)@', $this->dir_sep, $path);
		} elseif ($secure_url === true) {
			return preg_replace('@([\\\\/]+)@', '/', $path);
		} else {
			return preg_replace('@[^0-9a-z\._/-]@i', '_', $path);
		}
	}

	// get file info and get image info using php's gd support
/*
Returns:
			$results['folder'] = array('name', 'path', 'abs', 'url', 'size', 'lastmod');
			$results['image'] = array('name', 'abs', 'url', 'width', 'height', 'extension', 'mime', 'size', 'lastmod');
			$results['thumb'] = array('name', 'abs', 'url', 'width', 'height', 'extension', 'mime', 'size', 'lastmod');
			$results['thumb_error'] = 'ERROR: Could Not Find Thumbnail Or Thumbnail Is Not An Image File!';
			$results['non_image'] = array('name', 'abs', 'url', 'width', 'height', 'extension', 'mime', 'size', 'lastmod');
			$results['non_image_thumb'] = array('name', 'abs', 'url', 'width', 'height');
			$results['non_image_thumb_error'] = 'ERROR: Non-Image Thumbnail Does Not Exist Or Is Not An Image File!';
*/
//	protected
	function path_info($file, $path_abs, $path_url, $home_abs = false, $home_url = false, $find_thumb = false) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }
		if ($home_url === false) { $home_url = $this->options['home_url']; }
		if (is_dir($home_abs . $path_abs . $file . $this->dir_sep)) {
			$results['folder'] = array(
										'name'		=> $file,
										'path'		=> $path_abs . $file . $this->dir_sep,
										'abs'		=> $home_abs . $path_abs . $file . $this->dir_sep,
										'url'		=> $home_url . $path_url . $file . '/',
										'size'		=> filesize($home_abs . $path_abs . $file . $this->dir_sep),
										'lastmod'	=> filemtime($home_abs . $path_abs . $file . $this->dir_sep)
									);
		} elseif (is_file($home_abs . $path_abs . $file)) {

			if ($find_thumb === true) { $file = (!empty($this->options['thumb_folder']) ? $this->options['thumb_folder'] . $this->dir_sep : '') . (!empty($this->options['thumb_prefix']) ? $this->options['thumb_prefix'] . $file : $file); }
			$info = $this->parse_file_name($home_abs . $path_abs . $file);
//	$find_thumb === false && !empty($info['width']) && !empty($info['height']) || $find_thumb === true && $info['width'] <= $this->options['thumb_width'] && $info['height'] <= $this->options['thumb_height']
			if (!empty($info['width']) && !empty($info['height'])) {

				if ($find_thumb === true) {
					$results['thumb'] = array(
												'name'			=> $file,
												'abs'			=> $home_abs . $path_abs . $file,
												'url'			=> $home_url . $path_url . $file,
												'width'			=> $info['width'],
												'height'		=> $info['height'],
												'extension'		=> $info['extension'],
												'mime'			=> $info['mime'],
												'size'			=> filesize($home_abs . $path_abs . $file),
												'lastmod'		=> filemtime($home_abs . $path_abs . $file)
											);
				} else {
					$results['image'] = array(
												'name'			=> $file,
												'abs'			=> $home_abs . $path_abs . $file,
												'url'			=> $home_url . $path_url . $file,
												'width'			=> $info['width'],
												'height'		=> $info['height'],
												'extension'		=> $info['extension'],
												'mime'			=> $info['mime'],
												'size'			=> filesize($home_abs . $path_abs . $file),
												'lastmod'		=> filemtime($home_abs . $path_abs . $file)
											);
					$results = $results + $this->path_info($file, $path_abs, $path_url, $home_abs, $home_url, true);
				}
			} else {
				if ($find_thumb === true) {
					$results['thumb_error'] = PATH_INFO_THUMB_NOT_EXIST;
				} else {
					$results['non_image'] = array(
													'name'			=> $file,
													'abs'			=> $home_abs . $path_abs . $file,
													'url'			=> $home_url . $path_url . $file,
													'width'			=> $this->options['non_image_width'],
													'height'		=> $this->options['non_image_height'],
													'extension'		=> $info['extension'],
													'mime'			=> $info['mime'],
													'size'			=> filesize($home_abs . $path_abs . $file),
													'lastmod'		=> filemtime($home_abs . $path_abs . $file)
												);
				}
				// Get Non-Image Thumbnail Info
				$non_image_thumb = $this->options['default_thumb'];
				foreach ($this->options['default_thumbs'] as $ext => $image) {
					if ($ext == $info['extension']) {
						$non_image_thumb = $image;
						break;
					}
				}
				$non_image_thumb_info = $this->parse_file_name($this->options['no_thumb_image_path'] . $non_image_thumb);
				if (strpos($non_image_thumb_info['mime'], 'image') !== false) {
					$results['non_image_thumb'] = array(
														'name'		=> $non_image_thumb,
														'abs'		=> $this->options['default_thumb_path'] . $non_image_thumb,
														'url'		=> $this->options['default_thumb_path_url'] . $non_image_thumb,
														'width'		=> $non_image_thumb_info['width'],
														'height'	=> $non_image_thumb_info['height']
													);
				} else { $results['non_image_thumb_error'] = PATH_INFO_NON_IMAGE_THUMB_NOT_EXIST; }
			}
		}
		return $results;
	}

	// create browse page results / info on files
// Current Restrictions:
// browse_path() will not return any folders/files that have either 'thumb_folder' OR 'thumb_prefix' ANYWHERE!
//	protected
	function browse_path($path_abs, $only_allowed_files = true) {
		$path_url = $this->path_secure($path_abs, false, true);
//		$path_list = $this->parse_path('folders_files', $path_abs, false, '/^' . preg_quote($this->options['thumb_folder']) . '$|^' . preg_quote($this->options['thumb_prefix']) .  '.*$/', false);
		$path_list = $this->parse_path('folders_files', $path_abs, false, '/^' . (!empty($this->options['thumb_folder']) ? preg_quote($this->options['thumb_folder']) : '[.]') . '$|^' . (!empty($this->options['thumb_prefix']) ? preg_quote($this->options['thumb_prefix']) : '[.]') .  '.*$/', false);
		if (is_array($path_list['folders'])) {
			foreach($path_list['folders'] as $folder) {
				$results['folders'][] = $this->path_info($folder, $path_abs, $path_url);
			}
		} else { $results['folders'] = 'No Folders Found!'; }
		if (is_array($path_list['files'])) {
			foreach($path_list['files'] as $file) {
				if ($only_allowed_files === true) {
					$temp = $this->path_info($file, $path_abs, $path_url);
					if (empty($this->options['allowed_types'][0]) || in_array($temp['image']['extension'], $this->options['allowed_types']) || in_array($temp['non_image']['extension'], $this->options['allowed_types'])) {
						$results['files'][] = $temp;
					}
				} else {
					$results['files'][] = $this->path_info($file, $path_abs, $path_url);
				}
			}
			if (!is_array($results['files'])) { $results['files'] = BROWSE_PATH_NO_FILES_ALLOWED; }
		} else { $results['files'] = BROWSE_PATH_NO_FILES; }
		return $results;
	}


// Folder Tasks Functions

	// Create Folder / Thumbnail Folder
//	protected
	function create_folder($path_abs, $target, $home_abs = false, $thumb_folder = false) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }
		$target = ($thumb_folder === true ? (!empty($this->options['thumb_folder']) ? $target . $this->dir_sep . $this->options['thumb_folder'] : false) : $this->path_secure($target));
		if (!empty($target)) {
			if (($thumb_folder === false && $target != $this->options['thumb_folder']) || $thumb_folder === true) {
				if (!is_dir($home_abs . $path_abs . $target . $this->dir_sep)) {
					if (@mkdir($home_abs . $path_abs . $target . $this->dir_sep, 0777)) {
						@umask(0000);
						@chmod($home_abs . $path_abs . $target . $this->dir_sep, 0777);
						$info_message = sprintf(($thumb_folder === true ? CREATE_FOLDER_DONE_THUMB : CREATE_FOLDER_DONE), $path_abs . $target . $this->dir_sep);
						if ($thumb_folder === false && !empty($this->options['thumb_folder'])) { $info_message .= $this->create_folder($path_abs, $target, $home_abs, true); }
						return $info_message;
					} else { return sprintf(($thumb_folder === true ? CREATE_FOLDER_FAILED_THUMB : CREATE_FOLDER_FAILED), $path_abs . $target . $this->dir_sep); }
				} else { return ($thumb_folder === true ? CREATE_FOLDER_EXISTS_THUMB : CREATE_FOLDER_EXISTS); }
			} else { return ($thumb_folder === true ? CREATE_FOLDER_NEW_NAME_INCORRECT_THUMB : CREATE_FOLDER_NEW_NAME_INCORRECT); }
		} else { return ($thumb_folder === true ? CREATE_FOLDER_EMPTY_THUMB : CREATE_FOLDER_EMPTY); }
	}

	// Rename Folder / File
//	protected
	function rename_folder($path_abs, $folder, $target, $home_abs = false) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }
		if (!empty($folder)) {
			if (!empty($target)) {
				$target = $this->path_secure($target);
				if ($folder != $target) {
					if ($target != $this->options['thumb_folder']) {
						if (is_dir($home_abs . $path_abs . $folder . $this->dir_sep)) {
							if (!is_dir($home_abs . $path_abs . $target . $this->dir_sep)) {
								if (@rename($home_abs . $path_abs . $folder . $this->dir_sep, $home_abs . $path_abs . $target . $this->dir_sep)) {
									return sprintf(RENAME_FOLDER_DONE, $path_abs . $folder . $this->dir_sep, $path_abs . $target . $this->dir_sep);
								} else { return sprintf(RENAME_FOLDER_FAILED, $path_abs . $folder . $this->dir_sep, $path_abs . $target . $this->dir_sep); }
							} else { return RENAME_FOLDER_EXISTS; }
						} else { return RENAME_FOLDER_NOT_EXIST; }
					} else { return RENAME_FOLDER_NEW_NAME_INCORRECT; }
				} else { return RENAME_FOLDER_NEW_NAME_SAME; }
			} else { return RENAME_FOLDER_NEW_NAME_EMPTY; }
		} else { return RENAME_FOLDER_EMPTY; }
	}

	// Move Folder
//	protected
	function move_folder() {

	}

	// Copy Folder
//	protected
	function copy_folder() {

	}

	// Delete Folder
// Have to rework!
// use return more than $info_message ...
//	protected 
	function delete_folder($path_abs, $folder, $force_delete = false, $home_abs = false, $depth = 0, $thumb_folder = false) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }
		if (!empty($folder) && is_dir($home_abs . $path_abs . $folder . $this->dir_sep)) {
			$info_message = str_repeat('&#8212; ', $depth) . sprintf(($thumb_folder === true ? DELETE_FOLDER_CHECK_THUMB : DELETE_FOLDER_CHECK), $path_abs . $folder . $this->dir_sep);
			$path_list = $this->parse_path('folders_files', $path_abs . $folder . $this->dir_sep);
			if (is_array($path_list)) {
				if ($force_delete) {
					$info_message .= str_repeat('&#8212; ', $depth) . ($thumb_folder === true ? DELETE_FOLDER_NOT_EMPTY_FORCE_THUMB : DELETE_FOLDER_NOT_EMPTY_FORCE);
					if (is_array($path_list['folders'])) {
//		$info_message .= str_repeat('&#8212; ', $depth) . ($thumb_folder === true ? DELETE_FOLDER_SUB_THUMB : DELETE_FOLDER_SUB);
						foreach($path_list['folders'] as $check_folder) {
							$info_message .= $this->delete_folder($path_abs . $folder . $this->dir_sep, $check_folder, $force_delete, $home_abs, $depth + 1, ($check_folder == $this->options['thumb_folder'] || $thumb_folder === true ? true : false));
						}
//		$info_message .= str_repeat('&#8212; ', $depth) . ($thumb_folder === true ? DELETE_FOLDER_SUB_DONE_THUMB : DELETE_FOLDER_SUB_DONE);
					}
					if (is_array($path_list['files'])) {
//		$info_message .= str_repeat('&#8212; ', $depth) . ($thumb_folder === true ? DELETE_FOLDER_SUB_FILE_THUMB : DELETE_FOLDER_SUB_FILE);
						foreach($path_list['files'] as $file) {
							if (@unlink($home_abs . $path_abs . $folder . $this->dir_sep . $file)) {
								$info_message .= str_repeat('&#8212; ', $depth) . sprintf(($thumb_folder === true ? DELETE_FILE_DONE_THUMB : DELETE_FILE_DONE), $path_abs . $folder . $this->dir_sep . $file);
							} else {
								$info_message .= str_repeat('&#8212; ', $depth) . sprintf(($thumb_folder === true ? DELETE_FILE_FAILED_THUMB : DELETE_FILE_FAILED), $path_abs . $folder . $this->dir_sep . $file);
							}
//		$info_message .= str_repeat('&#8212; ', $depth) . ($thumb_folder === true ? DELETE_FOLDER_SUB_FILE_DONE_THUMB : DELETE_FOLDER_SUB_FILE_DONE);
		                }
					}
					if (!preg_match('@^.?/?$@', $folder) && @rmdir($home_abs . $path_abs . $folder . $this->dir_sep)) {
						$info_message .= str_repeat('&#8212; ', $depth) . sprintf(($thumb_folder === true ? DELETE_FOLDER_DONE_THUMB : DELETE_FOLDER_DONE), $path_abs . $folder . $this->dir_sep);
					} else {
						$info_message .= str_repeat('&#8212; ', $depth) . sprintf(($thumb_folder === true ? DELETE_FOLDER_FAILED_THUMB : DELETE_FOLDER_FAILED), $path_abs . $folder . $this->dir_sep);
					}
				} else {
					if (!is_array($path_list['files']) && count($path_list['folders']) == 1 && $path_list['folders'][0] == $this->options['thumb_folder']) {
						$info_message .= $this->delete_folder($path_abs . $folder . $this->dir_sep, $path_list['folders'][0], $force_delete, $home_abs, $depth + 1, true);
						if (!preg_match('@^.?/?$@', $folder) && @rmdir($home_abs . $path_abs . $folder . $this->dir_sep)) {
							$info_message .= str_repeat('&#8212; ', $depth) . sprintf(($thumb_folder === true ? DELETE_FOLDER_DONE_THUMB : DELETE_FOLDER_DONE), $path_abs . $folder . $this->dir_sep);
						} else {
							$info_message .= str_repeat('&#8212; ', $depth) . sprintf(($thumb_folder === true ? DELETE_FOLDER_FAILED_THUMB : DELETE_FOLDER_FAILED), $path_abs . $folder . $this->dir_sep);
						}
					} else { $info_message .= str_repeat('&#8212; ', $depth) . ($thumb_folder === true ? DELETE_FOLDER_NOT_EMPTY_THUMB : DELETE_FOLDER_NOT_EMPTY); }
				}
			} else {
				if (!preg_match('@^.?/?$@', $folder) && @rmdir($home_abs . $path_abs . $folder . $this->dir_sep)) {
					$info_message .= str_repeat('&#8212; ', $depth) . sprintf(($thumb_folder === true ? DELETE_FOLDER_DONE_THUMB : DELETE_FOLDER_DONE), $path_abs . $folder . $this->dir_sep);
				} else {
					$info_message .= str_repeat('&#8212; ', $depth) . sprintf(($thumb_folder === true ? DELETE_FOLDER_FAILED_THUMB : DELETE_FOLDER_FAILED), $path_abs . $folder . $this->dir_sep);
				}
			}
			return $info_message;
		} else { return ($thumb_folder === true ? DELETE_FOLDER_EMPTY_THUMB : DELETE_FOLDER_EMPTY); }
	}



// Image Manipulation Functions - PHP GD/GD2

	// Which PHP GD/GD2 Functions To Use For File Extension Type
//	protected
	function which_gd_functions($extension) {
		if (!empty($extension)) {
			if (function_exists('imagecopyresampled')) {
				switch (strtolower($extension)) {
					case 'gif':
						if (function_exists('imagecreatefromgif')) {
							$gd_func['load'] = 'imagecreatefromgif';
						} else { return sprintf(WHICH_GD_FUNC_NOT_LOADED, 'imagecreatefromgif()'); }
						if (function_exists('imagegif')) {
							$gd_func['save'] = 'imagegif';
						} elseif (function_exists('imagepng')) {
							$gd_func['save'] = 'imagepng';
						} else { return sprintf(WHICH_GD_FUNC_NOT_LOADED2, 'imagegif()', 'imagepng()'); }
						break;
					case 'jpeg':
					case 'jpg':
					case 'jfif':
						if (function_exists('imagecreatefromjpeg')) {
							$gd_func['load'] = 'imagecreatefromjpeg';
						} else { return sprintf(WHICH_GD_FUNC_NOT_LOADED, 'imagecreatefromjpeg()'); }
						if (function_exists('imagejpeg')) {
							$gd_func['save'] = 'imagejpeg';
						} elseif (function_exists('imagepng')) {
							$gd_func['save'] = 'imagepng';
						} else { return sprintf(WHICH_GD_FUNC_NOT_LOADED2, 'imagejpeg()', 'imagepng()'); }
						break;
					case 'png':
						if (function_exists('imagecreatefrompng')) {
							$gd_func['load'] = 'imagecreatefrompng';
						} else { return sprintf(WHICH_GD_FUNC_NOT_LOADED, 'imagecreatefrompng()'); }
						if (function_exists('imagepng')) {
							$gd_func['save'] = 'imagepng';
						} else { return sprintf(WHICH_GD_FUNC_NOT_LOADED, 'imagepng()'); }
						break;
					default:
						return sprintf(WHICH_GD_FUNC_FAILED, $extension);
						break;
				}
			} else { return sprintf(WHICH_GD_FUNC_NOT_LOADED, 'imagecopyresampled()'); }
		} else { return WHICH_GD_FUNC_INCORRECT_CALL; }
		return $gd_func;
	}

	// Resize Image With PHP GD/GD2
//	protected
	function resize_image_gd($file, $target, $extension, $width = false, $height = false, $thumb_file = false) {
		if (!empty($file) && !empty($target) && !empty($extension) && (!empty($width) || !empty($height))) {
			$gd_func = $this->which_gd_functions($extension);
			if (is_array($gd_func)) {
				$in = $gd_func['load']($file);
				$file_width = imagesx($in);
				$file_height = imagesy($in);
				$width_ratio = (!empty($width) ? $file_width / $width : 0);
				$height_ratio = (!empty($height) ? $file_height / $height : 0);
				if ($width_ratio <= 1 && $height_ratio <= 1 && $thumb_file === true) {
					return (@copy($file, $target) ? true : false);
				} else {
					$ratio = ($width_ratio >= $height_ratio ? $width_ratio : $height_ratio);
					$width = round($file_width / $ratio);
					$height = round($file_height / $ratio);
					$out = imagecreatetruecolor($width, $height);
				// Attempt to copy transparency information, this really only works for PNG
					if (function_exists('imagesavealpha')) {
						imagealphablending($out, false);
						imagesavealpha($out, true);
					}
					imagecopyresampled($out, $in, 0, 0, 0, 0, $width, $height, $file_width, $file_height);
					if ($gd_func['save']($out, $target, 100)) {
						unset($in, $out);
						return true;
					} else { unset($in, $out); return false; }
				}
			} else { return $gd_func; }
		} else { return RESIZE_IMAGE_GD_INCORRECT_CALL; }
	}

	// Rotate Image With PHP GD/GD2
//	protected
	function rotate_image_gd($file, $target, $extension, $degrees) {
		if (!empty($file) && !empty($target) && !empty($extension) && !empty($degrees)) {
			$gd_func = $this->which_gd_functions($extension);
			if (is_array($gd_func)) {
				$in = $gd_func['load']($file);
				$out = imagerotate($in, $degrees, 0);
				if ($gd_func['save']($out, $target)) {
					unset($in, $out);
					return true;
				} else { unset($in, $out); return false; }
			} else { return $gd_func; }
		} else { return ROTATE_IMAGE_GD_INCORRECT_CALL; }
	}

	// Create Thumbnail File
//	protected
	function create_thumbnail_file($path_abs, $file, $home_abs = false) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }

// Need To Think About This A Bit More! Maybe Some Error Check?
		$this->create_folder($path_abs, '', $home_abs, true);

		if (!empty($this->options['thumb_folder']) || !empty($this->options['thumb_prefix'])) {
			if (!empty($file)) {
				$info = $this->parse_file_name($home_abs . $path_abs . $file);
				if (!empty($info['width']) && !empty($info['height'])) {
//				if ((!empty($info['width']) && !empty($info['height'])) || $info['mime'] == 'application/pdf') {

					if (!empty($this->options['thumb_width']) || !empty($this->options['thumb_height'])) {
						$file_thumb = (!empty($this->options['thumb_folder']) ? $this->options['thumb_folder'] . $this->dir_sep : '') . (!empty($this->options['thumb_prefix']) ? $this->options['thumb_prefix'] . $file : $file);

						if ($this->options['use_magick']) {
//			        	    if ($info['mime'] == 'application/pdf') {
//        			    	   $cmd     = escapeshellcmd($serendipity['convert']) . ' -antialias -flatten -scale '. serendipity_escapeshellarg($newSize) .' '. serendipity_escapeshellarg($infile) .' '. serendipity_escapeshellarg($outfile . '.png');
//	            			} else {
								$cmd = escapeshellcmd($this->options['convert_path']) . escapeshellarg(' -antialias -scale ' . $this->options['thumb_width'] . 'x' . $this->options['thumb_height'] . ' ' . $home_abs . $path_abs . $file . ' ' . $home_abs . $path_abs . $file_thumb);
//        			    	}

//							$cmd = $this->options['convert_path'] . ' -antialias -scale ' . $this->options['thumb_width'] . 'x' . $this->options['thumb_height'] . ' ' . $infile . ' ' . $outfile . ' 2>&1';

							exec($cmd, $output, $result);
							if (empty($result)) {
								return sprintf(CREATE_THUMB_FILE_DONE, $path_abs . $file);
							} else {
								return sprintf(CREATE_THUMB_FILE_FAILED, $path_abs . $file) . sprintf(IMAGIC_ERROR, $cmd, $output[0], $result);
//								return 'exec() $output:<br />' . implode('<br />', $output) . '<br />';
							}
						} else {
						// call resize function if not use magick, pass infile, outfile, and thumbsize wanted
							$results = $this->resize_image_gd($home_abs . $path_abs . $file, $home_abs . $path_abs . $file_thumb, $info['extension'], $this->options['thumb_width'], $this->options['thumb_height'], true);
							if ($results === true) {
								return sprintf(CREATE_THUMB_FILE_DONE, $path_abs . $file);
							} else { return $results . sprintf(CREATE_THUMB_FILE_FAILED, $path_abs . $file); }
						}

					} else { return CREATE_THUMB_FILE_WIDTH_HEIGHT_EMPTY; }

				} else { return CREATE_THUMB_FILE_NOT_IMAGE; }
			} else { return CREATE_THUMB_FILE_EMPTY; }
		} else { return CREATE_THUMB_FILE_FOLDER_PREFIX_EMPTY; }
	}


// File Functions

	// Upload File
//	protected
/*
Use curl to get file
curl_getinfo() returns:
array(
		'url'							=> '',
		'content_type'					=> '',
		'http_code'						=> '',
		'header_size'					=> '',
		'request_size'					=> '',
		'filetime'						=> '',
		'ssl_verify_result'				=> '',
		'redirect_count'				=> '',
		'total_time'					=> '',
		'namelookup_time'				=> '',
		'connect_time'					=> '',
		'pretransfer_time'				=> '',
		'size_upload'					=> '',
		'size_download'					=> '',
		'speed_download'				=> '',
		'speed_upload'					=> '',
		'download_content_length'		=> '',
		'upload_content_length'			=> '',
		'starttransfer_time'			=> '',
		'redirect_time'					=> '',
	)

NOTES:
------
In future, use database to store curl_int ref and come back to check GET process
for now, just use sesstion/var passing to do this.
Allow resuming of fetching of files! need to move file_exists() check or something
May Want To Make Checks For File Type Varification On All Uploaded/Fetch
curl_getinfo($handle, CURLINFO_CONTENT_TYPE);
don't know how to use this feature
curl_setopt($handle, CURLOPT_NOPROGRESS, false);
*/
	function upload_file($path_abs, $upload_type, $file_url = false, $target, $home_abs = false) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }
		switch ($upload_type) {
			case 'fetch':
				if (!empty($file_url) && $file_url != 'http://') {
					if (empty($target)) { $target = basename($file_url); }
					$target = $this->path_secure($target);
					$target_name_info = $this->parse_file_name($target);
					if (empty($this->options['allowed_types'][0]) || in_array($target_name_info['extension'], $this->options['allowed_types'])) {
						if (!is_file($home_abs . $path_abs . $target)) {

							if (extension_loaded('curl')) {
							// if curl loaded, get file_url's info (size, mime, and if it exists)
								$handle = curl_init($file_url);
								curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($handle, CURLOPT_HEADER, true);
								curl_setopt($handle, CURLOPT_NOBODY, true);
								$content = curl_exec($handle);
								$handle_info = curl_getinfo($handle);
								$handle_error = curl_error($handle);
								curl_close($handle);
								if ($content !== false) {
									if ($handle_info['http_code'] == 200) {
//										if ($handle_info['content_type'] == $target_name_info['mime']) {
											if ($handle_info['download_content_length'] <= $this->convert_shortsize($this->options['max_size'])) {
												$fp = fopen($home_abs . $path_abs . $target, 'w');
												$handle = curl_init($file_url);
												curl_setopt($handle, CURLOPT_HEADER, false);
												curl_setopt($handle, CURLOPT_FILE, $fp);
//												curl_setopt($handle, CURLOPT_WRITEFUNCTION, 'call-back-function');
												$content = curl_exec($handle);
												$handle_info = curl_getinfo($handle);
												$handle_error = curl_error($handle);
												curl_close($handle);
												fclose($fp);
												if ($content !== false) {
													$info_message .= sprintf(FETCH_FILE_DONE, $path_abs . $target);
													$info_message .= $this->create_thumbnail_file($path_abs, $target, $home_abs);
													return $info_message;
												} else { return sprintf(FETCH_FILE_FAILED, $path_abs . $target) . sprintf(FETCH_FILE_CURL_FAILED, $handle_error); }
											} else { return sprintf(UPLOAD_FILE_EXCEEDS_MAX_SIZE, $this->format_filesize($handle_info['download_content_length']), $this->format_filesize($this->convert_shortsize($this->options['max_size']))); }
//										} else { return FETCH_FILE_CURL_MIME_EXT_MISMATCH; }
									} else { return sprintf(FETCH_FILE_CURL_NOT_EXIST, $handle_info['http_code']); }
								} else { return sprintf(FETCH_FILE_CURL_UNKNOWN_ERROR, $handle_error); }
							} else { return FETCH_FILE_CURL_NOT_LOADED; }
/*
// Normal file_get_contents() Fetch File
							if ($file_content = @file_get_contents($file_url)) {
								if (strlen($file_content) <= $this->convert_shortsize($this->options['max_size'])) {
									if (@file_put_contents($home_abs . $path_abs . $target, $file_content)) {
										@umask(000);
										@chmod($home_abs . $path_abs . $target, 0664);
										$info_message .= sprintf(FETCH_FILE_DONE, $path_abs . $target);
										$info_message .= $this->create_thumbnail_file($path_abs, $target, $home_abs);
										return $info_message;
									} else { return sprintf(FETCH_FILE_FAILED, $path_abs . $target); }
								} else { return sprintf(UPLOAD_FILE_EXCEEDS_MAX_SIZE, $this->format_filesize(strlen($file_content)), $this->format_filesize($this->convert_shortsize($this->options['max_size']))); }
							} else { return sprintf(FETCH_FILE_NOT_EXIST, $file_url); }
*/
						} else { return sprintf(FETCH_FILE_EXISTS, $path_abs . $target); }
					} else { return sprintf(FETCH_FILE_NOT_ALLOWED, $target_name_info['extension']); }
				} else { return FETCH_FILE_EMPTY; }
				break;
			case 'upload':
				switch ($_FILES['user_file']['error']) {
					case 0:
						if (empty($this->options['max_size']) || $_FILES['user_file']['size'] <= $this->convert_shortsize($this->options['max_size'])) {
							if (empty($target)) { $target = $_FILES['user_file']['name']; }
							$target = $this->path_secure($target);
							$target_name_info = $this->parse_file_name($target);
							if (empty($this->options['allowed_types'][0]) || in_array($target_name_info['extension'], $this->options['allowed_types'])) {
								if (!is_file($home_abs . $path_abs . $target)) {
									if (@move_uploaded_file($_FILES['user_file']['tmp_name'], $home_abs . $path_abs . $target)) {
										@umask(000);
										@chmod($home_abs . $path_abs . $target, 0664);
										$info_message .= sprintf(UPLOAD_FILE_DONE, $path_abs . $target);
										$info_message .= $this->create_thumbnail_file($path_abs, $target, $home_abs);
										return $info_message;
									} else { return sprintf(UPLOAD_FILE_FAILED, $path_abs . $target); } // Unknow Error Occurred During move_uploaded_file()
								} else { return sprintf(UPLOAD_FILE_EXISTS, $path_abs . $target); }
							} else { return sprintf(UPLOAD_FILE_NOT_ALLOWED, $target_name_info['extension']); }
						} else { return sprintf(UPLOAD_FILE_EXCEEDS_MAX_SIZE, $this->format_filesize($_FILES['user_file']['size']), $this->format_filesize($this->convert_shortsize($this->options['max_size']))); }
						break;
					case 1:
						return UPLOAD_FILE_EXCEEDS_UPLOAD_MAX_FILESIZE . sprintf(UPLOAD_FILE_EXCEEDS_MAX_SIZE, $this->format_filesize($_FILES['user_file']['size']), $this->format_filesize($this->convert_shortsize($this->options['max_size'])));
						break;
					case 2:
						return UPLOAD_FILE_EXCEEDS_MAX_FILE_SIZE . sprintf(UPLOAD_FILE_EXCEEDS_MAX_SIZE, $this->format_filesize($_FILES['user_file']['size']), $this->format_filesize($this->convert_shortsize($this->options['max_size'])));
						break;
					case 3:
						return UPLOAD_FILE_PARTIALLY;
						break;
					case 4:
						return UPLOAD_FILE_EMPTY;
						break;
					default:
						return UPLOAD_FILE_UNKNOWN_ERROR;
						break;
				}
				break;
			default:
				return UPLOAD_FILE_INCORRECT_CALL;
				break;
		}		
	}

	// Create File
//	protected
	function create_file() {
	
	}

	// Edit File
//	protected
	function edit_file() {
	
	}

	// Rename File
//	protected
	function rename_file($path_abs, $file, $target, $home_abs = false, $thumb_file = false) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }
		$file = ($thumb_file === true ? (!empty($this->options['thumb_folder']) ? $this->options['thumb_folder'] . $this->dir_sep . $this->options['thumb_prefix'] . $file : (!empty($this->options['thumb_prefix']) ? $this->options['thumb_prefix'] . $file : false)) : $file);
		$target = ($thumb_file === true ? (!empty($this->options['thumb_folder']) ? $this->options['thumb_folder'] . $this->dir_sep . $this->options['thumb_prefix'] . $target : (!empty($this->options['thumb_prefix']) ? $this->options['thumb_prefix'] . $target : false)) : $this->path_secure($target));
		if (!empty($file)) {
			if (!empty($target)) {
				if ($file != $target) {
					if (($thumb_file === false && !preg_match('/^' . preg_quote($this->options['thumb_prefix']) .  '.*$/', $target)) || $thumb_file === true) {
						if (is_file($home_abs . $path_abs . $file)) {
							if (!is_file($home_abs . $path_abs . $target)) {
								if (@rename($home_abs . $path_abs . $file, $home_abs . $path_abs . $target)) {
									$info_message = sprintf(($thumb_file === true ? RENAME_FILE_DONE_THUMB : RENAME_FILE_DONE), $path_abs . $file, $path_abs . $target);
									if ($thumb_file === false) { $info_message .= $this->rename_file($path_abs, $file, $target, $home_abs, true); }
									return $info_message;
								} else { return sprintf(($thumb_file === true ? RENAME_FILE_FAILED_THUMB : RENAME_FILE_FAILED), $path_abs . $file, $path_abs . $target); }
							} else { return ($thumb_file === true ? RENAME_FILE_EXISTS_THUMB : RENAME_FILE_EXISTS); }
						} else { return ($thumb_file === true ? RENAME_FILE_NOT_EXIST_THUMB : RENAME_FILE_NOT_EXIST); }
					} else { return ($thumb_file === true ? RENAME_FILE_NEW_NAME_INCORRECT_THUMB : RENAME_FILE_NEW_NAME_INCORRECT); }
				} else { return ($thumb_file === true ? RENAME_FILE_NEW_NAME_SAME_THUMB : RENAME_FILE_NEW_NAME_SAME); }
			} else { return ($thumb_file === true ? RENAME_FILE_NEW_NAME_EMPTY_THUMB : RENAME_FILE_NEW_NAME_EMPTY); }
		} else { return ($thumb_file === true ? RENAME_FILE_EMPTY_THUMB : RENAME_FILE_EMPTY); }
	}

	// Resize File
//	protected
	function resize_file($path_abs, $file, $width, $height, $home_abs = false) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }
		if (!empty($file)) {
			if (!empty($width) || !empty($height)) {
				$info = $this->parse_file_name($home_abs . $path_abs . $file);
				if (!empty($info['width']) && !empty($info['height'])) {
					if ($info['width'] != $width || $info['height'] != $height) {
						if ($this->options['use_magick']) {
							$cmd = escapeshellcmd($this->options['convert_path']) . escapeshellarg(' -scale ' . $width . 'x' . $height . ' ' . $home_abs . $path_abs . $file . ' ' . $home_abs . $path_abs . $file);
							exec($cmd, $output, $result);
							if (empty($result)) {
//								return sprintf(($thumb_file === true ? RESIZE_FILE_DONE_THUMB : RESIZE_FILE_DONE), $path_abs . $file);
								$info_message = sprintf(RESIZE_FILE_DONE, $path_abs . $file);
								$info_message .= $this->create_thumbnail_file($path_abs, $file, $home_abs);
								return $info_message;
							} else { return sprintf(RESIZE_FILE_FAILED, $path_abs . $file) . sprintf(IMAGIC_ERROR, $cmd, $output[0], $result); }
						} else {
//							return ($this->resize_file_gd($home_abs . $path_abs . $file, $home_abs . $path_abs . $file, $info['extension'], $width, $height) ? 'Resized File - ' . $path_abs . $file . ' => DONE!<br />' : 'Resized File - ' . $path_abs . $file . ' => FAILED!<br />');
							$results = $this->resize_image_gd($home_abs . $path_abs . $file, $home_abs . $path_abs . $file, $info['extension'], $width, $height);
							if ($results === true) {
								$info_message = sprintf(RESIZE_FILE_DONE, $path_abs . $file);
								$info_message .= $this->create_thumbnail_file($path_abs, $file, $home_abs);
								return $info_message;
							} else { return $results . sprintf(RESIZE_FILE_FAILED, $path_abs . $file); }
						}
					} else { return RESIZE_FILE_WIDTH_HEIGHT_SAME; }
				} else { return RESIZE_FILE_NOT_IMAGE; }
			} else { return RESIZE_FILE_WIDTH_HEIGHT_EMPTY; }
		} else { return RESIZE_FILE_EMPTY; }
	}


	// Rotate File
//	protected
	function rotate_file($path_abs, $file, $degrees, $home_abs = false) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }
		if (!empty($file)) {
			if (!empty($degrees)) {
				$info = $this->parse_file_name($home_abs . $path_abs . $file);
				if (!empty($info['width']) && !empty($info['height'])) {
					if ($this->options['use_magick']) {
						$cmd = escapeshellcmd($this->options['convert_path']) . escapeshellarg(' -rotate ' . $degrees . ' ' . $home_abs . $path_abs . $file . ' ' . $home_abs . $path_abs . $file);
						exec($cmd, $output, $result);
						if (empty($result)) {
							$info_message = sprintf(ROTATE_FILE_DONE, $path_abs . $file);
							$info_message .= $this->create_thumbnail_file($path_abs, $file, $home_abs);
							return $info_message;
						} else { return sprintf(ROTATE_FILE_FAILED, $path_abs . $file) . sprintf(IMAGIC_ERROR, $cmd, $output[0], $result); }
					} else {
						$results = $this->rotate_image_gd($home_abs . $path_abs . $file, $home_abs . $path_abs . $file, $info['extension'], $degrees);
						if ($results === true) {
							$info_message = sprintf(ROTATE_FILE_DONE, $path_abs . $file);
							$info_message .= $this->create_thumbnail_file($path_abs, $file, $home_abs);
							return $info_message;
						} else { return $results . sprintf(ROTATE_FILE_FAILED, $path_abs . $file); }
					}
				} else { return ROTATE_FILE_NOT_IMAGE; }
			} else { return ROTATE_FILE_DEGREES_EMPTY; }
		} else { return ROTATE_FILE_EMPTY; }
	}

	// Move File
//	protected
	function move_file() {

	}

	// Copy File
//	protected
	function copy_file() {

	}

	// Delete File
//	protected
	function delete_file($path_abs, $file, $home_abs = false, $thumb_file = false) {
		if ($home_abs === false) { $home_abs = $this->options['home_abs']; }
		$file = ($thumb_file === true ? (!empty($this->options['thumb_folder']) ? $this->options['thumb_folder'] . $this->dir_sep . $this->options['thumb_prefix'] . $file : (!empty($this->options['thumb_prefix']) ? $this->options['thumb_prefix'] . $file : false)) : $file);
		if (!empty($file)) {
			if (is_file($home_abs . $path_abs . $file)) {
				if (@unlink($home_abs . $path_abs . $file)) {
					$info_message = sprintf(($thumb_file === true ? DELETE_FILE_DONE_THUMB : DELETE_FILE_DONE), $path_abs . $file);
					if ($thumb_file === false) { $info_message .= $this->delete_file($path_abs, $file, $home_abs, true); }
					return $info_message;
				} else { return sprintf(($thumb_file === true ? DELETE_FILE_FAILED_THUMB : DELETE_FILE_FAILED), $path_abs . $file); }
			} else { return ($thumb_file === true ? DELETE_FILE_NOT_EXIST_THUMB : DELETE_FILE_NOT_EXIST); }
		} else { return ($thumb_file === true ? DELETE_FILE_EMPTY_THUMB : DELETE_FILE_EMPTY); }
	}







// Mis Display Functions

	// Convert Shorthand Size
//	protected
	function convert_shortsize($size) {
		$size = trim($size);
		$type = $size{strlen($size) - 1};
		switch($type) {
			case 'M': case 'm': return $size * 1048576;
			case 'K': case 'k': return $size * 1024;
			default: return $size;
		}
	}

	// Formats File's Size
//	protected
	function format_filesize($size) {
		if ($size >= 1073741824) {
			return round($size / 1073741824, 2) . ' GB';
		} elseif ($size >= 1048576) {
			return round($size / 1048576, 2) . ' MB';
		} elseif ($size >= 1024) {
			return round($size / 1024, 2) . ' KB';
		} else {
			return $size . ' bytes';
		}
	}

	// Formats A Timestamp
//	protected
	function format_timestamp($timestamp, $format = 'Y-m-d h:i:s A') {
		return date($format, $timestamp);
	}


	// Function to output a path_info() return
// 22 total -> remove 2 == 20 total
// 'type', 'url_path', 'width', 'height', 'ext', 'mime', 'size', 'last_mod', 'thumb_url', 'align', 'linkable', 'open_to', 'left', 'top', 'center', 'status_bar', 'menu_bar', 'location_bar', 'tool_bar', 'scroll_bars', 'resizable', 'focus_after_add', 'close_after_add'

// last code options with 'left' and 'top'
//	$code .= ', \'' . $this->options['align'] . '\', \'' . $this->options['make_linkable'] . '\', \'' . $this->options['open_to'] . '\', \'' . $this->options['left'] . '\', \'' . $this->options['top'] . '\', \'' . $this->options['center'] . '\', \'' . $this->options['status_bar'] . '\', \'' . $this->options['menu_bar'] . '\', \'' . $this->options['location_bar'] . '\', \'' . $this->options['tool_bar'] . '\', \'' . $this->options['scroll_bars'] . '\', \'' . $this->options['resizable'] . '\', \'' . $this->options['focus_after_add'] . '\', \'' . $this->options['close_after_add'] . '\'';
//	protected
	function display($file_info) {
		if (!empty($file_info['folder'])) {
			$name = $file_info['folder']['name'];
			$thumb_image = '<img src="images/folder.gif" alt="Folder" title="Folder" />';
			$code = '\'folder\', \'' . addslashes($file_info['folder']['path']) . '\', \'\', \'\', \'\', \'\', \'' . $this->format_filesize($file_info['folder']['size']) . '\', \'' . $this->format_timestamp($file_info['folder']['lastmod']) . '\'';
		} elseif (!empty($file_info['image'])) {
			$name = $file_info['image']['name'];
			$code = '\'image\', \'' . $file_info['image']['url'] . '\', ' . $file_info['image']['width'] . ', ' . $file_info['image']['height'] . ', \'' . $file_info['image']['extension'] . '\', \'' . $file_info['image']['mime'] . '\', \'' . $this->format_filesize($file_info['image']['size']) . '\', \'' . $this->format_timestamp($file_info['image']['lastmod']) . '\'';
			
			if (!empty($file_info['thumb']) && empty($file_info['thumb_error'])) {
				$thumb_image = '<img src="' . $file_info['thumb']['url'] . '" alt="' . $name . '" title="' . $name . '" />';
				$code .= ', \'' . $file_info['thumb']['url'] . '\'';
			} else {
// Work on ERROR Thumb Code
				$thumb_image = '<img src="' . $file_info['non_image_thumb']['url'] . '" alt="' . $file_info['thumb_error'] . '" title="' . $name . '" />';
				$code .= ', \'' . $file_info['non_image_thumb']['url'] . '\'';
			}

			$code .= ', \'' . $this->options['align'] . '\', \'' . $this->options['make_linkable'] . '\', \'' . $this->options['open_to'] . '\', \'\', \'\', \'' . $this->options['center'] . '\', \'' . $this->options['status_bar'] . '\', \'' . $this->options['menu_bar'] . '\', \'' . $this->options['location_bar'] . '\', \'' . $this->options['tool_bar'] . '\', \'' . $this->options['scroll_bars'] . '\', \'' . $this->options['resizable'] . '\', \'' . $this->options['focus_after_add'] . '\', \'' . $this->options['close_after_add'] . '\'';
		} elseif (!empty($file_info['non_image'])) {
			$name = $file_info['non_image']['name'];
			$code = '\'non_image\', \'' . $file_info['non_image']['url'] . '\', ' . $file_info['non_image']['width'] . ', ' . $file_info['non_image']['height'] . ', \'' . $file_info['non_image']['extension'] . '\', \'' . $file_info['non_image']['mime'] . '\', \'' . $this->format_filesize($file_info['non_image']['size']) . '\', \'' . $this->format_timestamp($file_info['non_image']['lastmod']) . '\'';

			if (!empty($file_info['non_image_thumb']) && empty($file_info['non_image_thumb_error'])) {
				$thumb_image = '<img src="' . $file_info['non_image_thumb']['url'] . '" alt="' . $name . '" title="' . $name . '" />';
				$code .= ', \'' . $file_info['non_image_thumb']['url'] . '\'';
			} else {
// Work on ERROR Thumb Code
				$thumb_image = '<img src="' . $file_info['non_image_thumb']['url'] . '" alt="' . $file_info['non_image_thumb_error'] . '" title="' . $name . '" />';
				$code .= ', \'' . $file_info['non_image_thumb']['url'] . '\'';
			}

			$code .= ', \'' . $this->options['align'] . '\', \'' . $this->options['make_linkable'] . '\', \'' . $this->options['open_to'] . '\', \'\', \'\', \'' . $this->options['center'] . '\', \'' . $this->options['status_bar'] . '\', \'' . $this->options['menu_bar'] . '\', \'' . $this->options['location_bar'] . '\', \'' . $this->options['tool_bar'] . '\', \'' . $this->options['scroll_bars'] . '\', \'' . $this->options['resizable'] . '\', \'' . $this->options['focus_after_add'] . '\', \'' . $this->options['close_after_add'] . '\'';
		} else {
// Work on ERROR Return Code!
			return 'ERROR!';
		}

/*
Album / Libary Code
	if ($fp_options['library'] == true) {
		$code_settings = '\'' . $results['image'][0] . '\', \'' . $fp_options['library_file_link'] . $_POST['target_directory'] . $results['image'][0] . '\', \'' . $results['image'][3] . '\', \'' . $results['image'][4] . '\', \'' . $results['thumb'][0] . '\', \'' . $results['thumb'][2] . '\', \'' . $results['thumb'][3] . '\', \'' . $results['thumb'][4] . '\', \'' . $fp_options['align'] . '\'';
	} else {
		$code_settings = '\'' . $results['image'][0] . '\', \'' . $results['image'][2] . '\', \'' . $results['image'][3] . '\', \'' . $results['image'][4] . '\', \'' . $results['thumb'][0] . '\', \'' . $results['thumb'][2] . '\', \'' . $results['thumb'][3] . '\', \'' . $results['thumb'][4] . '\', \'' . $fp_options['align'] . '\'';
	}

	if ($fp_options['library'] == true) {
		$code_settings = '\'' . $results['image'][0] . '\', \'' . $fp_options['library_file_link'] . $_POST['target_directory'] . $results['image'][0] . '\', \'' . $results['image'][3] . '\', \'' . $results['image'][4] . '\', \'' . $results['image'][0] . '\', \'' . $results['non_image_thumb'][2] . '\', \'' . $results['non_image_thumb'][3] . '\', \'' . $results['non_image_thumb'][4] . '\', \'' . $fp_options['align'] . '\'';
	} else {
		$code_settings = '\'' . $results['image'][0] . '\', \'' . $results['image'][2] . '\', \'' . $results['image'][3] . '\', \'' . $results['image'][4] . '\', \'' . $results['image'][0] . '\', \'' . $results['non_image_thumb'][2] . '\', \'' . $results['non_image_thumb'][3] . '\', \'' . $results['non_image_thumb'][4] . '\', \'' . $fp_options['align'] . '\'';
	}

	if ($fp_options['library'] == true) {
		$code_settings = '\'' . $results['image'][0] . '\', \'' . $fp_options['library_file_link'] . $_POST['target_directory'] . $results['image'][0] . '\', \'' . $results['image'][3] . '\', \'' . $results['image'][4] . '\', \'' . $results['image'][0] . '\', \'\', \'\', \'\', \'' . $fp_options['align'] . '\'';
	} else {
		$code_settings = '\'' . $results['image'][0] . '\', \'' . $results['image'][2] . '\', \'' . $results['image'][3] . '\', \'' . $results['image'][4] . '\', \'' . $results['image'][0] . '\', \'\', \'\', \'\', \'' . $fp_options['align'] . '\'';
	}

	if ($fp_options['library'] == true) {
		$code_settings = '\'' . $results['non_image'][0] . '\', \'' . $fp_options['library_file_link'] . $_POST['target_directory'] . $results['non_image'][0] . '\', \'\', \'\', \'' . $results['non_image'][0] . '\', \'' . $results['non_image_thumb'][2] . '\', \'' . $results['non_image_thumb'][3] . '\', \'' . $results['non_image_thumb'][4] . '\', \'' . $fp_options['align'] . '\'';
	} else {
		$code_settings = '\'' . $results['non_image'][0] . '\', \'' . $results['non_image'][2] . '\', \'\', \'\', \'' . $results['non_image'][0] . '\', \'' . $results['non_image_thumb'][2] . '\', \'' . $results['non_image_thumb'][3] . '\', \'' . $results['non_image_thumb'][4] . '\', \'' . $fp_options['align'] . '\'';
	}

	if ($fp_options['library'] == true) {
		$code_settings = '\'' . $results['non_image'][0] . '\', \'' . $fp_options['library_file_link'] . $_POST['target_directory'] . $results['non_image'][0] . '\', \'\', \'\', \'' . $results['non_image'][0] . '\', \'\', \'\', \'\', \'' . $fp_options['align'] . '\'';
	} else {
		$code_settings = '\'' . $results['non_image'][0] . '\', \'' . $results['non_image'][2] . '\', \'\', \'\', \'' . $results['non_image'][0] . '\', \'\', \'\', \'\', \'' . $fp_options['align'] . '\'';
	}
*/

?>
					<script type="text/javascript" language="javascript">
						files_listing['<?php echo $name; ?>'] = new Array(<?php echo $code; ?>);
					</script>
					<td id="<?php echo $name; ?>" onclick="load_info('<?php echo $name; ?>');" ondblclick="load_default_action('<?php echo $name; ?>');">
						<?php echo $thumb_image; ?><br />
						<strong><?php echo $name; ?></strong>
					</td>
<?php
	}



	// Browse Page
//	public
	function browse_page($info_message = false) {
/* Not yet!
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<input type="hidden" name="fp_dir_path" value="<?php echo $_REQUEST['fp_dir_path']; ?>">
	Sorted by: <select name="sortby" id="sortby" size="1">
		<option value='mtime_desc' selected='selected'>last modification (newer first)</option>
		<option value='mtime_asc'>last modification (older first)</option>
		<option value='name_asc'>name (A-z)</option>
		<option value='name_desc'>name (z-A)</option>
	</select>
	<input type='submit' value='Resort' />
</form>
*/
		if (!empty($this->path_abs)) {
			$previous_path = explode($this->dir_sep, $this->path_abs);
			$current_folder = $previous_path[count($previous_path) - 2];
			unset($previous_path[count($previous_path) - 2]);
			$previous_path = implode($this->dir_sep, $previous_path);
			$current_folder = $this->path_info($current_folder, $previous_path, $this->path_secure($previous_path, false, true));
		} else {
			$current_folder['folder'] = array(
												'name'		=> 'root',
												'abs'		=> $this->options['home_abs'],
												'url'		=> $this->options['home_url'],
												'path'		=> '',
												'size'		=> filesize($this->options['home_abs']),
												'lastmod'	=> filemtime($this->options['home_abs'])
											);
		}
?>
<div id="top_menu">
	<div id="logo" class="logo"><a class="button_link" href="http://aboutme.lmbbox.com/lmbbox-plugins/lmbbox-filepress/" target="_blank" title="LMB^Box FilePress">LMB^Box FilePress Site</a></div>
	<br />
<!--	<div id="jscoolmenu"></div> //-->
	<script type="text/javascript" language="javascript">
	<!--
	//	cmDraw('jscoolmenu', jscoolmenu, 'hbr', cm_lmbbox_filepress, 'lmbbox_filepress');
	//-->
	</script>
</div>
<table id="layout" cellspacing="10">
<?php
		if ($info_message !== false) {
?>
	<tr title="Click To Close!" onclick="this.style.display = 'none';">
		<td class="info_message" colspan="2"><?php echo $info_message; ?></td>
	</tr>
<?php
		}
?>
	<tr>
		<td class="address_bar" colspan="2"><?php echo $this->folder_menu($this->path_abs); ?></td>
	</tr>
	<tr>
		<td class="left_panel">
			<div class="title"><a href="javascript:panel_toggle('details');" title="Collapse / Expand"><img id="details_toggle" src="images/<?php echo (!empty($_COOKIE['details_toggle']) ? $_COOKIE['details_toggle'] : 'collapse'); ?>.gif" alt="Collapse / Expand" title="Collapse / Expand" /></a>Details</div>
			<div class="panel" id="details"<?php echo ($_COOKIE['details_toggle'] == 'expand' ? ' style="display: none;"' : ''); ?>>
				<span id="default_details">
					<strong>[<?php echo $current_folder['folder']['name']; ?>]</strong><br />
					- folder -<br />
					Size: <?php echo $this->format_filesize($current_folder['folder']['size']); ?><br />
					Date Modified: <?php echo $this->format_timestamp($current_folder['folder']['lastmod']); ?> 
				</span>
				<span id="generated_details" style="display: none;"></span>
			</div>
			<div class="title"><a href="javascript:panel_toggle('add_post');" title="Collapse / Expand"><img id="add_post_toggle" src="images/<?php echo (!empty($_COOKIE['add_post_toggle']) ? $_COOKIE['add_post_toggle'] : 'collapse'); ?>.gif" alt="Collapse / Expand" title="Collapse / Expand" /></a>Add To Post</div>
			<div class="panel" id="add_post"<?php echo ($_COOKIE['add_post_toggle'] == 'expand' ? ' style="display: none;"' : ''); ?>>
				<span id="default_add_post"><img src="images/info2.gif" alt="Icon" title="Please Select File To Add To Post." />No File Selected!</span>
				<form id="add_post_form" name="add_post_form" style="display: none;">
					<div id="add_post_form_image">
						<label title="Add Thumbnial Image In Post"><input type="radio" name="action" value="0" onclick="add_post_load_fields(this.value)" /> : Add Thumbnail</label><br />
						<label title="Add Full Image In Post"><input type="radio" name="action" value="1" onclick="add_post_load_fields(this.value)" /> : Add Full Image</label><br />
						<label title="Add Only Link, No Image / Thumbnail In Post"><input type="radio" name="action" value="2" onclick="add_post_load_fields(this.value)" /> : Add Image Link</label>
					</div>
					<div id="add_post_form_non_image">
						<label title="Add Non-Image Thumbnail With Link In Post"><input type="radio" name="action" value="3" onclick="add_post_load_fields(this.value)" /> : Add Non-Image Thumbnail Link</label><br />
						<label title="Add Only Link In Post"><input type="radio" name="action" value="4" onclick="add_post_load_fields(this.value)" /> : Add File Link</label><br />
						<label title="Embed File In Post &raquo; Example: wma, wmv, mp3, mpg, mov, swf, etc."><input type="radio" name="action" value="5" onclick="add_post_load_fields(this.value)" /> : Embed File</label>
					</div>
					<div id="add_post_form_make_linkable">
						<label title="Make Full Image or Thumbnail Linkable"><input type="checkbox" name="make_linkable" onclick="add_post_load_fields(this.value)" /> : Make Linkable</label>
					</div>
					<div id="add_post_form_open_to">
						<label title="Open in the Same Window"><input type="radio" name="open_to" value="open_same" onclick="add_post_load_fields(this.value)" /> : Same Window</label><br />
						<label title="Open in a New Window"><input type="radio" name="open_to" value="open_new" onclick="add_post_load_fields(this.value)" /> : New Window</label><br />
						<label title="Open in a Popup Window"><input type="radio" name="open_to" value="open_popup" onclick="add_post_load_fields(this.value)" /> : Popup Window</label><br />
						<div id="add_post_form_open_popup">
							<label><input type="text" name="width" size="5" value="" onchange="if (document.add_post_form.center.checked) { document.add_post_form.left.value = ((screen.width - this.value) / 2); }" /> : Width</label><br />
							<label><input type="text" name="height" size="5" value="" onchange="if (document.add_post_form.center.checked) { document.add_post_form.top.value = ((screen.height - this.value) / 2); }" /> : Height</label><br />
							<label><input type="text" name="left" size="5" value="" onchange="document.add_post_form.center.checked = false;" /> : Left</label><br />
							<label><input type="text" name="top" size="5" value="" onchange="document.add_post_form.center.checked = false;" /> : Top</label><br />
							<label><input type="checkbox" name="center" onclick="if (this.checked) { document.add_post_form.left.value = ((screen.width - document.add_post_form.width.value) / 2); document.add_post_form.top.value = ((screen.height - document.add_post_form.height.value) / 2); } else { document.add_post_form.left.value = ''; document.add_post_form.top.value = ''; }" /> : Center Popup</label><br />
							<br /><u>What Should I Show :</u><br />
							<label><input type="checkbox" name="status_bar" /> : Status Bar</label><br /><label><input type="checkbox" name="tool_bar" /> : Tool Bar</label><br />
							<label><input type="checkbox" name="menu_bar" /> : Menu Bar</label><br /><label><input type="checkbox" name="scroll_bars" /> : Scroll Bars</label><br />
							<label><input type="checkbox" name="location_bar" /> : Location Bar</label><br /><label><input type="checkbox" name="resizable" /> : Resizable</label>
						</div>
					</div>
					<div id="add_post_form_embeded">Embeded Settings Here : </div>

					<label>Discription to use for link : <input type="text" name="discription" size="25" value="" /></label>
					<input type="button" name="add_to_post" value="Add File to Post!" onclick="add_post_create_code();" /><br />
					<label title="Focus Admin Write Page Window After Add"><input type="checkbox" name="focus_after_add" value="true" /> : Focus Admin Page</label><br />
					<label title="Close FilePress Window After Add"><input type="checkbox" name="close_after_add" value="true" /> : Close FilePress</label>
				</form>
			</div>
			<div class="title"><a href="javascript:panel_toggle('tasks');" title="Collapse / Expand"><img id="tasks_toggle" src="images/<?php echo (!empty($_COOKIE['tasks_toggle']) ? $_COOKIE['tasks_toggle'] : 'collapse'); ?>.gif" alt="Collapse / Expand" title="Collapse / Expand" /></a>File And Folder Tasks</div>
			<div class="panel" id="tasks"<?php echo ($_COOKIE['tasks_toggle'] == 'expand' ? ' style="display: none;"' : ''); ?>>
				<span id="default_tasks">
					<a href="filepress: Create Folder" onclick="load_action('create_folder'); return false;" title="Create Folder"><img src="images/folder_new.gif" alt="Icon" title="Create Folder" />Create Folder</a><br />
					<a href="filepress: Create File" onclick="load_action('create_file'); return false;" title="Create File"><img src="images/file_new.gif" alt="Icon" title="Create File" />Create File</a><br />
					<a href="filepress: Upload File" onclick="load_action('upload_file'); return false;" title="Upload File"><img src="images/upload.gif" alt="Icon" title="Create File" />Upload File</a><br />
				</span>
				<span id="actions_tasks" style="display: none;">
					<span id="previous_folder_tasks" style="display: none;"><a href="#Open Previous Folder" onclick="load_action('open_folder'); return false;" title="Open Previous Folder"><img src="images/folder_back2.gif" alt="Icon" title="Open Previous Folder" />Open Previous Folder</a></span>
					<span id="folder_tasks" style="display: none;">
						<a href="filepress: Open Folder" onclick="load_action('open_folder'); return false;" title="Open Folder"><img src="images/folder_open.gif" alt="Icon" title="Open Folder" />Open Folder</a><br />
						<a href="filepress: Rename Folder" onclick="load_action('rename_folder'); return false;" title="Rename Folder"><img src="images/folder_rename.gif" alt="Icon" title="Rename Folder" />Rename Folder</a><br />
						<a href="filepress: Move Folder" onclick="load_action('move_folder'); return false;" title="Move Folder"><img src="images/folder_move.gif" alt="Icon" title="Move Folder" />Move Folder</a><br />
						<a href="filepress: Copy Folder" onclick="load_action('copy_folder'); return false;" title="Copy Folder"><img src="images/folder_copy.gif" alt="Icon" title="Copy Folder" />Copy Folder</a><br />
						<a href="filepress: Delete Folder" onclick="load_action('delete_folder'); return false;" title="Delete Folder"><img src="images/folder_delete.gif" alt="Icon" title="Delete Folder" />Delete Folder</a><br />
					</span>
					<span id="image_tasks" style="display: none;">
						<a href="filepress: View File" onclick="load_action('view_file'); return false;" title="View File"><img src="images/file_view.gif" alt="Icon" title="View File" />View File</a><br />
						<a href="filepress: Edit File" onclick="load_action('edit_file'); return false;" title="Edit File"><img src="images/file_edit.gif" alt="Icon" title="Edit File" />Edit File</a><br />
						<a href="filepress: Rename File" onclick="load_action('rename_file'); return false;" title="Rename File"><img src="images/file_rename.gif" alt="Icon" title="Rename File" />Rename File</a><br />
						<a href="filepress: Resize Image" onclick="load_action('resize_image'); return false;" title="Resize Image"><img src="images/file_resize.gif" alt="Icon" title="Resize Image" />Resize Image</a><br />
						<a href="filepress: Rotate Image CW" onclick="load_action('rotate_cw_image'); return false;" title="Rotate Image CW"><img src="images/file_rotate_cw.gif" alt="Icon" title="Rotate Image CW" />Rotate Image CW</a><br />
						<a href="filepress: Rotate Image CCW" onclick="load_action('rotate_ccw_image'); return false;" title="Rotate Image CCW"><img src="images/file_rotate_ccw.gif" alt="Icon" title="Rotate Image CCW" />Rotate Image CCW</a><br />
						<a href="filepress: Move File" onclick="load_action('move_file'); return false;" title="Move File"><img src="images/file_move.gif" alt="Icon" title="Move File" />Move File</a><br />
						<a href="filepress: Copy File" onclick="load_action('copy_file'); return false;" title="Copy File"><img src="images/file_copy.gif" alt="Icon" title="Copy File" />Copy File</a><br />
						<a href="filepress: Delete File" onclick="load_action('delete_file'); return false;" title="Delete File"><img src="images/file_delete.gif" alt="Icon" title="Delete File" />Delete File</a><br />
					</span>
					<span id="non_image_tasks" style="display: none;">
						<a href="filepress: View File" onclick="load_action('view_file'); return false;" title="View File"><img src="images/file_view.gif" alt="Icon" title="View File" />View File</a><br />
						<a href="filepress: Edit File" onclick="load_action('edit_file'); return false;" title="Edit File"><img src="images/file_edit.gif" alt="Icon" title="Edit File" />Edit File</a><br />
						<a href="filepress: Rename File" onclick="load_action('rename_file'); return false;" title="Rename File"><img src="images/file_rename.gif" alt="Icon" title="Rename File" />Rename File</a><br />
						<span title="Resize Image"><img src="images/disabled_file_resize.gif" alt="Icon" title="Resize Image" />Resize Image</span><br />
						<span title="Rotate Image CW"><img src="images/disabled_file_rotate_cw.gif" alt="Icon" title="Rotate Image CW" />Rotate Image CW</span><br />
						<span title="Rotate Image CCW"><img src="images/disabled_file_rotate_ccw.gif" alt="Icon" title="Rotate Image CCW" />Rotate Image CCW</span><br />
						<a href="filepress: Move File" onclick="load_action('move_file'); return false;" title="Move File"><img src="images/file_move.gif" alt="Icon" title="Move File" />Move File</a><br />
						<a href="filepress: Copy File" onclick="load_action('copy_file'); return false;" title="Copy File"><img src="images/file_copy.gif" alt="Icon" title="Copy File" />Copy File</a><br />
						<a href="filepress: Delete File" onclick="load_action('delete_file'); return false;" title="Delete File"><img src="images/file_delete.gif" alt="Icon" title="Delete File" />Delete File</a><br />
					</span>
				</span>
				<span id="forms_tasks" style="display: none;">
					<span id="create_folder_tasks" style="display: none;">
						<form name="manage_folder_create" id="manage_folder_create" action="" method="post">
							<input type="hidden" name="action" value="manage_folder" />
							<input type="hidden" name="path" value="<?php echo $this->path_abs; ?>" />
							<input type="hidden" name="manage_folder_action" value="create" />
							<h2>Create Folder</h2>
							<label>New Folder: <input type="text" name="target" id="target" value="" /></label><br />
							<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks('default_tasks');" /> <input type="submit" name="submit" value="Create Folder &raquo;" />
						</form>
					</span>
					<span id="create_file_tasks" style="display: none;">
						<form name="manage_file_create" id="manage_file_create" action="" method="post">
							<input type="hidden" name="action" value="manage_file" />
							<input type="hidden" name="path" value="<?php echo $this->path_abs; ?>" />
							<input type="hidden" name="manage_file_action" value="create" />
							<h2>Create File</h2>
							<label>New File: <input type="text" name="target" id="target" value="" /></label><br />
							<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks('default_tasks');" /> <input type="submit" name="submit" value="Create File &raquo;" />
						</form>
					</span>
					<span id="upload_file_tasks" style="display: none;">
						<form name="manage_file_upload" id="manage_file_upload" action="" method="post" enctype="multipart/form-data">
							<input type="hidden" name="action" value="manage_file" />
							<input type="hidden" name="path" value="<?php echo $this->path_abs; ?>" />
							<input type="hidden" name="manage_file_action" value="upload" />
							<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $this->convert_shortsize($this->options['max_size']); ?>" />
							<h2>Upload File</h2>
							Allowed File Extenstions: "<code><?php echo (!empty($this->options['allowed_types'][0]) ? implode(', ', $this->options['allowed_types']) : 'any'); ?></code>"<br />
							Max File Size: "<code><?php echo (!empty($this->options['max_size']) ? $this->format_filesize($this->convert_shortsize($this->options['max_size'])) : 'unlimited'); ?></code>"<br />
							If you're an admin you can configure these values under "Miscellaneous Options".<br />
							<br />
							<input type="radio" name="upload_type" id="upload_type" value="fetch" onclick="if (this.checked) { document.manage_file_upload.file_url.disabled = false; document.manage_file_upload.user_file.disabled = true; document.manage_file_upload.file_url.focus(); }" />
							<label onclick="document.manage_file_upload.upload_type[0].click();">URL Of File To Fetch: <input type="text" name="file_url" id="file_url" value="" size="30" disabled="disabled" onblur="get_file_name(document.manage_file_upload.target, this.value);" onchange="get_file_name(document.manage_file_upload.target, this.value);" onfocus="get_file_name(document.manage_file_upload.target, this.value);" onkeyup="get_file_name(document.manage_file_upload.target, this.value);" /></label><br />
							<strong> - Or - </strong><br />
							<input type="radio" name="upload_type" id="upload_type" value="upload" onclick="if (this.checked) { document.manage_file_upload.file_url.disabled = true; document.manage_file_upload.user_file.disabled = false; document.manage_file_upload.user_file.focus(); }" />
							<label onclick="document.manage_file_upload.upload_type[1].click();">Select File To Upload: <input type="file" name="user_file" id="user_file" disabled="disabled" onblur="get_file_name(document.manage_file_upload.target, this.value);" onchange="get_file_name(document.manage_file_upload.target, this.value);" onfocus="get_file_name(document.manage_file_upload.target, this.value);" onkeyup="get_file_name(document.manage_file_upload.target, this.value);" /></label><br />
							<label>Save File As: <input type="text" name="target" id="target" value="" size="30" /></label><br />
							<input type="button" name="cancel" value="&laquo; Cancel" onclick="switch_display_tasks('default_tasks');" /> <input type="submit" name="submit" value="Upload File &raquo;" />
						</form>
					</span>
					<span id="generated_tasks" style="display: none;"></span>
				</span>
			</div>
			<div class="title"><a href="javascript:panel_toggle('places');" title="Collapse / Expand"><img id="places_toggle" src="images/<?php echo (!empty($_COOKIE['places_toggle']) ? $_COOKIE['places_toggle'] : 'collapse'); ?>.gif" alt="Collapse / Expand" title="Collapse / Expand" /></a>Other Places</div>
			<div class="panel" id="places"<?php echo ($_COOKIE['places_toggle'] == 'expand' ? ' style="display: none;"' : ''); ?>>
				<a href="?path=" title="[root] Folder"><img src="images/folder_open.gif" alt="Icon" title="[root] Folder" />[root] Folder</a><br />
				<a href="javascript:void(0);" title="FilePress Plugin"><img src="images/info.gif" alt="Icon" title="FilePress Plugin" />FilePress Plugin</a>
			</div>
		</td>
		<td class="right_panel">
			<table id="browse_listing" cellspacing="5">
<?php
		if (!empty($this->path_abs)) {
			if (!$switch_pos) { echo "\t\t\t\t<tr>\n"; }
?>
					<script type="text/javascript" language="javascript">
						files_listing['!previous_folder'] = new Array('previous_folder', '<?php echo addslashes($previous_path); ?>');
					</script>
					<td id="!previous_folder" onclick="load_info('!previous_folder');" ondblclick="load_default_action('!previous_folder')">
						<img src="images/folder_back.gif" alt="Previous Folder" title="Previous Folder"><br>
						<strong>Previous Folder</strong>
					</td>
<?php
			if ($switch_pos) { echo "\t\t\t\t</tr>\n"; }
			$switch_pos = ($switch_pos ? false : true);
		}

		$path_listing = $this->browse_path($this->path_abs);
		if (is_array($path_listing['folders'])) {
			foreach($path_listing['folders'] as $folder) {
				if (!$switch_pos) { echo "\t\t\t\t<tr>\n"; }
				$this->display($folder);
				if ($switch_pos) { echo "\t\t\t\t</tr>\n"; }
				$switch_pos = ($switch_pos ? false : true);
			}
		} else {
			if (!$switch_pos) { echo "\t\t\t\t<tr>\n"; }
?>
					<td class="disabled">
						<img src="images/disabled_folder.gif" alt="Disabled Folder!" title="Disabled Folder!"><br>
						<strong><?php echo $path_listing['folders']; ?></strong>
					</td>
<?php
			if ($switch_pos) { echo "\t\t\t\t</tr>\n"; }
			$switch_pos = ($switch_pos ? false : true);
		}
		if (is_array($path_listing['files'])) {
			foreach($path_listing['files'] as $file) {
				if (!$switch_pos) { echo "\t\t\t\t<tr>\n"; }
				$this->display($file);
				if ($switch_pos) { echo "\t\t\t\t</tr>\n"; }
				$switch_pos = ($switch_pos ? false : true);
			}
		} else {
			if (!$switch_pos) { echo "\t\t\t\t<tr>\n"; }
?>
					<td class="disabled">
						<img src="images/disabled_file.gif" alt="Disabled File!" title="Disabled File!"><br>
						<strong><?php echo $path_listing['files']; ?></strong>
					</td>
<?php
			if ($switch_pos) { echo "\t\t\t\t</tr>\n"; }
			$switch_pos = ($switch_pos ? false : true);
		}
?>
			</table>
			<div id="generated_listing" style="display: none;"></div>
		</td>
	</tr>
</table>
<?php
	} // End of function browse_page

	// manage_folder
//	public
	function manage_folder($manage_folder_action, $folder = false, $target = false, $force_delete = false) {
		switch ($manage_folder_action) {
			case 'create':
				$info_message = '<strong>Creating Folder ...</strong><br />';
				$info_message .= $this->create_folder($this->path_abs, $target);
				$info_message .= '<strong>Done Creating Folder Process</strong>';
				break;
			case 'rename':
				$info_message = '<strong>Renaming Folder ...</strong><br />';
				$info_message .= $this->rename_folder($this->path_abs, $folder, $target);
				$info_message .= '<strong>Done Renaming Folder Process</strong>';
				break;
			case 'move':
				$info_message = 'Sorry, Move Folder Not Ready Yet!';
				break;
			case 'copy':
				$info_message = 'Sorry, Copy Folder Not Ready Yet!';
				break;
			case 'delete':
				$info_message = '<strong>Deleting Folder ...</strong><br />';
				$info_message .= $this->delete_folder($this->path_abs, $folder, $force_delete);
				$info_message .= '<strong>Done Deleting Folder Process</strong>';
				break;
			default:
				$info_message = '<strong>manage_folder() Called Incorrectly! Nothing Done!</strong>';
				break;
		}
		$this->browse_page($info_message);
	}

	// manage_file
//	public
	function manage_file($manage_file_action, $file = false, $upload_type = false, $file_url = false, $target = false, $width = false, $height = false) {
		switch ($manage_file_action) {
			case 'upload':
				$info_message = '<strong>Fetching/Uploading File ...</strong><br />';
				$info_message .= $this->upload_file($this->path_abs, $upload_type, $file_url, $target);
				$info_message .= '<strong>Done Fetching/Uploading File Process</strong>';
				break;
			case 'create':
				$info_message = 'Sorry, Create File Not Ready Yet!';
				break;
			case 'rename':
				$info_message = '<strong>Renaming File ...</strong><br />';
				$info_message .= $this->rename_file($this->path_abs, $file, $target);
				$info_message .= '<strong>Done Renaming File Process</strong>';
				break;
			case 'resize':
				$info_message = '<strong>Resizing File ...</strong><br />';
				$info_message .= $this->resize_file($this->path_abs, $file, $width, $height);
				$info_message .= '<strong>Done Resizing File Process</strong>';
				break;
			case 'rotate_cw':
				$info_message = '<strong>Rotating File ...</strong><br />';
				$info_message .= $this->rotate_file($this->path_abs, $file, 90);
				$info_message .= '<strong>Done Rotating File Process</strong>';
				break;
			case 'rotate_ccw':
				$info_message = '<strong>Rotating File ...</strong><br />';
				$info_message .= $this->rotate_file($this->path_abs, $file, -90);
				$info_message .= '<strong>Done Rotating File Process</strong>';
				break;
			case 'move':
				$info_message = 'Sorry, Move File Not Ready Yet!';
				break;
			case 'copy':
				$info_message = 'Sorry, Copy File Not Ready Yet!';
				break;
			case 'delete':
				$info_message = '<strong>Deleting File ...</strong><br />';
				$info_message .= $this->delete_file($this->path_abs, $file);
				$info_message .= '<strong>Done Deleting File Process</strong>';
				break;
			default:
				$info_message = '<strong>manage_file() Called Incorrectly! Nothing Done!</strong>';
				break;
		}
		$this->browse_page($info_message);
	}
}
// END - Class lmbbox_filepress_class

?>
