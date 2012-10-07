{include file='AdminHeader.tpl'}


<h2>{$Admin477} {$level_name}</h2>
<p style="padding-bottom:10px;">{$Admin478}</p>
{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}

<table cellspacing='0' cellpadding='0' width='100%' style="">
{section name=menu_loop loop=$level_menu}
  <tr><td width='100' nowrap='nowrap' class='vert_tab' style='{if $smarty.section.menu_loop.first != TRUE}border-top: none;{/if}{if $level_menu[menu_loop].page == $page} border-right: none;{/if}'><div style='width: 100px;'><a href='{$level_menu[menu_loop].link}?level_id={$level_id}'>{$level_menu[menu_loop].title}</a></div></td></tr>
{/section}
</table>
<br/>
<table cellspacing='0' cellpadding='0' width='100%' style="padding-left:50px;">

<tr>
<td valign='top' class='pagecell' rowspan='{math equation='x+2' x=$level_menu|@count}'>

  {if $result != 0}
    <p style="color:green;">{$Admin475}</p>
  {/if}

  {if $is_error != 0}
   <p style="color:red;">{$error_message}</p>
  {/if}

  <form action='AdminEditLevels.php' method='POST'>
  <p style="padding-bottom:0px;">{$Admin472}:</p>
  <input class="input-border" type='text' class='text' name='level_name' value='{$level_name}' size='40' maxlength='50'>
  <br/><br/>
  <p style="padding-bottom:0px;">{$Admin473}:</p>
  <textarea name='level_desc' rows='8' cols='60' class="input-border">{$level_desc}</textarea>
  <br/>
  <label class="button"><input type='submit' value='{$Admin474}'/></label>
  <input type='hidden' name='level_id' value='{$level_id}'>
  <input type='hidden' name='task' value='editlevel'>
  </form>

</td>
</tr>


</table>


{include file='AdminFooter.tpl'}