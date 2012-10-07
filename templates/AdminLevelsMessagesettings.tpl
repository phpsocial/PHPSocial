{include file='AdminHeader.tpl'}

<h2>{$Admin492} {$level_name}</h2>
{$Admin493}

<table cellspacing='0' cellpadding='0' width='100%' style='margin-top: 20px;'>
<tr>
<td class='vert_tab0'>&nbsp;</td>
<td valign='top' class='pagecell' rowspan='{math equation='x+2' x=$level_menu|@count}'>

  <h2>{$Admin479}</h2>
  {$Admin480}

  <br><br>

  {if $result != 0}
  <p style="color:green;">{$Admin491}</p>
  {/if}

  <table cellpadding='0' cellspacing='0' width='100%'>
  <form action='AdminMessagesettingsLevels.php' method='POST'>
  <tr><td class='header'>{$Admin481}</td></tr>
  <tr><td class='setting1'>
  {$Admin482}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='level_message_allow' id='message_allow_0' value='0'{if $message_allow == 0} CHECKED{/if}>&nbsp;</td><td><label for='message_allow_0'>{$Admin483}</label></td></tr>
    <tr><td><input type='radio' name='level_message_allow' id='message_allow_1' value='1'{if $message_allow == 1} CHECKED{/if}>&nbsp;</td><td><label for='message_allow_1'>{$Admin484}</label></td></tr>
    <tr><td><input type='radio' name='level_message_allow' id='message_allow_2' value='2'{if $message_allow == 2} CHECKED{/if}>&nbsp;</td><td><label for='message_allow_2'>{$Admin485}</label></td></tr>
    </table>
  </td></tr></table>

  <br>

  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr><td class='header'>{$Admin486}</td></tr>
  <tr><td class='setting1'>
  {$Admin487}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td>
    <select name='level_message_inbox' class='text'>
    <option value='5'{if $message_inbox == 5} SELECTED{/if}>5</option>
    <option value='10'{if $message_inbox == 10} SELECTED{/if}>10</option>
    <option value='20'{if $message_inbox == 20} SELECTED{/if}>20</option>
    <option value='30'{if $message_inbox == 30} SELECTED{/if}>30</option>
    <option value='40'{if $message_inbox == 40} SELECTED{/if}>40</option>
    <option value='50'{if $messae_inbox == 50} SELECTED{/if}>50</option>
    <option value='100'{if $message_inbox == 100} SELECTED{/if}>100</option>
    <option value='200'{if $message_inbox == 200} SELECTED{/if}>200</option>
    <option value='500'{if $message_inbox == 500} SELECTED{/if}>500</option>
    </select>
    </td>
    <td>&nbsp; {$Admin488}</td>
    </tr>
    <tr>
    <td>
    <select name='level_message_outbox' class='text'>
    <option value='5'{if $message_outbox == 5} SELECTED{/if}>5</option>
    <option value='10'{if $message_outbox == 10} SELECTED{/if}>10</option>
    <option value='20'{if $message_outbox == 20} SELECTED{/if}>20</option>
    <option value='30'{if $message_outbox == 30} SELECTED{/if}>30</option>
    <option value='40'{if $message_outbox == 40} SELECTED{/if}>40</option>
    <option value='50'{if $message_outbox == 50} SELECTED{/if}>50</option>
    <option value='100'{if $message_outbox == 100} SELECTED{/if}>100</option>
    <option value='200'{if $message_outbox == 200} SELECTED{/if}>200</option>
    <option value='500'{if $message_outbox == 500} SELECTED{/if}>500</option>
    </select>
    </td>
    <td>&nbsp; {$Admin489}</td>
    </tr>
    </table>
  </td></tr></table>
  
  <br>

  <input type='submit' class='button' value='{$Admin490}'>
  <input type='hidden' name='task' value='dosave'>
  <input type='hidden' name='level_id' value='{$level_id}'>
  </form>


</td>
</tr>

{section name=menu_loop loop=$level_menu}
  <tr><td width='100' nowrap='nowrap' class='vert_tab' style='{if $smarty.section.menu_loop.first != TRUE}border-top: none;{/if}{if $level_menu[menu_loop].page == $page} border-right: none;{/if}'><div style='width: 100px;'><a href='{$level_menu[menu_loop].link}?level_id={$level_id}'>{$level_menu[menu_loop].title}</a></div></td></tr>
{/section}

<tr>
<td class='vert_tab0'>
  <div style='height: 350px;'>&nbsp;</div>
</td>
</tr>
</table>





{include file='AdminFooter.tpl'}