{include file='AdminHeader.tpl'}

<h2>{$Admin932}</h2>
<p>{$Admin933}</p>

{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}

<table cellpadding='0' cellspacing='0' width='400' align='center'>
    <tr>
        <td align='center'>
            <div class='box'>
                <table cellpadding='2' cellspacing='0' align='center' style="color:#666666">
                    <tr><form action='AdminViewreports.php' method='POST'>
                            <td>
                                {$Admin945}<br>
                                <select name='f_reason' style="width:90px;" class="input-border">
                                    <option value=''{if $f_reason == ""} SELECTED{/if}></option>
                                    <option value='1'{if $f_reason == "1"} SELECTED{/if}>{$Admin939}</option>
                                    <option value='2'{if $f_reason == "2"} SELECTED{/if}>{$Admin940}</option>
                                    <option value='3'{if $f_reason == "3"} SELECTED{/if}>{$Admin941}</option>
                                    <option value='0'{if $f_reason == "0"} SELECTED{/if}>{$Admin942}</option>
                                </select>&nbsp;
                            </td>
                            <td>{$Admin12}<br><input type='text' class="input-border" name='f_details' value='{$f_details}' size='25' maxlength='50'>&nbsp;</td>
                            <td valign="bottom"><label class="button" style="margin:15px 15px 0 0;"><input type='submit' value='{$Admin946}'></label></td>
                            <input type='hidden' name='s' value='{$s}'>
                        </form>
                    </tr>
                </table>
            </div>
</td></tr></table>

<br>

{if $total_reports == 0}

<p><b>{$Admin935}</b></p>

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


<div class="result"><p><b>{$total_reports}</b> {$Admin947}  |  {$Admin948} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}<b>{$pages[page_loop].page}</b>{else}<a href='admin_viewgroups.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_owner={$f_owner}'>{$pages[page_loop].page}</a>{/if} {/section}</p></div>

<form action='AdminViewreports.php' method='post' name='items'>

<table cellpadding="0" cellspacing="0" class="view-users">
        <tr>
            <th align="left" valign="top" class="col-f"><div class="t-input"><input type='checkbox' name='select_all' onClick='javascript:doCheckAll()'/> <label> <a class='header' href='AdminViewreports.php?s={$i}&p={$p}&f_object={$f_object}&f_reason={$f_reason}&f_details={$f_details}'>{$Admin949}</a></label></div></th>
            <th align="left" valign="top"><a class='header' href='AdminViewreports.php?s={$u}&p={$p}&f_object={$f_object}&f_reason={$f_reason}&f_details={$f_details}'>{$Admin950}</a></th>
            <th align="left" valign="top">{$Admin943}</th>
            <th align="left" valign="top">{$Admin945}</th>
            <th align="center" valign="top">{$Admin951}</th>
           
        </tr>
        {section name=report_loop loop=$reports}
        <tr class='{cycle values="1, event"}'>
            <td align="left" class="col-f"><div class="t-input"><input type='checkbox' name='item_{$reports[report_loop].report_id}' value='1'/> {$reports[report_loop].report_id}</div></td>
            <td align="left"><a href='{$url->url_create("profile", $reports[report_loop].report_username)}' target='_blank'>{$reports[report_loop].report_username}</a></td>
            <td align="left">{$reports[report_loop].report_details|truncate:90:"...":true}</td>
            <td align="left">{$reports[report_loop].report_reason}</td>
            <td align="center" class="col-l"><a href='AdminLoginasuser.php?user_id={$reports[report_loop].report_user_id}&return_url={$reports[report_loop].report_url}' target='_blank'>{$Admin936}</a> | <a href='AdminViewreportsEdit.php.php?report_id={$reports[report_loop].report_id}'>{$Admin934}</a> | <a href='AdminViewreports.php?task=delete&report_id={$reports[report_loop].report_id}'>{$Admin937}</a></td>
        </tr>
        {/section}

    </table>
    <label class="button"><input type='submit' value='{$Admin938}'></label>
    <input type='hidden' name='task' value='dodelete'>
</form>

    <div class="result"><p><b>{$total_reports}</b> {$Admin16}  |  {$Admin948} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}<b>{$pages[page_loop].page}</b>{else}<a href='admin_viewgroups.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_owner={$f_owner}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
    <br>
{/if}


{include file='AdminFooter.tpl'}