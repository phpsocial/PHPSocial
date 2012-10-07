{include file='AdminHeader.tpl'}

<h2>{$Admin628}</h2>
<p>{$Admin624}</p>

{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}

{if $is_error != 0}
<p class="color:red;">{$Admin623}</p>
{/if}

<table cellpadding='0' cellspacing='4' style="color:#666666;">
<form action='AdminProfileAddtab.php' method='POST'>
<tr>
<td class='form1'>{$Admin625}</td>
<td><input type='text' name='tab_name' size='40' class='input-border' value='{$tab_name}' maxlength='50'></td>
</tr>
<tr>
<td class='form1'>&nbsp;</td>
<td>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><label class="button"><input type='submit' value='{$Admin626}'/></label></td>
  <input type='hidden' name='task' value='addtab'>
  <input type='hidden' name='o' value='{$o}'>
  </form>
  <form action='AdminProfileAddtab.php' method='POST'>
  <td>
  <label class="button"><input type='submit' value='{$Admin627}'/></label></td>
  <input type='hidden' name='task' value='cancel'>
  <input type='hidden' name='o' value='{$o}'>
  </form>
  </tr>
  </table>
</td>
</tr>
</table>


{include file='AdminFooter.tpl'}