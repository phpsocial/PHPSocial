{include file='AdminHeader.tpl'}

<h2>{$Admin905}</h2>
<p>{$Admin906}</p>

{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}

<p style="color:red;">{$error_message}</p>

<table cellpadding='0' cellspacing='3' style="color:#666666;">
    <form action='AdminAddViewadmins.php' method='POST'>
        <tr>
            <td class='form1'>{$Admin907}</td>
            <td class='form2'><input type='text' class="input-border" name='admin_username' value='{$admin_username}' maxlength='50'></td>
        </tr>
        <tr>
            <td class='form1'>{$Admin908}</td>
            <td class='form2'><input type='password' class="input-border" name='admin_password' maxlength='50'></td>
        </tr>
        <tr>
            <td class='form1'>{$Admin909}</td>
            <td class='form2'><input type='password' class="input-border" name='admin_password_confirm' maxlength='50'></td>
        </tr>
        <tr>
            <td class='form1'>{$Admin910}</td>
            <td class='form2'><input type='text' class="input-border" name='admin_name' value='{$admin_name}' maxlength='50'></td>
        </tr>
        <tr>
            <td class='form1'>{$Admin911}</td>
            <td class='form2'><input type='text' class="input-border" name='admin_email' value='{$admin_email}' maxlength='70'></td>
        </tr>
        <tr>
        
        <td class='form2' colspan="2" align="right">
        <table cellpadding='0' cellspacing='0' style="width:auto;">
        <tr>
            <td>&nbsp;</td>
        <td><label class="button"><input type='submit' value='{$Admin912}'></label>&nbsp;</td>

        <input type='hidden' name='task' value='addadmin'>
          
    </form>
    <form action='AdminAddViewadmins.php' method='POST'>
        
            <td><label class="button"><input type='submit' value='{$Admin913}'></label></td>
        </tr>
        <input type='hidden' name='task' value='cancel'>
    </form>
    </table>
    </td>
    </tr>
</table>

<br />



{include file='AdminFooter.tpl'}