Mage2 Module Experius WysiwygDownloads
====================

This module makes it possible to upload different filetypes inside the WYSIWYG-editor. 

   ``experius/module-wysiwygdownloads``
   
 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Additional Information](#markdown-header-additional-information)
 - [Change og](#markdown-header-change-log)

# Main Functionalities

The following filetypes are available by default and it is possible to add extra filetypes to the allowed filetypes in the configuration of the module (General > Content Management > WYSIWYG Options > Extra Allowed Filetypes):
 
 - Word (doc, docm, docx)
 - Excel (csv, xml, xls, xlsx)
 - PDF (pdf)
 - Compressed Folder (zip, tar)

Use the following instructions to upload a file and set a download link:
  
 
 ---

# Additional Information


1. Go to a WYSIWYG-editor (for example in the content of a CMS Page or a product textarea attribute)
2. Select a part of the text which is used as a Download Link (it is also possible to add the Download Link to an Image)
3. Click on the 'Insert/Edit Link'-button (under the textformat dropdown, do not use the 'Insert/Edit Image'-button)
4. Click on the 'Browse'-icon behind the Link URL-inputfield
5. Select the Folder in which you want to upload the Downloadable File (recommended is to create a new Downloads folder to store all the Downloadable Files)
6. Click the 'Browse files'-button
7. Select the File from your Documents and click on the 'Open/Insert'-button
8. Select the Uploaded File
9. Click on the 'Insert File'-button
10. (The 'File Upload'-windows will automatically close)
11. It is recommended to set the Target to 'Open Link in a New Window)
11. Press on the 'Insert'-button in the 'Insert/Edit Link'-popup
12. The part of the text which was selected is now a Download Link for the selected file

To Unlink the Downloadable File just set the cursor on the Download Link and Click on the 'Unlink'-button.

 ---


Add NGINX redirect is you use it as internal URL else where and use store_code in url

```
    if ( $request_uri ~ ^/(.+)/media/wysiwyg/PDF/(.*)(.pdf$|.PDF$) ) {
            rewrite ^/(.+)/media/wysiwyg/PDF/(.*)(.pdf$|.PDF$) /media/wysiwyg/PDF/$2$3;
    }
```

 ---

# Change log

Version 1.0.5 - June. 7, 2017 | Lewis Voncken

 * [TASK] Updated README.md with nginx redirect for internal url with storecodes

---

Version 1.0.4 - May. 18, 2017 | Lewis Voncken

 * [BUGFIX] Solved error message Unsupported image format

---

Version 1.0.3 - Sep. 23, 2016 | Lewis Voncken

 * [TASK] Changed README
 * [TASK] Added Open Software License

---

Version 1.0.2 - Sep. 19, 2016 | Lewis Voncken

 * [TASK] Version update to 1.0.2 added configuration option to add more allowed filetypes beside the Default Extra Filetypes

---

Version 1.0.1 - Sep. 17, 2016 | Lewis Voncken

 * [TASK] Changed the logic so file extensions can be added in the configuration

---

Version 1.0.0 - Sep. 16, 2016 | Lewis Voncken

 * Initial Commit

---
