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

    <div class="grey-head"><h2>{$Application702}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application703}</p>

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

{* SHOW SUCCESS MESSAGE *}
{if $result != 0}
  <p style="padding-left:25px; color:green;"> {$Application704}</p>
{/if}
        
         <div id="primary" class="info-cnt tuneddivs">
            <form action="UserMessagesSettings.php" method="post" name="messageform" class="settings">
                <p style="padding-left:8px;"><b>{$Application705}</b></p>
                <p>
                   <input style="float:left; width:15px; height:15px; margin-left:15px !important; margin-right:15px !important;" type='checkbox' value='1' id='message' name='usersetting_notify_message'{if $user->usersetting_info.usersetting_notify_message == 1} CHECKED{/if}/>
                   <label style="width:447px; clear:none;">{$Application706}</label>
                </p>

                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}
                <div class="f-left">

                    <a class="button" href="javascript:void(0)" onclick="document.messageform.submit();"><span>{$Application708}</span></a>
                    <a class="button" href="{$redirect}"><span>Cancel</span></a>
                    <input type='hidden' name='task' value='dosave'/>

                </div>
            </form>
        </div>

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