{include file='AdminHeader.tpl'}

<h2>{$Admin703}</h2>
<p>{$Admin704}</p>

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
{section name=tab_loop loop=$tabs}
<tr>
  {if $tabs[tab_loop].tab_order != "first"}
    <td>&nbsp;&nbsp; <a href='AdminProfileTaborder.php?task=reorder&tab_id={$tabs[tab_loop].tab_prev}&o={$o}'><img src='../images/arrow_up.gif' border='0'></a></td>
  {else}
    <td>&nbsp;&nbsp;</td>
  {/if}

  {if $tabs[tab_loop].tab_order != "last"}
    <td>&nbsp;&nbsp; <a href='AdminProfileTaborder.php?task=reorder&tab_id={$tabs[tab_loop].tab_id}&o={$o}'><img src='../images/arrow_down.gif' border='0'></a></td>
  {else}
    <td>&nbsp;&nbsp;</td>
  {/if}

  <td>&nbsp;&nbsp; {$tabs[tab_loop].tab_name}</td>

</tr>
{/section}
</table>

<br>

<form action='AdminProfileEdittab.php' method='POST'>
<label class="button"><input type='submit' value='{$Admin705}'/></label>
<input type='hidden' name='task' value='cancel'>
<input type='hidden' name='o' value='{$o}'>
</form>

{include file='AdminFooter.tpl'}