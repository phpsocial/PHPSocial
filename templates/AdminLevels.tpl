{include file='AdminHeader.tpl'}

<h2>{$Admin445}</h2>
<p>{$Admin446}</p>


{if $is_error != 0}
<p style="color:red;"> {$Admin459}</p>
{/if}

{if $result == 2}
  <p style="color:green;">{$Admin460}</p>
{/if}

<table cellpadding="0" cellspacing="0" class="view-users">
    <tr>
        <th align="left" valign="top" class="col-f"><a class='header' href='AdminLevels.php?s={$i}'>{$Admin448}</a></th>
        <th align="left" valign="top" style="width:auto !important;"><a href='AdminLevels.php?s={$n}'>{$Admin449}</a></th>
        <th align="left" valign="top"><a href='AdminLevels.php?s={$u}'>{$Admin450}</a></th>

        <th align="center" valign="top" style="width:auto !important;">{$Admin458}</th>
        <th align="center" valign="top" class="col-l" colspan="2" style="width:auto;">{$Admin451}</th>
    </tr>
    {section name=level_loop loop=$levels}
    <tr class='{cycle values="1, event"}'>
        <td align="left" class="col-f">{$levels[level_loop].level_id}</td>
        <td align="left" style="width:190px !important;">{$levels[level_loop].level_name}</td>
        <td align="left"><a href='AdminViewusers.php?f_level={$levels[level_loop].level_id}'>{$levels[level_loop].level_users} {$Admin461}</a></td>

        <td align="center" style="width:240px !important;"><a href='AdminLevels.php?task=savechanges&default={$levels[level_loop].level_id}'><img src='../images/icons/{if $levels[level_loop].level_default == 1}admin_checkbox2.gif{else}admin_checkbox1.gif{/if}' border='0' class='icon'></a></td>
        <td align="center" class="col-l" colspan="2" style="width:auto !important;" ><a href='AdminEditLevels.php?level_id={$levels[level_loop].level_id}'>{$Admin452}</a> | <a href='AdminLevels.php?task=confirm&level_id={$levels[level_loop].level_id}'>{$Admin453}</a></td>
    </tr>
    {/section}
</table>
<form action='AdminAddLevels.php' method='GET'>
<label class="button"><input type='submit' value='{$Admin447}'/></label>
</form>

<br>
{include file='AdminFooter.tpl'}