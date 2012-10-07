{include file='Header.tpl'}
{* JAVASCRIPT TO AUTOFOCUS ON SEARCH FIELD *}
{literal}
<script type="text/javascript">
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
    function windowonload() { document.search_form.search_text.focus(); }
    // -->
    {/literal}
</script>

<div id="content">
    {* SHOW PAGE TITLE *}
    <div class="grey-head"><h2>{$Application275}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application276}</p>
    </div>


    <div id="primary" class="info-cnt tuneddivs">
        <form action='Search.php' name='search_form' method='post' class="settings">

            <p>
                <label style="width:60px; clear:none; float:left;">{$Application277}</label>
                <input style="float:left; margin-left:15px !important; margin-right:15px !important;" type='text'  name='search_text' value='{$search_text}'/>
                <a href='SearchAdvanced.php'>{$Application276}</a>
            </p>

            <p class="line">&nbsp;</p>
            <div class="submits" style="margin-left:20px !important;">
                <label><input type="submit" value="{$Application275}"/></label>
                <label><input type="button" class="submit_button" value="Cancel" onclick="location.href='UserFriends.php'"/></label>
            </div>

            <input type='hidden' name='task' value='dosearch'/>
            <input type='hidden' name='t' value='0'/>
        </form>

    </div>
 {if $search_text != ""}
    <br/>
    <p style="padding-left:25px;"><b>Search results</b></p>
    <div id="primary" class="info-cnt tuneddivs" style="color:#666666;">
        <form action="" method="post" class="settings" style="margin-top:0px !important;">
            <p class="line">&nbsp;</p>
           

            {if $is_results == 0}
            <br/>
            <p align="center" style="color:red;">
                {$Application280} "<b>{$search_text}</b>" {$Application281}
            </p>
            <br/>
            {else}

            {* SHOW DIFFERENT RESULT TOTALS *}

            {* section name=search_loop loop=$search_objects}
            
            <p>{if $search_objects[search_loop].search_total == 0}{$search_objects[search_loop].search_total} {$search_objects[search_loop].search_item}{else}<a href='Search.php?task=dosearch&search_text={$url_search}&t={$search_objects[search_loop].search_type}'>{$search_objects[search_loop].search_total} {$search_objects[search_loop].search_item}</a>{/if}</p>

            {/section *}


            {* SHOW PAGES *}
            <div align="center">
            {if $p != 1}<p><a href='Search.php?task=dosearch&search_text={$url_search}&t={$t}&p={math equation='p-1' p=$p}'>&#171; {$Application286}</a> &nbsp;|&nbsp;&nbsp;</p>{/if}
            {if $p_start == $p_end}
            <p>
                <b>{$Application287} {$p_start} {$Application288} {$total_results} {$Application289}</b> ({$search_time} {$Application290})
            </p>
            {else}
            <p>
                <b>{$Application287} {$p_start} - {$p_end} {$Application288} {$total_results} {$Application289}</b> ({$search_time} {$Application290})
            </p>
            {/if}
            {if $p != $maxpage}<p>&nbsp;&nbsp;|&nbsp; <a href='Search.php?task=dosearch&search_text={$url_search}&t={$t}&p={math equation='p+1' p=$p}'>{$Application291} &#187;</a></p>{/if}
            </div>


            {* SHOW RESULTS *}
            {section name=result_loop loop=$results}
            <div class="row" {if $smarty.section.result_loop.last}style="border:none;"{/if}>
                <div class="f-right">

                </div>

                {* SET ICON *}
                {if $results[result_loop].result_icon != ''}
                {assign var='result_icon' value=$results[result_loop].result_icon}
                {elseif $results[result_loop].result_user != ''}
                {assign var='result_icon' value=$results[result_loop].result_user->user_photo('./images/nophoto.gif')}
                {else}
                {assign var='result_icon' value='./images/icons/search_profile22.gif'}
                {/if}


                <a class="f-left" href="{$results[result_loop].result_url}"><img src="{$result_icon}" class='img' width="92px" alt="{$Application500}"/></a>
                <dl style="width:380px! important;">
                    <dt style="width:50px !important;">Result:</dt>
                    <dd><a href="{$results[result_loop].result_url}"><b>{$results[result_loop].result_name}</b></a></dd>

                    {if $results[result_loop].result_desc}
                    <dt>Description:</dt>
                    <dd>{$results[result_loop].result_desc}</dd>
                    {/if}

                    {if $results[result_loop].result_online == 1}
                    <dt style="width:50px !important;">Online:</dt>
                    <dd>{$Application285}</dd>
                    {/if}

                </dl>
            </div>
            {/section}
            {/if}
          
        </form>
    </div>
    {/if}

    <div class="block-bot"><span>&nbsp;</span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>
<div id="sidebar_right">{include file='MenuSidebarRight.tpl'}</div>
{include file='Footer.tpl'}