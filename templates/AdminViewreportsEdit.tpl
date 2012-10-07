{include file='AdminHeader.tpl'}

<h2>{$Admin955}</h2>
<p>{$Admin956}</p>


<table cellpadding='0' cellspacing='4' style="color:#666666;">
<tr>
<td class='form1'>{$Admin957}</td>
<td class='form2'><a href='{$url->url_create("profile", $report_username)}' target='_blank'>{$report_username}</a></td>
</tr>
<tr>
<td class='form1'>{$Admin958}</td>
<td class='form2'><a href='AdminLoginasuser.php?user_id={$report_user_id}&url={$report_url_encoded}' target='_blank'>{$report_url}</a></td>
</tr>
<tr>
<td class='form1'>{$Admin959}</td>
<td class='form2'>{$report_reason}</td>
</tr>
<tr>
<td class='form1'>{$Admin960}</td>
<td class='form2'>{$report_details}</td>
</tr>
<tr><td colspan='2'>&nbsp;</td></tr>
<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td>
    <form action='AdminViewreportsEdit.php.php' method='POST'>
    <label class="button"><input type='submit' value='{$Admin961}'/></label>&nbsp;
    <input type='hidden' name='report_id' value='{$report_id}'>
    <input type='hidden' name='task' value='dodelete'>
    </form>
  </td>
  <td><form action='AdminViewreports.php' method='POST'><input type='submit' class='button' value='{$Admin962}'></form></td>
  </tr>
  </table>
</td>
</tr>
</table>

{include file='AdminFooter.tpl'}