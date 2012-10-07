{include file='AdminHeader.tpl'}
{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}

{* SHOW MAIN PAGE *}
{if $task == "main"}
<h2>{$Admin246}</h2>
<p>{$Admin247}</p>

<b><a href='AdminAnnouncements.php?task=post&type=email'>{$Admin248}</a></b>
<p>{$Admin249}</p>

<b><a href='AdminAnnouncements.php?task=post&type=news'>{$Admin250}</a></b>
<p>{$Admin251}</p>



{* LIST PAST ANNOUNCEMENTS *}
{if $news_total > 0}
<table cellpadding="0" cellspacing="0" class="view-users">
    <tr>
        <th align="left" valign="top" class="col-f" style="width:40px;">{$Admin252}</th>
        <th align="left" valign="top" style="width:540px; ">{$Admin253}</th>
        <th align="center" valign="top" class="col-l" style="background:transparent url(../images/th-l_ann.gif) no-repeat scroll right center;">{$Admin254}</th>
    </tr>
    {section name=news_loop loop=$news}
    <tr class='{cycle values="1, event"}'>
        <td align="left" class="col-f">{$news[news_loop].item_id}</td>
        <td align="left">
            <div><b>{if $news[news_loop].item_subject != ""}{$news[news_loop].item_subject|truncate:50:"...":true}{else}<i>{$Admin10}</i>{/if} </b>{if $news[news_loop].item_date != ""}{$news[news_loop].item_date}{else}<i>{$Admin11}</i>{/if}</div>
           
            <div>{$news[news_loop].item_body|truncate:300:"...":true}</div>
        </td>
        <td align="center" class="col-l">
            <a href='AdminAnnouncements.php?task=post&type=news&announcement_id={$news[news_loop].item_id}'>{$Admin257}</a> |
            {if $smarty.section.news_loop.last != true}<a href='AdminAnnouncements.php?task=moveup&type=news&announcement_id={$news[news_loop].item_id}'>{$Admin258}</a> |{/if}
            <a href='AdminAnnouncements.php?task=dodelete&type=news&announcement_id={$news[news_loop].item_id}'>{$Admin259}</a>
       </td>
    </tr>
    {/section}
</table>
<br/>

{/if}
{/if}




{* POST NEWS ITEM *}
{if $task == "post" AND $type == "news"}
<h2>{$Admin260}</h2>
<p>{$Admin261}</p>

<form action='AdminAnnouncements.php' method='post' style="color:#666666;">
    <b>{$Admin262}</b>
    <br><input type='text' name='date' size='50' class="input-border" maxlength='200' value='{$item_date}'>
    <br>{$Admin263}
    <br><br>
    <b>{$Admin264}</b>
    <br><input type='text' name='subject' size='50' class="input-border" maxlength='200' value='{$item_subject}'>
    <br><br>
    <b>{$Admin253}</b> {$Admin265}
    <br><textarea name='body' class="input-border" rows='7' cols='80'>{$item_body}</textarea>
    <br><br>
    <table cellpadding='0' cellspacing='0' style="color:#666666;">
    <tr>
    <td>
    <label class="button"><input type='submit' value='{$Admin266}'/></label>&nbsp;
    <input type='hidden' name='task' value='dopost'>
    <input type='hidden' name='type' value='news'>
    <input type='hidden' name='announcement_id' value='{$announcement_id}'>
</form>
</td>
<td>
    <form action='AdminAnnouncements.php' method='post'>
        <label class="button"><input type='submit' value='{$Admin267}'/></label>
    </form>
</td>
</tr>
</table>
{/if}




{* COMPOSE EMAIL ANNOUNCEMENT *}
{if $task == "post" AND $type == "email"}
<h2>{$Admin248}</h2>
<p>{$Admin268}</p>


{if $is_error == 1}
<p style="color:red;">{$error_msg}</p>
{/if}

<table cellpadding='5' cellspacing='4' style="color:#666666;">
    <form action='AdminAnnouncements.php' method='POST'>
        <tr>
            <td align='right'><b>{$Admin269}:</b></td>
            <td><input type='text' class="input-border" name='from' size='40' value='{$em_from}'></td>
        </tr>
        <tr>
            <td align='right'><b>{$Admin264}:</b></td>
            <td><input type='text' class="input-border" name='subject' size='40' value='{$em_sub}'></td>
        </tr>
        <tr>
            <td align='right' valign='top'><b>{$Admin253}:</b></td>
            <td><textarea name='message' class="input-border" rows='8' cols='80'>{$em_mess}</textarea></td>
        </tr>
        <tr>
            <td align='right' nowrap='nowrap'><b>{$Admin270}:</b></td>
            <td nowrap='nowrap'>
                <select class="input-border" name='emails_at_a_time'>
                    <option value='1'{if $emails_at_a_time == 1} selected='selected'{/if}>1 {$Admin280}</option>
                    <option value='2'{if $emails_at_a_time == 2} selected='selected'{/if}>2 {$Admin271}</option>
                    <option value='3'{if $emails_at_a_time == 3} selected='selected'{/if}>3 {$Admin271}</option>
                    <option value='4'{if $emails_at_a_time == 4} selected='selected'{/if}>4 {$Admin271}</option>
                    <option value='5'{if $emails_at_a_time == 5} selected='selected'{/if}>5 {$Admin271}</option>
                </select>
                <div>
            </td>
        </tr>

        {* DETERMINE HOW MANY LEVELS AND SUBNETS TO SHOW BEFORE ADDING SCROLLBARS *}
        {assign var='subnets_total' value=$subnets_total+1}
        {if $levels_total > 10 OR $subnets_total > 10}
        {assign var='options_to_show' value='10'}
        {elseif $levels_total > $subnets_total}
        {assign var='options_to_show' value=$levels_total}
        {elseif $levels_total < $subnets_total}
        {assign var='options_to_show' value=$subnets_total}
        {elseif $levels_total == $subnets_total}
        {assign var='options_to_show' value=$levels_total}
        {/if}

        <tr>
            <td align='right' valign='top'><b>{$Admin283}:</b></td>
            <td valign='top'>
                {$Admin284}
                <br><br>
                <table cellpadding='0' cellspacing='0' style="color:#666666;">
                    <tr>
                        <td>{$Admin285}:</td>
                        <td style='padding-left: 10px;'>{$Admin286}:</td>
                    </tr>
                    <tr>
                        <td>
                            <select size='{$options_to_show}' class="input-border" name='levels[]' multiple='multiple' style='width: 300px;'>
                                {section name=level_loop loop=$levels}
                                <option value='{$levels[level_loop].level_id}'{if $levels[level_loop].level_selected == 1} selected='selected'{/if}>{$levels[level_loop].level_name|truncate:75:"...":true}{if $levels[level_loop].level_default == 1} {$Admin287}{/if}</option>
                                {/section}
                            </select>
                        </td>
                        <td style='padding-left: 10px;'>
                            <select size='{$options_to_show}' class="input-border" name='subnets[]' multiple='multiple' style='width: 300px;'>
                                {section name=subnet_loop loop=$subnets}
                                <option value='{$subnets[subnet_loop].subnet_id}'{if $subnets[subnet_loop].subnet_selected == 1} selected='selected'{/if}>{$subnets[subnet_loop].subnet_name|truncate:75:"...":true}</option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td>
        <table cellpadding='0' cellspacing='0' style="color:#666666;">
        <tr>
        <td>
        <label class="button"><input type='submit' value='{$Admin272}'/></label>
        <input type='hidden' name='task' value='dosend'>
        <input type='hidden' name='type' value='email'>
    </form>
    </td>
    <td>
        <form action='AdminAnnouncements.php' method='post'>
            <label class="button"><input type='submit' value='{$Admin267}'/></label>
        </form>
    </td>
    </tr>
</table>
</td>
</tr>
</table>
{/if}




{* SEND ANNOUNCEMENTS *}
{if $task == "dosend" AND $type == "email"}
{if $totalinset < $emails_at_a_time}

<h2>{$Admin276}</h2>
<p>{$Admin277}</p>
<p>{$Admin278}</p>

<form action='AdminAnnouncements.php' method='post'>
    <label class="button"><input type='submit' value='{$Admin279}'/></label>
</form>

{else}

{assign var=startnum value=$start1-1}
{assign var=finishnum value=$finish1-1}

<h2>{$Admin279}</h2>
<p>{$Admin280} <b>#{$startnum} - #{$finishnum} {$Admin288} {$total}</b></p>
<p>{$Admin281}</p>
<br>
<form action='AdminAnnouncements.php' name='nextset' method='POST'>
    <label class="button"><input type='submit' value='{$Admin279}'/></label>
    <input type='hidden' name='start' value='{$finish}'>
    <input type='hidden' name='from' value='{$em_from}'>
    <input type='hidden' name='subject' value='{$em_sub}'>
    <input type='hidden' name='message' value='{$em_mess}'>
    <input type='hidden' name='levels' value='{$levels}'>
    <input type='hidden' name='subnets' value='{$subnets}'>
    <input type='hidden' name='emails_at_a_time' value='{$emails_at_a_time}'>
    <input type='hidden' name='task' value='dosend'>
    <input type='hidden' name='type' value='email'>
    <input type='hidden' name='total' value='{$total}'>
</form>

<script language="JavaScript">
    {literal}
    <!--
    function SymError() { return true; }
    window.onerror = SymError;
    var SymRealWinOpen = window.open;
    function SymWinOpen(url, name, attributes) { return (new Object()); }
    window.open = SymWinOpen;
    appendEvent = function(el, evname, func) {
        if (el.attachEvent) { // IE
            el.attachEvent('on' + evname, func);
        } else if (el.addEventListener) { // Gecko / W3C
            el.addEventListener(evname, func, true);
        } else {
            el['on' + evname] = func;
        }
    };
    appendEvent(window, 'load', windowonload);
    function windowonload() {
        setTimeout("document.nextset.submit()", 3000);
    }
    {/literal}
    // -->
</script>

{/if}

{/if}



{include file='AdminFooter.tpl'}