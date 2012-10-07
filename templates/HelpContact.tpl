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

    <div class="grey-head"><h2>{$Application109}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application110}</p>
    </div>

    <div class="layers">
        <ul class="list01">

            <li {if $page=='Help'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='Help.php'>{$Application119}</a>
            </li>

            <li {if $page=='HelpTos'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='HelpTos.php'>{$Application120}</a>
            </li>

            <li {if $page=='HelpContact'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='HelpContact.php'>{$Application121}</a>
            </li>
        </ul>

        {* SHOW SUCCESS MESSAGE *}
        {if $result != ""}
        <br/>
        <p align="center" style="color:green;">{$result}</p>
        <br/>
        {/if}

        {* SHOW ERROR MESSAGE *}
        {if $is_error == 1}
        <br/>
        <p align="center" style="color:red;">{$error_message}</p>
        <br/>
        {/if}


        <div id="primary" class="info-cnt tuneddivs">
            {* SHOW FORM IF NOT ALREADY SUBMITTED *}
            {if $success == 0}
            <form action='HelpContact.php' method='POST' class="settings">
                <table cellpadding='0' cellspacing='0' class='form'>
                    <p>
                        <label>{$Application111}</label>
                        <input type='text' class='text' name='contact_name' maxlength='50' size='30' value='{$contact_name}'/>
                    </p>
                    <p>
                        <label>{$Application112}</label>
                        <input type='text' class='text' name='contact_email' maxlength='70' size='30' value='{$contact_email}'/>
                    </p>
                    <p>
                        <label>{$Application113}</label>
                        <input type='text' class='text' name='contact_subject' maxlength='50' size='30' value='{$contact_subject}'/>
                    </p>
                    <p>
                        <label>{$Application114}</label>
                        <textarea style="border:1px solid #CBD0D2;" name='contact_message' rows='7' cols='60'>{$contact_message}</textarea>
                    </p>


                    <p class="line">&nbsp;</p>
                    {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}

                    <div class="submits">
                        <label><input type="submit" value="{$Application115}"/></label>
                        <label><input type="button" onclick="location.href='{$redirect_page}'" value="Cancel"/></label>
                    </div>
                    
                </table>
                <input type='hidden' name='task' value='dosend'/>
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