{include file='AdminHeader.tpl'}

<h2>{$Admin924}</h2>
<p>{$Admin925}</p>


{if $plugins_ready|@count == 0 & $plugins_installed|@count == 0}
<p>
    <img src='../images/icons/bulb16.gif' border='0' class='icon'>
    <b>{$Admin926}</b>
</p>

{/if}

{* LIST READY-TO-BE-INSTALLED PLUGINS *}
{section name=ready_loop loop=$plugins_ready}
<div class="row-blue" style="height:auto !important;">
    <table width='100%' cellpadding='0' cellspacing='0' class='stats' style='margin-bottom: 10px; color:#666666;'>
        <tr>
            <td class='plugin'>
                <table cellpadding='2' cellspacing='0' width="390px">
                    <tr>
                        <td width="1px"></td>
                        <td class='plugin_name' width="280px"><b>{$plugins_ready[ready_loop].plugin_name} v{$plugins_ready[ready_loop].plugin_version}</b></td>
                    </tr>
                </table>
                <div style='margin-top: 5px;'>{$plugins_ready[ready_loop].plugin_desc}</div>
                <div style='margin-top: 7px;'>
                    <a href='AdminViewplugins.php?install={$plugins_ready[ready_loop].plugin_type}'>{$Admin927}</a>
                </div>
            </td>
        </tr>
    </table>
</div>
{/section}

{* LIST INSTALLED PLUGINS *}
{section name=installed_loop loop=$plugins_installed}
<div class="row-blue" style="height:auto !important;">
    <table width='100%' cellpadding='0' cellspacing='0' class='stats' style='margin-bottom: 10px; color:#666666;'>
        <tr>
            <td class='plugin'>
                <table cellpadding='2' cellspacing='0' width="390px">
                    <tr>
                        <td width="1px"></td>
                        <td class='plugin_name' width="280px"><b>{$plugins_installed[installed_loop].plugin_name} v{$plugins_installed[installed_loop].plugin_version}</b></td>
                    </tr>
                </table>
                <div style='margin-top: 5px;'>{$plugins_installed[installed_loop].plugin_desc}</div>
                {if $plugins_installed[installed_loop].plugin_version_ready != "" & $plugins_installed[installed_loop].plugin_version_ready <= $plugins_installed[installed_loop].plugin_version}
                <table width='100%' cellpadding='0' cellspacing='0' style='margin-top: 10px; margin-bottom: 3px;'>
                    <tr valign="top">
                        <td class='error' valign="top" style="color:red;">
                            
                            {$Admin928}{$plugins_installed[installed_loop].plugin_type}{$Admin931}
                        </td>
                    </tr>
                </table>
                <br>
                {/if}
                <div style='margin-top: 7px;'>
                    {if $plugins_installed[installed_loop].plugin_version_ready > $plugins_installed[installed_loop].plugin_version}
                    <a href='AdminViewplugins.php?install={$plugins_installed[installed_loop].plugin_type}'>{$Admin929}</a> |
                    {elseif $plugins_installed[installed_loop].plugin_version_avail > $plugins_installed[installed_loop].plugin_version}
                    <a href='http://www.socialengine.net/login.php' target='_blank'>{$Admin930}</a> |
                    {/if}
                    {section name=page_loop loop=$plugins_installed[installed_loop].plugin_pages_main}
                    <a href='{$plugins_installed[installed_loop].plugin_pages_main[page_loop].file}'>{$plugins_installed[installed_loop].plugin_pages_main[page_loop].title}</a>{if $smarty.section.page_loop.last != TRUE} | {/if}
                    {/section}
                </div>
            </td>
        </tr>
    </table>
</div>
{/section}

{include file='AdminFooter.tpl'}