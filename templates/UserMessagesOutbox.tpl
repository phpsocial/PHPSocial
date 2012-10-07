{if !$ajax_call}
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
        #content .row dd {
            width:210px !important;
        }
        #content .row dl {
            float:left;
            padding:0;
            width:320px;
        }
    </style>
    {/literal}

    <div class="grey-head"><h2>{$Application682}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application683} {$total_pms} {$Application684}</p>
        {* DISPLAY PAGINATION MENU IF APPLICABLE *}
        {if $maxpage > 1}
        <br/>
        <p class="blue">
            {if $p != 1}<a href='UserMessagesOutbox.php?p={math equation='p-1' p=$p}'>&#171; {$Application686}</a>{else}<font class='disabled'>&#171; {$Application686}</font>{/if}
            {if $p_start == $p_end}
            &nbsp;|&nbsp; {$Application687} {$p_start} {$Application689} {$total_pms} &nbsp;|&nbsp;
            {else}
            &nbsp;|&nbsp; {$Application688} {$p_start}-{$p_end} {$Application689} {$total_pms} &nbsp;|&nbsp;
            {/if}
            {if $p != $maxpage}<a href='UserMessagesOutbox.php?p={math equation='p+1' p=$p}'>{$Application690} &#187;</a>{else}<font class='disabled'>{$Application690} &#187;</font>{/if}
        </p>

        {/if}
    </div>
    <div class="layers">
        <ul class="list01">

            <li id="li1" {if $page=='UserMessages'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='javascript:void(0)' onclick="getData('#ajaxContainer','UserMessages.php'); setActiveLi(1);">{$Application641}</a>
            </li>

            <li id="li2" {if $page=='UserMessagesOutbox'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='javascript:void(0)' onclick="getData('#ajaxContainer','UserMessagesOutbox.php'); setActiveLi(2);">{$Application642}</a>
            </li>

            <li id="li3" {if $page=='UserMessagesSettings'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='javascript:void(0)' onclick="getData('#ajaxContainer','UserMessagesSettings.php'); setActiveLi(3);">{$Application662}</a>
            </li>
        </ul>

{/if}

        <div id="ajaxContainer">

        <p style="padding-left:25px;"><a href='UserMessagesNew.php'>{$Application647}</a></p>

        {* SHOW SUCCESS MESSAGE *}
        {if $justsent == 1}
        <p style="padding-left:25px; color:green;">{$Application648}</p>
        {/if}


        {* JAVASCRIPT FOR CHECK ALL MESSAGES FEATURE *}
        {literal}
        <script language='JavaScript'>
            <!---
            var checkboxcount = 1;
            function doCheckAll() {
                if(checkboxcount == 0) {
                    with (document.messageform) {
                        for (var i=0; i < elements.length; i++) {
                            if (elements[i].type == 'checkbox') {
                                elements[i].checked = false;
                            }}
                        checkboxcount = checkboxcount + 1;
                    }
                } else
                    with (document.messageform) {
                        for (var i=0; i < elements.length; i++) {
                            if (elements[i].type == 'checkbox') {
                                elements[i].checked = true;
                            }}
                    checkboxcount = checkboxcount - 1;
                }
            }
            // -->
        </script>
        {/literal}



        {* CHECK IF THERE ARE NO MESSAGES IN OUTBOX *}
        {if $total_pms == 0}
        <br/>
        <p  align="center" style="color:red;">{$Application691}</p>
        <br/>
        <br/>

        {else}

        <div id="primary" class="info-cnt tuneddivs" style="color:#666666;">
            <form action="UserMessagesOutbox.php" method="post" name="messageform" class="settings">

                {* LIST INBOX MESSAGES *}
                {section name=pm_loop loop=$pms}

                {* IF MESSAGE IS NEW, HIGHLIGHT ROW *}
                {if $pms[pm_loop].pm_status == 0}
                {assign var='row_class' value='messages_unread'}
                {else}
                {assign var='row_class' value='messages_read'}
                {/if}



                {* LOOP THROUGH FRIENDS *}
                <div class="row" {if $smarty.section.pm_loop.last}style="border:none;"{/if}>
                     <div class="f-right">
                       
                        <a href='UserMessagesView.php?pm_id={$pms[pm_loop].pm_id}&task=delete'>{$Application660}</a><br/>
                        <input type='checkbox' name='message_{$pms[pm_loop].pm_id}' value='1' style="height:15px; width:15px;"/>
                    </div>

                    <a class="f-left" href="{$url->url_create('profile', $pms[pm_loop].pm_user->user_info.user_username)}"><img src="{$pms[pm_loop].pm_user->user_photo('./images/nophoto.gif')}" class='img' width="92px" alt="{$pms[pm_loop].pm_user->user_info.user_username} {$Application500}"/></a>
                    <dl>
                        <dt>{$Application655}</dt>
                        <dd><b><a href="{$url->url_create('profile', $pms[pm_loop].pm_user->user_info.user_username)}">{$pms[pm_loop].pm_user->user_info.user_username}</a></b></dd>

                        <dt>Date posted:</dt>
                        <dd>{$datetime->cdate("`$setting.setting_timeformat` `$setting.setting_dateformat`", $datetime->timezone($pms[pm_loop].pm_date, $global_timezone))}</dd>

                        <dt>{$Application656}:</dt>
                        <dd><b><a href='UserMessagesView.php?pm_id={$pms[pm_loop].pm_id}'>{$pms[pm_loop].pm_subject|truncate:50}</a></b></dd>

                        <dt>Message:</dt>
                        <dd>{$pms[pm_loop].pm_body|truncate:100|choptext:75:"<br>"}</dd>
                    </dl>
                </div>

                {/section}

                <p align="center"><input type="checkbox" name="select_all" onClick="javascript:doCheckAll()" style="height:15px; width:15px;"/>select all</p>

                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}
                <div class="f-left">

                    <a class="button" href="UserMessagesNew.php"><span>{$Application647}</span></a>


                    <a class="button" href="javascript:void(0)" onclick="document.messageform.submit();"><span>{$Application697}</span></a>
                    <input type='hidden' name='task' value='deleteselected'/>
                    <input type='hidden' name='p' value='{$p}'/>

                </div>
            </form>
        </div>
        {/if}
        
        </div>
        
{if !$ajax_call}
        
    </div>
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>



{include file='Footer.tpl'}

{/if}