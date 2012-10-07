{include file='Header.tpl'}
<div id="content">
    <div class="grey-head"><h2>Friend Requests</h2></div>

   <div class="layers">
    <ul class="list01">
        <li {if $uri_page=='UserFriends.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriends.php'>{$Application483}</a></li>
        <li {if $uri_page=='UserFriendsRequests.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsRequests.php'>{$Application484}</a></li>
        <li {if $uri_page=='UserFriendsRequestsOutgoing.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsRequestsOutgoing.php'>{$Application510}</a></li>
        <li {if $uri_page=='UserFriendsSettings.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsSettings.php'>{$Application509}</a></li>
    </ul>

    {* DISPLAY MESSAGE IF NO FRIEND REQUESTS *}
    {if $total_friends == 0 || !$friends}
    <div class="row" style="border:none;">
        <p style="color:red;" align="center">{$Application575}</p>
    </div>
    {* DISPLAY FRIEND REQUESTS *}
    {else}
    {section name=friend_loop loop=$friends}
    <div class="row" {if $smarty.section.friend_loop.last}style="border:none;"{/if}>
         <div class="f-right">
            {if $user->level_info.level_message_allow == 2}<a href='UserMessagesNew.php?to={$friends[friend_loop]->user_info.user_username}'>{$Application582}</a>{/if}

        </div>
        <a class="f-left" href='{$url->url_create('profile', $friends[friend_loop]->user_info.user_username)}'><img src='{$friends[friend_loop]->user_photo('./images/nophoto.gif')}' class='img' width='90'  alt="{$friends[friend_loop]->user_info.user_username}{$Application576}"></a>
        <dl style="float:none">
            <dt>Name</dt>
            <dd><a href='{$url->url_create('profile', $friends[friend_loop]->user_info.user_username)}'>{$friends[friend_loop]->user_info.user_username}</a></dd>
            <dt>{$Application576}</dt>
            <dd>{$datetime->time_since($friends[friend_loop]->user_info.user_dateupdated)}</dd>
            <dt>{$Application577}</dt>
            <dd>{$datetime->time_since($friends[friend_loop]->user_info.user_lastlogindate)}</dd>
        </dl>
        <div class="f-left">
            <a class="button" href='UserFriendsConfirm.php?user={$friends[friend_loop]->user_info.user_username}&task=confirm'><span>{$Application580}</span></a>
            <a class="button" href='UserFriendsConfirm.php?user={$friends[friend_loop]->user_info.user_username}&task=reject'><span>{$Application581}</span></a>
        </div>
    </div>
    {/section}
    {/if}
    </div>
    
   
    <div class="block-bot"><span>&nbsp;</span></div>
</div>

<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>



{include file='Footer.tpl'}