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

    <div class="grey-head"><h2>View Message: {$pm_subject}</h2></div>
    <div class="row-blue">
        <p class="blue">{if $convo_total >0}{$Application716}: {$convo_total} message(s){else}{$Application716}: 0 message(s){/if}</p>
    </div>

    {* SHOW SUCCESS MESSAGE *}
    {if $justsent == 1}
    <p style="padding-left:25px; color:green;">{$Application648}</p>
    {/if}


    <div id="primary" class="info-cnt tuneddivs" style="color:#666666;">
        <form action="UserMessagesView.php" method="post" name="messageform" class="settings">

            <div class="row" style="border:none;">
                <div class="f-right">
                    <a href='UserMessagesView.php?pm_id={$pms[pm_loop].pm_id}&task=delete'>{$Application660}</a><br/>
                    <input type='checkbox' name='message_{$pms[pm_loop].pm_id}' value='1' style="height:15px; width:15px;"/>
                </div>

                <a class="f-left" href="{$url->url_create('profile',$pm_author->user_info.user_username)}"><img src="{$pm_author->user_photo('./images/nophoto.gif')}" class='img' width="92px" alt="{$pms[pm_loop].pm_user->user_info.user_username} {$Application500}"/></a>
                <dl>
                    <dt>{$Application655}</dt>
                    <dd><b><a href="{$url->url_create('profile',$pm_author->user_info.user_username)}">{$pm_author->user_info.user_username|truncate:10:"...":true}</a></b></dd>

                    <dt>{$Application711}</dt>
                    <dd><b><a href="{$url->url_create('profile', $pm_recepient->user_info.user_username)}">{$pm_recepient->user_info.user_username}</a></b></dd>

                    <dt>Date posted:</dt>
                    <dd>{$datetime->cdate("`$setting.setting_timeformat` `$setting.setting_dateformat`", $datetime->timezone($pm_date, $global_timezone))}</dd>

                    <dt>{$Application656}:</dt>
                    <dd><b>{$pm_subject}</b></dd>

                    <dt>Message:</dt>
                    <dd>{$pm_body|choptext:75:"<br>"}</dd>
                </dl>
            </div>


            <p class="line">&nbsp;</p>
            {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}
            <div class="f-left">
                <a class="button" href="{if $pm_inbox == 1}UserMessages.php{else}UserMessagesOutbox.php{/if}"><span>{$Application713}</span></a>
                {if $pm_inbox == 1}
                <a class="button" href="UserMessagesNew.php?pm_id={$pm_id}"><span>{$Application714}</span></a>
                {/if}
                <a class="button" href="javascript:void(0)" onclick="document.messageform.submit();"><span>{$Application715}</span></a>
            </div>

            <input type='hidden' name='pm_id' value='{$pm_id}'/>
            <input type='hidden' name='task' value='delete'/>
        </form>
    </div>
{* SHOW MESSAGE HISTORY *}
{if $convo_total > 0 }
    <br/>
    <p style="padding-left:25px;"><b>{$Application716}</b></p>

        <div id="primary" class="info-cnt tuneddivs" style="color:#666666;">
        <form action="UserMessagesView.php" method="post" class="settings" style="margin-top:0px !important;">
         <p class="line">&nbsp;</p>
         {section name=convo_loop loop=$convo}
            <div class="row" style="border:none;">
                <div class="f-right">
                    
                </div>

                <a class="f-left" href="{$url->url_create('profile',$convo[convo_loop].pm_author->user_info.user_username)}"><img src="{$convo[convo_loop].pm_author->user_photo('./images/nophoto.gif')}" class='img' width="92px" alt="{$convo[convo_loop].pm_author->user_info.user_username {$Application500}"/></a>
                <dl style="width:380px! important;">
                    <dt>{$Application655}</dt>
                    <dd><b><a href="{$url->url_create('profile',$convo[convo_loop].pm_author->user_info.user_username)}">{$convo[convo_loop].pm_author->user_info.user_username|truncate:10:"...":true}</a></b></dd>

                    <dt>Date posted:</dt>
                    <dd>{if $convo[convo_loop].pm_author->user_info.user_username == $user->user_info.user_username}{$Application9}{else}{$Application10}{/if}: {$datetime->cdate("`$setting.setting_timeformat` `$setting.setting_dateformat`", $datetime->timezone($convo[convo_loop].pm_date, $global_timezone))}</dd>

                    <dt>{$Application656}:</dt>
                    <dd><b>{$convo[convo_loop].pm_subject}</b></dd>

                    <dt>Message:</dt>
                    <dd style="width:280px !important;">{$convo[convo_loop].pm_body|choptext:75:"<br>"}</dd>
                </dl>
            </div>
            {/section}

        </form>
    </div>
    {/if}
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>



{include file='Footer.tpl'}