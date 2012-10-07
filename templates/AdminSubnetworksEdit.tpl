{include file='AdminHeader.tpl'}

<h2>{$Admin839}</h2>
<p>{$Admin840}</p>

{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}

{if $error_message != ""}
<p style="color:red;">{$error_message}</p>
{/if}

<table cellpadding='0' cellspacing='4' style="color:#666666;">
<form action='AdminSubnetworksEdit.php' method='POST'>
<tr>
<td class='form1'>{$Admin841}:</td>
<td class='form2'><input type='text' class='input-border' name='subnet_name' value='{$subnet_name}' size='40' maxlength='50'></td>
</tr>
<tr>
<td class='form1'>{$Admin842}:</td>
<td class='form2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td>
  <select class='input-border' style="height:19px; width:50px;">
  <option>{$primary_field_title}</option>
  </select>&nbsp;
  </td>
  <td>
  <select class='input-border' name='subnet_field1_qual'>
  <option></option>
  <option value='=='{if $field1_qual == "=="} SELECTED{/if}>{$Admin844}</option>
  <option value='!='{if $field1_qual == "!="} SELECTED{/if}>{$Admin845}</option>
  <option value='>'{if $field1_qual == ">"} SELECTED{/if}>{$Admin846}</option>
  <option value='<'{if $field1_qual == "<"} SELECTED{/if}>{$Admin847}</option>
  <option value='>='{if $field1_qual == ">="} SELECTED{/if}>{$Admin848}</option>
  <option value='<='{if $field1_qual == "<="} SELECTED{/if}>{$Admin849}</option>
  </select>&nbsp;
  </td>
  <td>
    {* TEXT FIELD *}
    {if $primary_field.field_type == 1 OR $primary_field.field_type == 2}
      <input type='text' class='input-border' name='subnet_field1_value' value='{$subnet_field1_value}' maxlength='250' size='30'>

    {* SELECT BOX *}
    {elseif $primary_field.field_type == 3 OR $primary_field.field_type == 4}
      <select name='subnet_field1_value' class='input-border'>
      <option></option>
      {* LOOP THROUGH FIELD OPTIONS *}
      {section name=option_loop loop=$primary_field.field_options}
        <option value='{$primary_field.field_options[option_loop].option_id}'{$primary_field.field_options[option_loop].option_value}>{$primary_field.field_options[option_loop].option_label}</option>
      {/section}
      </select>

    {* DATE FIELD *}
    {elseif $primary_field.field_type == 5}
      <select name='subnet_field1_value_1' class='input-border'>
      {section name=date1 loop=$primary_field.date_array1}
        <option value='{$primary_field.date_array1[date1].value}'{$primary_field.date_array1[date1].selected}>{$primary_field.date_array1[date1].name}</option>
      {/section}
      </select>
 
      <select name='subnet_field1_value_2' class='input-border'>
      {section name=date2 loop=$primary_field.date_array2}
        <option value='{$primary_field.date_array2[date2].value}'{$primary_field.date_array2[date2].selected}>{$primary_field.date_array2[date2].name}</option>
      {/section}
      </select>

      <select name='subnet_field1_value_3' class='input-border'>
      {section name=date3 loop=$primary_field.date_array3}
        <option value='{$primary_field.date_array3[date3].value}'{$primary_field.date_array3[date3].selected}>{$primary_field.date_array3[date3].name}</option>
      {/section}
      </select>
    {/if}
  </td>
  </tr>
  </table>
</td>
</tr>
{if $secondary_field_id != -1}
<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>{$Admin843}:</td>
</tr>
<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td>
  <select class='input-border'>
  <option>{$secondary_field_title}</option>
  </select>&nbsp;
  </td>
  <td>
  <select class='input-border' name='subnet_field2_qual'>
  <option></option>
  <option value='=='{if $field2_qual == "=="} SELECTED{/if}>{$Admin844}</option>
  <option value='!='{if $field2_qual == "!="} SELECTED{/if}>{$Admin845}</option>
  <option value='>'{if $field2_qual == ">"} SELECTED{/if}>{$Admin846}</option>
  <option value='<'{if $field2_qual == "<"} SELECTED{/if}>{$Admin847}</option>
  <option value='>='{if $field2_qual == ">="} SELECTED{/if}>{$Admin848}</option>
  <option value='<='{if $field2_qual == "<="} SELECTED{/if}>{$Admin849}</option>
  </select>&nbsp;
  </td>
  <td>
    {* TEXT FIELD *}
    {if $secondary_field.field_type == 1 OR $secondary_field.field_type == 2}
      <input type='text' class='input-border' name='subnet_field2_value' value='{$subnet_field2_value}' maxlength='250' size='30'>

    {* SELECT BOX *}
    {elseif $secondary_field.field_type == 3 OR $secondary_field.field_type == 4}
      <select name='subnet_field2_value' class='input-border'>
      <option></option>
      {* LOOP THROUGH FIELD OPTIONS *}
      {section name=option_loop loop=$secondary_field.field_options}
        <option value='{$secondary_field.field_options[option_loop].option_id}'{$secondary_field.field_options[option_loop].option_value}>{$secondary_field.field_options[option_loop].option_label}</option>
      {/section}
      </select>

    {* DATE FIELD *}
    {elseif $secondary_field.field_type == 5}
      <select name='subnet_field2_value_1' class='input-border'>
      {section name=date1 loop=$secondary_field.date_array1}
        <option value='{$secondary_field.date_array1[date1].value}'{$secondary_field.date_array1[date1].selected}>{$secondary_field.date_array1[date1].name}</option>
      {/section}
      </select>
 
      <select name='subnet_field2_value_2' class='input-border'>
      {section name=date2 loop=$secondary_field.date_array2}
        <option value='{$secondary_field.date_array2[date2].value}'{$secondary_field.date_array2[date2].selected}>{$secondary_field.date_array2[date2].name}</option>
      {/section}
      </select>

      <select name='subnet_field2_value_3' class='input-border'>
      {section name=date3 loop=$secondary_field.date_array3}
        <option value='{$secondary_field.date_array3[date3].value}'{$secondary_field.date_array3[date3].selected}>{$secondary_field.date_array3[date3].name}</option>
      {/section}
      </select>
    {/if}
  </td>
  </tr>
  </table>
</td>
</tr>
{/if}
<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><label class="button"><input type='submit' value='{$Admin850}'/></label>&nbsp;</td>
  <input type='hidden' name='task' value='doedit'>
  <input type='hidden' name='s' value='{$s}'>
  <input type='hidden' name='subnet_id' value='{$subnet_id}'>
  </form>
  <form action='AdminSubnetworks.php' method='POST'>
  <td><label class="button"><input type='submit' value='{$Admin851}'/></label></td>
  </tr>
  <input type='hidden' name='s' value='{$s}'>
  </form>
  </table>
</td>
</tr>
</table>

{include file='AdminFooter.tpl'}