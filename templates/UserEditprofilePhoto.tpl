{include file='Header.tpl'}
<div id="content">
    <div class="grey-head"><h2>{$Application446}</h2></div>

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


            <p style="padding-left:25px;">{$Application447}</p>

            {* SHOW ERROR MESSAGE *}
            {if $is_error != 0}
            <p style="color:red; padding-left:25px;">{$error_message}</p>
            {/if}

            <form action='UserEditprofilePhoto.php' class="settings" method='POST' enctype='multipart/form-data'>
                <div class="row" style="border:none;">

                    <a href="{$url->url_create('profile', $user->user_info.user_username)}" class="f-left"><img class="img" alt="" width="92px" src='{$user->user_photo("./images/nophoto.gif")}'/></a>
                    <dl>
                        <dt><b>{$Application452}</b></dt>
                        <dd><input type='file' style="height:25px !important; border:1px solid #CBD0D2; height:20px; margin:0 10px 0 0;" name='photo' size='35'/></dd>
                        <br/>
                        <p style="color:#666666; padding-top:10px;">{$Application450} {$user->level_info.level_photo_exts}</p>
                   </dl>
                    
                </div>

                <p class="line">&nbsp;</p>

                {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}

                <div class="submits">
                    <label><input type="submit" value="{$Application449}"/></label>
                    <label><input type="button" onclick="location.href='{$redirect_page}'" value="Cancel"/></label>
                </div>

                <input type='hidden' name='task' value='upload'>
                <input type='hidden' name='MAX_FILE_SIZE' value='5000000'>
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