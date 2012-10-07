{* SHOW MENU IF USER IS LOGGED IN AND ACCESSING USER AREA *}
{if $user->user_exists != 0}
<div class="block">
    <div class="block-top"><span>&nbsp;</span></div>
    <ul>
        <li><a href="Profile.php?user={$user->user_info.user_username}">{$Application11}</a></li>
        {* SHOW FRIENDS MENU ITEM IF ENABLED *}
		<li><a href='UserEditprofile.php'>Edit Profile</a></li>
        {if $setting.setting_connection_allow != 0}
        <li><a href="UserFriends{if $total_friends_requests>0}Requests{/if}.php">{$Application14}{if $total_friends_requests>0} ({$total_friends_requests}){/if}</a></li>
        {/if}

        {* show plugin menu items *}
        {section name=menu_loop loop=$global_plugins}
        {if $global_plugins[menu_loop] != '' && $global_plugins[menu_loop] != 'Phototagger'} 
        	{if $global_plugins[menu_loop] == 'Chat'}
        		<li><a href='{$global_plugins[menu_loop]}.php'>{$global_plugins[menu_loop]}</a></li>
        	{elseif $global_plugins[menu_loop] == 'Music'}
        		<li><a href='UserMusicEdit.php'>{$global_plugins[menu_loop]}</a></li>
        	{elseif $global_plugins[menu_loop] == 'Vidfeeder'}
        		<li><a href='Vidfeeder.php'>{$global_plugins[menu_loop]}</a></li>
        	{else}
        		<li><a href='User{$global_plugins[menu_loop]}.php'>{$global_plugins[menu_loop]}s</a></li>
        	{/if}
        {/if}
        {/section}

        {* SHOW MESSAGES MENU ITEM IF ENABLED *}
        {if $user->level_info.level_message_allow != 0}
        <li><a href='UserMessages.php'>{$Application15}{if $user_unread_pms != 0} ({$user_unread_pms}){/if}</a></li>
        {/if}

        {* SHOW SETTINGS *}
        <li{if !$setting.setting_signup_phone == 1} class="last-li"{/if}><a href='UserAccount.php'>{$Application16}</a></li>
        {if $setting.setting_signup_phone == 1}<li class="last-li"><a href='Phonebook.php'>{$Application740}</a></li>{/if}
        
    </ul>
    <div class="block-bot"><span>&nbsp;</span></div>
</div>
{/if}

{literal}
<style type="text/css">
	.ad_left div{
		text-align: center;
		padding:5px;
	}
</style>
{/literal}

{if $ads->ad_left != ""}
<div class="block">
	<div class='ad_left' style=' visibility: visible;text-align: center;'>{$ads->ad_left}</div>
</div>
{/if}
