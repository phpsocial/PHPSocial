{include file='AdminHeader.tpl'}

<h2>{$Admin462}</h2>
<p>{$Admin463}</p>
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
<p style="color:red;">{$error_message}</p>
{/if}

<table cellpadding='0' cellspacing='6' style="color:#666666;">
<form action='AdminAddLevels.php' method='POST'>
<tr>
<td class='form1' align="left">{$Admin464}:</td>
<td class='form2' align="left"><input class="input-border" type='text' class='text' name='level_name' value='{$level_name}' size='41' maxlength='50'/></td>
</tr>
<tr>
<td class='form1' valign="top">{$Admin465}:</td>
<td class='form2'><textarea class="input-border" name='level_desc' rows='4' cols='40' class='text' style="overflow:auto;">{$level_desc}</textarea></td>
</tr>
<tr>

<td class='form2' colspan="2" align="right">
  <table cellpadding='0' cellspacing='0' width="100%">
  <tr>
     
  <td align="right"><label class="button" style="float:right;"><input type='submit' value='{$Admin466}'/></label>&nbsp;</td>
  <input type='hidden' name='task' value='createlevel'>
  </form>
  <form action='AdminLevels.php' method='POST'>
  <td><label class="button"><input type='submit' value='{$Admin467}'/></label></td>
  </tr>
  </form>
  </table>
</td>
</tr>
</table>




{include file='AdminFooter.tpl'}