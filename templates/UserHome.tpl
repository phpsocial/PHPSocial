{include file='Header.tpl'}

<table cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td class='home_left' width='200'>

  {* SHOW USER PHOTO *}
  <div class='home_photo'><a href='{$url->url_create('profile', $user->user_info.user_username)}'><img src='{$user->user_photo("./images/nophoto.gif")}' class='photo' border='0'></a></div>

  {* SHOW MENU *}
  <table class='home_menu' cellpadding='0' cellspacing='0' width='100%'>
  <tr><td class='home_menu1'><a href='{$url->url_create('profile',$user->user_info.user_username)}'><img src='./images/icons/menu_profile.gif' class='icon' border='0'>{$Application635}</a></td></tr>
  <tr><td class='home_menu1'><a href='UserEditprofile.php'><img src='./images/icons/menu_editprofile.gif' class='icon' border='0'>{$Application636}</a></td></tr>
  {if $setting.setting_connection_allow != 0}<tr><td class='home_menu1'><a href='UserFriends.php'><img src='./images/icons/menu_friends.gif' class='icon' border='0'>{$Application637}</a></td></tr>{/if}
  <tr><td class='home_menu1'><a href='SearchAdvanced.php'><img src='./images/icons/search16.gif' class='icon' border='0'>{$Application637}</a></td></tr>
  </table>

  {* SHOW ONLINE USERS IF MORE THAN ZERO *}
  {if $online_users|@count > 0}
    <table cellpadding='0' cellspacing='0' class='portal_table' align='center' width='100%'>
    <tr><td class='header'>{$Application629} ({$online_users|@count})</td></tr>
    <tr>
    <td class='home_box'>
      {section name=online_users_loop loop=$online_users max=20}{if $smarty.section.online_users_loop.rownum != 1}, {/if}<a href='{$url->url_create('profile',$online_users[online_users_loop])}'>{$online_users[online_users_loop]}</a>{/section}
    </td>
    </tr>
    </table>
  {/if}

</td>
{* BEGIN MIDDLE COLUMN *}
<td class='home_middle'>
  {* SHOW RECENT ACTIVITY LIST *}
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr><td class='home_header'>{$Application620}</td></tr>
  <td class='home_box'>
    {section name=actions_loop loop=$actions}
      {* DISPLAY ACTION *}
      <div id='action_{$actions[actions_loop].action_id}'  class='home_action{if $smarty.section.actions_loop.last == true}_bottom{/if}'>
	<table cellpadding='0' cellspacing='0'>
	<tr>
	<td valign='top'><img src='./images/icons/{$actions[actions_loop].action_icon}' border='0' class='icon'></td>
	<td valign='top' width='100%'>
	  <div class='home_action_date'>{$datetime->time_since($actions[actions_loop].action_date)}</div>
	  {$actions[actions_loop].action_text|choptext:50:"<br>"}
        </td>
	</tr>
	</table>
      </div>
    {sectionelse}
      {$Application628}
    {/section}
  </td>
  </tr>
  </table>
</td>

{* BEGIN RIGHT COLUMN *}
<td class='home_right' width='190'>

  {* SHOW STATS AND NOTIFICATIONS *}  
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr><td class='home_header'>{$Application622}</td></tr>
  <tr>
  <td class='home_box'>
    {* SHOW NEW MESSAGE NOTIFICATION *}
    {if $user_unread_pms > 0}
      <div style='margin-bottom: 5px;'><a href='UserMessages.php'><img src='./images/icons/newmessage16.gif' border='0' class='icon'>{$user_unread_pms} {$Application633}</a></div>
    {/if}
    {* SHOW NEW FRIEND REQUESTS NOTIFICATION *}
    {if $total_friend_requests > 0}
      <div style='margin-bottom: 5px;'><a href='UserFriendsRequests.php'><img src='./images/icons/newfriends16.gif' border='0' class='icon'>{$total_friend_requests} {$Application634}</a></div>
    {/if}
    {* SHOW PLUGIN NOTIFICATIONS *}
    {section name=notify_loop loop=$notifications}
      <div style='margin-bottom: 5px;'><a href='{$notifications[notify_loop].notify_url}'><img src='./images/icons/{$notifications[notify_loop].notify_icon}' border='0' class='icon'>{$notifications[notify_loop].notify_text}</a></div>
    {/section}
    {* SHOW NUMBER OF TIMES PROFILE HAS BEEN VIEWED *}
    <div><img src='./images/icons/newviews16.gif' border='0' class='icon'>{$user->user_info.user_views_profile} {$Application624} {if $user->user_info.user_views_profile != 0}[ <a href='Profile.php?task=resetviews'>{$Application625}</a> ]{/if}</div>
  </td>
  </tr>
  </table>

  {* SHOW STATUS *}
  <table cellpadding='0' cellspacing='0' width='100%' style='margin-top: 10px;'>
  <tr><td class='home_header'>{$Application630}</td></tr>
  <tr>
  <td class='home_box'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td valign='top'><img src='./images/icons/status16.gif' border='0' class='icon2'>&nbsp;&nbsp;</td>
    <td>
      <div id='ajax_currentstatus_none'{if $user->user_info.user_status != ""} style='display: none;'{/if}>
        <a href="javascript:void(0);" onClick="changeStatus()">{$Application623}</a>
      </div>
      <div id='ajax_currentstatus'{if $user->user_info.user_status == ""} style='display: none;'{/if}>
        {$Application632} <span id='ajax_currentstatus_value'>{$user->user_info.user_status|choptext:12:"<br>"}</span>
        <br>[ <a href="javascript:void(0);" onClick="changeStatus()">{$Application631}</a> ]
      </div>
      <div id='ajax_changestatus' style='display: none;'>
	<form action='UserEditprofileStatus.php' method='post' id='ajax_statusform' target='ajax_statusframe' onSubmit="changeStatus_do()">
	{$Application632}:<br>
	<input type='text' class='text_small' name='status_new' id='status_new' maxlength='100' value='{$user->user_info.user_status}' size='10' style='width: 140px; margin: 2px 0px 2px 0px;'>
	<br>
        <a href="javascript:void(0);" onClick="changeStatus_submit();">{$Application626}</a> |
        <a href="javascript:void(0);" onClick="changeStatus_return();">{$Application627}</a>
	<input type='hidden' name='task' value='dosave'>
	<input type='hidden' name='is_ajax' value='1'>
	</form>
      </div>
      <iframe id='uploadframe' name='ajax_statusframe' style='display: none;' src="UserEditprofileStatus.php?task=blank"></iframe> 
    </td>
    </tr>
    </table>
  </td>
  </tr>
  </table>

  {* SHOW LAST 3 NEWS ANNOUNCEMENTS *}
  <table cellpadding='0' cellspacing='0' width='100%' style='margin-top: 10px;'>
  <tr><td class='home_header'>{$Application639}</td></tr>
  <tr>
  <td class='home_box'>
    {if $news_total > 0}
      {section name=news_loop loop=$news}
        <table cellpadding='0' cellspacing='0' width='100%'>
        <tr><td valign='top'><b>{$news[news_loop].item_subject}</b><br><i>{$news[news_loop].item_date}</i><br>{$news[news_loop].item_body}</td></tr>
        </table>
        {if $smarty.section.news_loop.last == false}<br>{/if}
      {/section}
    {else}
      {$Application640}
    {/if}
  </td>
  </tr>
  </table>

</td>
</tr>
</table>

{include file='Footer.tpl'}