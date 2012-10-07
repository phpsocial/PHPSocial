{include file='AdminHeader.tpl'}

<h2>{$Admin701}</h2>
<p>{$Admin702}</p>

{if $is_error != 0}
    <p style="color:red;">{$Admin693}</p>
{/if}

{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}

<table cellpadding='0' cellspacing='4' style="color:#666666;">
<form action='AdminProfileEdittab.php' method='POST'>
<tr>
<td class='form1'>{$Admin695}</td>
<td class='form2'><input type='text' class='input-border' size='30' name='tab_name' value='{$tab_name}' maxlength='50'></td>
</tr>
<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>

  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><label class="button"><input type='submit' value='{$Admin696}'/></label></td>
  <input type='hidden' name='task' value='edittab'>
  <input type='hidden' name='o' value='{$o}'>
  <input type='hidden' name='tab_id' value='{$tab_id}'>
  </form>
  <form action='AdminProfileEdittab.php' method='POST'>
  <td><label class="button"><input type='submit' value='{$Admin698}'/></label></td>
  <input type='hidden' name='task' value='confirmdeletetab'>
  <input type='hidden' name='o' value='{$o}'>
  <input type='hidden' name='tab_id' value='{$tab_id}'>
  </form>
  <form action='AdminProfileEdittab.php' method='POST'>
  <td><label class="button"><input type='submit' value='{$Admin697}'/></label></td>
  <input type='hidden' name='task' value='cancel'>
  <input type='hidden' name='o' value='{$o}'>
  </form>
  </tr>
  </table>

</td>
</tr>
</table>

<br>

<table cellpadding='0' cellspacing='0'>
{section name=field_loop loop=$fields}
<tr>
  {if $fields[field_loop].field_order != "first"}
    <td>&nbsp;&nbsp; <a href='AdminProfileEdittab.php?task=reorder&tab_id={$tab_id}&field_id={$fields[field_loop].field_prev}&o={$o}'><img src='../images/arrow_up.gif' border='0'></a></td>
  {else}
    <td>&nbsp;&nbsp;</td>
  {/if}

  {if $fields[field_loop].field_order != "last"}
    <td>&nbsp;&nbsp; <a href='AdminProfileEdittab.php?task=reorder&tab_id={$tab_id}&field_id={$fields[field_loop].field_id}&o={$o}'><img src='../images/arrow_down.gif' border='0'></a></td>
  {else}
    <td>&nbsp;&nbsp;</td>
  {/if}

  <td>&nbsp;&nbsp; {$fields[field_loop].field_title}</td>
</tr>
{/section}
</table>

<br>

<form action='AdminProfileEdittab.php' method='POST'>
<label class="button"><input type='submit' value='{$Admin700}'/></label>
<input type='hidden' name='task' value='cancel'>
<input type='hidden' name='o' value='{$o}'>
</form>

{include file='AdminFooter.tpl'}