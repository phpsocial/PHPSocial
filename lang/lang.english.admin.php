<?php

setlocale(LC_ALL, 'C');
$multi_language = "no";


$Admin[1] = "Admin Panel";
$Admin[2] = "Hello,";
$Admin[3] = "user(s) are currently logged in.";
$Admin[4] = "user(s) have signed up today.";
$Admin[5] = "Network Management";
$Admin[6] = "Summary";
$Admin[7] = "View Users";
$Admin[8] = "View Admins";
$Admin[9] = "Global Settings";
$Admin[10] = "Signup Settings";
$Admin[11] = "HTML Templates";
$Admin[12] = "Profile Fields";
$Admin[13] = "Subnetworks";
$Admin[14] = "Banning/Spam";
$Admin[15] = "User Connections";
$Admin[16] = "URL Settings";
$Admin[17] = "View Plugins";
$Admin[18] = "General Settings";
$Admin[19] = "Statistics";
$Admin[20] = "User Levels";
$Admin[21] = "Other Tools";
$Admin[22] = "Access Log";
$Admin[23] = "Logout";
$Admin[24] = "!";
$Admin[25] = "Announcements";
$Admin[26] = "System Emails";
$Admin[27] = "View Reports";
$Admin[28] = "Invite Users";
$Admin[29] = "Level Settings";
$Admin[30] = "User Settings";
$Admin[31] = "Message Settings";
$Admin[32] = "Ad Campaigns";
$Admin[33] = "Recent Activity Feed";


$Admin[34] = "Your browser does not have Javascript enabled. Please enable Javascript and try again.";
$Admin[35] = "The login details you provided were invalid. Did you <a href='AdminLostpass.php'>forget your password</a>?";
$Admin[36] = "You must complete all the fields.";
$Admin[37] = "The Old Password field must match this admin's old password.";
$Admin[38] = "Username and Password fields must be alpha-numeric.";
$Admin[39] = "The username you have entered is already in use by another admin.";
$Admin[40] = "Passwords must be at least 6 characters in length.";
$Admin[41] = "Password and Password Confirmation fields must match.";



// PAGE SPECIFIC VARIABLES
//switch ($page) {

//case "AdminActivity":
	$Admin[42] = "Recent Activity Feed Settings";
	$Admin[43] = "This feature is an auto-updating series of actions that have happened on your network. It shows up on your member`s \"My Home\" page. If you enable this feature, each of the member`s own activity list is displayed on their page. Once a change is made, it is not retroactive so only new stuff will show up. Not previous actions prior to the feed being started.";
	$Admin[44] = "Your changes have been saved.";
	$Admin[45] = "You can select the specific items you want to show up on the activity feed. All of the possible choices of actions that can show in your recent activity feed are listed below. You can choose not to show up in the recent activity feed by un-checking them, or you can change their text. Note that some of the actions have variables that are replaced by the system (e.g. [username]). Also, note that installing new plug-ins may add new actions. Un-checking the checkbox next to an action will disable that action type, however any previously recorded actions of that type will not be deleted from the feed.";
	$Admin[46] = "Remember to write a brief description of each action type (in the description fields below) - these are displayed on the user`s account settings page (if action type privacy is enabled below). If you don`t want to include any of these action types from your users' settings page, you will simply leave the description blank.";
	$Admin[47] = "Action Text";
	$Admin[48] = "Keyword";
	$Admin[49] = "How many recent actions do you want to keep in the database for each member?";
	$Admin[50] = "A higher value here will keep more information about each user`s activity, while a lower value will keep less and thus increase database performance. Note: If the number of actions you want to display on each user's profile is less than the number of actions you want to store in the database, you can edit the \"profile.tpl\" template file to limit the number of actions shown.";
	$Admin[51] = "action(s) stored in the database and published on each user's profile page";
	$Admin[52] = "Feed Limits";
	$Admin[53] = "You can show hoe many of the total activities you want included on this feed. The more you include, the longer the page will be.";
	$Admin[54] = "action(s) published in the recent activity feed";
	$Admin[55] = "How long do want items to be show up in the recent activity feed? This basically allows you to delete some of the items after an amount of time has passed. Typically, in a smaller network you will probably want to make the time period longer.";
	$Admin[56] = "minute";
	$Admin[57] = "minutes";
	$Admin[58] = "hour";
	$Admin[59] = "hours";
	$Admin[60] = "day";
	$Admin[61] = "days";
	$Admin[62] = "week";
	$Admin[63] = "weeks";
	$Admin[64] = "month";
	$Admin[65] = "How many actions per user can be shown on the recent activity feed? It`s important to have a nice mix of actions from various users on your social network, so here you can set a limit on the number of actions published about each user at any given time. For smaller social networks, a higher number of published actions per user might be more appropriate.";
	$Admin[66] = "action(s) published per user in the recent activity feed";
	$Admin[67] = "Do you want to give your users permission to delete actions published about themselves?";
	$Admin[68] = "Do you want to give users the option of deleting actions published about themselves? This is generally an important freedom to give users because it helps to maintain their privacy.";
	$Admin[69] = "Yes, allow users to delete actions about themselves.";
	$Admin[70] = "No, users may not delete actions about themselves.";
	$Admin[71] = "Whose actions should users see in the recent activity list?";
	$Admin[72] = "When a user is looking at the recent activity feed, whose actions should they see? For smaller networks, it may make more sense to show recent actions from \"All Registered Users\" so the feed is quickly populated.";
	$Admin[74] = "Should users be able to prevent certain action types from being published?";
	$Admin[75] = "Do you want to let your users stop specific action types from being published about them? If yes, a setting will appear on your users' account settings page allowing them to choose which action types to NOT publish in the recent activity feed.";
	$Admin[76] = "Save Changes";
	$Admin[77] = "Yes, users can specify which action types will not be published about them.";
	$Admin[78] = "No, users cannot specify what actions will be published or not published about them.";
	$Admin[79] = "Description";
//	break;

//case "AdminAds":
	$Admin[80] = "Advertising";
	$Admin[81] = "When you create an ad campaigns, you can determine exactly where your ads will show up, how long they will be displayed, and who sees them. Showing advertisements on your social network is a great way to monetize it.  The key to generating excellent revenue from your social network is to create targeted ad campaigns. This means that you should make an effort to show specific ads to users based on their interests or personal characteristics (e.g. their profile information). To accomplish this, ad campaigns can be created for specific <a href='AdminLevels.php'>user levels</a> and/or <a href='AdminSubnetworks.php'>subnetworks</a>";
	$Admin[82] = "Create New Campaign";
	$Admin[83] = "Refresh Stats";
	$Admin[84] = "ID";
	$Admin[85] = "Name";
	$Admin[86] = "Status";
	$Admin[87] = "Views";
	$Admin[88] = "Clicks";
	$Admin[89] = "CTR";
	$Admin[90] = "Options";
	$Admin[100] = "Untitled Campaign";
	$Admin[101] = "edit";
	$Admin[102] = "pause";
	$Admin[103] = "unpause";
	$Admin[104] = "delete";
	$Admin[105] = "There are currently no advertising campaigns on your social network.";
	$Admin[106] = "Delete Ad Campaign?";
	$Admin[107] = "Are you sure you want to delete this ad campaign?";
	$Admin[108] = "Delete Campaign";
	$Admin[109] = "Cancel";
	$Admin[110] = "Active";
	$Admin[111] = "Waiting For Start Date";
	$Admin[112] = "Completed";
	$Admin[113] = "Paused";
//	break;

//case "AdminAdsAdd":
	$Admin[114] = "Please upload a banner or specify your advertisement HTML for this campaign.";
	$Admin[115] = "Please provide a name for this advertising campaign.";
	$Admin[116] = "Please provide a complete start date for this campaign.";
	$Admin[117] = "Please provide a complete end date for this campaign.";
	$Admin[118] = "Please select an end date that is later than your start date.";
	$Admin[119] = "Please provide a maximum number of views for this campaign. This must be an integer (e.g. 250000).";
	$Admin[120] = "Please provide a maximum number of clicks for this campaign. This must be an integer (e.g. 250).";
	$Admin[121] = "Please provide a minimum CTR limit in the form of a percentage of clicks to views (e.g. 1.50%). This value may not exceed 100%.";
	$Admin[122] = "Create Advertising Campaign";
	$Admin[123] = "You can follow this guide to design and start a new advertising campaign.";
	$Admin[124] = "Advertisement Media";
	$Admin[125] = "Upload a banner image from your computer or specify your advertisement HTML code (e.g. Google Adsense). If you choose to upload an image, it must be a valid GIF, JPG, JPEG, or PNG file under 200kb.";
	$Admin[126] = "Upload Banner Image";
	$Admin[127] = "OR";
	$Admin[128] = "Insert Banner HTML";
	$Admin[129] = "Upload Banner Image";
	$Admin[130] = "File:";
	$Admin[131] = "Link URL:";
	$Admin[132] = "Upload Banner & Preview";
	$Admin[133] = "Cancel";
	$Admin[134] = "Insert Banner HTML Code";
	$Admin[135] = "Save HTML Code & Preview";
	$Admin[136] = "Save Banner";
	$Admin[137] = "Banner Preview";
	$Admin[138] = "Remove Banner";
	$Admin[139] = "Please choose a file from your hard drive to upload."; // USED IN JAVASCRIPT, DONT USE APOSTROPHES (')
	$Admin[140] = "The file you specified failed to upload. Please make sure this is a valid image file and the /uploads_admin/ads directory is writeable on the server."; // USED IN JAVASCRIPT, DONT USE APOSTROPHES (')
	$Admin[141] = "Please insert your banner HTML before continuing."; // USED IN JAVASCRIPT, DONT USE APOSTROPHES (')
	$Admin[142] = "Campaign Information";
	$Admin[143] = "Start by naming this campaign and deciding its start date and end date. If you select an ending date, the campaign will end immediately once that date arrives. If you specify a certain number of total views allowed or total clicks allowed, the campaign will end when that number of views or clicks is reached. If you specify a minimum CTR (click-through ratio, which is the ratio of clicks to views) and the campaign's CTR goes below your limit, the campaign will end. If you decide to specify a minimum CTR limit, you should enter it as a percentage of clicks to views (e.g. 0.05%). To create a campaign with no date end, don't specify an end date or any other limits and your campaign will continue until you decide to end it. ";
	$Admin[144] = "Note: Current date is";
	$Admin[145] = "Campaign Name:";
	$Admin[146] = "Start Date:";
	$Admin[147] = "Jan";
	$Admin[148] = "Feb";
	$Admin[149] = "Mar";
	$Admin[150] = "Apr";
	$Admin[151] = "May";
	$Admin[152] = "Jun";
	$Admin[153] = "Jul";
	$Admin[154] = "Aug";
	$Admin[155] = "Sep";
	$Admin[156] = "Oct";
	$Admin[157] = "Nov";
	$Admin[158] = "Dec";
	$Admin[159] = "AM";
	$Admin[160] = "PM";
	$Admin[161] = "End Date:";
	$Admin[162] = "Don't end this campaign on a specific date.";
	$Admin[163] = "End this campaign on a specific date.";
	$Admin[164] = "Total Views Allowed:";
	$Admin[165] = "Unlimited";
	$Admin[166] = "Total Clicks Allowed:";
	$Admin[167] = "Minimum CTR:";
	$Admin[168] = "Select Placement Position";
	$Admin[169] = "You can decide where on the page you want your banner to be. You can put your banners at the very top of the page, just above the main content area, to the left of the content area, to the right of the content area, or at the very bottom of the page. It’s important to know that this automatic placement will NOT work if you have removed the advertisement code Smarty variables from your Header.tpl and Footer.tpl files. Also note that if you select a position below, the banner will show up in that position on every page of the social network. You can insert banners on a single page (or a few pages) by following the manual insertion instructions below. ";
	$Admin[170] = "If you want to have this advertisement display somewhere other than the site-wide positions shown above (e.g. within the content on a single page), you can insert the following code into any of your <a href='AdminTemplates.php' target='_blank'>templates</a> and it will display your advertisement once you've created the campaign.";
	$Admin[171] = "Select Audience";
	$Admin[172] = "Specify which users will be shown advertisements from this campaign. To include the entire user population in this campaign, leave all of the <a href='AdminLevels.php' target='_blank'>user levels</a> and <a href='AdminSubnetworks.php' target='_blank'>subnetworks</a> selected. To select multiple user levels or subnetworks, use CTRL-click. Note that this advertising campaign will only be displayed to logged-in users that match both a user level <b>AND</b> a subnetwork you've selected.";
	$Admin[173] = "Subnetworks";
	$Admin[174] = "(signup default)";
	$Admin[175] = "Also show this advertisement to visitors that are not logged in.";
	$Admin[176] = "Create New Campaign";
	$Admin[177] = "Cancel";
	$Admin[178] = "Edit HTML";
	$Admin[179] = "Default Subnetwork";
//	break;

//case "AdminAdsEdit":
	$Admin[180] = "Please upload a banner or specify your advertisement HTML for this campaign.";
	$Admin[181] = "Please provide a name for this advertising campaign.";
	$Admin[182] = "Please provide a complete start date for this campaign.";
	$Admin[183] = "Please provide a complete end date for this campaign.";
	$Admin[184] = "Please select an end date that is later than your start date.";
	$Admin[185] = "Please provide a maximum number of views for this campaign. This must be an integer (e.g. 250000).";
	$Admin[186] = "Please provide a maximum number of clicks for this campaign. This must be an integer (e.g. 250).";
	$Admin[187] = "Please provide a minimum CTR limit in the form of a percentage of clicks to views (e.g. 1.50%). This value may not exceed 100%.";
	$Admin[188] = "Edit Advertising Campaign";
	$Admin[189] = "Edit this advertising campaign's details below.";
	$Admin[190] = "Advertisement Media";
	$Admin[191] = "Upload a banner image from your computer or specify your advertisement HTML code (e.g. Google Adsense). If you choose to upload an image, it must be a valid GIF, JPG, JPEG, or PNG file under 200kb.";
	$Admin[192] = "Upload Banner Image";
	$Admin[193] = "OR";
	$Admin[194] = "Insert Banner HTML";
	$Admin[195] = "Upload Banner Image";
	$Admin[196] = "File:";
	$Admin[197] = "Link URL:";
	$Admin[198] = "Upload Banner & Preview";
	$Admin[199] = "Cancel";
	$Admin[200] = "Insert Banner HTML Code";
	$Admin[201] = "Save HTML Code & Preview";
	$Admin[202] = "Banner Preview";
	$Admin[203] = "Save Banner";
	$Admin[204] = "Remove Banner";
	$Admin[205] = "Please choose a file from your hard drive to upload."; // USED IN JAVASCRIPT, DONT USE APOSTROPHES (')
	$Admin[206] = "The file you specified failed to upload. Please make sure this is a valid image file and the /uploads_admin/ads directory is writeable on the server."; // USED IN JAVASCRIPT, DONT USE APOSTROPHES (')
	$Admin[207] = "Please insert your banner HTML before continuing."; // USED IN JAVASCRIPT, DONT USE APOSTROPHES (')
	$Admin[208] = "Campaign Information";
	$Admin[209] = "Begin by naming this campaign and determining its start date and ending terms. If you select an ending date, the campaign will end immediately when that date is reached. If you specify a certain number of total views allowed or total clicks allowed, the campaign will end when that number of views or clicks is reached. If you specify a minimum CTR (click-through ratio, which is the ratio of clicks to views) and the campaign's CTR goes below your limit, the campaign will end. If you decide to specify a minimum CTR limit, you should enter it as a percentage of clicks to views (e.g. 0.05%). To create a campaign with no definite end, don't specify an end date or any other limits and your campaign will continue until you choose to end it.";
	$Admin[210] = "Note: Current date is";
	$Admin[211] = "Campaign Name:";
	$Admin[212] = "Start Date:";
	$Admin[213] = "Jan";
	$Admin[214] = "Feb";
	$Admin[215] = "Mar";
	$Admin[216] = "Apr";
	$Admin[217] = "May";
	$Admin[218] = "Jun";
	$Admin[219] = "Jul";
	$Admin[220] = "Aug";
	$Admin[221] = "Sep";
	$Admin[222] = "Oct";
	$Admin[223] = "Nov";
	$Admin[224] = "Dec";
	$Admin[225] = "AM";
	$Admin[226] = "PM";
	$Admin[227] = "End Date:";
	$Admin[228] = "Don't end this campaign on a specific date.";
	$Admin[229] = "End this campaign on a specific date.";
	$Admin[230] = "Total Views Allowed:";
	$Admin[231] = "Unlimited";
	$Admin[232] = "Total Clicks Allowed:";
	$Admin[233] = "Minimum CTR:";
	$Admin[234] = "Select Placement Position";
	$Admin[235] = "Where on the page do you want your banners to display? You can place your banners at the very top of the page, just above the main content area, to the left of the content area, to the right of the content area, or at the very bottom of the page. Please note that this automatic placement will NOT work if you have removed the advertisement code Smarty variables from your Header.tpl and Footer.tpl files. Also note that if you select a position below, the banner will show up in that position on every page of the social network. You can insert banners on a single page (or a few pages) by following the manual insertion instructions below.";
	$Admin[236] = "If you want to have this advertisement display somewhere other than the site-wide positions shown above (e.g. within the content on a single page), you can insert the following code into any of your <a href='AdminTemplates.php' target='_blank'>templates</a> and it will display your advertisement.";
	$Admin[237] = "Select Audience";
	$Admin[238] = "Specify which users will be shown advertisements from this campaign. To include the entire user population in this campaign, leave all of the <a href='AdminLevels.php' target='_blank'>user levels</a> and <a href='AdminSubnetworks.php' target='_blank'>subnetworks</a> selected. To select multiple user levels or subnetworks, use CTRL-click. Note that this advertising campaign will only be displayed to logged-in users that match both a user level <b>AND</b> a subnetwork you've selected.";
	$Admin[239] = "Subnetworks";
	$Admin[240] = "(signup default)";
	$Admin[241] = "User Levels";
	$Admin[242] = "Also show this advertisement to visitors that are not logged in.";
	$Admin[243] = "Save Changes";
	$Admin[244] = "Edit HTML";
	$Admin[245] = "Default Subnetwork";
//	break;

//case "AdminAnnouncements":
	$Admin[246] = "Announcements";
	$Admin[247] = "You can use announcements to get a message out to all the users on your social network. You can submit announcements via email or news items.";
	$Admin[248] = "Send Email Announcement";
	$Admin[249] = "The announcement you post will be sent as an email message to all of the users in your network. It will sometimes take awhile if you have a lot of members.";
	$Admin[250] = "Post News Item";
	$Admin[251] = "This feature posts your news on the portal page. No matter how big your network is, the process is immediate. Any announcements you have made in the past will show up below. However, if there is HTML in the news item, it will not show up below but will show correctly on your portal page.";
	$Admin[252] = "ID";
	$Admin[253] = "Contents";
	$Admin[254] = "Options";
	$Admin[255] = "Untitled";
	$Admin[256] = "No Date Provided";
	$Admin[257] = "edit item";
	$Admin[258] = "move down";
	$Admin[259] = "delete";
	$Admin[260] = "Post News Item";
	$Admin[261] = "Please complete the following form to post your news item.";
	$Admin[262] = "Date";
	$Admin[263] = "(date will be displayed exactly as you enter it above)";
	$Admin[264] = "Subject";
	$Admin[265] = "(HTML OK)";
	$Admin[266] = "Save News Item";
	$Admin[267] = "Cancel";
	$Admin[268] = "When you want send out an email to all registered members on your network, you would use this form. Once you click the send button below, the system will start looping through your user database and emailing your message to each of your members. If you put more emails on a page, it will speed up the process. If your server is stressed as it is, however; you should keep the emails per page much lower to reduce the risk of a possible timeout.";
	$Admin[269] = "From";
	$Admin[270] = "Emails Per Page";
	$Admin[271] = "emails per page";
	$Admin[272] = "Send Announcement";
	$Admin[273] = "Emailing Complete";
	$Admin[274] = "The emailing process has been completed. All users on your social network have been sent an email with your announcement.";
	$Admin[275] = "Return";
	$Admin[276] = "Emailing in Progress";
	$Admin[277] = "Your announcement is being sent to users";
	$Admin[278] = "This page will refresh and email the next set of users in several seconds. If it does not automatically continue within a minute, click the continue button below.";
	$Admin[279] = "Continue...";
	$Admin[280] = "email per page";
	$Admin[281] = "Please provide a message body for this announcement.";
	$Admin[282] = "Please select at least one user level or subnetwork that will receive this announcement.";
	$Admin[283] = "Recipients";
	$Admin[284] = "To do this, select which users will receive this email announcement. By default, all user levels and sub-networks are selected - this means that every user on your social network will receive this announcement. Use CTRL-click to select or deselect multiple user levels or sub networks. If a user matches any user level OR sub network you have selected here, they will receive this announcement.";
	$Admin[285] = "User Levels";
	$Admin[286] = "Subnetworks";
	$Admin[287] = "(default)";
	$Admin[288] = "of";
	$Admin[289] = "Default Subnetwork";
//	break;

//case "AdminBanning":
	$Admin[290] = "Banning/Spam Settings";
	$Admin[291] = "Social Networking sites are commonly targeted by aggressive spammers who are trying to advertise their product through targeting your users or to obtain back links. Generally they try to do this by creating fake profiles from which they can spam out comments.  On this page, you can manage the various anti-spam and censorship features. Note: To turn on the signup image verification feature (a popular anti-spam tool), see the <a href='AdminSignup.php'>Signup Settings</a> page.";
	$Admin[292] = "Ban Users by IP Address";
	$Admin[293] = "You can ban a user from your site by their IP address. To do this, enter their address into the field below. Addresses should be separated by commas, like 333.222.888.777, 11.22.33.44</i>";
	$Admin[294] = "Ban Users by Email Address";
	$Admin[295] = "You can also ban a user by their email address by entering their email into the field below. Emails should be separated by commas, like user1@domain1.com, user2@domain2.com. Note that you can ban all email addresses with a specific domain as follows: *@domain.com";
	$Admin[296] = "Ban Users by Username";
	$Admin[297] = "Enter the usernames that are not permitted on your social network. Usernames should be separated by commas, like username1, username2";
	$Admin[298] = "Censored Words on Profiles and plugins";
	$Admin[299] = "Enter any words that you want to censor on your users' profiles as well as any plugins you have installed. These will be replaced with asterisks (*). Separate words by commas like word1, word2";
	$Admin[300] = "Require users to enter validation code when commenting";
	$Admin[301] = "If you have selected Yes, an image containing a random sequence of 6 numbers and letters will be shown to users on the \"write a comment\" page. Users must enter the Verification Code field before they may continue. In order for this feature to properly work, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. Try turning this off if you are seeing errors or users can not leave comments. ";
	$Admin[302] = "Yes, enable validation code for commenting.";
	$Admin[303] = "No, disable validation code for commenting.";
	$Admin[304] = "Save Changes";
	$Admin[305] = "Your changes have been saved.";
	$Admin[306] = "Require users to enter validation code when inviting others?";
	$Admin[307] = "If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the \"invite\" page. Users must enter the Verification Code field before they may continue. In order for this feature to properly work, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. Try turning this off if you are seeing errors or users can not leave comments..";
	$Admin[308] = "Yes, enable validation code for inviting.";
	$Admin[309] = "No, disable validation code for inviting.";
//	break;

//case "AdminConnections":
	$Admin[310] = "User Friendship Settings";
	$Admin[311] = "Encouraging friendships and relationships on any level between your users is essential to building a successful social network. There are multiple types of connections that can exist between users. You can use this page to determine how your users will associate with each other. Note that although we refer to these relationships as \"friendships\" in this control panel, you should use a word that best fits with your social network's theme. For example, if you are running a business-oriented social network, you may want to change this word to \"connections.\"";
	$Admin[312] = "Who can users invite to become friends?";
	$Admin[313] = "Pick who users can invite to become their friends. Note that if you select \"nobody\", none of the other settings on this page will apply.";
	$Admin[314] = "Users cannot invite anyone to become friends.";
	$Admin[315] = "Users can invite any other user to become friends.";
	$Admin[316] = "Users can only invite other users in the same subnetwork to become friends.";
	$Admin[317] = "Users can only invite their current friends' friends to become friends.";
	$Admin[318] = "Nobody";
	$Admin[319] = "Anybody";
	$Admin[320] = "Same Subnetwork";
	$Admin[321] = "Friends of Friends";
	$Admin[322] = "Friendship Framework";
	$Admin[323] = "Please select how you want the friendship request process to work. If you change this setting from \"Verified Friendships\" to \"Unverified Friendships\", all pending friendships will be automatically confirmed.";
	$Admin[324] = "Verified Friendships (Two-way)";
	$Admin[325] = "Verified Friendships (One-way)";
	$Admin[326] = "Unverified Friendships (Two-way)";
	$Admin[327] = "Unverified Friendships (One-way)";
	$Admin[328] = "When UserA invites UserB to become friends, UserB is added to UserA's friend list and UserA is added to UserB's friend list after UserB confirms the friendship.";
	$Admin[329] = "When UserA invites UserB to become friends, UserB is added to UserA's friend list after UserB confirms the friendship.";
	$Admin[330] = "When UserA invites UserB to become friends, UserB is immediately listed in UserA's friend list, and UserA is immediately listed in UserB's friend list.";
	$Admin[331] = "When UserA invites UserB to become friends, UserB is immediately listed in UserA's friend list.";
	$Admin[332] = "Save Changes";
	$Admin[333] = "Your changes have been saved.";
	$Admin[334] = "Friendship Types";
	$Admin[335] = "Add friendship types to allow your users to specify their varying degrees of friendships. Example friendship types include \"Acquaintance\", \"Co-Worker\", \"Best Friend\", \"Significant Other\", etc. If you only specify one friendship type or leave this area blank, users will not be prompted to specify a friendship type when connecting to other users.";
	$Admin[336] = "Friendship Types";
	$Admin[337] = "Add New Type";
	$Admin[338] = "Custom Friendship Types";
	$Admin[339] = "Allow users to specify a custom friendship type.";
	$Admin[340] = "Do not allow users to specify a custom friendship type.";
	$Admin[341] = "Friendship Explanation";
	$Admin[342] = "Allow users to provide an explanation of their friendships.";
	$Admin[343] = "Do not allow users to provide an explanation of their friendships.";
//	break;

//case "AdminEmails":
	$Admin[344] = "System Email Settings";
	$Admin[345] = "This page allows you to change the content of email messages sent by the system.";
	$Admin[346] = "Save Changes";
	$Admin[347] = "From Address";
	$Admin[348] = "Enter the name and email address you want the emails from the system to come from in the fields below.";
	$Admin[349] = "From Name:";
	$Admin[350] = "From Address:";
	$Admin[351] = "Subject";
	$Admin[352] = "Message";
	$Admin[353] = "Invite Code Email";
	$Admin[354] = "This is the email that gets sent if you allow users to join by invite only.";
	$Admin[355] = "Invitation Email";
	$Admin[354] = "This is the email that gets sent when users invite their friends to join during the signup process.";
	$Admin[355] = "Verification Email";
	$Admin[356] = "This is the email that gets sent to users to verify their email addresses.";
	$Admin[357] = "New Password Email";
	$Admin[358] = "This is the email that gets sent if you have chosen to create a random password for users upon signup.";
	$Admin[359] = "Welcome Email";
	$Admin[360] = "This is the email that gets sent when a user signs up.";
	$Admin[361] = "[username] - replaced with the username of the sender.<br>[email] - replaced with the email address of the sender.<br>[message] - replaced with the custom message written by the sender.<br>[code] - replaced with the invite code.<br>[link] - replaced with the link to signup.";
	$Admin[362] = "[username] - replaced with the username of the sender.<br>[email] - replaced with the email address of the sender.<br>[message] - replaced with the custom message written by the sender.<br>[link] - replaced with the link to signup.";
	$Admin[363] = "[username] - replaced with the username of the recepient.<br>[email] - replaced with the email address of the recepient.<br>[link] - replaced with the link to verify recepient's email address.";
	$Admin[364] = "[username] - replaced with the username of the recepient.<br>[email] - replaced with the email address of the recepient.<br>[password] - replaced with the recepient's randomly generated password.<br>[link] - replaced with the link to login.";
	$Admin[365] = "[username] - replaced with the username of the recepient.<br>[email] - replaced with the email address of the recepient.<br>[password] - replaced with the password of the recepient.<br>[link] - replaced with the link to login.";
	$Admin[366] = "New Profile Comment Email";
	$Admin[367] = "This is the email that gets sent to a user when a new comment is posted on their profile.";
	$Admin[368] = "[username] - replaced with the username of the recepient.<br>[commenter] - replaced with the name of the user who posted the comment.<br>[link] - replaced with the link to the user's profile.";
	$Admin[369] = "Lost Password Email";
	$Admin[370] = "This is the email that gets sent if a user forgets their password and requests to create a new one.";
	$Admin[371] = "[username] - replaced with the username of the recepient.<br>[email] - replaced with the email address of the recepient.<br>[link] - replaced with the link to create a new password.";
	$Admin[372] = "Friend Request Email";
	$Admin[373] = "This is the email that gets sent to a user when they are added as a friend by another user.";
	$Admin[374] = "[username] - replaced with the username of the recepient.<br>[friendname] - replaced with the name of the user making the friend request.<br>[link] - replaced with the link to login.";
	$Admin[375] = "New Message Email";
	$Admin[376] = "This is the email that gets sent to a user when they receive a new message.";
	$Admin[377] = "[username] - replaced with the username of the recepient.<br>[sender] - replaced with the name of the user who sent the message.<br>[link] - replaced with the link to login.";
	$Admin[378] = "Your changes have been saved.";
//	break;

//case "AdminGeneral":
	$Admin[379] = "General Settings";
	$Admin[380] = "This page contains general settings that affect your entire social network.";
	$Admin[381] = "Time zone";
	$Admin[382] = "You can select the time zone for your social network. If your users do not select the time zone themselves, then they will be on this defaulted time zone that you set. ";
	$Admin[383] = "Date Format";
	$Admin[384] = "Select the date formatting for your social network. This is the way the date will appear throughout your site.";
	$Admin[385] = "Save Changes";
	$Admin[386] = "Your changes have been saved.";
	$Admin[387] = "Public Permission Defaults";
	$Admin[388] = "Decide and choose if you want to let the public (visitors that are not logged-in) view the following sections of your social network. In some cases (such as Profiles), if you have given them the option, your members can still make their profiles private even if you have made this setting so all can view.";
	$Admin[389] = "Profiles";
	$Admin[390] = "Yes, the public can view profiles unless they are made private.";
	$Admin[391] = "No, the public cannot view profiles.";
	$Admin[392] = "Invite Page";
	$Admin[393] = "Yes, the public can use the invite page.";
	$Admin[394] = "No, the public cannot use the invite page.";
	$Admin[395] = "Search Page";
	$Admin[396] = "Yes, the public can use the search page.";
	$Admin[397] = "No, the public cannot use the search page.";
	$Admin[398] = "Portal Page";
	$Admin[399] = "Yes, the public view use the portal page.";
	$Admin[400] = "No, the public cannot view the portal page.";
	$Admin[401] = "Default Language";
	$Admin[402] = "Here you can select the language of your site (i.e. French, English, etc.) and if you want to add more languages, you must create files in your \"lang\" directory with names like \"lang_xxx.php\" and \"lang_xxx_admin.php\". Replace \"xxx\" with the name of your language (e.g. lang.english.php and lang.english.admin.php). If you have plug-ins installed, remember to create language files for them as well. Your language file names should NOT contain any CAPITAL letters and should NOT exceed 20 characters in length.";
	$Admin[403] = "If you have more than one language pack, you can set whether you want users to be able to use more than one language. Note that this will only apply if you have more than one language pack above.";
	$Admin[404] = "Yes, allow users to choose their own language.";
	$Admin[405] = "No, all users must use the default language.";
//	break;

//case "AdminHome":
	$Admin[406] = "Welcome, Admin!";
	$Admin[407] = "Welcome to the phpSocial control panel. From here, you will be able to control and modify each part of your php social network. <br>All the information you need to help you is below: ";
	$Admin[408] = "PHPSocial License:";
	$Admin[409] = "Version:";
	$Admin[410] = "Total Users:";
	$Admin[411] = "Comments:";
	$Admin[412] = "Private Messages:";
	$Admin[413] = "User(s) Online:";
	$Admin[414] = "Warning: You have not yet deleted install.php and/or installsql.php. Leaving these files on your server is a security risk!";
	$Admin[415] = "Upgrade Available";
	$Admin[416] = "User Levels:";
	$Admin[417] = "Abuse Reports:";
	$Admin[418] = "Friendships:";
	$Admin[419] = "News Posts:";
	$Admin[420] = "Signups Today:";
	$Admin[421] = "Logins Today:";
	$Admin[422] = "Admin Accounts:";
	$Admin[423] = "<h2>To Get Started</h2>Following, you will find useful recommendations to get going on your social network:";
	$Admin[424] = "1";
	$Admin[425] = "2";
	$Admin[426] = "3";
	$Admin[427] = "4";
	$Admin[428] = "5";
	$Admin[429] = "Creating Fields for User Profiles";
	$Admin[430] = "The fields for your profiles are a very important part of setting up your social network since they determine what information users share about one another.";
	$Admin[431] = "Editing Settings for Sign up";
	$Admin[432] = "Once, the profile fields are done, you`re going to want to customize the signup process your users will go through. Here you can chose what information users are required to give, if they have to have an invitation or referral to join and other key details.";
	$Admin[433] = "Edit Default User Level";
	$Admin[434] = "Here you will now decide which features users can have access to and the limits you will put on their accounts. You can accomplish this by editing the default user level or creating new user levels (examples are Platinum Members or VIP Access Members).";
	$Admin[435] = "Install Plugins";
	$Admin[436] = "You have bought the required plug-ins so you would now be able to install and configure them. Plug-ins give your social network site an additional functionality and interactivity.";
	$Admin[437] = "Customize Look & Feel";
	$Admin[438] = "You now need to give your new social network a style of its own. Here, you can edit any of the HTML templates (including a global header template and CSS file) to add your own personal site design.";
//	break;

//case "AdminInvite":
	$Admin[439] = "Invite Users";
	$Admin[440] = "This is the page you would to invite new members to your network. You can specify 10 email addresses at a time. If you have specified that users may signup by invitation only, this page will email an invitation code to the email addresses you specify. Otherwise, a simple invitation email will be sent out. Both these emails can be modified on your <a href='AdminEmails.php'>System Emails</a> page.";
	$Admin[441] = "Email Addresses";
	$Admin[442] = "Enter email addresses (max 10), separated by commas, in the field below.";
	$Admin[443] = "Invite Users";
	$Admin[444] = "Invitations have been sent!";
//	break;

//case "AdminLevels":
	$Admin[445] = "User Levels";
	$Admin[446] = "If you chose to put users into different groups with varying access to, you may create multiple user groups. You must always have at least one group - your default group (which cannot be deleted). When a user signs up, they will be placed into the group you have designated as the default group on this page. You can then change a user's group by editing their account from the <a href='AdminViewusers.php'>View Users</a> page. If you decide to give all users the same features and limits, you will only need one user level. This option is generally found on paid access sites where various levels based on amount or length of payment will give the user say a silver or gold membership.";
	$Admin[447] = "Add User Level";
	$Admin[448] = "ID";
	$Admin[449] = "Name";
	$Admin[450] = "Users";
	$Admin[451] = "Options";
	$Admin[452] = "edit";
	$Admin[453] = "delete";
	$Admin[454] = "Delete User Level";
	$Admin[455] = "Are you sure you want to delete this user level? All users within this user level will be moved to the default user level.";
	$Admin[456] = "Delete Level";
	$Admin[457] = "Cancel";
	$Admin[458] = "Default";
	$Admin[459] = "You may not delete the default user level. Please select/create a new default before attempting to delete this level.";
	$Admin[460] = "The user level you selected has been deleted.";
	$Admin[461] = "user(s)";
//	break;

//case "AdminLevelsAdd":
	$Admin[462] = "Add User Level";
	$Admin[463] = "To create a user level, complete the following form. Once it is created, you will be able to edit all the settings for this user level.";
	$Admin[464] = "Name";
	$Admin[465] = "Description";
	$Admin[466] = "Add Level";
	$Admin[467] = "Cancel";
	$Admin[468] = "Please specify a name for this user level.";
	$Admin[469] = "Editing User Level:";
//	break;

//case "AdminLevelsEdit":
	$Admin[470] = "Edit User Level";
	$Admin[471] = "To modify this user level, complete the following form.";
	$Admin[472] = "Name";
	$Admin[473] = "Description";
	$Admin[474] = "Save Changes";
	$Admin[475] = "Your changes have been saved.";
	$Admin[476] = "Please specify a name for this user level.";
	$Admin[477] = "Editing User Level:";
	$Admin[478] = "You are currently editing this user level's settings. Remember, these settings only apply to the users that belong to this user level. When you're finished, you can edit the <a href='AdminLevels.php'>other levels here</a>.";
//	break;

//case "AdminLevelsMessagesettings":
	$Admin[479] = "Message Settings";
	$Admin[480] = "Facilitating user interactivity is the key to developing a successful social network. Allowing private messages between users is an excellent way to increase interactivity. From this page, you can enable the private messaging feature and configure its settings. ";
	$Admin[481] = "Who can users send private messages to?";
	$Admin[482] = "If set to \"nobody,\" none of the other settings on this page will apply. Otherwise, users will have access to their private message inbox and will be able to send each other messages. ";
	$Admin[483] = "Nobody - users cannot send private messages.";
	$Admin[484] = "Friends only - users can send private messages to their friends only.";
	$Admin[485] = "Everyone - users can send private messages to anyone.";
	$Admin[486] = "Inbox/Outbox Capacity";
	$Admin[487] = "How many total messages will users be allowed to store in their inbox and outbox? If a user's inbox or outbox is full and a new message arrives, the oldest message will be automatically deleted.";
	$Admin[488] = "messages in inbox folder.";
	$Admin[489] = "messages in outbox folder.";
	$Admin[490] = "Save Changes";
	$Admin[491] = "Your changes have been saved.";
	$Admin[492] = "Editing User Level:";
	$Admin[493] = "You are currently editing this user level's settings. Remember, these settings only apply to the users that belong to this user level. When you're finished, you can edit the <a href='AdminLevels.php'>other levels here</a>.";
//	break;

//case "AdminLevelsUsersettings":
	$Admin[494] = "General User Settings";
	$Admin[495] = "This page contains various settings that affect your users' accounts.";
	$Admin[496] = "Privacy Options";
	$Admin[497] = "Search Privacy Options";
	$Admin[498] = "If you enable this feature, users will be able to exclude themselves from search results. Otherwise, all users will be included in search results.";
	$Admin[499] = "Profile Privacy Options";
	$Admin[500] = "Your changes have been saved.";
	$Admin[501] = "Photo width and height must be integers between 1 and 999";
	$Admin[502] = "Photo file types can only be gif, jpg, jpeg, or png.";
	$Admin[503] = "Allow custom CSS in profiles?";
	$Admin[504] = "Allow User Photos?";
	$Admin[505] = "If you enable this feature, users can upload a small photo icon of themselves. This will be shown next to their name/username on their profiles, in search/browse results, next to their private messages, etc.";
	$Admin[506] = "Yes, users can upload a photo.";
	$Admin[507] = "No, users can not upload a photo.";
	$Admin[508] = "If you have selected \"Yes\" above, please input the maximum dimensions for the user photos. If your users upload a photo that is larger than these dimensions, the server will attempt to scale them down automatically. This feature requires that your PHP server is compiled with support for the GD Libraries.";
	$Admin[509] = "Maximum Width:";
	$Admin[510] = "(in pixels, between 1 and 999)";
	$Admin[511] = "Maximum Height:";
	$Admin[512] = "What file types do you want to allow for user photos (gif, jpg, jpeg, or png)? Separate file types with commas, i.e. <i>jpg, jpeg, gif, png</i>";
	$Admin[513] = "Allowed File Types:";
	$Admin[514] = "Save Changes";
	$Admin[515] = "Enable this feature if you want to allow users to customize the colors and fonts of their profiles with their own CSS styles.";
	$Admin[516] = "Yes, users can add custom CSS styles to their profiles.";
	$Admin[517] = "No, users cannot add custom CSS styles to their profiles.";
	$Admin[518] = "Yes, allow users to exclude themselves from search results.";
	$Admin[519] = "No, force all users to be included in search results.";
	$Admin[520] = "Allow profile status messages?";
	$Admin[521] = "Enable this feature if you want to allow users to show their \"status\" on their profile. By updating their status, users can tell others what they are up to, what's on their minds, etc. ";
	$Admin[522] = "Yes, allow users to have a \"status\" message.";
	$Admin[523] = "No, users cannot have a \"status\" message.";
	$Admin[524] = "Can users block other users?";
	$Admin[525] = "If set to \"yes,\" users can block other users from sending them private messages, requesting their friendship, and viewing their profile. This helps fight spam and network abuse. ";
	$Admin[526] = "Yes, users can block other users.";
	$Admin[527] = "No, users cannot block other users.";
	$Admin[528] = "Your users can choose from any of the options checked below when they decide who can see their profile. If you do not check any options, everyone will be allowed to view profiles.";
	$Admin[529] = "Profile Comment Options";
	$Admin[530] = "Your users can choose from any of the options checked below when they decide who can post comments on their profile. If you do not check any options, everyone will be allowed to post comments on profiles.";
	$Admin[531] = "Editing User Level:";
	$Admin[532] = "You are currently editing this user level's settings. Remember, these settings only apply to the users that belong to this user level. When you're finished, you can edit the <a href='AdminLevels.php'>other levels here</a>.";
//	break;

//case "AdminLog":
	$Admin[533] = "Access Log";
	$Admin[534] = "Here, you will see the last 300 attempted logins. You can use this page to see any suspicious attempts to login to your site.";
	$Admin[535] = "ID";
	$Admin[536] = "Email";
	$Admin[537] = "Date";
	$Admin[538] = "Result";
	$Admin[539] = "IP";
	$Admin[540] = "Hostname";
	$Admin[541] = "Success";
	$Admin[542] = "Failure";
//	break;

//case "AdminLogin":
	$Admin[543] = "Administrator Login";
	$Admin[544] = "Username:";
	$Admin[545] = "Password:";
	$Admin[546] = "Login";
	$Admin[547] = "Lost Password";
//	break;

//case "AdminLostpass":
	$Admin[548] = "Lost Password";
	$Admin[549] = "If you cannot login because you have forgotten your password, please enter your email address in the field below.";
	$Admin[550] = "You have been sent an email with instructions how to reset your password. If the email does not arrive within several minutes, be sure to check your spam or junk mail folders.";
	$Admin[551] = "The email you have entered was not found in the database. Please try again.";
	$Admin[552] = "Email Address:";
	$Admin[553] = "Submit";
	$Admin[554] = "Cancel";
	$Admin[555] = "Reset PhpSocial Admin Password Request";
	$Admin[556] = "Hello,\n\nYou have requested to reset your PhpSocial admin password. If you would like to do so, please click the link below. If you did not request a password reset, simply ignore this email.";
	$Admin[557] = "Thank You";
//	break;

//case "AdminLostpassReset":
	$Admin[558] = "Please make sure you have completed both fields.";
	$Admin[559] = "Username and Password fields must be alpha-numeric.";
	$Admin[560] = "Passwords must be at least 6 characters in length.";
	$Admin[561] = "Password and Password Confirmation fields must match.";
	$Admin[562] = "Lost Password Reset";
	$Admin[563] = "Your password has been reset. <a href='AdminLogin.php'>Click here</a> to login.";
	$Admin[564] = "Complete the form below to reset your password.";
	$Admin[565] = "New Password:";
	$Admin[566] = "Confirm New Password:";
	$Admin[567] = "Reset Password";
	$Admin[568] = "Cancel";
	$Admin[569] = "This link is invalid or expired. Please <a href='AdminLostpass.php'>resubmit</a> your password request and follow the link sent to your email address.";
//	break;

//case "AdminProfile":
	$Admin[570] = "Profile Fields";
	$Admin[571] = "The members of your social network will have a chance to show who they are through their profiles. Giving them the opportunity to do this through relevant fields on their profile of your social network lets your users distinguish themselves. Common tabs are Contact Info, About me, etc. It`s important that you create tabs that will properly allow you to organize your fields. The fields of the profile are the actual places the users will type their information into.";
	$Admin[572] = "Add Tab";
	$Admin[573] = "Add Field";
	$Admin[574] = "User Profile";
	$Admin[575] = "Note: You do not have any profile tabs to manage. Click the \"Add Tab\" button above to create one.";
	$Admin[576] = "Contract All";
	$Admin[577] = "Expand All";
	$Admin[578] = "<i>Dependent Field</i>";
	$Admin[579] = "(Age)";
//	break;

//case "AdminProfileAddfield":
	$Admin[580] = "Add Profile Field";
	$Admin[581] = "Use this page to create a new profile field. You must specify a name for this field and assign it to a profile tab. To decide whether or not this field will appear on the user signup page, visit <a href='AdminSignup.php'>Signup Settings</a>.";
	$Admin[582] = "No dependent field";
	$Admin[583] = "Yes, has dependent field";
	$Admin[584] = "Field Title:";
	$Admin[585] = "Profile Tab:";
	$Admin[586] = "Field Type:";
	$Admin[587] = "Text Field";
	$Admin[588] = "Multi-line Text Area";
	$Admin[589] = "Pull-down Select Box";
	$Admin[590] = "Radio Buttons";
	$Admin[591] = "Inline CSS Style:";
	$Admin[592] = "Field Maxlength:";
	$Admin[593] = "Regex Validation:";
	$Admin[594] = "If you want to force the user to enter data in a certain format,<br>enter the corresponding regular expression above. A preg_match()<br>will be applied when the user enters data. This is optional - if you<br>don't understand or need regular expressions, leave this blank.";
	$Admin[595] = "Custom Error Message:";
	$Admin[596] = "Options:";
	$Admin[597] = "You must specify at least one option.";
	$Admin[598] = "Label";
	$Admin[599] = "Dependency?";
	$Admin[600] = "Dependent Field Label";
	$Admin[601] = "Add New Option";
	$Admin[602] = "Add Field";
	$Admin[603] = "Cancel";
	$Admin[604] = "Birthday?";
	$Admin[605] = "You must specify a field type.";
	$Admin[606] = "Please enter both a value and a label for each option.";
	$Admin[607] = "You must enter a title for this field.";
	$Admin[608] = "Field Description:";
	$Admin[609] = "Searchable/Linked:";
	$Admin[610] = "Searchable, Linked on Profile";
	$Admin[611] = "Searchable";
	$Admin[612] = "Not Searchable";
	$Admin[613] = "Required:";
	$Admin[614] = "Required";
	$Admin[615] = "Not Required";
	$Admin[616] = "Date Field";
	$Admin[617] = "Checking this box will allow for age calculation and members' birthday notifications.";
	$Admin[618] = "Link Field To:";
	$Admin[619] = "If you want this field to link to another URL, enter the link format above. Note that<br> this will override the \"Searchable/Linked\" setting above. Use [field_value] to represent<br> the user's input for this field. Examples:<br><i>Regular link (if user's input is a URL - must begin with \"http://\"):</i> <strong>[field_value]</strong><br><i>Mailto link (if user's input is an email address):</i> <strong>mailto:[field_value]</strong><br><i>AIM Link (if user's input is an AIM screenname):</i> <strong>aim:goim?screenname=[field_value]</strong>";
	$Admin[620] = "Not Searchable, Not Visible on Profile";
	$Admin[621] = "Allowed HTML Tags:";
	$Admin[622] = "By default, the user may not enter any HTML tags into this profile field. If you want<br>to allow specific tags, you can enter them above (separated by commas). Example:<br><i>b, img, a, embed, font<i>";
//	break;

//case "AdminProfileAddtab":
	$Admin[623] = "Please specify a name for this tab.";
	$Admin[624] = "Profile tabs represent the different sections of your users' profiles. When editing their profiles, they will see their profile fields organized within the tabs that you specify. To create a new profile tab, please complete the following form.";
	$Admin[625] = "Tab Name:";
	$Admin[626] = "Add Tab";
	$Admin[627] = "Cancel";
	$Admin[628] = "Create Profile Tab";
//	break;

//case "AdminProfileEditdepfield":
	$Admin[629] = "Edit Dependent Profile Field";
	$Admin[630] = "Complete this form to edit this dependent field.";
	$Admin[631] = "Field Label:";
	$Admin[632] = "Inline CSS Style:";
	$Admin[633] = "Link Field To:";
	$Admin[634] = "If you want this field to link to another URL, enter the link format above.<br> Use [field_value] to represent the user's input for this field. Examples:<br><i>Regular link (if user's input is a URL):</i> <strong>[field_value]</strong><br><i>Mailto link (if user's input is an email address):</i> <strong>mailto:[field_value]</strong><br><i>AIM Link (if user's input is an AIM screenname):</i> <strong>aim:goim?screenname=[field_value]</strong>";
	$Admin[635] = "Regex Validation:";
	$Admin[636] = "If you want to force the user to enter data in a certain format,<br>enter the corresponding regular expression above. A preg_match()<br>will be applied when the user enters data. This is optional - if you<br>don't understand or need regular expressions, leave this blank.";
	$Admin[637] = "Save Changes";
	$Admin[638] = "Cancel";
	$Admin[639] = "Parent Field:";
	$Admin[640] = "Field Maxlength:";
	$Admin[641] = "Required:";
	$Admin[642] = "Required";
	$Admin[643] = "Not Required";
	$Admin[644] = "Linked:";
	$Admin[645] = "Linked on Profile";
	$Admin[646] = "Not Linked on Profile";
//	break;

//case "AdminProfileEditfield":
	$Admin[647] = "Edit Profile Field";
	$Admin[648] = "Use this page to edit a profile field. To decide whether or not this field will appear on the user signup page, visit <a href='AdminSignup.php'>Signup Settings</a>.";
	$Admin[649] = "No dependent field";
	$Admin[650] = "Yes, has dependent field";
	$Admin[651] = "Field Title:";
	$Admin[652] = "Profile Tab:";
	$Admin[653] = "Field Type:";
	$Admin[654] = "Text Field";
	$Admin[655] = "Multi-line Text Area";
	$Admin[656] = "Pull-down Select Box";
	$Admin[657] = "Radio Buttons";
	$Admin[658] = "Inline CSS Style:";
	$Admin[659] = "Field Maxlength:";
	$Admin[660] = "Regex Validation:";
	$Admin[661] = "If you want to force the user to enter data in a certain format,<br>enter the corresponding regular expression above. A preg_match()<br>will be applied when the user enters data. This is optional - if you<br>don't understand or need regular expressions, leave this blank.";
	$Admin[662] = "Custom Error Message:";
	$Admin[663] = "Options:";
	$Admin[664] = "You must specify at least one option.";
	$Admin[665] = "Label";
	$Admin[666] = "Dependency?";
	$Admin[667] = "Dependent Field Label";
	$Admin[668] = "Add New Option";
	$Admin[669] = "Edit Field";
	$Admin[670] = "Cancel";
	$Admin[671] = "Birthday?";
	$Admin[672] = "You must specify a field type.";
	$Admin[673] = "Please enter both a value and a label for each option.";
	$Admin[674] = "You must enter a title for this field.";
	$Admin[675] = "Field Description:";
	$Admin[676] = "Searchable/Linked:";
	$Admin[677] = "Searchable, Linked on Profile";
	$Admin[678] = "Searchable";
	$Admin[679] = "Not Searchable";
	$Admin[680] = "Delete Field";
	$Admin[681] = "Confirm Field Deletion";
	$Admin[682] = "Are you sure you want to delete this field and any dependent fields it may have?";
	$Admin[683] = "Required:";
	$Admin[684] = "Required";
	$Admin[685] = "Not Required";
	$Admin[686] = "Date Field";
	$Admin[687] = "Checking this box will allow for age calculation and members' birthday notifications.";
	$Admin[688] = "Link Field To:";
	$Admin[689] = "If you want this field to link to another URL, enter the link format above. Note that<br> this will override the \"Searchable/Linked\" setting above. Use [field_value] to represent<br> the user's input for this field. Examples:<br><i>Regular link (if user's input is a URL - must begin with \"http://\"):</i> <strong>[field_value]</strong><br><i>Mailto link (if user's input is an email address):</i> <strong>mailto:[field_value]</strong><br><i>AIM Link (if user's input is an AIM screenname):</i> <strong>aim:goim?screenname=[field_value]</strong>";
	$Admin[690] = "Not Searchable, Not Visible on Profile";
	$Admin[691] = "Allowed HTML Tags:";
	$Admin[692] = "By default, the user may not enter any HTML tags into this profile field. If you want<br>to allow specific tags, you can enter them above (separated by commas). Example:<br><i>b, img, a, embed, font</i>";
//	break;

//case "AdminProfileEdittab":
	$Admin[693] = "Please specify a name for this tab.";
	$Admin[694] = "Delete Tab";
	$Admin[695] = "Tab Name:";
	$Admin[696] = "Edit Tab";
	$Admin[697] = "Cancel";
	$Admin[698] = "Delete Tab";
	$Admin[699] = "Are you sure you want to delete this tab and all the fields contained within?";
	$Admin[700] = "Back to Tabs";
	$Admin[701] = "Edit Profile Tab";
	$Admin[702] = "Use this page to edit the name of a profile tab. The tab name should be a one or two word phrase to describe the profile fields within the tag. You can also use this page to alter the order in which profile fields are displayed on your users' profiles. To move a field up or down, click the appropriate arrow icon next to the field name.";
//	break;

//case "AdminProfileTaborder":
	$Admin[703] = "Reorder Profile Tabs";
	$Admin[704] = "You can use this page to alter the order in which profile tabs are displayed on your users' profiles. To move a tab up or down, click the appropriate arrow icon next to the tab name.";
	$Admin[705] = "Back to Tabs";
//	break;

//case "AdminSignup":
	$Admin[706] = "Signup Settings";
	$Admin[707] = "The signup process for your users is a crucial element of your social network. You need to design a signup method that is both user friendly and which gets the initial information you need from your new users. On this page, you can configure your signup process.";
	$Admin[708] = "Fields on Signup Page";
	$Admin[709] = "When your users sign up, they will then have the chance to start filling out their profile information. Below, you can decide what profile fields will appear on the signup page, and which will be required. Keep in mind that a lengthy signup process may make some users change their minds on signing up to your social network. If you want to add or delete profile fields, go to the <a href='AdminProfile.php'>Profile Fields</a> page.";
	$Admin[710] = "No fields exist within this profile tab.";
	$Admin[711] = "You can choose how many invites a user gets once they are signed up. If you want to give one user more invites, you can go into the <a href='AdminViewusers.php'>View Users</a> page and do it from there. You will have the option of entering a number between 0 and 999.";
	$Admin[712] = "invites are given to each user when they signup.";
	$Admin[713] = "User Photo Upload";
	$Admin[714] = "Invite Only?";
	$Admin[715] = "If you choose to make it so users can only sign up by invitation, this is an option you have. You have the option in this case of allowing both admins and users or just admins to invite new people. If you make this option YES, then users will have to enter an invite code to sign up.";
	$Admin[716] = "Yes, admins and users must invite new users before they can signup.";
	$Admin[717] = "Yes, admins must invite new users before they can signup.";
	$Admin[718] = "No, disable the invite only feature.";
	$Admin[719] = "Show the \"Invite Friends\" Page?";
	$Admin[720] = "If you have chosen YES, then users will see a page upon sign up which gives them the option of inviting one or more of their friends to also sign up. The feature for invite friends is not the same as the invite only feature. You won`t want to click YES on both of these options because all invite friends does is send an email to the person invited and they won`t get a code..";
	$Admin[721] = "Yes, show invite friends page.";
	$Admin[722] = "No, do not show invite friends page.";
	$Admin[723] = "Verify User Email Address?";
	$Admin[724] = "If you set this option to YES, it will force new users to verify their email address prior to being able to login. They will get an email with a verification link which they have to click to activate their account.";
	$Admin[725] = "Yes, verify email addresses.";
	$Admin[726] = "No, do not verify email addresses.";
	$Admin[727] = "Require Users to Enter a Captcha/Verification Code?";
	$Admin[728] = "Selecting YES on this feature keeps users from using bots from automatically setting up accounts on your system. An image containing a varied sequence of 6 numbers and/or symbols is shown to users on the signup page which they must enter into the Verification Code field before they may continue. In order for this feature to properly work, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. Try turning this off if you are seeing errors or users cannot signup.";
	$Admin[729] = "Yes, show verification code image.";
	$Admin[730] = "No, do not show verification code image.";
	$Admin[731] = "Generating Random Passwords?";
	$Admin[732] = "This feature generates a random password for a user upon sign up if YES is selected. The password is emailed to them once they finish the signup steps. This is another method of verifying the user`s email address as they won`t be able to login with out password and won`t be able to get the password without a valid email.";
	$Admin[733] = "Yes, generate random passwords and email to new users.";
	$Admin[734] = "No, let users choose their own passwords.";
	$Admin[735] = "Require users to agree to your terms of service?";
	$Admin[736] = "If you click YES on this feature, your users will be made to click a checkbox saying that they have read your terms of service and they understand and agree to it. You can change the terms of service in the field below this and HTML is fine.";
	$Admin[737] = "Yes, make users agree to your terms of service on signup.";
	$Admin[738] = "No, users will not be shown a terms of service checkbox on signup.";
	$Admin[739] = "Save Changes";
	$Admin[740] = "Your changes have been saved.";
	$Admin[741] = "Here users can upload their photo upon finishing signing up if you want to allow them to do that.";
	$Admin[742] = "Yes, give users the option to upload a photo upon signup.";
	$Admin[743] = "No, do not allow users to upload a photo upon signup.";
	$Admin[744] = "Send Welcome Email To New Users?";
	$Admin[745] = "If you want to send new users a welcome email once, they sign up you can do so. You can also activate the email verification option so users will have to activate in the email they are sent. You have the ability to change what this email says on the the <a href='AdminEmails.php'>System Emails</a> page.";
	$Admin[746] = "Yes, send users a welcome email.";
	$Admin[747] = "No, do not send users a welcome email.";
	$Admin[748] = "Enable Users?";
	$Admin[749] = "If you select YES on this, then your users are auto enabled once they have signed up. If you choose NO on this, then you will have to approve users manually through the <a href='AdminViewusers.php'>View Users</a> page. If the user is not enabled, he won`t be able to login.";
	$Admin[750] = "Yes, enable users upon signup.";
	$Admin[751] = "No, do not enable users upon signup.";
	$Admin[752] = "You can also set it so that each invite code is set to a particular email address. If YES, then anyone who has a matching email and code may sign up. If NO, anyone with a valid code may sign up and the email won`t be required to match.";
	$Admin[753] = "Yes, check that a user's email address was invited before accepting their invite code.";
	$Admin[754] = "No, anyone with an invite code can signup, regardless of their email address.";
	$Admin[1029] = 'Yes, enable phonebook option';
	$Admin[1030] = 'No, disable phonebook option';
	$Admin[1031] = 'Do you want your users to be able to have phonebook on this site?';
	$Admin[1032] = 'Phonebook';
	$Admin[1033] = 'Turn off public signups and only allow invited users to signup?';
	$Admin[1034] = 'Should each invite code be bound to each invited email address?';
	
//	break;

//case "AdminStats":
	$Admin[755] = "Network Statistics";
	$Admin[756] = "This page monitors the traffic patterns and network usage for your site. You can select any of the stats available below to get started.";
	$Admin[757] = "Page Views";
	$Admin[758] = "Logins";
	$Admin[759] = "New Signups";
	$Admin[760] = "New Friends";
	$Admin[761] = "Week of";
	$Admin[762] = " (";
	$Admin[763] = ")";
	$Admin[764] = "Network Usage";
	$Admin[765] = "Quick Summary";
	$Admin[766] = "Visits/Impressions";
	$Admin[767] = "New Logins";
	$Admin[768] = "New Signups";
	$Admin[769] = "New Friendships";
	$Admin[770] = "Other Stats";
	$Admin[771] = "Referring URLs";
	$Admin[772] = "Space Used";
	$Admin[773] = "Period:";
	$Admin[774] = "This Week (Daily)";
	$Admin[775] = "This Month (Daily)";
	$Admin[776] = "This Year (Monthly)";
	$Admin[777] = "Refresh";
	$Admin[778] = "Referring URLs";
	$Admin[779] = "These are the 100 most common referring URLs tracked from your <a href='../Home.php' target='_blank'>Home.php</a> file.<br>This indicates that most new traffic is coming from the following URLs.<br>Clearing the list periodically will give you fresh referrer data.";
	$Admin[780] = "clear now";
	$Admin[781] = "Hits";
	$Admin[782] = "Url";
	$Admin[783] = "The referrer URL list is currently empty.";
	$Admin[784] = "Uploaded Media:";
	$Admin[785] = "Database Size:";
	$Admin[786] = "Total Space Used (Estimated):";
	$Admin[787] = "Quick Network Statistics";
	$Admin[788] = "The following data is a quick snapshot of your social network.<br>The data does not include any items that have been deleted.";
	$Admin[789] = "Total Users:";
	$Admin[790] = "Total Private Messages:";
	$Admin[791] = "Total Comments:";
	$Admin[792] = "users";
	$Admin[793] = "messages";
	$Admin[794] = "comments";
	$Admin[795] = "Last Period";
	$Admin[796] = "Next Period";
//	break;

//case "AdminSubnetworks":
	$Admin[797] = "Subnetworks";
	$Admin[798] = "You have the ability to organize users into \"sub networks\" in your social network based on the profile information they have in common with each other. You can then limit access and privacy between sub networks, display sub network-specific content in your templates, or to simply organize your users.";
	$Admin[799] = "Primary Requirement Field:";
	$Admin[800] = "Secondary Requirement Field:";
	$Admin[801] = "Update";
	$Admin[802] = "Add New Subnetwork";
	$Admin[803] = "ID";
	$Admin[804] = "Name";
	$Admin[805] = "Users";
	$Admin[806] = "Requirements";
	$Admin[807] = "Options";
	$Admin[808] = "edit";
	$Admin[809] = "delete";
	$Admin[810] = "Default Subnetwork";
	$Admin[811] = "Users Not In Another Subnetwork";
	$Admin[812] = "Email Address";
	$Admin[813] = "Your requirement fields have been updated.";
	$Admin[814] = "Delete Subnetwork";
	$Admin[815] = "Are you sure you want to delete this subnetwork? All users within this subnetwork will be moved to the default subnetwork.";
	$Admin[816] = "Cancel";
	$Admin[817] = "The subnetwork you selected has been deleted.";
	$Admin[818] = "<b>Important:</b> \"Required on Signup\" must be set on the requirement fields you choose on the <a href='AdminSignup.php'>Signup Settings</a> page. If they are not set to \"Required on Signup\", they may not appear during the signup process and users will not have an opportunity to fill them out. Because they have not filled out your requirement fields, they will automatically be placed in the \"Default Subnetwork\" until they fill out the fields. If you already have users in sub networks on your social network and you change the requirement fields or the requirements of a specific sub network, users will remain in the same sub networks (based on the original requirements or differentiation fields you had set) until their profile information is updated. All users that are not sorted into a sub network will be placed into the \"Default Subnetwork\" until their profile information is updated and matches the requirements of a different sub network. When a sub network is deleted, users within the deleted sub network will be moved into the \"Default Subnetwork\". <br><br><b>An example:</b> If you decided to create two sub networks - one for male users and one for female users - you would create a profile field called \"Gender\" and use it as your primary requirement field below. If you want to have four sub networks - males in California, females in California, males outside California, and females outside California - you should create a profile field called \"location\" and use it as your secondary requirement field. Then, create sub networks with the appropriate requirements so that these four sub networks are mutually exclusive.";
	$Admin[819] = "(Age)";
	$Admin[820] = "Show Detailed Instructions";
//	break;

//case "AdminSubnetworksAdd":
	$Admin[821] = "Add Subnetwork";
	$Admin[822] = "To create a new subnetwork, complete the following form. You will need to specify who can belong to this subnetwork. You can do this by creating requirements. Note that you must specify a requirement with regards to your primary requirement field. Requirements based on the secondary requirement field are optional. The use of wildcards (*) is accepted when using the \"is equal to (==)\" and \"is not equal to (!=)\" operators. String values (such as words and phrases) will NOT be case sensitive. Please make sure that subnetwork requirements are mutually exclusive; that is, make sure users can only be placed in one subnetwork based on the requirements you provide. If the requirements overlap with another subnetwork's requirements, users will be randomly placed into one of the overlapping subnetworks.";
	$Admin[823] = "Name";
	$Admin[824] = "Requirements";
	$Admin[825] = "And";
	$Admin[826] = "is equal to ( == )";
	$Admin[827] = "is not equal to ( != )";
	$Admin[828] = "is greater than ( > )";
	$Admin[829] = "is less than ( < )";
	$Admin[830] = "is greater than or equal to ( >= )";
	$Admin[831] = "is less than or equal to ( <= )";
	$Admin[832] = "Add Subnetwork";
	$Admin[833] = "Cancel";
	$Admin[834] = "You must specify a primary requirement.";
	$Admin[835] = "Please specify a name for this subnetwork.";
	$Admin[836] = "Please complete the secondary requirement or leave it completely blank.";
	$Admin[837] = "Email Address";
	$Admin[838] = "(Age)";
//	break;

//case "AdminSubnetworksEdit":
	$Admin[839] = "Edit Subnetwork";
	$Admin[840] = "To edit this subnetwork, please use the following form. You will need to specify who can belong to this subnetwork. You can do this by creating requirements. Note that you must specify a requirement with regards to your primary requirement field. Requirements based on the secondary requirement field are optional. The use of wildcards (*) is accepted when using the \"is equal to (==)\" and \"is not equal to (!=)\" operators. String values (such as words and phrases) will NOT be case sensitive. Please make sure that subnetwork requirements are mutually exclusive; that is, make sure users can only be placed in one subnetwork based on the requirements you provide. If the requirements overlap with another subnetwork's requirements, users will be randomly placed into one of the overlapping subnetworks.";
	$Admin[841] = "Name";
	$Admin[842] = "Requirements";
	$Admin[843] = "And";
	$Admin[844] = "is equal to";
	$Admin[845] = "is not equal to";
	$Admin[846] = "is greater than";
	$Admin[847] = "is less than";
	$Admin[848] = "is greater than or equal to";
	$Admin[849] = "is less than or equal to";
	$Admin[850] = "Edit Subnetwork";
	$Admin[851] = "Cancel";
	$Admin[852] = "You must specify a requirement with regards to the primary requirement field.";
	$Admin[853] = "Please specify a name for this subnetwork.";
	$Admin[854] = "Please complete the secondary requirement or leave it completely blank.";
	$Admin[855] = "Email Address";
	$Admin[856] = "(Age)";
//	break;

//case "AdminTemplates":
	$Admin[857] = "HTML Templates";
	$Admin[858] = "You have total over your social network`s look and feel. The PHP code which powers your site is totally different than the HTML code used for presentation. The HTML code is stored in the templates below, which you can edit directly on this page. If you want to edit a template, you can simply click its name.<br><br><b>About the template system:<br><br></b>The system uses Smarty, considered the most advanced and renown third-party PHP templating system out there. Though the templates are primarily HTML, some Smarty tags are used for different purposes. For help with the templating system, you can visit the <a href='http://smarty.net' target='_blank'>Smarty</a> website. Note that many tags you will see in the templates are actually language variables. These are used to display bits of text that have been specified in your language pack. To change these bits of text, you must edit the language file you are using in the <b><i>lang</i></b> directory on your server. <br><br><b>Adding your site`s header/footer wrapper: </b><br><br> The easiest way to integrate your social network into your website is to copy your website's header/footer HTML and paste it into the <b><i>Header/Footer Templates</i></b> below. To make global changes to the CSS style sheet, you can edit <b><i>styles.css</i></b>.";
	$Admin[859] = "Logged-in User Pages";
	$Admin[860] = "Public Pages";
	$Admin[861] = "Header/Footer Templates";
	$Admin[862] = "(Global Header HTML)";
	$Admin[863] = "(Global Footer HTML)";
//	break;

//case "AdminTemplatesEdit":
	$Admin[864] = "Edit Template";
	$Admin[865] = "The HTML and Smarty code for this template is displayed below. After making your desired changes to the template, be sure to click the \"Save Changes\" button. For help with Smarty, see the <a href='http://smarty.php.net' target='_blank'>official website</a> and <a href='http://smarty.php.net/crashcourse.php' target='_blank'>crash course</a>.";
	$Admin[866] = "Save Changes";
	$Admin[867] = "Cancel";
	$Admin[868] = "The file you specified is not a valid template file.";
	$Admin[869] = "The template you specified could not be found.";
	$Admin[870] = "The template you specified could not be read. Try setting full permissions (CHMOD 777) to this file and the templates directory.";
	$Admin[871] = "The template you specified is not writable. Try setting full permissions (CHMOD 777) to this file and the templates directory.";
	$Admin[872] = "Cannot write to file";
	$Admin[873] = "Return";
//	break;

//case "AdminUrl":
	$Admin[874] = "URL Settings";
	$Admin[875] = "Some of your social network members will prefer to have profile addresses (URLs) that are easier to remember, more visually appealing, and more search-engine friendly. By default, your users' URLs will appear in the \"normal\" format as demonstrated below. If you want to give them \"subdirectory URLs\", your web server must be running Apache and have mod_rewrite installed.";
	$Admin[876] = "After you select a URL style and click the submit button below, you will be prompted with further instructions for enabling the URL style of your choice. Please follow these instructions carefully to ensure that your URLs are working properly.";
	$Admin[877] = "Normal URLs";
	$Admin[878] = "Subdirectory URLs";
	$Admin[879] = "Save Changes";
	$Admin[880] = " - (Need help? Review the instructions <a href='AdminHelpUrl.php'>here</a>.)";
	$Admin[881] = "Your changes have been saved.";
	$Admin[882] = "URL Style";
	$Admin[883] = "<b>Normal URLs</b><br>Profile URL: http://www.yourdomain.com/Profile.php?user=username";
	$Admin[884] = "<b>Subdirectory URLs</b><br>Profile URL: http://www.yourdomain.com/username";
//	break;

//case "AdminUrlHelp":
	$Admin[885] = "URL Settings Help";
	$Admin[886] = "We have now set up the system to use subdirectory URLs, which require an .htaccess file in your PhpSocial root directory. Copy and paste the code in the following box into a blank text file named .htaccess, and place it into your PhpSocial root directory. This is the directory on your server in which you have installed PhpSocial.";
	$Admin[887] = "Return to URL Settings";
//	break;

//case "AdminViewadmins":
	$Admin[888] = "View Admin Accounts";
	$Admin[889] = "You may have more than one administrator on your social network. The first time you create an admin (when you install) this admin because \"superadmin\" an will not be able to be deleted. The superadmin can then  create and delete other admin accounts which are useful if you have a team or staff of admins. Below, you will see all of your admin accounts listed.";
	$Admin[890] = "ID";
	$Admin[891] = "Username";
	$Admin[892] = "Name";
	$Admin[893] = "Email";
	$Admin[894] = "Status";
	$Admin[895] = "Options";
	$Admin[896] = "Superadmin";
	$Admin[897] = "Admin";
	$Admin[898] = "edit";
	$Admin[899] = "delete";
	$Admin[900] = "Add Admin";
	$Admin[901] = "Are you sure you want to delete this admin?";
	$Admin[902] = "Delete Admin";
	$Admin[903] = "Cancel";
	$Admin[904] = "Delete Admin?";
//	break;

//case "AdminViewadminsAdd":
	$Admin[905] = "Add Admin Account";
	$Admin[906] = "To create a new admin account, please complete the form below. This account will not be able to delete or modify the superadmin account.";
	$Admin[907] = "Username:";
	$Admin[908] = "Password:";
	$Admin[909] = "Confirm Password:";
	$Admin[910] = "Name:";
	$Admin[911] = "Email:";
	$Admin[912] = "Add Admin";
	$Admin[913] = "Cancel";
//	break;

//case "AdminViewadminsEdit":
	$Admin[914] = "Edit Admin Account";
	$Admin[915] = "To edit this admin account, please modify the fields below. To change the password, complete the Old Password, New Password, and New Password Confirmation fields. If you do not wish to change this admin's password, leave those fields blank.";
	$Admin[916] = "Username:";
	$Admin[917] = "New Password:";
	$Admin[918] = "Confirm New Password:";
	$Admin[919] = "Name:";
	$Admin[920] = "Email:";
	$Admin[921] = "Edit Admin";
	$Admin[922] = "Cancel";
	$Admin[923] = "Old Password";
//	break;

//case "AdminViewplugins":
	$Admin[924] = "View Plugins";
	$Admin[925] = "Any phpSocial plugins that you have installed will appear on this page. Note that some plugins may have user level-specific settings which are available on the <a href='AdminLevels.php'>User Levels</a> page.";
	$Admin[926] = "There are currently no plugins installed. Visit the <a href='http://www.phpsocial.net/' target='_blank'>PhpSocial site</a> to add plugins to your social network!";
	$Admin[927] = "Install Plugin";
	$Admin[928] = "Warning: You have not yet deleted install_";
	$Admin[929] = "Install Upgrade";
	$Admin[930] = "Upgrade Available!";
	$Admin[931] = ".php. Leaving this file on your server is a security risk!";
//	break;


//case "AdminViewreports":
	$Admin[932] = "View Reports";
	$Admin[933] = "Reports of any inappropriate content, spam, system abuse, etc. are sent to this page and will show up in a list. You can then use search fields to look for reports that contain a particular word or phrase.  The system will delete very old reports from time to time.";
	$Admin[934] = "details";
	$Admin[935] = "You don`t have any reports currently.";
	$Admin[936] = "login & view";
	$Admin[937] = "delete";
	$Admin[938] = "Delete Selected";
	$Admin[939] = "Spam";
	$Admin[940] = "Content";
	$Admin[941] = "Abuse";
	$Admin[942] = "Other";
	$Admin[943] = "Details";
	$Admin[944] = "other";
	$Admin[945] = "Reason";
	$Admin[946] = "Filter";
	$Admin[947] = "Total Reports Found";
	$Admin[948] = "Page:";
	$Admin[949] = "ID";
	$Admin[950] = "Username";
	$Admin[951] = "Options";
	$Admin[952] = "spam";
	$Admin[953] = "content";
	$Admin[954] = "abuse";
//	break;

//case "AdminViewreportsEdit":
	$Admin[955] = "View Report";
	$Admin[956] = "This report was sent to you by a concerned user. The report details are listed below, and you can view the subject matter of the report by clicking the link next to \"Object\".";
	$Admin[957] = "Reporter:";
	$Admin[958] = "Object:";
	$Admin[959] = "Reason:";
	$Admin[960] = "Details:";
	$Admin[961] = "Delete Report";
	$Admin[962] = "Cancel";
	$Admin[963] = "Spam";
	$Admin[964] = "Inappropriate Content";
	$Admin[965] = "Abuse";
	$Admin[966] = "Other";
//	break;

//case "AdminViewusers":
	$Admin[967] = "View Users";
	$Admin[968] = "All users that exist in your social network will show up on this page. If you want more information about a particular user, you can click on the \"edit\" link in its row. Then click the \"login\" link to login as that user. You can also use the filter fields to find users based on your exact criteria. If you leave all the filter fields blank, every user in your system will show up.";
	$Admin[969] = "Username";
	$Admin[970] = "unverified";
	$Admin[971] = "Email";
	$Admin[972] = "Enabled";
	$Admin[973] = "Signup Date";
	$Admin[974] = "Options ";
	$Admin[975] = "Yes";
	$Admin[976] = "No";
	$Admin[977] = "edit";
	$Admin[978] = "delete";
	$Admin[979] = "login";
	$Admin[980] = "Filter";
	$Admin[981] = "ID";
	$Admin[982] = "Users Found";
	$Admin[983] = "Page:";
	$Admin[984] = "Delete User";
	$Admin[985] = "Are you sure you want to delete this user? Warning: Any plugin objects created by this user will also be deleted!";
	$Admin[986] = "Cancel";
	$Admin[987] = "No users were found.";
	$Admin[988] = "Verified";
	$Admin[989] = "Delete Selected";
	$Admin[990] = "User Level";
	$Admin[991] = "Subnetwork";
	$Admin[992] = "Default";
//	break;

//case "AdminViewusersEdit":
	$Admin[993] = "Edit User:";
	$Admin[994] = "To edit this users's account, make changes to the form below. If you want to temporarily prevent this user from logging in, you can set the user account to \"disabled\" below.";
	$Admin[995] = "Only enter if you want to reset pass.";
	$Admin[996] = "Total Friends:";
	$Admin[997] = "Total Logins:";
	$Admin[998] = "Messages Stored:";
	$Admin[999] = "Last Login:";
	$Admin[1000] = "Email Address:";
	$Admin[1001] = "Username:";
	$Admin[1002] = "Password:";
	$Admin[1003] = "Enabled?";
	$Admin[1004] = "Save Changes";
	$Admin[1005] = "Cancel";
	$Admin[1006] = "Never";
	$Admin[1007] = "Profile Comments Made:";
	$Admin[1008] = "You must fill out all the fields.";
	$Admin[1009] = "Username and Password fields must be alphanumeric.";
	$Admin[1010] = "Please make sure you have entered a valid email address.";
	$Admin[1011] = "The username you have entered is already in use by another user.";
	$Admin[1012] = "The email address you have entered is already in use by another user.";
	$Admin[1013] = "Passwords must be at least 6 characters in length.";
	$Admin[1014] = "unverified";
	$Admin[1015] = "resend verification email";
	$Admin[1016] = "Enabled";
	$Admin[1017] = "Disabled";
	$Admin[1018] = "The number of invites left must be between 0 and 999.";
	$Admin[1019] = "Invites Remaining:";
	$Admin[1020] = "manually verify";
	$Admin[1021] = "Email verification has been resent.";
	$Admin[1022] = "User email has been manually verified.";
	$Admin[1023] = "User Level:";
//	break;

//}

//license
	$Admin[1024] = "License error";
	$Admin[1025] = "Your license key is invalid!";
	$Admin[1026] = "Reenter license key";

// Admin blocks
	$Admin[1027] = 'Homepage blocks';
	$Admin[1028] = 'You can choose which blocks to display on the homepage.';


// ASSIGN ALL SMARTY VARIABLES
  while(list($key, $val) = each($Admin)) {
    $smarty->assign('Admin'.$key, $val);
  }
//}


switch ($page) {
case "AdminViewusers":
	$admin_viewusers[1] = "View Users";
	$admin_viewusers[2] = "This page lists all of the users that exist on your social network. For more information about a specific user, click on the \"edit\" link in its row. Click the \"login\" link to login as a specific user. Use the filter fields to find specific users based on your criteria. To view all users on your system, leave all the filter fields blank. ";
	$admin_viewusers[3] = "Username";
	$admin_viewusers[4] = "unverified";
	$admin_viewusers[5] = "Email";
	$admin_viewusers[6] = "Enabled";
	$admin_viewusers[7] = "Signup Date";
	$admin_viewusers[8] = "Options ";
	$admin_viewusers[9] = "Yes";
	$admin_viewusers[10] = "No";
	$admin_viewusers[11] = "edit";
	$admin_viewusers[12] = "delete";
	$admin_viewusers[13] = "login";
	$admin_viewusers[14] = "Filter";
	$admin_viewusers[15] = "ID";
	$admin_viewusers[16] = "Users Found";
	$admin_viewusers[17] = "Page:";
	$admin_viewusers[18] = "Delete User";
	$admin_viewusers[19] = "Are you sure you want to delete this user? Warning: Any plugin objects created by this user will also be deleted!";
	$admin_viewusers[20] = "Cancel";
	$admin_viewusers[21] = "No users were found.";
	$admin_viewusers[22] = "Verified";
	$admin_viewusers[23] = "Delete Selected";
	$admin_viewusers[24] = "User Level";
	$admin_viewusers[25] = "Subnetwork";
	$admin_viewusers[26] = "Default";
	break;
}
if(is_array(${"$page"})) {
  reset(${"$page"});
  while(list($key, $val) = each(${"$page"})) {
    $smarty->assign($page.$key, $val);
  }
}

?>