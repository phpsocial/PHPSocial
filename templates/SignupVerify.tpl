{include file='Header.tpl'}

<div class='page_header'>{$Application371}</div>

{if $is_error == 0}
  <div class='success'><img src='./images/success.gif' border='0' class='icon'> {$Application372} {$subnet_changed} {$Application373}</div>
  <br>
  <form action='login.php' method='GET'>
  <input type='submit' class='button' value='{$Application374}'>
  </form>
{else}
  {if $resend == 0}
    <div>{$Application375}</div>
    <br>
    <form action='SignupVerify.php' method='POST'>
    {$Application376}<br><input type='text' class='text' name='resend_email' size='40' maxlength='70'>
    <br><br>
    <input type='submit' class='button' value='{$Application377}'>
    <input type='hidden' name='task' value='resend'>
    </form>
  {else}
    {if $is_resend_error == 0}
      <div class='success'><img src='./images/success.gif' border='0' class='icon'> {$Application378}</div>
    {else}
      <div class='success'><img src='./images/error.gif' border='0' class='icon'>{$error_message}</div>
    {/if}
  {/if}
{/if}

{include file='Footer.tpl'}