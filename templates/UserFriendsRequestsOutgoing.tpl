{include file='Header.tpl'}
<div id="content">

    <div class="grey-head"><h2>{$Application592}</h2></div>
     {if $total_friends != 0}
    <div class="row-blue">
        <span>
        <a href="#">Friend Requests ({$total_friends})</a>
        </span>
    </div>
    {/if}

    {* DISPLAY PAGINATION MENU IF APPLICABLE *}
    {if $maxpage > 1}
    <div class="wp-pagenavi blue">
        {if $p != 1}<a href='UserFriendsRequestsOutgoing.php?p={math equation='p-1' p=$p}'>&#171; {$Application602}</a>{else}<font class='disabled'>&#171; {$Application602}</font>{/if}
        {if $p_start == $p_end}
        &nbsp;|&nbsp; {$Application603} {$p_start} {$Application605} {$total_friends} &nbsp;|&nbsp;
        {else}
        &nbsp;|&nbsp; {$Application604} {$p_start}-{$p_end} {$Application605} {$total_friends} &nbsp;|&nbsp;
        {/if}
        {if $p != $maxpage}<a href='UserFriendsRequestsOutgoing.php?p={math equation='p+1' p=$p}'>{$Application606} &#187;</a>{else}<font class='disabled'>{$Application606} &#187;</font>{/if}
    </div>
    {/if}


    <div class="layers">
        <ul class="list01">
            <li {if $uri_page=='UserFriends.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriends.php'>{$Application483}</a></li>
            <li {if $uri_page=='UserFriendsRequests.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsRequests.php'>{$Application484}</a></li>
            <li {if $uri_page=='UserFriendsRequestsOutgoing.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsRequestsOutgoing.php'>{$Application510}</a></li>
            <li {if $uri_page=='UserFriendsSettings.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsSettings.php'>{$Application509}</a></li>
        </ul>


        <p style="padding-left:25px;">{$Application593}</p>
        {if !$friends}<br/><br/><br/>{/if}

        {* DISPLAY MESSAGE IF NO FRIEND REQUESTS *}
        {if $total_friends == 0}

        <div class="row" style="border:none;">
            <p style="color:red;" align="center">{$Application594}</p>
        </div>

        {* DISPLAY FRIEND REQUESTS *}
        {else}
        {section name=friend_loop loop=$friends}
        <div class="row" {if $smarty.section.friend_loop.last}style="border:none;"{/if}>
             <div class="f-right">
                {if $user->level_info.level_message_allow == 2}<a href='UserMessagesNew.php?to={$friends[friend_loop]->user_info.user_username}'>{$Application601}</a>{/if}
                <a href='UserFriendsConfirm.php?user={$friends[friend_loop]->user_info.user_username}&task=cancelrequest'>{$Application600}</a>

            </div>
            <a class="f-left" href='{$url->url_create('profile', $friends[friend_loop]->user_info.user_username)}'><img src='{$friends[friend_loop]->user_photo('./images/nophoto.gif')}' class='img' width='90'  alt="{$friends[friend_loop]->user_info.user_username}{$Application576}"></a>
            <dl style="width:280px !important;">
                <dt>Name</dt>
                <dd style="width:180px !important"><a href='{$url->url_create('profile', $friends[friend_loop]->user_info.user_username)}'>{$friends[friend_loop]->user_info.user_username}</a></dd>

                <dt>{$Application576}</dt>
                <dd style="width:180px !important">{$datetime->time_since($friends[friend_loop]->user_info.user_dateupdated)}</dd>

                <dt>{$Application577}</dt>
                <dd style="width:180px !important">{$datetime->time_since($friends[friend_loop]->user_info.user_lastlogindate)}</dd>

                {if $friends[friend_loop]->friend_type != ""}
                <dt>{$Application597}</dt>
                <dd style="width:180px !important">{$friends[friend_loop]->friend_type}</dd>
                {/if}

                {if $friends[friend_loop]->friend_explain != ""}
                <dt>{$Application598}</dt>
                <dd style="width:180px !important">{$friends[friend_loop]->friend_explain}</dd>
                {/if}
            </dl>
            <div class="f-left">

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