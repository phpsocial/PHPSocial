{include file='Header.tpl'}
{literal}
<style type="text/css">
    .submit_button{
        background:transparent url(../images/link-btn.gif) no-repeat scroll 0 0;
        color:#FFFFFF;
        display:block;
        font-weight:bold;
        height:23px;
        line-height:23px;
        margin-top:10px;
        text-align:center;
        width:129px;
        text-decoration:none;
        margin-left:25px;
    }
</style>
{/literal}


<div id="content">
    {* SHOW PAGE TITLE *}
    <div class="grey-head"><h2><a href='{$url->url_create('profile',$owner->user_info.user_username)}'>{$owner->user_info.user_username}</a>{$Application257}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application258}<a href='{$url->url_create('profile',$owner->user_info.user_username)}'>{$owner->user_info.user_username}</a>{$Application259}</p>
    </div>

    {* SHOW NO FRIENDS NOTICE IF NECESSARY *}
    {if $total_friends == 0}
    <br/>
    <p align="center" style="color:red;">
        <b><a href='{$url->url_create('profile',$owner->user_info.user_username)}'>{$owner->user_info.user_username}</a></b>{$Application260}
    </p>
    <br/>
    {/if}

    <div id="primary" class="info-cnt tuneddivs" style="color:#666666;">

        <form action="" method="post" class="settings" style="margin-top:0px !important;">
            {* DISPLAY PAGINATION MENU IF APPLICABLE *}
            {if $maxpage > 1}
            <p>
                {if $p != 1}<a href='ProfileFriends.php?user={$owner->user_info.user_username}&s={$s}&p={math equation='p-1' p=$p}'>&#171; {$Application5}</a>{else}<font class='disabled'>&#171; {$Application261}</font>{/if}
                {if $p_start == $p_end}
                &nbsp;|&nbsp; {$Application262} {$p_start} {$Application263} {$total_friends} &nbsp;|&nbsp;
                {else}
                &nbsp;|&nbsp; {$Application262} {$p_start}-{$p_end} {$Application263} {$total_friends} &nbsp;|&nbsp;
                {/if}
                {if $p != $maxpage}<a href='ProfileFriends.php?user={$owner->user_info.user_username}&s={$s}&p={math equation='p+1' p=$p}'>{$Application264} &#187;</a>{else}<font class='disabled'>{$Application264} &#187;</font>{/if}
            </p>
            {/if}

            {* LIST FRIENDS *}
            {section name=friend_loop loop=$friends}
            <div class="row" {if $smarty.section.friend_loop.last}style="border:none;"{/if}>
                 <div class="f-right">
                    <a href='{$url->url_create('profile',$friends[friend_loop]->user_info.user_username)}'>{$Application266}</a>{if $user->level_info.level_message_allow != 0}<br/>
                    <a href='UserMessagesNew.php?to={$friends[friend_loop]->user_info.user_username}'>{$Application268}</a>{/if}
                </div>

                <a class="f-left" href="{$url->url_create('profile',$friends[friend_loop]->user_info.user_username)}"><img src="{$friends[friend_loop]->user_photo('./images/nophoto.gif')}" class='img' width="92px" alt="{$friends[friend_loop]->user_info.user_username}"/></a>
                <dl style="width:350px! important;">

                    <dt style="width:75px !important;">{$Application270}</dt>
                    <dd><a href="{$url->url_create('profile',$friends[friend_loop]->user_info.user_username)}"><b>{$friends[friend_loop]->user_info.user_username}</b></a></dd>

                     {if $friends[friend_loop]->user_info.user_dateupdated != "0"}
                    <dt style="width:75px !important;">{$Application271}</dt>
                    <dd>{$datetime->time_since($friends[friend_loop]->user_info.user_dateupdated)}</dd>
                    {/if}

                    {if $friends[friend_loop]->user_info.user_lastlogindate != "0"}
                    <dt style="width:75px !important;">{$Application272}</dt>
                    <dd>{$datetime->time_since($friends[friend_loop]->user_info.user_lastlogindate)}</dd>
                    {/if}

                </dl>
            </div>
            {/section}

        </form>
    </div>


    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>


{include file='Footer.tpl'}