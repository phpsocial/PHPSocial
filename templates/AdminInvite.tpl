{include file='AdminHeader.tpl'}

<h2>{$Admin439}</h2>
<p>{$Admin440}</p>

{if $result != 0}
<p style="color:green;">{$Admin444}</p>
{/if}
<p class="line">&nbsp;</p>
<form action='AdminInvite.php' method='POST'>

    <div class="row" style="border-bottom:none; margin-bottom:0px;">
        <div class="block">
            <div class="block-head"><h3>{$Admin441}</h3></div>
            <div class="block-in">
                <p><label><textarea name='invite_emails'></textarea></label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin442}</p>
    </div>
    
    <div style="padding-left:20px;"><label class="button"><input type='submit' value='{$Admin443}'/></label></div>
    <input type='hidden' name='task' value='doinvite'>

</form>



{include file='AdminFooter.tpl'}