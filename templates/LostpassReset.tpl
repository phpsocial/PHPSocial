{include file='Header.tpl'}

<div class='page_header'>{$Application185}</div>

{if $valid == 1 AND $submitted == 1}
  
  {$Application186}

{elseif $valid == 1 AND $submitted == 0}

  {$Application187}

  <br><br>

  {if $is_error == 1}{$error_message}{/if}

  <table cellpadding='0' cellspacing='0' class='form'>
  <form action='LostpassReset.php' method='POST'>
  <tr>
  <td class='form1'>{$Application188}</td>
  <td class='form2'><input type='password' class='text' name='user_password' maxlength='50' size='40'></td>
  </tr>
  <tr>
  <td class='form1'>{$Application189}</td>
  <td class='form2'><input type='password' class='text' name='user_password2' maxlength='50' size='40'></td>
  </tr>
  <tr>
  <td class='form1'>&nbsp;</td>
  <td class='form2'>
    <table cellpadding='0' cellspacing='0'>
    <td><input type='submit' class='button' value='{$Application190}'>&nbsp;</td>
    <input type='hidden' name='task' value='reset'>
    <input type='hidden' name='r' value='{$r}'>
    <input type='hidden' name='user' value='{$owner->user_info.user_username}'>
    </form>
    <form action='login.php' method='POST'>
    <td><input type='submit' class='button' value='{$Application191}'></td>
    </tr>
    </form>
    </table>
  </td>
  </tr>
  </form>
  </table>

{else}

  {$Application192}

{/if}

{include file='Footer.tpl'}
