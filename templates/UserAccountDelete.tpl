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
        .form_check input{
            border:none !important;
        }
    </style>
    {/literal}


    <div class="grey-head"><h2>{$Application403}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application403}</p>
    </div>

    <div class="layers">
        <ul class="list01">

            <li {if $page=='UserAccount'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='UserAccount.php'>{$Application385}</a>
            </li>

            <li {if $page=='UserAccountPass'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='UserAccountPass.php'>{$Application386}</a>
            </li>

            <li {if $page=='UserAccountDelete'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='UserAccountDelete.php'>{$Application387}</a>
            </li>
        </ul>

        <p style="padding-left:25px; color:red;">{$Application404}</p>
        
        {* SHOW SUCCESS MESSAGE *}
        {if $result != 0}
        <br/>
        <p align="center" style="color:green;">{$Application407}</p>
        <br/>

        {* SHOW ERROR MESSAGE *}
        {elseif $is_error != 0}
        <br/>
        <p align="center" style="color:red;">{$error_message}</p>
        <br/>
        {/if}

        <div id="primary" class="info-cnt tuneddivs">
            <form action='UserAccountDelete.php' method="POST" class="settings">
      
                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}

                <div class="f-left">
                   <a class="button"><span>{$Application405}</span></a>
                   
                    <a class="button" href="{$redirect_page}"><span>Cancel</span></a>
                </div>

                 <input type='hidden' name='task' value='dodelete'/>
            </form>
        </div>
    </div>
    <div class="block-bot"><span></span></div>
</div>

<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>


{include file='Footer.tpl'}