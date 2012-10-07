<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/DTD/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{$global_page_title}</title>
    <base href='{$baseurl}' />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <link href="templates/reset_client.css" rel="stylesheet" type="text/css" />
    <link href="templates/main_client.css" rel="stylesheet" type="text/css" />
	
    <script type="text/javascript" src="include/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="include/js/jquery-ui-1.7.2.custom.min.js"></script>
	<script src="include/js/jquery.easing.1.3.js" type="text/javascript"></script>
	<script src="include/js/jquery.kwicks-1.5.1.pack.js" type="text/javascript"></script>
    <script type="text/javascript" src="include/js/jquery.accordion.js"></script>
    <script type="text/javascript" src="include/js/main.js"></script>

	<!--[if lt IE 7]><script type="text/javascript" src="include/js/unitpngfix.js"></script><![endif]-->

    <!--[if gte IE 5.5]>
        <![if lte IE 6]>
        <iframe id="shim" src="" style="position:absolute;display:none;filter:progid:DXImageTransform.Microsoft.Chroma(Color='#ffffff');" scrolling="no" frameborder="0"></iframe>
        <iframe id="shim2" src="" style="position:absolute;display:none;filter:progid:DXImageTransform.Microsoft.Chroma(Color='#ffffff');" scrolling="no" frameborder="0"></iframe>
        <![endif]>
    <![endif]-->

    {* CODE FOR VARIOUS JAVASCRIPT-BASED FEATURES, DO NOT REMOVE *}
    <script type="text/javascript" src="include/js/tips.js"></script>
    <script type="text/javascript" src="include/js/showhide.js"></script>
    <script type="text/javascript" src="include/js/suggest.js"></script>
    <script type="text/javascript" src="include/js/status.js"></script>

    {* ASSIGN PLUGIN MENU ITEMS AND INCLUDE NECESSARY STYLE/JAVASCRIPT FILES *}
    {section name=header_loop loop=$global_plugins}
        {capture assign='pltpl1'}../plugins/{$global_plugins[header_loop]}/templates/Header{$global_plugins[header_loop]}.tpl{/capture}
        {capture assign='pltpl2'}../../{$global_plugins[header_loop]}/templates/Header{$global_plugins[header_loop]}.tpl{/capture}
        {if $location == "plugins" || $location == "pluginsfront"}
            {include file=$pltpl2}
        {else}
            {include file=$pltpl1}
        {/if}
    {/section}
    {array var="global_plugin_menu" value=''}
    
</head>
<body>
<div id="container">
<div id="header">
    <div id="quickSearch">
        <form action='Search.php' method='get'>
            <div id="qquery">
                <input value="{$Application4}" onBlur="{literal}if(document.getElementById('qinput').value ==''){document.getElementById('qinput').value='{/literal}{$Application4}{literal}'} document.getElementById('list').style.dispay='none';  document.getElementById('qchoose').style.dispay='none';{/literal}" onFocus="document.getElementById('qinput').value=''" id="qinput"/>
                <span id="qchoose">&nbsp;</span>
            </div>
            <div id="qfriends">
                <div class="selected-cat">
                    <a href="#">{$Application69}</a>
                </div>
                <input type="text" name="search_text" value="Search"/>
            </div>
            <ul class="src-cats" id="list">
                <li><a href="#" class="active">{$Application69}</a></li>
                {section name=menu_loop loop=$global_plugins_search}
                {if $global_plugins_search[menu_loop] != ''}
                <li><a href='#' alt="{$global_plugins_search[menu_loop]}">{$global_plugins_search[menu_loop]}s</a></li>
                {/if}
                {/section}
            </ul>
            <input type='hidden' name='task' value='dosearch' />
            <input type='hidden' id="t" name='t' value='0' />
            <input type="submit" style="position: absolute; top: -100px"/>
        </form>
    </div>

 

    <a href="/" id="logo"></a>
    <ul id="nav">
                {* IF USER IS LOGGED IN, SHOW APPROPRIATE TOP MENU ITEMS *}
        {if $user->user_exists != 0}
         <li class="cat_item"><a href="UserLogout.php">{$Application8}</a></li>

        {* IF USER IS NOT LOGGED IN, SHOW APPROPRIATE TOP MENU ITEMS *}
        {else}
        <li class="cat_item"><a href="Login.php">{$Application10}</a></li>
        <li class="cat_item"><a href="Signup.php">{$Application9}</a><span>|</span></li>
        {/if}

        <li class="cat_item"><a href="Help.php">{$Application6}</a><span>|</span></li>
        {if $setting.setting_permission_invite}
            <li class="cat_item"><a href="Invite.php">{$Application5}</a><span>|</span></li>
        {/if}
        {if (!($setting.setting_news_page == 0 && !$user->user_exists))}
        <li class="cat_item"><a href="News.php">{$Application743}</a><span>|</span></li>
        {/if}
        <li class="cat_item"><a href="Search.php">{$Application4}</a><span>|</span></li>
        <li class="cat_item"><a href="Home.php">{$Application3}</a><span>|</span></li>
    </ul>
</div>

{* BEGIN PAGE CONTENT *}
<div id="wrapper">
{if $ads->ad_top != ""}<div class='ad_top' style='display: block; visibility: visible;text-align: center;float:right;padding:5px;'>{$ads->ad_top}</div>{/if}
