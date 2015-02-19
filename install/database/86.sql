INSERT INTO 'SETTING' ('settingid','setting','value','fieldType','helptext','options','cat','userChange','title','type','validation','ordering','default','userSee') VALUES
(82,'LIBRARY_MEDIA_DELETEOLDVER_CHECKB','Unchecked','dropdown','Default the checkbox for Deleting Old Version of media when a new file is being uploaded to the library.','Checked|Unchecked','defaults',1,'Default Delete Old Version of media','dropdown','',50,'Checked',1);

UPDATE `version` SET `app_ver` = '1.7.2', `XmdsVersion` = 4, `XlfVersion` = 2;
UPDATE `setting` SET `value` = 0 WHERE `setting` = 'PHONE_HOME_DATE';
UPDATE `version` SET `DBVersion` = '86';