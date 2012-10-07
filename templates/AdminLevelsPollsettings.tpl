{include file='AdminHeader.tpl'}

<h2>{$AdminLevelsPollsettings19} {$level_name}</h2>
{$AdminLevelsPollsettings20}

<table cellspacing='0' cellpadding='0' width='100%' style='margin-top: 20px;'>
<tr>
<td class='vert_tab0'>&nbsp;</td>
<td valign='top' class='pagecell' rowspan='{math equation='x+2' x=$level_menu|@count}'>

  <h2>{$AdminLevelsPollsettings1}</h2>
  {$AdminLevelsPollsettings2}

  <br/>

  {if $result != 0}
    <p style="color:green;">{$AdminLevelsPollsettings7}</p>
  {/if}

  {if $is_error != 0}
    <p style="color:red;">{$error_message}</p>
  {/if}

  <form action='admin_levels_pollsettings.php' name='info' method='post'>
  <table cellpadding='0' cellspacing='0' width='600'>
  <tr><td class='header'>{$AdminLevelsPollsettings9}</td></tr>
  <tr><td class='setting1'>
  {$AdminLevelsPollsettings10}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='level_poll_allow' id='poll_allow_1' value='1'{if $poll_allow == 1} CHECKED{/if}>&nbsp;</td><td><label for='poll_allow_1'>{$AdminLevelsPollsettings11}</label></td></tr>
    <tr><td><input type='radio' name='level_poll_allow' id='poll_allow_0' value='0'{if $poll_allow == 0} CHECKED{/if}>&nbsp;</td><td><label for='poll_allow_0'>{$AdminLevelsPollsettings12}</label></td></tr>
    </table>
  </td></tr></table>

  <br>
  
  <table cellpadding='0' cellspacing='0' width='600'>
  <tr>
  <td class='header'>{$AdminLevelsPollsettings3}</td>
  </tr>
  <td class='setting1'>
  {$AdminLevelsPollsettings4}
  </td>
  </tr>
  <tr>
  <td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='text' class='text' size='2' name='level_poll_entries' maxlength='3' value='{$entries_value}'></td><td>&nbsp; {$AdminLevelsPollsettings5}</td></tr>
    </table>
  </td>
  </tr>
  </table>

  <br>

  <table cellpadding='0' cellspacing='0' width='600'>
  <tr><td class='header'>{$AdminLevelsPollsettings16}</td></tr>
  <tr><td class='setting1'>
  {$AdminLevelsPollsettings13}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
      <tr><td><input type='radio' name='level_poll_search' id='poll_search_1' value='1'{if $poll_search == 1} CHECKED{/if}></td><td><label for='poll_search_1'>{$AdminLevelsPollsettings14}</label>&nbsp;&nbsp;</td></tr>
      <tr><td><input type='radio' name='level_poll_search' id='poll_search_0' value='0'{if $poll_search == 0} CHECKED{/if}></td><td><label for='poll_search_0'>{$AdminLevelsPollsettings15}</label>&nbsp;&nbsp;</td></tr>
    </table>
  </td></tr>
  <tr><td class='setting1'>
  {$AdminLevelsPollsettings17}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    {section name=privacy_loop loop=$poll_privacy}
      <tr><td><input type='checkbox' name='{$poll_privacy[privacy_loop].privacy_name}' id='{$poll_privacy[privacy_loop].privacy_name}' value='{$poll_privacy[privacy_loop].privacy_value}'{if $poll_privacy[privacy_loop].privacy_selected == 1} CHECKED{/if}></td><td><label for='{$poll_privacy[privacy_loop].privacy_name}'>{$poll_privacy[privacy_loop].privacy_option}</label>&nbsp;&nbsp;</td></tr>
    {/section}
    </table>
  </td></tr>
  <tr><td class='setting1'>
  {$AdminLevelsPollsettings18}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    {section name=comment_loop loop=$poll_comments}
      <tr><td><input type='checkbox' name='{$poll_comments[comment_loop].comment_name}' id='{$poll_comments[comment_loop].comment_name}' value='{$poll_comments[comment_loop].comment_value}'{if $poll_comments[comment_loop].comment_selected == 1} CHECKED{/if}></td><td><label for='{$poll_comments[comment_loop].comment_name}'>{$poll_comments[comment_loop].comment_option}</label>&nbsp;&nbsp;</td></tr>
    {/section}
    </table>
  </td></tr>
  </table>
  
  <br>
  
  <input type='submit' class='button' value='{$AdminLevelsPollsettings6}'>
  <input type='hidden' name='task' value='dosave'>
  <input type='hidden' name='level_id' value='{$level_id}'>
  </form>
  
</td>
</tr>

{section name=menu_loop loop=$level_menu}
  <tr><td width='100' nowrap='nowrap' class='vert_tab' style='{if $smarty.section.menu_loop.first != TRUE} border-top: none;{/if}{if $level_menu[menu_loop].page == $page} border-right: none;{/if}'><a href='{$level_menu[menu_loop].link}?level_id={$level_id}'>{$level_menu[menu_loop].title}</td></tr>
{/section}

<tr>
<td class='vert_tab0'>
  <div style='height: 760px;'>&nbsp;</div>
</td>
</tr>
</table>

{include file='AdminFooter.tpl'}