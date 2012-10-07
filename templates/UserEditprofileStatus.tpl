{include file='Header.tpl'}
<div id="content">
    <div class="grey-head"><h2>{$Application479}</h2></div>

  <div class="layers">
        <ul class="list01">
            {section name=tab_loop loop=$tabs}
            <li {if $uri_page==$tabs[tab_loop].tab_id}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='UserEditprofile.php?tab_id={$tabs[tab_loop].tab_id}'>{$tabs[tab_loop].tab_name}</a>
            </li>
            {if $tabs[tab_loop].tab_id == $tab_id}{assign var="pagename" value=$tabs[tab_loop].tab_name}{/if}
            {/section}
            {if $user->level_info.level_profile_status != 0} <li {if $uri_page=='UserEditprofileStatus.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserEditprofileStatus.php'>{$Application419}</a></li>{/if}
            {if $user->level_info.level_photo_allow != 0} <li {if $uri_page=='UserEditprofilePhoto.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserEditprofilePhoto.php'>{$Application420}</a></li>{/if}
            <li {if $uri_page=='UserEditprofileSettings.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserEditprofileSettings.php'>{$Application422}</a></li>
        </ul>

        <div id="primary" class="info-cnt tuneddivs">

            <p style="padding-left:25px;">{$Application480}</p>

             {* SHOW RESULT MESSAGE *}
            {if $result != 0}
            <p style="color:green; padding-left:25px;"> {$Application474}</p>
            {/if}

            <form action='UserEditprofileStatus.php' method='POST' name='profile' class="settings">


                <p>
                    <label><b>{$user->user_info.user_username} {$Application482}</b></label>
                    <input type='text' class='text' name='status_new' size='50' maxlength='100' value='{$user->user_info.user_status}'/>
                </p>
                <p class="line">&nbsp;</p>

                {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}
                
                <div class="submits">
                    <label><input type="submit" value="{$Application481}"/></label>
                    <label><input type="button" onclick="location.href='{$redirect_page}'" value="Cancel"/></label>
                </div>

                <input type='hidden' name='task' value='dosave'>
                <input type='hidden' name='return_url' value='{$return_url}'>
            </form>
        </div>
    </div>
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>


{include file='Footer.tpl'}