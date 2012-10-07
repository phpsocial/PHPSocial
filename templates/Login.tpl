{include file='Header.tpl'}
<div id="content">
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
    function windowonload() {
        if(document.login.email.value == "") {
            document.login.email.focus();
        } else {
            document.login.password.focus();
        }
    }
    // -->
</script>
{/literal}

    <div class="grey-head"><h2>{$Application172}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application177}</p>
    </div>

    {if $setting.setting_signup_verify == 1}<p style="padding-left:25px;">{$Application170}</p>{/if}

    {* SHOW ERROR MESSAGE *}
    {if $error_message != ""}
    <br/>
    <p style="color:red; padding-left:25px;">{$error_message}</p>
    <br/>
    {/if}

        <form action='Login.php' method='post' name='login' class="settings">

            <div><b>{$Application173}</b></div>
            <div class='form_desc'></div>
            <input style="width:235px !important; border:1px solid #CBD0D2;"  type='text' class='text' name='email' value='{$email}'/>
            <br/><br/>

            <div><b>{$Application174}</b></div>
            <div class='form_desc'></div>
            <input style="width:235px !important; border:1px solid #CBD0D2;" type='password' class='text' name='password' size='30' maxlength='50'/>
            <br/><br/>

            <label style="width:90px;">{$Application171}</label>
            <input style="border:none; width:15px !important; height:15px !important; float:left !important; margin-left:5px;" type='checkbox' name='persistent' id='persistent' value='1'/>
            &nbsp; <a href='Lostpass.php'>{$Application176}</a>

            <p class="line">&nbsp;</p>
            <div class="submits" style="margin-left:0px !important;">
                <label><input style="width:92px !important; width:100px !important;" type="submit" value="{$Application10}"/></label>
            </div>
            
            <NOSCRIPT><input type='hidden' name='javascript_disabled' value='1'/></NOSCRIPT>
            <input type='hidden' name='task' value='dologin'/>
            <input type='hidden' name='return_url' value='{$return_url}'/>
        </form>

    <div class="block-bot"><span>&nbsp;</span></div>
</div>






{include file='Footer.tpl'}