=== LMB^Box FilePress ===
Contributors: lmbbox
Donate link: 
Tags: file, uploading, adding, post, browse, images, documents, code, file
Stable tag: 1.0

FilePress can upload new files, create thumbnails of images, link to files, link to images, include thumbnails / images / certain files, and also include thumbnails / images / certain files with links to the orginal file.

== Description ==

LMB^Box FilePress plugin is the plugin to use if you want / need to upload files (not just Images) to your WP Blog 
and be able to add them to your posts as links, embedded in the post, popup links, or just in the post. There is 
a new button added to the Quicktags Toolbar on the Admin Write Pages: FilePress. You use this button to popup a 
new window to browse, upload, and manage all of you files. LMB^Box FilePress allow you to add your files to your 
posts by selecting how you want to display the file and then click "Add File to Post!" which will add all the code 
needed directly to your post's content. LMB^Box FilePress will try to make thumbnails of all Images that you 
upload and use it to show you what the image file is. If FilePress can't make the thumbnail for an Image or the 
file isn't an Image, it will use a file type default thumbnail image for file display. All settings are made in 
the Admin Panel, in the LMB^Box FilePress and Miscellaneous Options Pages.

== Installation ==

1. Copy the folder lmbbox-filepress into your wp-content/plugins directory
2. Copy the "files" folder to your wp-content/ directory
	2.1 You will need to create a folder on your server where all the files will be uploaded to and set the permissions 
		to 777 (full access). By default, the folder is called files and is in your wp-content/ directory.
3. Activate this plugin in the WordPress Admin Panel
4. Go to your Options -> LMB^Box FilePress Page and make sure to check and set all settings correctly.

#### Uninstallation #### --> Not Yet!
5. If you want to uninstall LMB^Box Comment Quicktags, just deactivate the plugin in your Plugins Page. 
	When you click on deactivate, you will be prompt to if to remove LMB^Box Comment Quicktags Settings. 
	Click Ok/Yes to remove settings or Cancel/No to keep settings.

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

== Screenshots ==



== Change Log ==


	= 1.0 Beta =

	More Info With Next Release! But For Now ...
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

	= 0.9 Beta =

	Almost finish the beta of this plugin!
	Added almost all the features.
	Delete directory is not done yet!
	ToDo: Add file management (rename, resize, delete, etc)!
	ToDo: Finish documentation!

	= 0.1 Beta =

	The Beta release of LMB^Box FilePress!
	Plugin is not complete yet, but I released it to get feedback.
