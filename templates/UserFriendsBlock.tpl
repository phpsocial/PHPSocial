{include file='Header.tpl'}
<div id="content">
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

    {* UNBLOCK USER *}
   {if $task == "unblock"}
    {* DISPLAY CONFIRMATION QUESTION *}
    {if $confirm == 1}

    <div class="grey-head"><h2>{$Application549} <a href='{$url->url_create('profile', $owner->user_info.user_username)}'>{$owner->user_info.user_username}</a>{$Application540}</h2></div>


    <div class="layers">
        <p style="padding-left:25px;">{$Application550} <a href="{$url->url_create('profile', $owner->user_info.user_username)}">{$owner->user_info.user_username}</a>{$Application540}</p>

        <div id="primary" class="info-cnt tuneddivs">
            <form action='UserFriendsBlock.php' method='POST' class="settings">
                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $owner->user_info.user_username)}

                <div class="submits">
                    <label><input type="submit" value="{$Application551}"/></label>
                    <label><input type="button" onclick="location.href='{$redirect_page}'" value="Cancel"/></label>
                </div>

                <input type='hidden' name='task' value='unblock'/>
                <input type='hidden' name='confirm' value='1'/>
                <input type='hidden' name='user' value='{$owner->user_info.user_username}'/>
            </form>
        </div>
    </div>


    {* DISPLAY RESULT *}
    {else}
    <div class="grey-head"><h2>{$Application549} <a href='{$url->url_create('profile', $owner->user_info.user_username)}'>{$owner->user_info.user_username}</a>{$Application540}</h2></div>

    <div class="layers">
        <p style="padding-left:25px;"><a href="{$url->url_create('profile', $owner->user_info.user_username)}">{$owner->user_info.user_username}</a> {$Application552}</p>

        <div id="primary" class="info-cnt tuneddivs">
            <form action='Profile.php' method='get' class="settings">
                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $owner->user_info.user_username)}
                <div class="submits">
                    <label><input type="submit" value="{$Application543}"/></label>
                </div>
                <input type='hidden' name='user' value='{$owner->user_info.user_username}'/>
            </form>
        </div>
    </div>
    {/if}

    {* BLOCK USER *}
    {else}
    {* DISPLAY CONFIRMATION QUESTION *}
    {if $confirm == 1}

    <div class="grey-head"><h2>{$Application538} <a href="{$url->url_create('profile', $owner->user_info.user_username)}">{$owner->user_info.user_username}</a>{$Application540}</h2></div>

    <div class="layers">
        <p style="padding-left:25px;">{$Application539} <a href="{$url->url_create('profile', $owner->user_info.user_username)}">{$owner->user_info.user_username}</a>{$Application540}</p>

        <div id="primary" class="info-cnt tuneddivs">
            <form action='UserFriendsBlock.php' method='POST' class="settings">
                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $owner->user_info.user_username)}

               <div class="submits">
                    <label><input type="submit" value="{$Application541}"/></label>
                    <label><input type="button" onclick="location.href='{$redirect_page}'" value="Cancel"/></label>
                </div>
                <input type='hidden' name='task' value='block'/>
                <input type='hidden' name='confirm' value='1'/>
                <input type='hidden' name='user' value='{$owner->user_info.user_username}'/>
            </form>
        </div>
    </div>

{* DISPLAY RESULT *}
{else}
    <div class="grey-head"><h2>{$Application538} <a href='{$url->url_create('profile', $owner->user_info.user_username)}'>{$owner->user_info.user_username}</a>{$Application540}</div>

    <div class="layers">
        <p style="padding-left:25px;"><a href="{$url->url_create('profile', $owner->user_info.user_username)}">{$owner->user_info.user_username}</a> {$Application544}</h2></p>

        <div id="primary" class="info-cnt tuneddivs">
            <form action='UserFriendsBlock.php' method='POST' class="settings">
                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $owner->user_info.user_username)}

               <div class="submits">
                    <label><input type="button" onclick="location.href='{$redirect_page}'" value="{$Application543}"/></label>
                </div>

                <input type='hidden' name='user' value='{$owner->user_info.user_username}'/>
            </form>
        </div>
    </div>
    {/if}
{/if}
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>

{include file='Footer.tpl'}