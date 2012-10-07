{include file='AdminHeader.tpl'}

<h2>{$Admin290}</h2>
<p>{$Admin291}</p>

{if $result != 0}
<p style="color:green;">{$Admin305}</p>
{/if}

<form action='AdminBanning.php' method='POST'>
<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin292}</h3></div>
        <div class="block-in">
            <p><label><textarea name='banned_ips'>{$setting_banned_ips}</textarea></label></p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin293}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin294}</h3></div>
        <div class="block-in">
            <p><label><textarea name='banned_emails'>{$setting_banned_emails}</textarea></label></p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin295}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin296}</h3></div>
        <div class="block-in">
            <p><label><textarea name='banned_usernames'>{$setting_banned_usernames}</textarea></label></p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin297}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin298}</h3></div>
        <div class="block-in">
            <p><label><textarea name='banned_words'>{$setting_banned_words}</textarea></label></p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin299}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin300}</h3></div>
        <div class="block-in">
            <p><input type='radio' name='comment_code' id='comment_code_1' value='1'{if $setting_comment_code == 1} CHECKED{/if}/><label for='comment_code_1'> {$Admin302}</label></p>
            <p><input type='radio' name='comment_code' id='comment_code_0' value='0'{if $setting_comment_code == 0} CHECKED{/if}/><label for='comment_code_0'> {$Admin303}</label></p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin301}</p>
</div>

<div class="row" style="border:none; margin-bottom:0px;">
    <div class="block">
        <div class="block-head"><h3>{$Admin306}</h3></div>
        <div class="block-in">
            <p><input type='radio' name='invite_code' id='invite_code_1' value='1'{if $setting_invite_code == 1} CHECKED{/if}/><label for='invite_code_1'>{$Admin308}</label></p>
            <p><input type='radio' name='invite_code' id='invite_code_0' value='0'{if $setting_invite_code == 0} CHECKED{/if}/><label for='invite_code_0'>{$Admin309}</label></p>
            <br/>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin307}</p>
</div>

<div style="padding-left:20px;"><label class="button"><input type='submit' value='{$Admin304}'/></label></div>
<input type='hidden' name='task' value='dosave'>

</form>



{include file='AdminFooter.tpl'}