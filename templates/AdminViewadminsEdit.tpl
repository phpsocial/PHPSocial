{include file='AdminHeader.tpl'}

<h2>{$Admin914}</h2>
<p>{$Admin915}</p>
{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}
{if $error_message}<p style="color:red;">{$error_message}</p>{/if}

<table cellpadding='0' cellspacing='4' style="color:#666666;">
<form action='AdminEditViewadmins.php' method='POST'>
<tr>
<td class='form1'>{$Admin916}</td>
<td class='form2'><input type='text' class="input-border" name='admin_username' value='{$admin_username}' maxlength='50'></td>
</tr>
<tr>
<td class='form1'>{$Admin919}</td>
<td class='form2'><input type='text' class="input-border" name='admin_name' value='{$admin_name}' maxlength='50'></td>
</tr>
<tr>
<td class='form1'>{$Admin920}</td>
<td class='form2'><input type='text' class="input-border" name='admin_email' value='{$admin_email}' maxlength='70'></td>
</tr>
<tr>
<td class='form1'>{$Admin923}</td>
<td class='form2'><input type='password' class="input-border" name='admin_old_password' maxlength='50'></td>
</tr>
<tr>
<td class='form1'>{$Admin917}</td>
<td class='form2'><input type='password' class="input-border" name='admin_password' maxlength='50'></td>
</tr>
<tr>
<td class='form1'>{$Admin918}</td>
<td class='form2'><input type='password' class="input-border" name='admin_password_confirm' maxlength='50'></td>
</tr>
<tr>

<td class='form2' colspan="2" align="right">
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><label class="button"><input type='submit' value='{$Admin921}'></label>&nbsp;</td>
  <input type='hidden' name='task' value='editadmin'>
  <input type='hidden' name='admin_id' value='{$admin_id}'>
  </form>
  <form action='AdminEditViewadmins.php' method='POST'>
  <td><label class="button"><input type='submit' value='{$Admin922}'></label></td>
  <input type='hidden' name='task' value='cancel'>
  </form>
  </tr>
  </table>
</td>
</tr>
</table>

<br />

{include file='AdminFooter.tpl'}