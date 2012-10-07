{include file='AdminHeader.tpl'}

<h2>{$Admin533}</h2>
<p>{$Admin534}</p>

<table cellpadding="0" cellspacing="0" class="view-users">
    <tr>
        <th align="left" valign="top" class="col-f">{$Admin535}</th>
        <th align="left" valign="top" style="width:auto !important;">{$Admin537}</th>
        <th align="left" valign="top">{$Admin536}</th>
        <th align="center" valign="top" style="width:auto !important;">{$Admin538}</th>
        <th align="center" valign="top" class="col-l" colspan="2" style="width:auto;">{$Admin539} ({$Admin540})</th>
    </tr>
    {section name=login_loop loop=$logins}
    <tr class='{cycle values="1, event"}'>
        <td align="left" class="col-f">{$logins[login_loop].login_id}</td>
        <td align="left" style="width:190px !important;">{$datetime->cdate("g:i:s a, M. j", $datetime->timezone($logins[login_loop].login_date, $setting.setting_timezone))}</td>
        <td align="left"><a href='mailto:{$logins[login_loop].login_email}'>{$logins[login_loop].login_email}</a></td>
        <td align="center" style="width:240px !important;">
            {if $logins[login_loop].login_result == 0}
            <font color='#FF0000'>{$Admin542}</font>
            {else}
            {$Admin541}
        {/if}</td>
        <td align="center" class="col-l" colspan="2" style="width:auto !important;" >{$logins[login_loop].login_ip} {$logins[login_loop].login_hostname}</td>
    </tr>
    {/section}
</table>

<br/>

{include file='AdminFooter.tpl'}