Mage2 Module Experius WysiwygDownloads
====================

This module makes it possible to upload different filetypes inside the WYSIWYG-editor. 

   ``experius/module-wysiwygdownloads``
   
 - [Main Functionalities](#main-functionalities)
 - [Additional Information](#additional-information)
 - [Important Issue in Magento < 2.2](#important-issue-in-magento--22)
 - [Change log](#change-log)

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


Add NGINX redirect if you use it as internal URL else where and use store_code in url

```
    if ( $request_uri ~ ^/(.+)/media/wysiwyg/PDF/(.*)(.pdf$|.PDF$) ) {
            rewrite ^/(.+)/media/wysiwyg/PDF/(.*)(.pdf$|.PDF$) /media/wysiwyg/PDF/$2$3;
    }
```

# Important Issue in Magento < 2.2

## Fix

This is an issue in Magento and is solved in 2.2.2 for more information see the following commit:

https://github.com/magento/magento2/commit/62378774f239c2019e39bdd353c8c6c674b54fb1


## Issue

![bildschirmfoto 2017-09-20 um 16 44 22](https://user-images.githubusercontent.com/30178722/30651034-cd9c998c-9e24-11e7-9f1f-26f777ec0633.png)
![bildschirmfoto 2017-09-20 um 16 49 11](https://user-images.githubusercontent.com/30178722/30651037-ce3745f4-9e24-11e7-9b43-4344691a7ab5.png)

**src is correct:**
`<img src="http://domain.com/pub/media/wysiwyg/.thumbs/home/home-t-shirts.png?rand=1505918839" alt="home-t-shirts.png">`

**src is incorrect:**
`<img src="http://domain.com/admin_111/cms/wysiwyg_images/thumbnail/file/aHRtbC1jaGVhdC1zaGVldC5wbmc-/key/08c5525fa3b16c91f2ad0f757282e78f6abf1f797e8c30628598f1b3824934d8/" alt="html-cheat-sheet.png">`


 ---

# Change log

Version 1.0.8 - Jan 19, 2018 | Lewis Voncken

 * [TASK] Updated README.md and CHANGE.log
   Added Important Issue in Magento < 2.2

---

Version 1.0.7 - Sep 4, 2017 | Lewis Voncken

 * [BUGFIX] Solved problem with Product Image upload => Notice: Undefined index: extension

---

Version 1.0.6 - June 12, 2017 | Derrick Heesbeen

 * [BUGFIX] make it compatible with the Experius FileManager

---

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
