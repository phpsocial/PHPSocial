{include file='Header.tpl'}
<div id="content">

    {* SHOW NO INVITES LEFT PAGE *}
    {if $setting.setting_signup_invite == 2 & $user->user_info.user_invitesleft == 0}

    <div class="grey-head"><h2>{$Application154}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application155}</p>
    </div>


    {* SHOW NOT LOGGED IN WARNING *}
    {if $user->user_exists == 0}
    <br/>
    <p align="center" style="color:red;"> You must be logged in to invite other people.</p>
    <br/>
    {else}
    <br/>
    <p align="center">{$Application156} {$user->user_info.user_invitesleft} {$Application157}</p>
    <br/>
    {/if}

    {* SHOW INVITE PAGE *}
    {else}

    <div class="grey-head"><h2>{$Application154}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application155} {$Application158}</p>
    </div>

    
        
    {if $setting.setting_signup_invite == 2}<p style="padding-left:25px;">{$Application158}</p>{/if}

    {* IF INVITE ONLY FEATURE IS TURNED OFF, HIDE NUMBER OF INVITES LEFT *}
    {if $setting.setting_signup_invite != 0}
    <p style="padding-left:25px;"> {$Application156} {$user->user_info.user_invitesleft} {$Application157}</p>
    {/if}

    {* SHOW SUCCESS MESSAGE *}
    {if $result != ""}
    <br/>
    <p align="center" style="color:green;">{$result}</p>
    <br/>
    {/if}

    {* SHOW ERROR MESSAGE *}
    {if $error_message != ""}
    <br/>
    <p align="center" style="color:red;">{$error_message}</p>
    <br/>
    {/if}

    <div id="primary" class="info-cnt tuneddivs">
        <form action='Invite.php' method='POST' class="settings" style="color:#666666;">
            <div><b>{$Application159}</b></div>
            <div class='form_desc'>{$Application160}</div>
            <textarea style="border:1px solid #CBD0D2; width:600px;"  name='invite_emails' rows='2' cols='60'></textarea>
            <br/><br/>

            <div><b>{$Application161}</b></div>
            <div class='form_desc'>{$Application162}</div>
            <textarea style="border:1px solid #CBD0D2; width:600px;"  name='invite_message' rows='5' cols='60'></textarea>
            <br/><br/>

            {if $setting.setting_invite_code == 1}
            <table cellpadding='0' cellspacing='0'>
                <tr>
                    <td><input type='text' name='invite_secure' class='text' size='6' maxlength='10' style="width:100px;">&nbsp;</td>
                    <td><img src='./images/secure.php' border='0' height='20' width='67' class='signup_code'>&nbsp;&nbsp;</td>
                    <td><img src='./images/icons/tip.gif' border='0' class='icon' onMouseover="tip('{$Application167}')"; onMouseout="hidetip()"></td>
                </tr>
            </table>
            {/if}

            <p class="line">&nbsp;</p>
            {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}

            <div class="submits">
                <label><input type="submit" value="{$Application163}"/></label>
                <label><input type="button" onclick="location.href='{$redirect_page}'" value="Cancel"/></label>
            </div>

            <input type='hidden' name='task' value='doinvite'>
        </form>

    </div>
    {/if}
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>

{include file='Footer.tpl'}