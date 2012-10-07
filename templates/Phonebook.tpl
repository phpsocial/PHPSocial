{include file='Header.tpl'}
{literal}
<style type="text/css">
    .submit_button{
        background:transparent url(../images/link-btn.gif) no-repeat scroll 0 0;
        color:#FFFFFF;
        display:block;
        font-weight:bold;
        height:23px;
        line-height:23px;
        margin-top:10px;
        text-align:center;
        width:129px;
        text-decoration:none;
        margin-left:25px;
    }
</style>
{/literal}

{* JAVASCRIPT TO AUTOFOCUS ON SEARCH FIELD *}
{literal}
<script language="JavaScript">
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
    <div class="grey-head"><h2>{$Application740}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application741}</p>
    </div>


    <div id="primary" class="info-cnt tuneddivs">
        <form action='Phonebook.php' method='POST' name='searchform' class="settings">

            <p>
                <label style="width:105px; clear:none; float:left;">{$Application488}</label>
                <input style="float:left; margin-left:15px !important; margin-right:15px !important;" type='text' maxlength='100' size='30' class='text' id='search' name='search' value='{$search}'/>
            </p>
            
            <p id='suggest' class='suggest' style="padding-left:125px;"></p>

            <p class="line">&nbsp;</p>
            <div class="submits" style="margin-left:20px !important;">
                <label><input type="submit" value="{$Application489}"/></label>
                <label><input type="button" class="submit_button" value="Cancel" onclick="location.href='UserFriends.php'"/></label>
            </div>


            <input type='hidden' name='s' value='{$s}'>
            <input type='hidden' name='p' value='{$p}'>
        </form>

    </div>

    <br/>
    <p style="padding-left:25px;"><b>Search results</b></p>
    <div id="primary" class="info-cnt tuneddivs" style="color:#666666;">
        <form action="" method="post" class="settings" style="margin-top:0px !important;">
            <p class="line">&nbsp;</p>


            {* SHOW MESSAGE IF USER HAS NO FRIENDS *}
            {if $total_friends == 0 AND $search == ""}
            <br/>
            <p align="center" style="color:red;">
                {$Application487}
            </p>
            <br/>
            {/if}

            {* DISPLAY MESSAGE IF NO FRIENDS *}
            {if $total_friends == 0}

            {* DISPLAY MESSAGE IF NO SEARCHED FRIENDS *}
            {if $search != ""}
            <br/>
            <p align="center" style="color:red;">
                {$Application494}
            </p>
            <br/>
            {/if}

            {* DISPLAY FRIENDS *}
            {else}

            {* SHOW DIFFERENT RESULT TOTALS *}

            {* DISPLAY PAGINATION MENU IF APPLICABLE *}
            {if $maxpage > 1}
            <p>
                {if $p != 1}<a href='Phonebook.php?s={$s}&search={$search}&p={math equation='p-1' p=$p}'>&#171; {$Application495}</a>{else}<font class='disabled'>&#171; {$Application496}</font>{/if}
                {if $p_start == $p_end}
                &nbsp;|&nbsp; {$Application496} {$p_start} {$Application498} {$total_friends} &nbsp;|&nbsp;
                {else}
                &nbsp;|&nbsp; {$Application497} {$p_start}-{$p_end} {$Application498} {$total_friends} &nbsp;|&nbsp;
                {/if}
                {if $p != $maxpage}<a href='Phonebook.php?s={$s}&search={$search}&p={math equation='p+1' p=$p}'>{$Application499} &#187;</a>{else}<font class='disabled'>{$Application499} &#187;</font>{/if}
            </p>
            {/if}

            {section name=friend_loop loop=$friends}
            {* LOOP THROUGH FRIENDS *}
            <div class="row" {if $smarty.section.friend_loop.last}style="border:none;"{/if}>
                 <div class="f-right">

                </div>

                <a class="f-left" href="{$url->url_create('profile',$friends[friend_loop]->user_info.user_username)}"><img src="{$friends[friend_loop]->user_photo('./images/nophoto.gif')}" class='img' width="92px" alt="{$friends[friend_loop]->user_info.user_username}"/></a>
                <dl style="width:380px! important;">
                    <dt style="width:50px !important;">Name:</dt>
                    <dd><a href="{$url->url_create('profile',$friends[friend_loop]->user_info.user_username)}"><b>{$friends[friend_loop]->user_info.user_username}</b></a></dd>

                    {if $friends[friend_loop]->user_info.user_phone}
                    <dt style="width:50px !important;">Phone:</dt>
                    <dd>{$friends[friend_loop]->user_info.user_phone}</dd>
                    {/if}



                </dl>
            </div>
            {/section}
            {/if}

        </form>
    </div>


    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>


{include file='Footer.tpl'}