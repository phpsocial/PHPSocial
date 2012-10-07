{include file='AdminHeader.tpl'}

<h2>{$Admin967}</h2>
<p>{$Admin968}</p>
<div class="row-blue">
    <form action='AdminViewusers.php' method='POST'>
        <div class="f-left"><label>{$Admin969}</label><br/><input type='text' name='f_user' value='{$f_user}'/></div>
        <div class="f-left"><label>{$Admin971}</label><br/><input type="text" name='f_email' value='{$f_email}'/></div>
        <div class="f-left">
            <label>{$Admin990}</label><br/>
            <select style="width:115px;" name='f_level'>
                <option></option>
                {section name=level_loop loop=$levels}
                <option value='{$levels[level_loop].level_id}'{if $f_level == $levels[level_loop].level_id} SELECTED{/if}>{$levels[level_loop].level_name}</option>
                {/section}
            </select>

        </div>
        <div class="f-left"><label>{$Admin991}</label><br/>
            <select style="width:90px;" name='f_subnet'>
                <option></option>
                {section name=subnet_loop loop=$subnets}
                <option value='{$subnets[subnet_loop].subnet_id}'{if $f_subnet == $subnets[subnet_loop].subnet_id} SELECTED{/if}>{$subnets[subnet_loop].subnet_name}</option>
                {/section}
            </select>
        </div>

        <div class="f-left"><label>{$Admin972}</label><br/>
            <select style="width:60px;" name='f_enabled'>
                <option></option>
                <option value='1'{if $f_enabled == "1"} SELECTED{/if}>{$Admin975}</option>
                <option value='0'{if $f_enabled == "0"} SELECTED{/if}>{$Admin976}</option>
            </select>

        </div>
        <div class="f-left" style="margin:0;"><label class="img-button" style="margin-top:12px !important;"><input type="submit" value="{$Admin980}"/></label></div>
        <input type='hidden' name='s' value='{$s}'>
    </form>
</div>

{if $total_users == 0}

<div class="result"><p><b>{$Admin987}</b></p></div>


{else}

{* JAVASCRIPT FOR CHECK ALL *}
{literal}
<script language='JavaScript'>
    <!---
    var checkboxcount = 1;
    function doCheckAll() {
        if(checkboxcount == 0) {
            with (document.items) {
                for (var i=0; i < elements.length; i++) {
                    if (elements[i].type == 'checkbox') {
                        elements[i].checked = false;
                    }}
                checkboxcount = checkboxcount + 1;
            }
        } else
            with (document.items) {
                for (var i=0; i < elements.length; i++) {
                    if (elements[i].type == 'checkbox') {
                        elements[i].checked = true;
                    }}
            checkboxcount = checkboxcount - 1;
        }
    }
    // -->
</script>
{/literal}

<div class="result"><p><b>{$total_users}</b> {$Admin982}  |  {$Admin983} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}<b>{$pages[page_loop].page}</b>{else}<a href='AdminViewusers.php?s={$s}&p={$pages[page_loop].page}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$pages[page_loop].page}</a>{/if} {/section}</p></div>

<form action='AdminViewusers.php' method='post' name='items'>
    <table cellpadding="0" cellspacing="0" class="view-users">
        <tr>
            <th align="left" valign="top" class="col-f"><div class="t-input"><input type='checkbox' name='select_all' onClick='javascript:doCheckAll()'/> <label> <a href='AdminViewusers.php?s={$i}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'> {$Admin981}</a></label></div></th>
            <th align="left" valign="top"><a href='AdminViewusers.php?s={$u}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$Admin969}</a></th>
            <th align="left" valign="top"><a href='AdminViewusers.php?s={$em}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$Admin971}</a>{if $user_verification != 0} (<a href='AdminViewusers.php?s={$v}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$Admin988}</a>){/if}</th>
            <th align="left" valign="top">{$Admin990}</th>
            <th align="left" valign="top">{$Admin991}</th>
            <th align="center" valign="top">{$Admin972}</th>
            <th align="center" valign="top"><a href='AdminViewusers.php?s={$sd}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$Admin973}</a></th>
            <th align="center" valign="top" class="col-l">{$Admin974}</th>
        </tr>
        {section name=user_loop loop=$users}
        <tr class='{cycle values="1, event"}'>
            <td align="left" class="col-f"><div class="t-input"><input type='checkbox' name='item_{$users[user_loop].user_id}' value='1'/> {$users[user_loop].user_id}</div></td>
            <td align="left"><a href='{$url->url_create('profile', $users[user_loop].user_username)}'>{$users[user_loop].user_username|truncate:25:"...":true}</a></td>
            <td align="left"><a href='mailto:{$users[user_loop].user_email}'>{$users[user_loop].user_email|truncate:25:"...":true}</a>{if $user_verification != 0 & $users[user_loop].user_verified == 0} ({$Admin970}){/if}</td>
            <td align="left"><a href='AdminEditLevels.php?level_id={$users[user_loop].user_level_id}'>{$users[user_loop].user_level}</a></td>
            <td align="left"><a href='AdminSubnetworksEdit.php?subnet_id={$users[user_loop].user_subnet_id}'>{$users[user_loop].user_subnet}</a></td>
            <td align="center">{$users[user_loop].user_enabled}</td>
            <td align="center">{$datetime->cdate($setting.setting_dateformat, $datetime->timezone($users[user_loop].user_signupdate, $setting.setting_timezone))}</td>
            <td align="center" class="col-l"><a href='AdminViewusersEdit.php?user_id={$users[user_loop].user_id}&s={$s}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$Admin977}</a> | <a href='AdminViewusers.php?task=confirm&user_id={$users[user_loop].user_id}&s={$s}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$Admin978}</a> | <a href='AdminLoginasuser.php?user_id={$users[user_loop].user_id}' target='_blank'>{$Admin979}</a></td>
        </tr>
        {/section}
       
    </table>
    
    <div class="result"><p><b>{$total_users}</b> {$Admin982}  |  {$Admin983} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}<b>{$pages[page_loop].page}</b>{else}<a href='AdminViewusers.php?s={$s}&p={$pages[page_loop].page}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
    <input type='hidden' name='task' value='dodelete'>
    <label class="button"><input type="submit" value="{$Admin989}"/></label>
    <br/>
</form>
{/if}




{include file='AdminFooter.tpl'}