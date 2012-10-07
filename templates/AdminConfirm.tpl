{include file=$path2Phps|cat:'templates/AdminHeader.tpl'}

<h2>{$headline}</h2>
<p>{$instructions}</p>



<table cellpadding='0' cellspacing='0'>
<form action='{$confirm_form_action}' method='POST'>
<tr>
<td><label class="button"><input type='submit' value='Submit'/></label></td>
{section name=confirm_loop loop=$confirm_hidden}
  <input type='hidden' name='{$confirm_hidden[confirm_loop].name}' value='{$confirm_hidden[confirm_loop].value}'>
{/section}
</form>
<form action='{$cancel_form_action}' method='POST'>
<td><label class="button"><input type='submit' value='Cancel'/></label></td>
{section name=cancel_loop loop=$cancel_hidden}
  <input type='hidden' name='{$cancel_hidden[cancel_loop].name}' value='{$cancel_hidden[cancel_loop].value}'>
{/section}
</form>
</tr>
</table>

{include file=$path2Phps|cat:'templates/AdminFooter.tpl'}