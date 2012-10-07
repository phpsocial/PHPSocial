{include file='AdminHeader.tpl'}

<h2>{$Admin993} {$user_username}</h2>
<p>{$Admin994}</p>

{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}

{if $error_message != ""}
<p style="color:red;">{$error_message}</div></p>
{/if}

{if $result != ""}
<p style="color:green;">$result}</p>
{/if}

{* SHOW QUICK STATS *}

<div class="row">
    <dl class="f-left">
        <dt style="width:86px;">{$Admin996}</dt><dd>{$total_friends}</dd>
    </dl>
    <dl class="f-left">
        <dt>{$Admin998}</dt><dd>{$total_messages}</dd>
    </dl>
    <dl class="f-left" style="width:184px;">
        <dt style="width:143px;">{$Admin1007}</dt><dd style="width:38px;">{$total_profilecomments}</dd>
    </dl>
    <dl class="f-left" style="width:200px !important;">
        <dt style="width:68px;">{$Admin999}</dt><dd style="width:129px;">{$last_login}</dd>
    </dl>

</div>


<form action='AdminViewusersEdit.php' method='POST'>
    <table cellpadding='0' cellspacing='5' style="color:#666666;">
    <tr>
        <td class='form1'>{$Admin1000}</td>
        <td class='form2'>
            <input type='text' class="input-border" name='user_email' value='{$user_email}' size='30' maxlength='70'>
            {if $user_verified == 0}
            <br>({$Admin1014} - <a href='AdminViewusersEdit.php?user_id={$user_id}&task=resend&s={$s}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$Admin1015}</a> - <a href='AdminViewusersEdit.php?user_id={$user_id}&task=verify&s={$s}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$Admin1020}</a>)
            {/if}
           
        </td>
    </tr>

    <tr>
        <td class='form1'>{$Admin1001}</td>
        <td class='form2'><input type='text' class="input-border" name='user_username' value='{$user_username}' size='30' maxlength='50'></td>
    </tr>
    <tr>
        <td class='form1' valign="top">{$Admin1002}</td>
        <td class='form2'><input type='password' class="input-border" name='user_password' value='' size='30' maxlength='50'><br>{$Admin995}</td>
    </tr>
    <tr>
        <td class='form1'>{$Admin1003}</td>
        <td class='form2'><select class="input-border" name='user_enabled'><option value='1'{if $user_enabled == 1} SELECTED{/if}>{$Admin1016}</option><option value='0'{if $user_enabled == 0} SELECTED{/if}>{$Admin1017}</option></td>
    </tr>
    <tr>
        <td class='form1'>{$Admin1023}</td>
        <td class='form2'><select class="input-border" name='user_level_id'>{section name=level_loop loop=$levels}<option value='{$levels[level_loop].level_id}'{if $user_level_id == $levels[level_loop].level_id} SELECTED{/if}>{$levels[level_loop].level_name}</option>{/section}</td>
    </tr>
    <tr>
        <td class='form1'>{$Admin1019}</td>
        <td class='form2'><input type='text' class="input-border" name='user_invitesleft' value='{$user_invitesleft}' maxlength='3' size='2'></td>
    </tr>
    <tr>
  
    <td class='form2' colspan="2" align="right">
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td><label class="button"><input type='submit' value='{$Admin1004}'></label>&nbsp;</td>
    <input type='hidden' name='task' value='edituser'>
    <input type='hidden' name='user_id' value='{$user_id}'>
    <input type='hidden' name='s' value='{$s}'>
    <input type='hidden' name='p' value='{$p}'>
    <input type='hidden' name='f_user' value='{$f_user}'>
    <input type='hidden' name='f_email' value='{$f_email}'>
    <input type='hidden' name='f_level' value='{$f_level}'>
    <input type='hidden' name='f_enabled' value='{$f_enabled}'>
</form>
<form action='AdminViewusersEdit.php' method='POST'>
    <td><label class="button"><input type='submit' value='{$Admin1005}'></label></td>
    <input type='hidden' name='s' value='{$s}'>
    <input type='hidden' name='p' value='{$p}'>
    <input type='hidden' name='f_user' value='{$f_user}'>
    <input type='hidden' name='f_email' value='{$f_email}'>
    <input type='hidden' name='f_level' value='{$f_level}'>
    <input type='hidden' name='f_enabled' value='{$f_enabled}'>
    </tr>
</form>
</table>
</td>
</tr>
</form>
</table>

{include file='AdminFooter.tpl'}