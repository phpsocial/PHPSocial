{include file='Header.tpl'}
<div id="content">

    {literal}
<style type="text/css">

    input{
        border:none !important;
    }
</style>
{/literal}

    {* JAVASCRIPT FOR CHECK ALL MESSAGES FEATURE *}
    {literal}
    <script language='JavaScript'>
        <!---
        var checkboxcount = 1;
        function doCheckAll() {
            if(checkboxcount == 0) {
                with (document.comments) {
                    for (var i=0; i < elements.length; i++) {
                        if (elements[i].type == 'checkbox') {
                            elements[i].checked = false;
                        }}
                    checkboxcount = checkboxcount + 1;
                }
                select_all.checked=false;
            } else
                with (document.comments) {
                    for (var i=0; i < elements.length; i++) {
                        if (elements[i].type == 'checkbox') {
                            elements[i].checked = true;
                        }}
                checkboxcount = checkboxcount - 1;
                select_all.checked=true;
            }
        }
        // -->
    </script>
    {/literal}

    {section name=tab_loop loop=$tabs}
    {if $tabs[tab_loop].tab_id == $tab_id}{assign var="pagename" value=$tabs[tab_loop].tab_name}{/if}
    {/section}
    <div class="grey-head"><h2>{$Application431}</h2></div>
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
            <li {if $uri_page=='UserEditprofileComments.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserEditprofileComments.php'>{$Application421}</a></li>
            <li {if $uri_page=='UserEditprofileSettings.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserEditprofileSettings.php'>{$Application422}</a></li>
        </ul>

        <div id="primary" class="info-cnt tuneddivs">



            <p style="padding-left:25px;">{$Application432}</p>
            {if $total_comments == 0}
            {* DISPLAY MESSAGE IF THERE ARE NO COMMENTS *}
            <br/><br/>
            <p align="center" style="color:red;"> {$Application439}</p>
            <br/><br/><br/>
            {else}
            {* LIST COMMENTS *}
            <form action='UserEditprofileComments.php' method='post' name='comments' class="settings">
                {section name=comment_loop loop=$comments}
                <div class="row" {if $smarty.section.comment_loop.last}style="border:none;"{/if}>
                     <div class="f-right">
                        <input style="width:15px; height:15px; margin-left:37px !important;" type='checkbox' name='comment_{$comments[comment_loop].comment_id}' value='1'/><br/>
                    </div>

                    {if $comments[comment_loop].comment_author->user_info.user_id != 0}
                    <a class="f-left" href='{$url->url_create('profile', $comments[comment_loop].comment_author->user_info.user_username)}'>
                       <img class="img" src="{$comments[comment_loop].comment_author->user_photo('./images/nophoto.gif')}" width="92px"/>
                    </a>
                    {else}
                    <a href="#" class="f-left">
                        <img class="img" width="92px" src='./images/nophoto.gif'/>
                    </a>
                    {/if}

                    <dl style="width:350px;"><b>{if $comments[comment_loop].comment_author->user_info.user_id != 0}<a href='{$url->url_create('profile',$comments[comment_loop].comment_author->user_info.user_username)}'>{$comments[comment_loop].comment_author->user_info.user_username}</a>{else}{$Application440}{/if}</b>
                        - {$datetime->cdate("`$setting.setting_timeformat` `$Application3` `$setting.setting_dateformat`", $datetime->timezone($comments[comment_loop].comment_date, $global_timezone))}<br/>
                        {$comments[comment_loop].comment_body}
                    </dl>
                </div>
                {/section}
                        {* DISPLAY PAGINATION MENU IF APPLICABLE *}
        {if $maxpage > 1}
        <div style="padding-left:150px;">
            {if $p != 1}<a href='UserEditprofileComments.php?p={math equation='p-1' p=$p}'>&#171; {$Application434}</a>{else}<font class='disabled'>&#171; {$Application434}</font>{/if}
            {if $p_start == $p_end}
            &nbsp;|&nbsp; {$Application435} {$p_start} {$Application436} {$total_comments} &nbsp;|&nbsp;
            {else}
            &nbsp;|&nbsp; {$Application437} {$p_start}-{$p_end} {$Application436} {$total_comments} &nbsp;|&nbsp;
            {/if}
            {if $p != $maxpage}<a href='UserEditprofileComments.php?p={math equation='p+1' p=$p}'>{$Application438} &#187;</a>{else}<font class='disabled'>{$Application438} &#187;</font>{/if}
        </div>
        {/if}
                <table border="0" align="center" style="padding-left:200px;">
                    <tr>
                        <td><input style="width:15px; height:15px;" type='checkbox' name='select_all' id='select_all' onClick='doCheckAll()'/></td>
                        <td>[ <a href='javascript:doCheckAll()'>{$Application433}</a> ]</td>
                    </tr>
                </table>

                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}

                <div class="submits">
                    <label><input type="submit" value="{$Application441}"/></label>
                    <label><input type="button" onclick="location.href='{$redirect_page}'" value="Cancel"/></label>
                </div>

                <input type='hidden' name='task' value='delete'/>
                <input type='hidden' name='p' value='{$p}'/>

            </form>
            {/if}

        </div>
    </div>
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>
       


{include file='Footer.tpl'}