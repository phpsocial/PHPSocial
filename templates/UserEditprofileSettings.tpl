{include file='Header.tpl'}
{literal}
<style type="text/css">
    .settings input {
        width:auto !important;
        height:auto !important;
    }
    .submits input{
        width:92px !important;
        height:23px !important;
    }
    input{
        border:none !important;
    }
</style>
{/literal}
<div id="content">
    {section name=tab_loop loop=$tabs}
    {if $tabs[tab_loop].tab_id == $tab_id}{assign var="pagename" value=$tabs[tab_loop].tab_name}{/if}
    {/section}
    <div class="grey-head"><h2>{$Application458}</h2></div>

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
            <p style="padding-left:25px;">{$Application459}</p>
            {* SHOW SUCCESS MESSAGE *}
            {if $result != 0}
            <br/>
            <p style="color:green; padding-left:25px;">{$Application453}</p>
            {/if}

            <form action='UserEditprofileSettings.php' method='POST' class="settings" style="color:#666666;">

                {if $user->level_info.level_profile_style == 1}
                <div><b>{$Application461}</b></div>
                <div class='form_desc'>{$Application462}</div>
                <textarea style="border:1px solid #CBD0D2; width:600px;" name='style_profile' rows='17' cols='50' style='width: 100%; font-family: courier, serif;'>{$style_profile}</textarea>
                <br><br>
                {/if}

                {if $privacy_profile_options|@count > 1}
                <div><b>{$Application463}</b></div>
                <div class='form_desc'>{$Application464}</div>
                <table border="0" cellpadding='0' cellspacing='0' class='editprofile_options'>
                    {* LIST PRIVACY OPTIONS *}
                    {section name=privacy_profile_loop loop=$privacy_profile_options}
                    <tr><td valign="top"><input type='radio' name='privacy_profile' id='{$privacy_profile_options[privacy_profile_loop].privacy_id}' value='{$privacy_profile_options[privacy_profile_loop].privacy_value}'{if $privacy_profile == $privacy_profile_options[privacy_profile_loop].privacy_value} CHECKED{/if}></td><td><label for='{$privacy_profile_options[privacy_profile_loop].privacy_id}'>{$privacy_profile_options[privacy_profile_loop].privacy_option}</label></td></tr>
                    {/section}
                </table>
                <br/>
                {/if}

                {if $comments_profile_options|@count > 1}
                <div><b>{$Application465}</b></div>
                <div class='form_desc'>{$Application466}</div>
                <table border="0" cellpadding='0' cellspacing='0' >
                    {* LIST PRIVACY OPTIONS *}
                    {section name=comments_profile_loop loop=$comments_profile_options}
                    <tr><td valign="top"><input type='radio' name='comments_profile' id='{$comments_profile_options[comments_profile_loop].privacy_id}' value='{$comments_profile_options[comments_profile_loop].privacy_value}'{if $comments_profile == $comments_profile_options[comments_profile_loop].privacy_value} CHECKED{/if}></td><td><label for='{$comments_profile_options[comments_profile_loop].privacy_id}'>{$comments_profile_options[comments_profile_loop].privacy_option}</label></td></tr>
                    {/section}
                </table>
                <br/>
                {/if}

                {if $user->level_info.level_profile_search == 1}
                <div><b>{$Application467}</b></div>
                <div class='form_desc'>{$Application468}</div>
                <table border="0" cellpadding='0' cellspacing='0' class='editprofile_options'>
                    <tr><td valign="top"><input type='radio' name='search_profile' id='search_profile1' value='1'{if $user->user_info.user_privacy_search == 1} CHECKED{/if}></td><td><label for='search_profile1'>{$Application469}</label></td></tr>
                    <tr><td valign="top"><input type='radio' name='search_profile' id='search_profile0' value='0'{if $user->user_info.user_privacy_search == 0} CHECKED{/if}></td><td><label for='search_profile0'>{$Application470}</label></td></tr>
                </table>
                <br/>
                {/if}

                {if $user->level_info.level_profile_comments !== "6"}
                <div><b>{$Application471}</b></div>
                <div class='form_desc'>{$Application472}</div>
                <table border="0" cellpadding='0' cellspacing='0' class='editprofile_options'>
                    <tr><td valign="top"><input type='checkbox' value='1' id='profilecomment' name='usersetting_notify_profilecomment'{if $user->usersetting_info.usersetting_notify_profilecomment == 1} CHECKED{/if}></td><td><label for='profilecomment'>{$Application473}</label></td></tr>
                </table>
                <br/>
                {/if}

                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}

                <div class="submits">
                    <label><input type="submit" value="{$Application460}"/></label>
                    <label><input type="button" onclick="location.href='{$redirect_page}'" value="Cancel"/></label>
                </div>
                
                <input type='hidden' name='task' value='dosave'>
            </form>

        </div>
    </div>
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>







{include file='Footer.tpl'}