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
    <h2>{$Application558}</h2>
</div>
<div class="row-blue">
    <span>{$Application520} <b><a href='{$url->url_create('profile', $owner->user_info.user_username)}'>{$owner->user_info.user_username}</a></b> {$Application521}</span>
</div>

<div class="layers">

<div id="primary" class="info-cnt tuneddivs">

<p style="padding-left:25px;">{$Application523}</p>

{literal}
<script language='JavaScript'>
    <!--
    function show_other() {
        if(document.confirmform.friend_type.options[document.confirmform.friend_type.selectedIndex].value == 'other_friendtype') {
            document.getElementById('other').style.display='block';
            document.getElementById('friend_type_other').focus();
        } else {
            document.getElementById('other').style.display='none';
            document.getElementById('friend_type_other').value = '';
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
        {if $setting.setting_connection_other != 0}<option value='other_friendtype'{if $friend_type_other != ""} SELECTED{/if}>{$Application561}</option>{/if}
    </select>
</p>
{* SHOW OTHER SPECIFY FIELD IF NECESSARY *}
{if $setting.setting_connection_other != 0}
<div style='display: {if $friend_type_other != ""}block{else}none{/if};' id='other'>
<p>
    <label style="width:126px;">{$Application562}</label>
    <input type='text' class='text' name='friend_type_other' id='friend_type_other' value='{$friend_type_other}' maxlength='50'/>
</p>
</div>
{else}
<input type='hidden' name='friend_type_other' value=''>
{/if}
{else}
{if $setting.setting_connection_other != 0}
<p>
    <label style="width:126px;">{$Application563}</label>
    <input type='text' name='friend_type_other' value='{$friend_type_other}' maxlength='50'/>
</p>
{else}
<input type='hidden' name='friend_type_other' value=''>
{/if}
<input type='hidden' name='friend_type' value=''>
{/if}
{* SHOW FRIEND EXPLANATION IF APPLICABLE *}
{if $setting.setting_connection_explain != 0}
<p>
<label style="width:126px;">{$Application564} <a href='{$url->url_create('profile', $owner->user_info.user_username)}'>{$owner->user_info.user_username}</a>{$Application565}</b></label>
<textarea class="text" name='friend_explain' rows='5' cols='60' style='margin-top: 3px;'>{$friend_explain}</textarea>
</p>
{else}
<input type='hidden' name='friend_explain' value=''/>
{/if}
<p class="line">&nbsp;</p>
                <div class="f-left">
                    <a class="button" href="javascript:void(0);" onclick="document.addform.submit();">
                        <span>{$Application566}</span>
                    </a>

                    <a class="button" href="{$redirect_page}">
                        <span>{$Application529}</span>
                    </a>
                </div>

<input type='hidden' name='task' value='editdo'/>
<input type='hidden' name='user' value='{$owner->user_info.user_username}'/>
</form>



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