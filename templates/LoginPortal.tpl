{include file='Header.tpl'}
<div id="content">
    <div class="block-top"><span>&nbsp;</span></div>
    <div class="main-post main-post2">
        {* SHOW ERROR MESSAGE *}
        {if $error_message != ""}
        <p style="color:red;">{$error_message}</p>
        {/if}
        <p>{$Application177}</p
        {if $setting.setting_signup_verify == 1}<p>{$Application170}</p>{/if}>
    </div>
    <div class="block-bot"><span>&nbsp;</span></div>
</div>
<div id="sidebar">
    <form class="login" action='Login.php' method='post' name='login'>
        <label>{$Application173}</label><input type="text" name='email' value='{$email}'/>
        <label>{$Application174}</label><input type='password'  name='password'/>
        <label style="">{$Application171}</label><input style="height:14px !important; width:14px !important; margin:0 10px 0 5px !important;" type='checkbox'  name='persistent' id='persistent' value='1'/>
        <br />
        <label class="registr"><input style="margin:10px 10px 10px 0;" type="submit" value="Login"/></label>
        <a class="registr" href="Signup.php" style="margin:10px 10px 10px 0;"><span>Register</span></a>

        <NOSCRIPT><input type='hidden' name='javascript_disabled' value='1' /></NOSCRIPT>
        <input type='hidden' name='task' value='dologin' />
        <input type='hidden' name='return_url' value='{$return_url}' />
    </form>
</div>


{include file='Footer.tpl'}