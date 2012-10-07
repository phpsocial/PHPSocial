{include file='AdminHeader.tpl'}

<h2>{$Admin888}</h2>
<p>{$Admin889}</p>

    <table cellpadding="0" cellspacing="0" class="view-users">
        <tr>
            <th align="left" valign="top" class="col-f"><div class="t-input"><label>{$Admin890}</label></div></th>
            <th align="left" valign="top">{$Admin891}</th>
            <th align="left" valign="top">{$Admin892}</th>
            <th align="left" valign="top">{$Admin893}</th>
            <th align="left" valign="top">{$Admin894}</th>
            <th align="center" valign="top">{$Admin895}</th>
        </tr>
        {section name=admin_loop loop=$admins}
        <tr class='{cycle values="1, event"}'>
            <td align="left" class="col-f"><div class="t-input">{$admins[admin_loop].admin_id}</div></td>
            <td align="left">{$admins[admin_loop].admin_username}</td>
            <td align="left">{$admins[admin_loop].admin_name}</td>
            <td align="left"><a href='mailto:{$admins[admin_loop].admin_email}'>{$admins[admin_loop].admin_email}</a></td>
            <td align="left">{if $admins[admin_loop].admin_status == "0"}{$Admin9}{else}{$Admin10}{/if}</td>
            <td align="center" class="col-l"><a href='AdminEditViewadmins.php?admin_id={$admins[admin_loop].admin_id}'>{$Admin898}</a>{if $admins[admin_loop].admin_status != "0"} | <a href='AdminViewadmins.php?task=confirmdeleteadmin&admin_id={$admins[admin_loop].admin_id}'>{$Admin899}</a>{/if}</td>
        </tr>
        {/section}
    </table>

<form action='AdminAddViewadmins.php' method='POST'>
<label class="button"><input type='submit' value='{$Admin900}'></label>
<input type='hidden' name='task' value='main'>
</form>

{include file='AdminFooter.tpl'}