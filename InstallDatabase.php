<?php

// clear database
mysql_query("DROP TABLE IF EXISTS phps_actions");
mysql_query("DROP TABLE IF EXISTS phps_actiontypes");
mysql_query("DROP TABLE IF EXISTS phps_admins");
mysql_query("DROP TABLE IF EXISTS phps_ads");
mysql_query("DROP TABLE IF EXISTS phps_announcements");
mysql_query("DROP TABLE IF EXISTS phps_fields");
mysql_query("DROP TABLE IF EXISTS phps_friendexplains");
mysql_query("DROP TABLE IF EXISTS phps_friends");
mysql_query("DROP TABLE IF EXISTS phps_invites");
mysql_query("DROP TABLE IF EXISTS phps_levels");
mysql_query("DROP TABLE IF EXISTS phps_logins");
mysql_query("DROP TABLE IF EXISTS phps_plugins");
mysql_query("DROP TABLE IF EXISTS phps_pms");
mysql_query("DROP TABLE IF EXISTS phps_profilecomments");
mysql_query("DROP TABLE IF EXISTS phps_profiles");
mysql_query("DROP TABLE IF EXISTS phps_profilestyles");
mysql_query("DROP TABLE IF EXISTS phps_reports");
mysql_query("DROP TABLE IF EXISTS phps_settings");
mysql_query("DROP TABLE IF EXISTS phps_statrefs");
mysql_query("DROP TABLE IF EXISTS phps_stats");
mysql_query("DROP TABLE IF EXISTS phps_subnets");
mysql_query("DROP TABLE IF EXISTS phps_tabs");
mysql_query("DROP TABLE IF EXISTS phps_urls");
mysql_query("DROP TABLE IF EXISTS phps_users");
mysql_query("DROP TABLE IF EXISTS phps_usersettings");





// create table phps_actions
mysql_query("CREATE TABLE `phps_actions` (
  `action_id` int(9) NOT NULL auto_increment,
  `action_actiontype_id` int(9) NOT NULL default '0',
  `action_date` int(14) NOT NULL default '0',
  `action_user_id` int(9) NOT NULL default '0',
  `action_subnet_id` int(9) NOT NULL default '0',
  `action_icon` varchar(50) NOT NULL default '',
  `action_text` text NOT NULL,
  PRIMARY KEY  (`action_id`),
  KEY `action_user_id` (`action_user_id`),
  KEY `action_subnet_id` (`action_subnet_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_actions<br>Error: ".mysql_error());





// create table phps_actiontypes
mysql_query("CREATE TABLE `phps_actiontypes` (
  `actiontype_id` int(9) NOT NULL auto_increment,         
  `actiontype_name` varchar(50) NOT NULL default '',      
  `actiontype_icon` varchar(50) NOT NULL default '',      
  `actiontype_desc` varchar(250) NOT NULL default '',     
  `actiontype_desc_other` varchar(250) default '',        
  `actiontype_enabled` int(1) NOT NULL default '0',       
  `actiontype_text` text NOT NULL,
  PRIMARY KEY  (`actiontype_id`),
  UNIQUE KEY `actiontype_name` (`actiontype_name`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_actiontypes<br>Error: ".mysql_error());


//inserting data into phps_actiontypes
mysql_query("INSERT INTO `phps_actiontypes` (`actiontype_id`, `actiontype_name`, `actiontype_icon`, `actiontype_desc`, `actiontype_desc_other`, `actiontype_enabled`, `actiontype_text`) VALUES 
				(1, 'login', 'action_login.gif', 'When I log in.', 'Logins', 1, '&lt;a href=&#039;Profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; logged in.'),
				(2, 'editphoto', 'action_editphoto.gif', 'When I update my profile photo.', 'Avatar updates', 1, '&lt;a href=&#039;Profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; updated their profile photo.&lt;div style=&#039;padding: 10px 10px 10px 20px;&#039;&gt;&lt;a href=&#039;Profile.php?user=[username]&#039;&gt;&lt;img src=&#039;[photo]&#039; border=&#039;0&#039;&gt;&lt;/a&gt;&lt;/div&gt;'),
				(3, 'editprofile', 'action_editprofile.gif', 'When I update my profile.', 'Profile updates', 1, '&lt;a href=&#039;Profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; updated their profile.'),
				(4, 'postcomment', 'action_postcomment.gif', 'When I post a comment on someone&#039;s profile.', 'Profile comments', 1, '&lt;a href=&#039;Profile.php?user=[username1]&#039;&gt;[username1]&lt;/a&gt; posted a comment on &lt;a href=&#039;Profile.php?user=[username2]&#039;&gt;[username2]&lt;/a&gt;&#039;s profile:&lt;div style=&#039;padding: 10px 20px 10px 20px;&#039;&gt;[comment]&lt;/div&gt;'),
				(5, 'addfriend', 'action_addfriend.gif', 'When I add a friend.', 'Adding a friend.', 1, '&lt;a href=&#039;Profile.php?user=[username1]&#039;&gt;[username1]&lt;/a&gt; and &lt;a href=&#039;Profile.php?user=[username2]&#039;&gt;[username2]&lt;/a&gt; are now friends.'),
				(6, 'signup', 'action_signup.gif', '', 'Signups', 1, '&lt;a href=&#039;Profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; signed up.'),
				(7, 'editstatus', 'action_editstatus.gif', 'When I update my status.', 'Status updates', 1, '&lt;a href=&#039;Profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; is [status]')");




// create table phps_admins
mysql_query("CREATE TABLE `phps_admins` (
  `admin_id` int(9) NOT NULL auto_increment,
  `admin_username` varchar(50) NOT NULL default '',
  `admin_password` varchar(50) NOT NULL default '',
  `admin_name` varchar(50) NOT NULL default '',
  `admin_email` varchar(70) NOT NULL default '',
  `admin_lostpassword_code` varchar(15) NOT NULL default '',
  `admin_lostpassword_time` int(14) NOT NULL default '0',
  PRIMARY KEY  (`admin_id`),
  UNIQUE KEY `UNIQUE` (`admin_username`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_admins<br>Error: ".mysql_error());

//inserting data into DEFAULTS INTO phps_admins
mysql_query("INSERT INTO `phps_admins` (`admin_username`, `admin_password`, `admin_name`, `admin_email`) VALUES ('admin', '$adminPasswordHash', 'Administrator', 'email@domain.com')") or die("Insert: phps_admins<br>Error: ".mysql_error());





// create table phps_ads
mysql_query("CREATE TABLE `phps_ads` (
  `ad_id` int(9) NOT NULL auto_increment,
  `ad_name` varchar(250) NOT NULL default '',
  `ad_date_start` varchar(15) NOT NULL default '',
  `ad_date_end` varchar(15) NOT NULL default '',
  `ad_paused` int(1) NOT NULL default '0',
  `ad_limit_views` int(10) NOT NULL default '0',
  `ad_limit_clicks` int(10) NOT NULL default '0',
  `ad_limit_ctr` varchar(8) NOT NULL default '0',
  `ad_public` int(1) NOT NULL default '0',
  `ad_position` varchar(15) NOT NULL default '',
  `ad_levels` text NOT NULL,
  `ad_subnets` text NOT NULL,
  `ad_html` text NOT NULL,
  `ad_total_views` int(10) NOT NULL default '0',
  `ad_total_clicks` int(10) NOT NULL default '0',
  `ad_filename` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`ad_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_ads<br>Error: ".mysql_error());





// create table phps_announcements
mysql_query("CREATE TABLE `phps_announcements` (
  `announcement_id` int(9) NOT NULL auto_increment,
  `announcement_order` int(9) NOT NULL default '0',
  `announcement_date` varchar(255) NOT NULL default '0',
  `announcement_subject` varchar(255) NOT NULL default '',
  `announcement_body` text NULL,
  PRIMARY KEY  (`announcement_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_announcements<br>Error: ".mysql_error());





// create table phps_fields
mysql_query("CREATE TABLE `phps_fields` (
  `field_id` int(9) NOT NULL auto_increment,
  `field_tab_id` int(9) NOT NULL default '0',
  `field_order` int(3) NOT NULL default '0',
  `field_dependency` int(9) NOT NULL default '0',
  `field_title` varchar(100) NOT NULL default '',
  `field_desc` text,
  `field_error` varchar(250) NOT NULL default '',
  `field_type` int(1) NOT NULL default '0',
  `field_signup` int(1) NOT NULL default '0',
  `field_style` varchar(200) NOT NULL default '',
  `field_maxlength` int(3) NOT NULL default '0',
  `field_link` varchar(250) NOT NULL default '',
  `field_options` text,
  `field_browsable` int(1) NOT NULL default '0',
  `field_required` int(1) NOT NULL default '0',
  `field_regex` varchar(250) NOT NULL default '',
  `field_birthday` int(1) NOT NULL default '0',
  `field_html` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`field_id`),
  KEY `INDEX` (`field_tab_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_fields<br>Error: ".mysql_error());

//inserting data into DEFAULTS INTO phps_fields
mysql_query("INSERT INTO `phps_fields` (`field_id`, `field_tab_id`, `field_order`, `field_dependency`, `field_title`, `field_desc`, `field_error`, `field_type`, `field_signup`, `field_style`, `field_maxlength`, `field_link`, `field_options`, `field_browsable`, `field_required`, `field_regex`, `field_birthday`, `field_html`) VALUES 
(1, 2, 7, 0, 'Country', '', '', 1, 1, '', 50, '', '', 2, 0, '', 0, ''),
(2, 2, 8, 0, 'Phone Number', 'Ex: (888) 555-1234', '', 1, 1, '', 50, '', '', 2, 0, '', 0, ''),
(3, 2, 9, 0, 'Website URL', 'Ex: http://www.yoursite.com', '', 1, 1, '', 50, '[field_value]', '', 2, 0, '', 0, ''),
(4, 2, 6, 0, 'State/Province', '', '', 1, 1, '', 50, '', '', 2, 0, '', 0, ''),
(5, 2, 5, 0, 'City', '', '', 1, 1, '', 50, '', '', 2, 0, '', 0, ''),
(6, 1, 3, 0, 'Gender', '', '', 3, 1, '', 50, '', '0<!>Male<!>0<!><~!~>1<!>Female<!>0<!><~!~>', 2, 0, '', 0, ''),
(7, 2, 4, 0, 'Street Address', '', '', 1, 1, '', 50, '', '', 2, 0, '', 0, ''),
(8, 1, 1, 0, 'Name', '', '', 1, 1, '', 50, '', '', 2, 0, '', 0, ''),
(9, 1, 2, 0, 'Birthday', '', '', 5, 1, '', 50, '', '', 2, 0, '', 1, '')") or die("Insert: phps_fields<br>Error: ".mysql_error());





// create table phps_friendexplains
mysql_query("CREATE TABLE `phps_friendexplains` (
  `friendexplain_id` int(9) NOT NULL auto_increment,
  `friendexplain_friend_id` int(9) NOT NULL default '0',
  `friendexplain_body` text NULL,
  PRIMARY KEY  (`friendexplain_id`),
  KEY `friend_id` (`friendexplain_friend_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_friendexplains<br>Error: ".mysql_error());





// create table phps_friends
mysql_query("CREATE TABLE `phps_friends` (
  `friend_id` int(9) NOT NULL auto_increment,
  `friend_user_id1` int(9) NOT NULL default '0',
  `friend_user_id2` int(9) NOT NULL default '0',
  `friend_status` int(1) NOT NULL default '0',
  `friend_type` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`friend_id`),
  KEY `INDEX` (`friend_user_id1`,`friend_user_id2`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_friends<br>Error: ".mysql_error());





// create table phps_invites
mysql_query("CREATE TABLE `phps_invites` (
  `invite_id` int(9) NOT NULL auto_increment,
  `invite_user_id` int(9) NOT NULL default '0',
  `invite_date` int(14) NOT NULL default '0',
  `invite_email` varchar(70) NOT NULL default '',
  `invite_code` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`invite_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_invites<br>Error: ".mysql_error());








// create table phps_levels
mysql_query("CREATE TABLE `phps_levels` (
  `level_id` int(9) NOT NULL auto_increment,
  `level_name` varchar(50) NOT NULL default '',
  `level_desc` text NOT NULL,
  `level_default` int(1) NOT NULL default '0',
  `level_signup` int(1) NOT NULL default '0',
  `level_message_allow` int(1) NOT NULL default '0',
  `level_message_inbox` int(3) NOT NULL default '0',
  `level_message_outbox` int(3) NOT NULL default '0',
  `level_profile_style` int(1) NOT NULL default '0',
  `level_profile_block` int(1) NOT NULL default '0',
  `level_profile_search` int(1) NOT NULL default '0',
  `level_profile_privacy` varchar(10) NOT NULL default '',
  `level_profile_comments` varchar(10) NOT NULL default '',
  `level_profile_status` int(1) NOT NULL default '0',
  `level_photo_allow` int(1) NOT NULL default '0',
  `level_photo_width` varchar(3) NOT NULL default '',
  `level_photo_height` varchar(3) NOT NULL default '',
  `level_photo_exts` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`level_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_levels<br>Error: ".mysql_error());

//inserting data into DEFAULTS INTO phps_levels
mysql_query("INSERT INTO `phps_levels` (`level_name`, `level_desc`, `level_default`, `level_signup`, `level_message_allow`, `level_message_inbox`, `level_message_outbox`, `level_profile_style`, `level_profile_block`, `level_profile_search`, `level_profile_privacy`, `level_profile_comments`, `level_profile_status`, `level_photo_allow`, `level_photo_width`, `level_photo_height`, `level_photo_exts`) VALUES ('Default Level', '', 1, 0, 1, 100, 50, 1, 1, 1, '012345', '0123456', 1, 1, 200, 200, 'jpg,jpeg,gif,png')") or die("Insert: phps_levels<br>Error: ".mysql_error());








// create table phps_logins
mysql_query("CREATE TABLE `phps_logins` (
  `login_id` int(9) NOT NULL auto_increment,
  `login_email` varchar(70) NOT NULL default '',
  `login_password` varchar(50) NOT NULL default '',
  `login_date` int(14) NOT NULL default '0',
  `login_ip` varchar(15) NOT NULL default '',
  `login_result` int(1) NOT NULL default '0',
  PRIMARY KEY  (`login_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_logins<br>Error: ".mysql_error());








// create table phps_plugins
mysql_query("CREATE TABLE `phps_plugins` (
  `plugin_id` int(9) NOT NULL auto_increment,
  `plugin_name` varchar(100) NOT NULL default '',
  `plugin_version` varchar(4) NOT NULL default '',
  `plugin_type` varchar(30) NOT NULL default '',
  `plugin_desc` text NOT NULL,
  `plugin_icon` varchar(50) NOT NULL default '',
  `plugin_pages_main` text NOT NULL,
  `plugin_pages_level` text NOT NULL,
  `plugin_url_htaccess` text NOT NULL,
  `plugin_search` int(1) DEFAULT 0,
  PRIMARY KEY  (`plugin_id`),
  UNIQUE KEY `plugin_type` (`plugin_type`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_plugins<br>Error: ".mysql_error());








// create table phps_pms
mysql_query("CREATE TABLE `phps_pms` (
  `pm_id` int(9) NOT NULL auto_increment,
  `pm_user_id` int(9) NOT NULL default '0',
  `pm_authoruser_id` int(9) NOT NULL default '0',
  `pm_convo_id` int(9) NOT NULL default '0',
  `pm_date` int(14) NOT NULL default '0',
  `pm_subject` varchar(50) NOT NULL default '',
  `pm_body` text NULL,
  `pm_status` int(1) NOT NULL default '0',
  `pm_outbox` int(1) NOT NULL default '0',
  PRIMARY KEY  (`pm_id`),
  KEY `INDEX` (`pm_user_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_pms<br>Error: ".mysql_error());








// create table phps_profilecomments
mysql_query("CREATE TABLE `phps_profilecomments` (
  `profilecomment_id` int(9) NOT NULL auto_increment,
  `profilecomment_user_id` int(9) NOT NULL default '0',
  `profilecomment_authoruser_id` int(9) NOT NULL default '0',
  `profilecomment_date` int(14) NOT NULL default '0',
  `profilecomment_body` text NULL,
  PRIMARY KEY  (`profilecomment_id`),
  KEY `profilecomment_user_id` (`profilecomment_user_id`,`profilecomment_authoruser_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_profilecomments<br>Error: ".mysql_error());








// create table phps_profiles
mysql_query("CREATE TABLE `phps_profiles` (
  `profile_id` int(9) NOT NULL auto_increment,
  `profile_user_id` int(9) NOT NULL default '0',
  `profile_1` varchar(250) NOT NULL default '',
  `profile_2` varchar(250) NOT NULL default '',
  `profile_3` varchar(250) NOT NULL default '',
  `profile_4` varchar(250) NOT NULL default '',
  `profile_5` varchar(250) NOT NULL default '',
  `profile_6` int(2) NOT NULL default '0',
  `profile_7` varchar(250) NOT NULL default '',
  `profile_8` varchar(250) NOT NULL default '',
  `profile_9` int(14) NOT NULL default '0',
  PRIMARY KEY  (`profile_id`),
  KEY `INDEX` (`profile_user_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_profiles<br>Error: ".mysql_error());








// create table phps_profilestyles
mysql_query("CREATE TABLE `phps_profilestyles` (
  `profilestyle_id` int(9) NOT NULL auto_increment,
  `profilestyle_user_id` int(9) NOT NULL default '0',
  `profilestyle_css` text,
  PRIMARY KEY  (`profilestyle_id`),
  KEY `profilestyle_user_id` (`profilestyle_user_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_profilestyles<br>Error: ".mysql_error());








// create table phps_reports
mysql_query("CREATE TABLE `phps_reports` (
  `report_id` int(9) NOT NULL auto_increment,
  `report_user_id` int(9) NOT NULL default '0',
  `report_url` varchar(250) NOT NULL default '',
  `report_reason` int(1) NOT NULL default '0',
  `report_details` text NULL,
  PRIMARY KEY  (`report_id`),
  KEY `INDEX` (`report_user_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_reports<br>Error: ".mysql_error());







// create table phps_settings
mysql_query("CREATE TABLE `phps_settings` (
  `setting_id` int(9) NOT NULL auto_increment,
  `setting_key` varchar(20) NOT NULL default '',
  `setting_url` int(1) NOT NULL default '1',
  `setting_lang_default` varchar(50) NOT NULL default '',
  `setting_lang_allow` int(1) NOT NULL default '0',
  `setting_timezone` varchar(5) NOT NULL default '',
  `setting_dateformat` varchar(20) NOT NULL default '',
  `setting_timeformat` varchar(20) NOT NULL default '',
  `setting_permission_profile` int(1) NOT NULL default '0',
  `setting_permission_invite` int(1) NOT NULL default '0',
  `setting_permission_search` int(1) NOT NULL default '0',
  `setting_permission_portal` int(1) NOT NULL default '0',
  `setting_banned_ips` text NULL,
  `setting_banned_emails` text NULL,
  `setting_banned_usernames` text NULL,
  `setting_banned_words` text NULL,
  `setting_comment_code` int(1) NOT NULL default '0',
  `setting_connection_allow` int(1) NOT NULL default '0',
  `setting_connection_framework` int(1) NOT NULL default '0',
  `setting_connection_types` text NULL,
  `setting_connection_other` int(1) NOT NULL default '0',
  `setting_connection_explain` int(1) NOT NULL default '0',
  `setting_signup_photo` int(1) NOT NULL default '0',
  `setting_signup_phone` int(1) NOT NULL default '1',
  `setting_signup_enable` int(1) NOT NULL default '0',
  `setting_signup_welcome` int(1) NOT NULL default '0',
  `setting_signup_invite` int(1) NOT NULL default '0',
  `setting_signup_invite_checkemail` int(1) NOT NULL default '0',
  `setting_signup_invite_numgiven` int(3) NOT NULL default '0',
  `setting_signup_invitepage` int(1) NOT NULL default '0',
  `setting_signup_verify` int(1) NOT NULL default '0',
  `setting_signup_code` int(1) NOT NULL default '0',
  `setting_signup_randpass` int(1) NOT NULL default '0',
  `setting_signup_tos` int(1) NOT NULL default '0',
  `setting_signup_tostext` text NULL,
  `setting_invite_code` int(1) NOT NULL default '0',
  `setting_actions_showlength` int(14) NOT NULL default '0',
  `setting_actions_actionsperuser` int(2) NOT NULL default '0',
  `setting_actions_selfdelete` int(2) NOT NULL default '0',
  `setting_actions_privacy` int(1) NOT NULL default '0',
  `setting_actions_actionsonprofile` int(2) NOT NULL default '0',
  `setting_actions_actionsinlist` int(2) NOT NULL default '0',
  `setting_actions_visibility` int(1) NOT NULL default '0',
  `setting_subnet_field1_id` int(9) NOT NULL default '0',
  `setting_subnet_field2_id` int(9) NOT NULL default '0',
  `setting_email_fromname` varchar(70) NOT NULL default '',
  `setting_email_fromemail` varchar(70) NOT NULL default '',
  `setting_email_invitecode_subject` varchar(200) NOT NULL default '',
  `setting_email_invitecode_message` text NULL,
  `setting_email_invite_subject` varchar(200) NOT NULL default '',
  `setting_email_invite_message` text NULL,
  `setting_email_verify_subject` varchar(200) NOT NULL default '',
  `setting_email_verify_message` text NULL,
  `setting_email_newpass_subject` varchar(200) NOT NULL default '',
  `setting_email_newpass_message` text NULL,
  `setting_email_welcome_subject` varchar(200) NOT NULL default '',
  `setting_email_welcome_message` text NULL,
  `setting_email_lostpassword_subject` varchar(200) NOT NULL default '',
  `setting_email_lostpassword_message` text NULL,
  `setting_email_friendrequest_subject` varchar(200) NOT NULL default '',
  `setting_email_friendrequest_message` text NULL,
  `setting_email_message_subject` varchar(200) NOT NULL default '',
  `setting_email_message_message` text NULL,
  `setting_email_profilecomment_subject` varchar(200) NOT NULL default '',
  `setting_email_profilecomment_message` text NULL,
  `homepage_blocks` text NOT NULL,
  `setting_news_page` int(1) NOT NULL default '0',
  PRIMARY KEY  (`setting_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_settings<br>Error: ".mysql_error());

//inserting data into DEFAULTS INTO phps_settings
mysql_query("INSERT INTO `phps_settings` (`setting_id`, `setting_key`, `setting_url`, `setting_lang_default`, `setting_lang_allow`, `setting_timezone`, `setting_dateformat`, `setting_timeformat`, `setting_permission_profile`, `setting_permission_invite`, `setting_permission_search`, `setting_permission_portal`, `setting_banned_ips`, `setting_banned_emails`, `setting_banned_usernames`, `setting_banned_words`, `setting_comment_code`, `setting_connection_allow`, `setting_connection_framework`, `setting_connection_types`, `setting_connection_other`, `setting_connection_explain`, `setting_signup_photo`, `setting_signup_enable`, `setting_signup_welcome`, `setting_signup_invite`, `setting_signup_invite_checkemail`, `setting_signup_invite_numgiven`, `setting_signup_invitepage`, `setting_signup_verify`, `setting_signup_code`, `setting_signup_randpass`, `setting_signup_tos`, `setting_signup_tostext`, `setting_invite_code`, `setting_actions_showlength`, `setting_actions_actionsperuser`, `setting_actions_selfdelete`, `setting_actions_privacy`, `setting_actions_actionsonprofile`, `setting_actions_actionsinlist`, `setting_actions_visibility`, `setting_subnet_field1_id`, `setting_subnet_field2_id`, `setting_email_fromname`, `setting_email_fromemail`, `setting_email_invitecode_subject`, `setting_email_invitecode_message`, `setting_email_invite_subject`, `setting_email_invite_message`, `setting_email_verify_subject`, `setting_email_verify_message`, `setting_email_newpass_subject`, `setting_email_newpass_message`, `setting_email_welcome_subject`, `setting_email_welcome_message`, `setting_email_lostpassword_subject`, `setting_email_lostpassword_message`, `setting_email_friendrequest_subject`, `setting_email_friendrequest_message`, `setting_email_message_subject`, `setting_email_message_message`, `setting_email_profilecomment_subject`, `setting_email_profilecomment_message`, `homepage_blocks`, `setting_news_page`) VALUES (1, '$license', 0, 'english', 0, '-8', 'M. j, Y', 'g:i A', 1, 1, 1, 1, '', '', '', '', 1, 3, 0, 'Friend<!>Co-Worker<!>Family', 1, 1, 1, 1, 1, 0, 0, 5, 1, 0, 1, 0, 1, 'This is the terms of service agreement.', 1, 3600, 3, 1, 1, 7, 15, 1, 0, 8, 'PHPSocial Admin', 'email@domain.com', 'You have received an invitation to join our social network!', 'Hello,\r\n\r\nYou have been invited by [username] to join our social network. To join, please follow the link below and enter your invite code.\r\n\r\n[link]\r\nInvite Code: [code]\r\n\r\nBest Regards,\r\nSocial Network Administration\r\n\r\n----------------------------------------\r\n\r\n[message]', 'You have received an invitation to join our social network.', 'Hello,\r\n\r\nYou have been invited by [username] to join our social network. To join, please follow the link below:\r\n\r\n[link]\r\n\r\nBest Regards,\r\nSocial Network Administration\r\n\r\n----------------------------------------\r\n\r\n[message]', 'Social Network - Email Verification', 'Hello [username],\r\n\r\nThank you for joining our social network. To verify your email address and continue, please click the following link:\r\n\r\n[link]\r\n\r\nBest Regards,\r\nSocial Network Administration', 'Social Network - Login Details', 'Hello [username],\r\n\r\nThank you for joining our social network. Click the following link and enter your information below to login:\r\n\r\n[link]\r\n\r\nEmail: [email]\r\nPassword: [password]\r\n\r\nBest Regards,\r\nSocial Network Administration', 'Welcome to the social network!', 'Hello [username],\r\n\r\nThank you for joining our social network. Click the following link and enter your information below to login:\r\n\r\n[link]\r\n\r\nEmail: [email]\r\nPassword: [password]\r\n\r\nBest Regards,\r\nSocial Network Administration\r\n', 'Social Network - Lost Password', 'Hello [username],\r\n\r\nYou have requested to reset your password because you have forgotten your password. If you did not request this, please ignore it. It will expire in 24 hours.\r\n\r\nTo reset your password, please click the following link:\r\n\r\n[link]\r\n\r\nBest Regards,\r\nSocial Network Administration', '[friendname] has added you as a friend.', 'Hello [username],\r\n\r\n[friendname] has added you as a friend. Please click the following link to login and confirm this friendship request:\r\n\r\n[link]\r\n\r\nBest Regards,\r\nSocial Network Administration', 'You have received a new message.', 'Hello [username],\r\n\r\nYou have just received a new message from [sender]. Please click the following link to login and view it:\r\n\r\n[link]\r\n\r\nBest Regards,\r\nSocial Network Administration', 'New Profile Comment', 'Hello [username],\r\n\r\nA new comment has been posted on your profile by [commenter]. Please click the following link to view it:\r\n\r\n[link]\r\n\r\nBest Regards,\r\nSocial Network Administration', 'a:7:{i:0;s:17:\"Network statistic\";i:1;s:14:\"Newest members\";i:2;s:20:\"Most popular members\";i:3;s:22:\"Members last logged in\";i:4;s:14:\"Members online\";i:5;s:11:\"Recent news\";i:6;s:13:\"Hello message\";}', '0')") or die("Insert: phps_settings<br>Error: ".mysql_error());








// create table phps_statrefs
mysql_query("CREATE TABLE `phps_statrefs` (
  `statref_id` int(9) NOT NULL auto_increment,
  `statref_hits` int(9) NOT NULL default '0',
  `statref_url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`statref_id`),
  UNIQUE KEY `statref_url` (`statref_url`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_statrefs<br>Error: ".mysql_error());








// create table phps_stats
mysql_query("CREATE TABLE `phps_stats` (
  `stat_id` int(9) NOT NULL auto_increment,
  `stat_date` int(9) NOT NULL default '0',
  `stat_views` int(9) NOT NULL default '0',
  `stat_visits` int(9) NOT NULL default '0',
  `stat_logins` int(9) NOT NULL default '0',
  `stat_signups` int(9) NOT NULL default '0',
  `stat_friends` int(9) NOT NULL default '0',
  PRIMARY KEY  (`stat_id`),
  UNIQUE KEY `stat_date` (`stat_date`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_stats<br>Error: ".mysql_error());








// create table phps_subnets
mysql_query("CREATE TABLE `phps_subnets` (
  `subnet_id` int(9) NOT NULL auto_increment,
  `subnet_name` varchar(50) NOT NULL default '',
  `subnet_field1_qual` varchar(2) NOT NULL default '',
  `subnet_field1_value` varchar(250) NOT NULL default '',
  `subnet_field2_qual` varchar(2) NOT NULL default '',
  `subnet_field2_value` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`subnet_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_subnets<br>Error: ".mysql_error());








// create table phps_tabs
mysql_query("CREATE TABLE `phps_tabs` (
  `tab_id` int(9) NOT NULL auto_increment,
  `tab_name` varchar(50) NOT NULL default '',
  `tab_order` int(2) NOT NULL default '0',
  PRIMARY KEY  (`tab_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_tabs<br>Error: ".mysql_error());

//inserting data into DEFAULTS INTO phps_tabs
mysql_query("INSERT INTO `phps_tabs` (`tab_id`, `tab_name`, `tab_order`) VALUES 
('1', 'Personal Information', 1),
('2', 'Contact Information', 2)") or die("Insert: phps_tabs<br>Error: ".mysql_error());








// create table phps_urls
mysql_query("CREATE TABLE `phps_urls` (
  `url_id` int(9) NOT NULL auto_increment,
  `url_title` varchar(100) NOT NULL default '',
  `url_file` varchar(50) NOT NULL default '',
  `url_regular` varchar(200) NOT NULL default '',
  `url_subdirectory` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`url_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_urls<br>Error: ".mysql_error());








// create table phps_users
mysql_query("CREATE TABLE `phps_users` (
  `user_id` int(9) NOT NULL auto_increment,
  `user_level_id` int(9) NOT NULL default '0',
  `user_subnet_id` int(9) NOT NULL default '0',
  `user_email` varchar(70) NOT NULL default '',
  `user_newemail` varchar(70) NOT NULL default '',
  `user_username` varchar(50) NOT NULL default '',
  `user_password` varchar(50) NOT NULL default '',
  `user_code` varchar(8) NOT NULL default '',
  `user_enabled` int(1) NOT NULL default '0',
  `user_verified` int(1) NOT NULL default '0',
  `user_lang` varchar(20) NOT NULL default '',
  `user_signupdate` int(14) NOT NULL default '0',
  `user_lastlogindate` int(14) NOT NULL default '0',
  `user_lastactive` int(14) NOT NULL default '0',
  `user_status` varchar(100) NOT NULL default '',
  `user_logins` int(9) NOT NULL default '0',
  `user_invitesleft` int(3) NOT NULL default '0',
  `user_timezone` varchar(5) NOT NULL default '',
  `user_views_profile` int(9) NOT NULL default '0',
  `user_dateupdated` int(14) NOT NULL default '0',
  `user_blocklist` text NULL,
  `user_photo` varchar(10) NOT NULL default '',
  `user_phone` varchar(100) NOT NULL default '',
  `user_privacy_search` int(1) NOT NULL default '0',
  `user_privacy_profile` int(1) NOT NULL default '0',
  `user_privacy_comments` int(1) NOT NULL default '0',
  `user_allowed_actions` varchar(255) character set utf8 collate utf8_unicode_ci default '1,2,3,4,5,7', 
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `UNIQUE` (`user_email`,`user_username`),
  KEY `INDEX` (`user_username`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_users<br>Error: ".mysql_error());








// create table phps_usersettings
mysql_query("CREATE TABLE `phps_usersettings` (
  `usersetting_id` int(9) NOT NULL auto_increment,
  `usersetting_user_id` int(9) NOT NULL default '0',
  `usersetting_lostpassword_code` varchar(15) NOT NULL default '',
  `usersetting_lostpassword_time` int(14) NOT NULL default '0',
  `usersetting_notify_friendrequest` int(1) NOT NULL default '0',
  `usersetting_notify_message` int(1) NOT NULL default '0',
  `usersetting_notify_profilecomment` int(1) NOT NULL default '0',
  `usersetting_actions_dontpublish` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`usersetting_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci") or die("Create: phps_usersettings<br>Error: ".mysql_error());

?>
