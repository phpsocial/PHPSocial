{include file='AdminHeader.tpl'}

<h2>{$Admin344}</h2>
<p>{$Admin345}</p>


{if $result != 0}
<p style="color:green;">{$Admin378}</p>
{/if}

<form action='AdminEmails.php' method='POST'>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin347}</h3></div>
        <div class="block-in">
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin349}</b><input type='text' class='text' size='40' name='setting_email_fromname' value='{$setting_email_fromname}' maxlength='37'/> </label></p>
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin350}</b><input type='text' class='text' size='40' name='setting_email_fromemail' value='{$setting_email_fromemail}' maxlength='37'/> </label></p>
            <br/>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin348}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin353}</h3></div>
        <div class="block-in">
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin351}:</b><input type='text' class='text' size='40' name='setting_email_invitecode_subject' value='{$setting_email_invitecode_subject}' maxlength='200'/> </label></p>
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin352}:</b><textarea  style="margin:0 0 0 0 !important;" rows='6' cols='80' class='text' name='setting_email_invitecode_message'>{$setting_email_invitecode_message}</textarea> </label></p>
            <br/>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin354} <br/><br/>{$Admin361}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin355}</h3></div>
        <div class="block-in">
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin351}:</b><input type='text' class='text' size='40' name='setting_email_invite_subject' value='{$setting_email_invite_subject}' maxlength='200'/> </label></p>
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin352}:</b><textarea  style="margin:0 0 0 0 !important;" rows='6' cols='80' class='text' name='setting_email_invite_message'>{$setting_email_invite_message}</textarea></label></p>
            <br/>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin356} <br/><br/>{$Admin362}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin355}</h3></div>
        <div class="block-in">
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin351}:</b><input type='text' class='text' size='40' name='setting_email_verify_subject' value='{$setting_email_verify_subject}' maxlength='200'/> </label></p>
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin352}:</b><textarea  style="margin:0 0 0 0 !important;" rows='6' cols='80' class='text' name='setting_email_verify_message'>{$setting_email_verify_message}</textarea></label></p>
            <br/>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin356} <br/><br/>{$Admin363}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin357}</h3></div>
        <div class="block-in">
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin351}:</b><input type='text' class='text' size='40' name='setting_email_newpass_subject' value='{$setting_email_newpass_subject}' maxlength='200'/> </label></p>
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin352}:</b><textarea  style="margin:0 0 0 0 !important;" rows='6' cols='80' class='text' name='setting_email_newpass_message'>{$setting_email_newpass_message}</textarea></label></p>
            <br/>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin358} <br/><br/>{$Admin364}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin359}</h3></div>
        <div class="block-in">
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin351}:</b><input type='text' class='text' size='40' name='setting_email_welcome_subject' value='{$setting_email_welcome_subject}' maxlength='200'/></label></p>
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin352}:</b><textarea  style="margin:0 0 0 0 !important;" rows='6' cols='80' class='text' name='setting_email_welcome_message'>{$setting_email_welcome_message}</textarea></label></p>
            <br/>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin360} <br/><br/>{$Admin365}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin369}</h3></div>
        <div class="block-in">
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin351}:</b><input type='text' class='text' size='40' name='setting_email_lostpassword_subject' value='{$setting_email_lostpassword_subject}' maxlength='200'/></label></p>
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin352}:</b><textarea  style="margin:0 0 0 0 !important;" rows='6' cols='80' class='text' name='setting_email_lostpassword_message'>{$setting_email_lostpassword_message}</textarea></label></p>
            <br/>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin370} <br/><br/>{$Admin371}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin372}</h3></div>
        <div class="block-in">
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin351}:</b><input type='text' class='text' size='40' name='setting_email_friendrequest_subject' value='{$setting_email_friendrequest_subject}' maxlength='200'/></label></p>
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin352}:</b><textarea  style="margin:0 0 0 0 !important;" rows='6' cols='80' class='text' name='setting_email_friendrequest_message'>{$setting_email_friendrequest_message}</textarea><br/>{$Admin33}</label></p>
            
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin373}<br/><br/>{$Admin374}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin375}</h3></div>
        <div class="block-in">
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin351}:</b><input type='text' class='text' size='40' name='setting_email_message_subject' value='{$setting_email_message_subject}' maxlength='200'/></label></p>
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin352}:</b><textarea  style="margin:0 0 0 0 !important;" rows='6' cols='80' class='text' name='setting_email_message_message'>{$setting_email_message_message}</textarea></label></p>
            <br/>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin377}</p>
</div>

<div class="row" style="border-bottom:none; margin-bottom:0px;">
    <div class="block">
        <div class="block-head"><h3>{$Admin366}</h3></div>
        <div class="block-in">
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin351}:</b><input type='text' class='text' size='40' name='setting_email_profilecomment_subject' value='{$setting_email_profilecomment_subject}' maxlength='200'/></label></p>
            <p style="margin:0 0 0 -10px;"><label><b>{$Admin352}:</b><textarea  style="margin:0 0 0 0 !important;" rows='6' cols='80' class='text' name='setting_email_profilecomment_message'>{$setting_email_profilecomment_message}</textarea></label></p>
            <br/>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin367}<br/><br/>{$Admin368}</p>
</div>


<div style="padding-left:20px;"><label class="button"><input type='submit' value='{$Admin346}'/></label></div>
<input type='hidden' name='task' value='dosave'>
</form>


{include file='AdminFooter.tpl'}