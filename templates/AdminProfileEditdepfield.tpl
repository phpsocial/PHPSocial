{include file='AdminHeader.tpl'}

<h2>{$Admin629}</h2>
<p>{$Admin630}</p>

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
<form action='AdminProfileEditdepfield.php' method='POST'>
<tr>
<td class='form1'>{$Admin639}</td>
<td class='form2'><a href='AdminProfileEditfield.php?field_id={$field_parent_id}&o={$o}'>{$field_parent_title}</a></td>
</tr>
<tr>
<td class='form1'>{$Admin631}</td>
<td class='form2'><input type='text' class='input-border' name='field_title' value='{$field_title}' maxlength='100' size='30'></td>
</tr>
<tr>
<td class='form1'>{$Admin632}</td>
<td class='form2'><input type='text' class='input-border' name='field_style' value='{$field_style}' maxlength='200' size='30'></td>
</tr>
<tr>
<td class='form1'>{$Admin641}</td>
<td class='form2'>
<select name='field_required' class='input-border'>
<option value='0'{if $field_required == 0} SELECTED{/if}>{$Admin643}</option>
<option value='1'{if $field_required == 1} SELECTED{/if}>{$Admin642}</option>
</select>
</td>
</tr>
<tr>
<td class='form1'>{$Admin644}</td>
<td class='form2'>
<select name='field_browsable' class='input-border'>
<option value='2'{if $field_browsable == 2} SELECTED{/if}>{$Admin645}</option>
<option value='-1'{if $field_browsable == -1} SELECTED{/if}>{$Admin646}</option>
</select>
</td>
</tr>
<tr>
<td class='form1' width='150'>{$Admin640}</td>
<td class='form2'>
<select name='field_maxlength' class='input-border'>
<option{if $field_maxlength == 50} SELECTED{/if}>50</option>
<option{if $field_maxlength == 100} SELECTED{/if}>100</option>
<option{if $field_maxlength == 150} SELECTED{/if}>150</option>
<option{if $field_maxlength == 200} SELECTED{/if}>200</option>
<option{if $field_maxlength == 250} SELECTED{/if}>250</option>
</select>
</td>
</tr>
<tr>
<td class='form1'>{$Admin633}</td>
<td class='form2'>
<input type='text' class='input-border' name='field_link' value='{$field_link}' size='30' maxlength='250'>
<br>{$Admin634}
</td>
</tr>
<tr>
<td class='form1'>{$Admin635}</td>
<td class='form2'><input type='text' class='input-border' name='field_regex' value='{$field_regex}' maxlength='250' size='30'><br>{$Admin636}</td>
</tr>
<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><label class="button"><input type='submit' value='{$Admin637}'/></label>
  <input type='hidden' name='task' value='editdepfield'>
  <input type='hidden' name='field_id' value='{$field_id}'>
  <input type='hidden' name='o' value='{$o}'></form></td>
  
  
  <td><form action='AdminProfileEditdepfield.php' method='POST'><label class="button"><input type='submit' value='{$Admin638}'/></label>
  <input type='hidden' name='task' value='cancel'>
  <input type='hidden' name='field_id' value='{$field_id}'>
  <input type='hidden' name='o' value='{$o}'></form></td>
  </tr>
  </table>
</td>
</tr>
</table>

{include file='AdminFooter.tpl'}