{include file='Header.tpl'}
<div id="content">
    {assign var="redirect_page" value=$url->url_create('profile', $owner->user_info.user_username)}
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
        .text{
            border:1px solid #CBD0D2 !important;
        }

    </style>
    {/literal}

    <div class="grey-head">
        <h2>{$Application519}</h2>
    </div>
    <div class="row-blue">

        <span>{$Application520} <b><a href='{$url->url_create('profile', $owner->user_info.user_username)}'>{$owner->user_info.user_username}</a></b> {$Application521}</span>
    </div>

    <div class="layers">

        <div id="primary" class="info-cnt tuneddivs">
            {* DISPLAY CONFIRMATION *}
            {* DISPLAY RESULT *}
            {if $result != ""}
            <p {if $is_error != ""}style="padding-left:25px; color:red;"{else}style="padding-left:25px; color:green;"{/if}>{$result}</p>
            {/if}

            {* DISPLAY BACK BUTTON IF NO CONFIRMATION *}
            {if $confirm != 1}
            <form action='Profile.php' method='get' class="settings">
                <p class="line"></p>
                <div class="f-left">
                    <a class="button" href="{$redirect_page}">
                        <span>{$Application522}</span>
                    </a>
                </div><br/>
            </form>
            {/if}

            {if $confirm == 1}
            <p style="padding-left:25px;">{$Application523}</p>
            {literal}

            <script language='JavaScript'>
                <!--
                function show_other() {
                    if(document.addform.friend_type.options[document.addform.friend_type.selectedIndex].value == 'other_friendtype') {
                        document.getElementById('other').style.display='block';
                    } else {
                        document.getElementById('other').style.display='none';
                    }
                }
                // -->
            </script>
            {/literal}

            <form action='UserFriendsAdd.php' method='POST' name='addform' class="settings">
                {* SHOW FRIEND TYPES IF APPLICABLE *}
                {if $friend_types != ""}
                <p>
                    <label style="width:126px;">{$Application524}</label>
                    <select style="width:100px !important;" name='friend_type' onChange='javascript: show_other();'>
                        <option></option>
                        {section name=type_loop loop=$friend_types}
                        <option value='{$friend_types[type_loop]}'>{$friend_types[type_loop]}</option>
                        {/section}
                        {if $friend_other != 0}<option value='other_friendtype'>{$Application525}</option>{/if}
                    </select>
                </p>
                {if $friend_other != 0}
                <p style='display: none;' id='other'>
                    <input type='text' class='text' name='friend_type_other' maxlength='50'/>
                </p>
                {else}
                <input type='hidden' name='friend_type_other' value=''>
                {/if}

                {else}
                {if $friend_other != 0}
                <p>
                    <label style="width:126px;">{$Application526}</label>
                    <input type='text' name='friend_type_other' maxlength='50'/>
                </p>
                {else}
                <input type='hidden' name='friend_type_other' value=''/>
                {/if}
                <input type='hidden' name='friend_type' value=''/>
                {/if}

                {* SHOW FRIEND EXPLANATION IF APPLICABLE *}
                {if $friend_explain != 0}
                <p>
                <label style="width:126px;">{$Application527}</label>
                <textarea name='friend_explain' rows='5' cols='60' class="text"></textarea>

                {else}
                <input type='hidden' name='friend_explain' value=''>
                {/if}
                <p class="line">&nbsp;</p>

                <div class="submits">
                    <label><input type='submit' value='{$Application528}'/></label>
                    <label><input type="button" onclick="location.href='{$redirect_page}'" value="{$Application529}"/></label>
                </div>
                    <input type='hidden' name='task' value='add'>
                         <input type='hidden' name='user' value='{$owner->user_info.user_username}'>
            </form>
            {/if}

        </div>
    </div>
    <div class="block-bot">
        <span>&nbsp;</span>
    </div>
</div>

<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>


{include file='Footer.tpl'}