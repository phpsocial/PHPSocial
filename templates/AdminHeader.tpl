<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/DTD/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$Admin1}</title>
    <base href='{$baseurl}admin/' />
    <link href="../templates/reset.css" rel="stylesheet" type="text/css" />
    <link href="../templates/main.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="../include/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="../include/js/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript" src="../include/js/main.js"></script>
  
	{literal}
		<script language='JavaScript'>
			<!--
			function showdiv(id1) {
				if(document.getElementById(id1))
				document.getElementById(id1).style.display='block';
			}
			
			function hidediv(id1) {
				if(document.getElementById(id1))
				document.getElementById(id1).style.display='none';
			}
			Rollimage1 = new Array()
			Rollimage1['1'] = new Image(216,23);
			Rollimage1['1'].src = "../images/admin_menu_bg1.gif";
			Rollimage1['2'] = new Image(216,23);
			Rollimage1['2'].src = "../images/admin_menu_bg2.gif";
			//-->
		</script>
	{/literal}
</head>
<body>


<div id="container">
    	<div id="header">
            <a href="./AdminHome.php" id="logo"></a>
            <div class="admin-area">&nbsp;</div>
        </div>
        <div id="wrapper" >
            <div id="content" >
                <div class="layers">
                    <div class="tunedtabs">
                        <ul class="list01">
                            <li {if $category_main=='network'}class="active"{/if}><a href="AdminHome.php">{$Admin5}</a></li>
                            <li {if $category_main=='global'}class="active"{/if}><a href="AdminGeneral.php">{$Admin9}</a></li>
                            <li {if $category_main=='layout'}class="active"{/if}><a href="AdminTemplates.php">Layout Settings</a></li>
                            <li {if $category_main=='other'}class="active"{/if}><a href="AdminInvite.php">{$Admin21}</a></li>
                            <li><a href='AdminLogout.php'>{$Admin23}</a></li>
                        </ul>
                    </div>
                    <div class="info-cnt tuneddivs layer2">
                        {if $category_main=='network'}
                    	<div class="tunedtabs" id="network">
                            <ul class="list01-top">
                                <li {if $uri_page=='AdminHome.php'}class="active"{/if}><a href='AdminHome.php'>{$Admin6}</a></li>
                                <li {if $uri_page=='AdminViewusers.php' || $uri_page=='AdminViewusersEdit.php' }class="active"{/if}><a href='AdminViewusers.php'>{$Admin7}</a></li>
                                <li {if $uri_page=='AdminViewadmins.php' || $uri_page=='AdminEditViewadmins.php' || $uri_page=='AdminAddViewadmins.php'}class="active"{/if}><a href='AdminViewadmins.php'>{$Admin8}</a></li>
                                <li {if $uri_page=='AdminViewreports.php' || $uri_page=='AdminViewreportsEdit.php'}class="active"{/if}><a href='AdminViewreports.php'>{$Admin27}</a></li>
                                <li {if $uri_page=='AdminViewplugins.php' || $uri_page =='AdminViewevents.php' || $uri_page =='AdminEvent.php' || 
                                		$uri_page =='AdminViewalbums.php' || $uri_page =='AdminAlbum.php' ||
                                		$uri_page =='AdminViewarticles.php' || $uri_page =='AdminArticle.php' ||
                                		$uri_page =='AdminGroupAddfield.php' || $uri_page =='AdminGroupEditfield.php' ||
                                		$uri_page =='AdminViewgroups.php' || $uri_page =='AdminGroup.php' ||
                                		$uri_page =='AdminClassified.php' || $uri_page =='AdminViewclassifieds.php' ||
                                		$uri_page =='AdminBlog.php' || $uri_page =='AdminViewblogs.php' ||
                                		$uri_page =='AdminChat.php' || $uri_page =='AdminVideo.php' ||
                                		$uri_page =='AdminViewmusic.php' || $uri_page =='AdminPhototagger.php' ||
                                		$uri_page =='AdminViewvideos.php'}class="active"{/if}><a href='AdminViewplugins.php'>{$Admin17}</a></li>
                                <li {if $uri_page=='AdminLevels.php' || $uri_page=='AdminAddLevels.php' || 
                                		$uri_page =='AdminLevelsAlbumsettings.php' || $uri_page =='AdminLevelsAlbumsettings.php' ||
                                		$uri_page =='AdminLevelsArticlesettings.php' || $uri_page =='AdminLevelsGroupsettings.php' ||
                                		$uri_page =='AdminLevelsClassifiedsettings.php' || $uri_page =='AdminLevelsBlogsettings.php' ||
                                		$uri_page =='AdminLevelsVideosettings.php' || $uri_page =='AdminLevelsBlogsettings.php' ||
                                		$uri_page =='AdminLevelsMusicsettings.php' || $uri_page =='AdminLevelsBlogsettings.php' ||
                                		$uri_page=='AdminEditLevels.php'}class="active"{/if}><a href='AdminLevels.php'>{$Admin20}</a></li>
                                <li {if $uri_page=='AdminSubnetworks.php' || $uri_page=='AdminAddSubnetworks.php' || $uri_page=='AdminSubnetworksEdit.php'}class="active"{/if}><a href='AdminSubnetworks.php'>{$Admin13}</a></li>
                                <li {if $uri_page=='AdminAds.php' || $uri_page=='AdminAdsEdit.php' || $uri_page=='AdminAdsAdd.php'}class="active"{/if}><a href='AdminAds.php'>{$Admin32}</a></li>
                            </ul>
                        </div>
                        {/if}

                        {if $category_main=='global'}
                        <div class="tunedtabs" id="global">
                            <ul class="list01-top">
                                <li {if $uri_page=='AdminGeneral.php'}class="active"{/if}><a href='AdminGeneral.php'>{$Admin18}</a></li>
                                <li {if $uri_page=='AdminSignup.php'}class="active"{/if}><a href='AdminSignup.php'>{$Admin10}</a></li>
                                <li {if $uri_page=='AdminActivity.php'}class="active"{/if}><a href='AdminActivity.php'>{$Admin33}</a></li>
                                <li {if $uri_page=='AdminProfile.php' || $uri_page=='AdminProfileEditfield.php' || $uri_page=='AdminProfileAddfield.php' || $uri_page=='AdminProfileAddtab.php' || $uri_page=='AdminProfileEdittab.php'}class="active"{/if}><a href='AdminProfile.php'>{$Admin12}</a></li>
                                <li {if $uri_page=='AdminBanning.php'}class="active"{/if}><a href='AdminBanning.php'>{$Admin14}</a></li>
                                <li {if $uri_page=='AdminConnections.php'}class="active"{/if}><a href='AdminConnections.php'>{$Admin15}</a></li>
                                <li {if $uri_page=='AdminEmails.php'}class="active"{/if}><a href='AdminEmails.php'>{$Admin26}</a></li>
                            </ul>
                        </div>
                        {/if}

                        {if $category_main=='layout'}
                        <div class="tunedtabs" id="layout">
                            <ul class="list01-top">
                                <li {if $uri_page=='AdminTemplates.php'}class="active"{/if}><a href='AdminTemplates.php'>{$Admin11}</a></li>
                                <!-- li {if $uri_page=='AdminUrl.php'}class="active"{/if}><a href='AdminUrl.php'>{$Admin16}</a></li -->
                                <li {if $uri_page=='AdminHelpUrl.php'}class="active"{/if}><a href='AdminHelpUrl.php'>Help URL</a></li>
                            </ul>
                        </div>
                        {/if}

                        {if $category_main=='other'}
                        <div class="tunedtabs" id="other">
                            <ul class="list01-top">
                                <li {if $uri_page=='AdminInvite.php'}class="active"{/if}><a href='AdminInvite.php'>{$Admin28}</a></li>
                                <li {if $uri_page=='AdminAnnouncements.php'}class="active"{/if}><a href='AdminAnnouncements.php'>{$Admin25}</a></li>
                                <li {if $uri_page=='AdminLog.php'}class="active"{/if}><a href='AdminLog.php'>{$Admin22}</a></li>
                            </ul>
                        </div>
                        {/if}

<div class="info-cnt layer-in tuneddivs">

