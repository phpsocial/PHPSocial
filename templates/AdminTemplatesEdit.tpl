{include file='AdminHeader.tpl'}

<h2>{$Admin864}</h2>
<p>{$Admin865}</p>


{if $error_message == ""}
<!-- SHOW EDIT TEMPLATE FORM -->
  <form action='AdminEditTemplates.php' method='POST'>
  <textarea name='template_code' rows='40' style="width:800px" class='template'>{$template_code}</textarea>
  <br>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><label class="button"><input type='submit' value='{$Admin866}'/></label>&nbsp;
  <input type='hidden' name='task' value='save'>
  <input type='hidden' name='t' value='{$filename}'>
  </form>
  </td>
  <td><form action='AdminTemplates.php' method='POST'><label class="button"><input style="width: 120px" type='submit' value='{$Admin867}'/></label>&nbsp;</form></td>
  </tr>
  </table>
{else}
<!-- SHOW ERROR -->
  <p style="color:red;">{$error_message}</p>
  <table cellpadding='0' cellspacing='0'>
  
  <tr>
  <td><form action='AdminTemplates.php' method='POST'><label class="button"><input style="width: 120px" type='submit' value='{$Admin873}'/></label>&nbsp;</form></td>
  </tr>
  
  </table>
{/if}

{include file='AdminFooter.tpl'}