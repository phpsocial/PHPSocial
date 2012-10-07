{include file='AdminHeader.tpl'}

<h2>{$Admin531} {$level_name}</h2>
<p>{$Admin532}</p>

<table cellspacing='4' cellpadding='0' width='100%' style='margin-top: 20px; color:#666666;'>
<tr>
<td class='vert_tab0'>&nbsp;</td>
<td valign='top' class='pagecell' rowspan='{math equation='x+2' x=$level_menu|@count}'>
  <h2>{$Admin494}</h2>
  {$Admin495}
  <br><br>

  {if $result != 0}
    <p style="color:green;">{$Admin500}</div>
  {/if}

  {if $error_message != ""}
    <p style="color:red;">{$error_message}</p>
  {/if}

  <form action='AdminUsersettingsLevels.php' method='post' id='info' name='info'>
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr><td class='header'>{$Admin524}</td></tr>
  <tr><td class='setting1'>
  {$Admin525}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='level_profile_block' id='profile_block_1' value='1'{if $profile_block == 1} CHECKED{/if}>&nbsp;</td><td><label for='profile_block_1'>{$Admin526}</label></td></tr>
    <tr><td><input type='radio' name='level_profile_block' id='profile_block_0' value='0'{if $profile_block == 0} CHECKED{/if}>&nbsp;</td><td><label for='profile_block_0'>{$Admin527}</label></td></tr>
    </table>
  </td></tr></table>

  <br>

  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr><td class='header'>{$Admin496}</td></tr>
  <td class='setting1'>
  <b>{$Admin497}</b><br>
  {$Admin498}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
      <tr><td><input type='radio' name='profile_search' id='profile_search1' value='1' {if $profile_search == 1} CHECKED{/if}></td><td><label for='profile_search1'>{$Admin518}</label>&nbsp;&nbsp;</td></tr>
      <tr><td><input type='radio' name='profile_search' id='profile_search0' value='0' {if $profile_search == 0} CHECKED{/if}></td><td><label for='profile_search0'>{$Admin519}</label>&nbsp;&nbsp;</td></tr>
    </table>
  </td></tr>
  <tr><td class='setting1'>
  <b>{$Admin499}</b><br>
  {$Admin528}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    {section name=privacy_loop loop=$profile_privacy}
      <tr><td><input type='checkbox' name='{$profile_privacy[privacy_loop].privacy_name}' id='{$profile_privacy[privacy_loop].privacy_name}' value='{$profile_privacy[privacy_loop].privacy_value}'{if $profile_privacy[privacy_loop].privacy_selected == 1} CHECKED{/if}></td><td><label for='{$profile_privacy[privacy_loop].privacy_name}'>{$profile_privacy[privacy_loop].privacy_option}</label>&nbsp;&nbsp;</td></tr>
    {/section}
    </table>
  </td></tr>
  <tr><td class='setting1'>
  <b>{$Admin529}</b><br>
  {$Admin530}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    {section name=comment_loop loop=$profile_comments}
      <tr><td><input type='checkbox' name='{$profile_comments[comment_loop].comment_name}' id='{$profile_comments[comment_loop].comment_name}' value='{$profile_comments[comment_loop].comment_value}'{if $profile_comments[comment_loop].comment_selected == 1} CHECKED{/if}></td><td><label for='{$profile_comments[comment_loop].comment_name}'>{$profile_comments[comment_loop].comment_option}</label>&nbsp;&nbsp;</td></tr>
    {/section}
    </table>
  </td></tr>
  </table>
  
  <br>

  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr><td class='header'>{$Admin504}</td></tr>
  <td class='setting1'>
  {$Admin505}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='photo_allow' id='photo_allow_1' value='1'{if $photo_allow == 1} CHECKED{/if}>&nbsp;</td><td><label for='photo_allow_1'>{$Admin506}</label></td></tr>
    <tr><td><input type='radio' name='photo_allow' id='photo_allow_0' value='0'{if $photo_allow == 0} CHECKED{/if}>&nbsp;</td><td><label for='photo_allow_0'>{$Admin507}</label></td></tr>
    </table>
  </td></tr>
  <tr>
  <td class='setting1'>
  {$Admin508}
  </td>
  </tr>
  <tr>
  <td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td>{$Admin509} &nbsp;</td>
    <td><input type='text' class='text' name='photo_width' value='{$photo_width}' maxlength='3' size='3'> &nbsp;</td>
    <td>{$Admin510}</td>
    </tr>
    <tr>
    <td>{$Admin511} &nbsp;</td>
    <td><input type='text' class='text' name='photo_height' value='{$photo_height}' maxlength='3' size='3'> &nbsp;</td>
    <td>{$Admin510}</td>
    </tr>
    </table>
  </td>
  </tr>
  <tr>
  <td class='setting1'>
  {$Admin512}
  </td>
  </tr>
  <tr>
  <td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td>{$Admin513} &nbsp;</td>
    <td><input type='text' class='text' name='photo_exts' value='{$photo_exts}' size='40' maxlength='50'></td>
    </tr>
    </table>
  </td>
  </tr>
  </table>
  
  <br>

  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td class='header'>{$Admin503}</td>
  </tr>
  <td class='setting1'>
  {$Admin515}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='profile_style' id='profile_style_1' value='1'{if $profile_style == 1} CHECKED{/if}>&nbsp;</td><td><label for='profile_style_1'>{$Admin516}</label></td></tr>
    <tr><td><input type='radio' name='profile_style' id='profile_style_0' value='0'{if $profile_style == 0} CHECKED{/if}>&nbsp;</td><td><label for='profile_style_0'>{$Admin517}</label></td></tr>
    </table>
  </td></tr></table>
  
  <br>
  
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td class='header'>{$Admin520}</td>
  </tr>
  <td class='setting1'>
  {$Admin521}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='profile_status' id='profile_status_1' value='1'{if $profile_status == 1} CHECKED{/if}>&nbsp;</td><td><label for='profile_status_1'>{$Admin522}</label></td></tr>
    <tr><td><input type='radio' name='profile_status' id='profile_status_0' value='0'{if $profile_status == 0} CHECKED{/if}>&nbsp;</td><td><label for='profile_status_0'>{$Admin523}</label></td></tr>
    </table>
  </td></tr></table>
  
  <br>

<label class="button"><input type='submit' value='{$Admin514}'></label>
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
  <div style='height: 1400px;'>&nbsp;</div>
</td>
</tr>
</table>

{include file='AdminFooter.tpl'}