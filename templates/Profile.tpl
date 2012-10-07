{include file='Header.tpl'}

{* JAVASCRIPT FOR ADDING COMMENT *}
{literal}
<script type='text/javascript'>
<!--
var comment_changed = 0;
var first_comment = 1;
var last_comment = {/literal}{if $comments[0].comment_id}{$comments[0].comment_id}{else}0{/if}{literal};
var next_comment = last_comment+1;
var total_comments = {/literal}{$total_comments}{literal};

function removeText(commentBody) {
  if(comment_changed == 0) {
    commentBody.value='';
    commentBody.style.color='#000000';
    comment_changed = 1;
  }
}

function addText(commentBody) {
  if(commentBody.value == '') {
    commentBody.value = '{/literal}{$Application230}{literal}';
    commentBody.style.color = '#888888';
    comment_changed = 0;
  }
}

function checkText() {
  if(comment_changed == 0) { 
    var commentBody = document.getElementById('comment_body');
    commentBody.value=''; 
  }
  var commentSubmit = document.getElementById('comment_submit');
  commentSubmit.value = '{/literal}{$Application231}{literal}';
  commentSubmit.disabled = true;
  
}

function deleteComment(id) {
  document.getElementById("comment_" + id).style.display = "none";
  $.ajax({
    type: "GET",
    url: "UserEditprofileComments.php?comment_id=" + id,
    dataType: "script"
  });  
}

function addComment(is_error, comment_body, comment_date, comment_id) {
  if(is_error == 1) {
    var commentError = document.getElementById('comment_error');
    commentError.style.display = 'block';
    if(comment_body == '') {
      commentError.innerHTML = '{/literal}{$Application232}{literal}';
    } else {
      commentError.innerHTML = '{/literal}{$Application233}{literal}';
    }
    var commentSubmit = document.getElementById('comment_submit');
    commentSubmit.value = '{/literal}{$Application234}{literal}';
    commentSubmit.disabled = false;
  } else {
    var commentError = document.getElementById('comment_error');
    commentError.style.display = 'none';
    commentError.innerHTML = '';

    var commentBody = document.getElementById('comment_body');
    commentBody.value = '';
    addText(commentBody);

    var commentSubmit = document.getElementById('comment_submit');
    commentSubmit.value = '{/literal}{$Application234}{literal}';
    commentSubmit.disabled = false;

    if(document.getElementById('comment_secure')) {
      var commentSecure = document.getElementById('comment_secure');
      commentSecure.value=''
      var secureImage = document.getElementById('secure_image');
      secureImage.src = secureImage.src + '?' + (new Date()).getTime();
    }

    total_comments++;
    var totalComments = document.getElementById('total_comments');
    totalComments.innerHTML = total_comments;

    if(total_comments > 10) {
      var oldComment = document.getElementById('comment_'+first_comment);
      if(oldComment) { oldComment.style.display = 'none'; first_comment++; }
    }

    var newComment = document.createElement('div');
    var divIdName = 'comment_'+comment_id;
    newComment.setAttribute('id',divIdName);

    var newTable = "<div class='row post'><div class='w80 fleft'>";
    {/literal}
      {if $user->user_info.user_id != 0}
        newTable += "<a href='{$url->url_create('profile',$user->user_info.user_username)}'><img src='{$user->user_photo('./images/nophoto.gif')}' class='photo' border='0' width='{$misc->photo_size($user->user_photo('./images/nophoto.gif'),'75','75','w')}'></a>";
      {else}
        newTable += "<img src='./images/nophoto.gif' class='photo' border='0' width='75'>";
      {/if}
      newTable += "</div><div class='fright w490'><div class='grey w490 mb10'><div class='f-right'>2 {$Application22}</div><a href='{$url->url_create('profile',$user->user_info.user_username)}'>{$user->user_info.user_username}</a>{if $user->user_info.user_id == $owner->user_info.user_id}&nbsp;<a style='margin-left: 250px' href='javascript:deleteComment(" + comment_id + ")'>{$Application660}</a>{/if}{literal}</div><div class='wall-img w490'>" + comment_body + "</div></div></div>";
    newComment.innerHTML = newTable;
    var profileComments = document.getElementById('profile_comments');
    var prevComment = document.getElementById('comment_'+last_comment);
    profileComments.insertBefore(newComment, prevComment);
    last_comment = comment_id;
    document.getElementById('comment_form').reset();
  }
}


//-->
</script>
{/literal}


            <div id="content">
		<div class="block-top"><span></span></div>
				
				
                <div class="pfl">				
                    {if $owner->user_info.user_username != $user->user_info.user_username}
                    <br/><img width="174px" src='{$owner->user_photo("./images/nophoto.gif")}' class="img"/>
                    {if ($total_friends != 0) || ($friendship_allowed != 0 && $user->user_exists != 0) || ($user->level_info.level_message_allow == 2 || (($user->level_info.level_message_allow == 1 && $is_friend)) && ($owner->level_info.level_message_allow == 2 || ($owner->level_info.level_message_allow == 1 && $is_friend))) || ($user->level_info.level_profile_block != 0)}
                    <br/><br/>
                    <div class="block">
                        <div class="block-top"><span></span></div>
                        <ul>
                            {if $total_friends != 0}<li{if (!(($user->level_info.level_message_allow == 2 || ($user->level_info.level_message_allow == 1 && $is_friend)) && ($owner->level_info.level_message_allow == 2 || ($owner->level_info.level_message_allow == 1 && $is_friend))) && $user->level_info.level_profile_block == 0 && (!($friendship_allowed != 0 && $user->user_exists != 0)))} class="last-li"{/if}><a href='ProfileFriends.php?user={$owner->user_info.user_username}'>{$Application199} {$owner->user_info.user_username|truncate:10:"...":true}{$Application200}</a></li>{/if}
                            {if $friendship_allowed != 0 && $user->user_exists != 0}
                              {if $is_friend == TRUE}
                                <li{if (!(($user->level_info.level_message_allow == 2 || ($user->level_info.level_message_allow == 1 && $is_friend)) && ($owner->level_info.level_message_allow == 2 || ($owner->level_info.level_message_allow == 1 && $is_friend))) && $user->level_info.level_profile_block == 0)} class="last-li"{/if}><a href='UserFriendsConfirm.php?task=remove&user={$owner->user_info.user_username}&return_url={$url->url_create('profile', $owner->user_info.user_username)}'>{$Application227}</a></li>
                              {else}
                                <li{if (!(($user->level_info.level_message_allow == 2 || ($user->level_info.level_message_allow == 1 && $is_friend)) && ($owner->level_info.level_message_allow == 2 || ($owner->level_info.level_message_allow == 1 && $is_friend))) && $user->level_info.level_profile_block == 0)} class="last-li"{/if}><a href='UserFriendsAdd.php?user={$owner->user_info.user_username}'>{$Application201}</a></li>
                              {/if}
                            {/if}
                            {if ($user->level_info.level_message_allow == 2 || ($user->level_info.level_message_allow == 1 && $is_friend)) && ($owner->level_info.level_message_allow == 2 || ($owner->level_info.level_message_allow == 1 && $is_friend))}
                              <li{if $user->level_info.level_profile_block == 0} class="last-li"{/if}><a href='UserMessagesNew.php?to={$owner->user_info.user_username}'>{$Application202}</a></li>
                            {/if}
                            {if $user->level_info.level_profile_block != 0}
                              {if $user->user_blocked($owner->user_info.user_id) == TRUE}
                                <li class="last-li"><a href='UserFriendsBlock.php?task=unblock&user={$owner->user_info.user_username}'>{$Application228}</a></li>
                              {else}
                                <li class="last-li"><a href='UserFriendsBlock.php?task=block&user={$owner->user_info.user_username}'>{$Application204}</a></li>
                              {/if}
                            {/if}
                        </ul>  
                        <div class="block-bot"><span></span></div>
                    </div>
                    {/if}
                    {else}
                    <br/>
                    <div style="position: relative; overflow: visible">
                        <img width="174px" src='{$user->user_photo("./images/nophoto.gif")}' class="img"/>
                        {if $user->user_photo("") == ""}
                        <a style="position: absolute; top: 120px; left: 65px;" href="./UserEditprofilePhoto.php">Set Avatar</a>
                        {/if}
                    </div>
                    <br/><br/>
                    {/if}
                </div>
				
				<h3 class="stat w385">
				    {if $user->user_info.user_id == $owner->user_info.user_id}<a href="#" class="f-right set-status">change status</a>{/if}
				    <b>{$owner->user_info.user_username}
				    
				    {if $is_online == 1}{$Application213}{/if}</b>&nbsp;
				    
                    <span class="status-text">
                      {if $owner->level_info.level_profile_status != 0 AND $owner->user_info.user_status != "" AND $owner->user_info.user_id == $user->user_info.user_id}
                        {$owner->user_info.user_status|choptext:12:"<br>"}
                      {/if}
                    </span> 
				    {if $owner->level_info.level_profile_status != 0 AND $owner->user_info.user_status != "" AND $owner->user_info.user_id != $user->user_info.user_id}
                    <span class="status-text2">{$owner->user_info.user_status|choptext:12:"<br>"}</span>
                    {/if}
				    <span class="status"><input type="text" value="{$owner->user_info.user_status|choptext:12:"<br>"}"/></span>
				    <input type="hidden" style="display:none" id="status_username" value="{$owner->user_info.user_username}" />
			    </h3>
			    {if $is_private_profile}
			          <h2>{$Application195}</h2>
                      {$Application196}
                {else}

                	<dl class="w385">
                        <dt>{$Application208}</dt><dd style="width: 250px !important">{$total_views} {$Application209}</dd>
                        {if $setting.setting_connection_allow != 0}<dt>{$Application210}</dt><dd style="width: 250px !important">{$total_friends} {$Application211}</dd>{/if}
                        {if $owner->user_info.user_dateupdated != ""}<dt>{$Application214}</dt><dd style="width: 250px !important">{$datetime->time_since($owner->user_info.user_dateupdated)}</dd>{/if}
                        {if $owner->user_info.user_signupdate != ""}<dt>{$Application215}</dt><dd style="width: 250px !important">{$datetime->cdate("`$setting.setting_dateformat`", $datetime->timezone("`$owner->user_info.user_signupdate`", $global_timezone))}</dd>{/if}
                    </dl>
                    
                    <ul class="accordion">
                        <li class="active"><a href="#" class="opener active"><h2>Information</h2></a>
                         	<div class="slide">
                                {* Profile fields *}
                                {section name=tab_loop loop=$tabs}
                               	<h3>{$tabs[tab_loop].tab_name} {if $owner->user_info.user_id == $user->user_info.user_id}<span style="width:30px; display:block;float:right; position: relative"><a href="#" class="f-right edit-info save-btn" style="position: absolute;display:none;top:0;">save</a>&nbsp;<a href="#" class="f-right edit-info edit-btn" style="position: absolute; top:0;">edit</a>{/if}</span></h3>
                                <dl>
                                    {* LOOP THROUGH FIELDS IN TAB, ONLY SHOW FIELDS THAT HAVE BEEN FILLED IN *}
                                    {section name=field_loop loop=$tabs[tab_loop].fields}
                                    <dt>{$tabs[tab_loop].fields[field_loop].field_title}:</dt>
                                    <dd>
                                        <div class="field-case">
                                            {* TEXT FIELD *}
                                            {if $tabs[tab_loop].fields[field_loop].field_type == 1}
                                            <input type='text' class='text' name='field_{$tabs[tab_loop].fields[field_loop].field_id}' value='{$tabs[tab_loop].fields[field_loop].field_value}' style='{$tabs[tab_loop].fields[field_loop].field_style}' maxlength='{$tabs[tab_loop].fields[field_loop].field_maxlength}'/>
                        
                                            {* TEXTAREA *}
                                            {elseif $tabs[tab_loop].fields[field_loop].field_type == 2}
                                            <textarea rows='6' cols='50' name='field_{$tabs[tab_loop].fields[field_loop].field_id}' style='{$tabs[tab_loop].fields[field_loop].field_style}'>{$tabs[tab_loop].fields[field_loop].field_value}</textarea>
                                            <div class='form_desc'>{$tabs[tab_loop].fields[field_loop].field_desc}</div>
                        
                                            {* SELECT BOX *}
                                            {elseif $tabs[tab_loop].fields[field_loop].field_type == 3}
                                            <select name='field_{$tabs[tab_loop].fields[field_loop].field_id}' id='field_{$tabs[tab_loop].fields[field_loop].field_id}' onchange="ShowHideSelectDeps({$tabs[tab_loop].fields[field_loop].field_id})" style='{$tabs[tab_loop].fields[field_loop].field_style}'>
                                                <option value='-1'></option>
                                                {* LOOP THROUGH FIELD OPTIONS *}
                                                {section name=option_loop loop=$tabs[tab_loop].fields[field_loop].field_options}
                                                <option id='op' value='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}'{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id == $tabs[tab_loop].fields[field_loop].field_value} SELECTED{/if}>{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_label}</option>
                                                {/section}
                                            </select>
                        
                                            {* LOOP THROUGH DEPENDENT FIELDS }
                                            {section name=option_loop loop=$tabs[tab_loop].fields[field_loop].field_options}
                                            {if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_dependency == 1}
                                            <div id='field_{$tabs[tab_loop].fields[field_loop].field_id}_option{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' style='margin: 5px 5px 10px 5px;{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id != $tabs[tab_loop].fields[field_loop].field_value} display: none;{/if}'>
                                                {$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_title}{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_required != 0}*{/if}
                                                <input type='text' class='text' name='field_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_id}' value='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_value}' style='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_style}' maxlength='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_maxlength}'>
                                            </div>
                                            {else}
                                            <div id='field_{$tabs[tab_loop].fields[field_loop].field_id}_option{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' style='display: none;'></div>
                                            {/if}
                                            {/section} *}
                        
                                            {* RADIO BUTTONS *}
                                            {elseif $tabs[tab_loop].fields[field_loop].field_type == 4}
                        
                                            {* LOOP THROUGH FIELD OPTIONS *}
                                            {section name=option_loop loop=$tabs[tab_loop].fields[field_loop].field_options}
                        
                                            <div>
                                                <input type='radio' class='radio' onclick="ShowHideRadioDeps({$tabs[tab_loop].fields[field_loop].field_id}, {$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}, 'field_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_id}', {$tabs[tab_loop].fields[field_loop].field_options|@count})" style='{$tabs[tab_loop].fields[field_loop].field_style}' name='field_{$tabs[tab_loop].fields[field_loop].field_id}' id='label_{$tabs[tab_loop].fields[field_loop].field_id}_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' value='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}'{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id == $tabs[tab_loop].fields[field_loop].field_value} CHECKED{/if}>
                                                       <label id="field_{$tabs[tab_loop].fields[field_loop].field_id}_label_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}" for='label_{$tabs[tab_loop].fields[field_loop].field_id}_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}'>{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_label}</label>
                        
                                                {* DISPLAY DEPENDENT FIELDS 
                                                {if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_dependency == 1}
                                                <div id='field_{$tabs[tab_loop].fields[field_loop].field_id}_radio{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' style='margin: 0px 5px 10px 23px;{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id != $tabs[tab_loop].fields[field_loop].field_value} display: none;{/if}'>
                                                    {$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_title}
                                                    {if $tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_required != 0}*{/if}
                                                    <input type='text' class='text' name='field_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_id}' id='field_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_id}' value='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_value}' style='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_style}' maxlength='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_maxlength}'>
                                                </div>
                                                {else}
                                                <div id='field_{$tabs[tab_loop].fields[field_loop].field_id}_radio{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' style='display: none;'></div>
                                                {/if} *}
                        
                                            </div>
                                            {/section}
                        
                        
                                            {* DATE FIELD *}
                                            {elseif $tabs[tab_loop].fields[field_loop].field_type == 5}
                                            <input type='text' class='text' name='field_{$tabs[tab_loop].fields[field_loop].field_id}' value='{$datetime->cdate("`$setting.setting_dateformat`", $tabs[tab_loop].fields[field_loop].field_value)}' style='{$tabs[tab_loop].fields[field_loop].field_style}' maxlength='{$tabs[tab_loop].fields[field_loop].field_maxlength}'/>

                                            {/if}    
                                                                                    
                                            <!-- input type="text" name="profilevalue_{$tabs[tab_loop].fields[field_loop].field_id}" value="{$tabs[tab_loop].fields[field_loop].field_value}" -->
                                        </div>
                                        <div id="{$tabs[tab_loop].fields[field_loop].field_id}" class="field-val">{$tabs[tab_loop].fields[field_loop].field_value_profile}
                                        {if $tabs[tab_loop].fields[field_loop].field_birthday == 1} ({$datetime->age($tabs[tab_loop].fields[field_loop].field_value)} {$Application224}){/if}</div>
                                    </dd>
                                    {/section}
                                </dl>
                                {/section}
                                {* end profile fields *}                    
                            </div>
                        </li>
                        {* Comments *}
                        <li class="active"><a href="#" class="opener active"><h2> {$Application225} (<span id='total_comments'>{$total_comments}</span>)</h2></a>
                            <div class="slide" style="padding:0; width: 640px">
                                <div class="row-blue">
                                    <div class="f-right" style="padding-right:5px;">
                                        {if $allowed_to_comment != 0}<a style="padding-left: 10px" href="#" class="oth-func-link">other functions ></a>{/if}
                                    </div>
                                </div>
                                {if $allowed_to_comment != 0}
                                <form action='ProfileComments.php' id="comment_form" method='post' target='AddCommentWindow' enctype="multipart/form-data" onSubmit='checkText()'>
                                <div class="oth-func-box">
                                    <div class="sl">
                                        <a href="#audio">{$Application745}</a>
                                        <a href="#photo">{$Application744}</a>
                                        <a href="#video">{$Application746}</a>
                                    </div>
                                </div>
                                <div class="func-box audio">
                                    <div class="sl">
                                      <table cellpadding='0' cellspacing='0' width='100%'>
                                      <tr>
                                      <td width="100" align='left'>
                                          {$Application745}
                                      </td>
                                      <td colspan="3" align='left' style='padding-top: 5px;'>
                                          <input type="file" name="comment_mp3" width="200" />
                                      </td>
                                      </tr>
                                      <tr>
                                      </table>
                                    </div>
                                </div>
                                <div class="func-box photo">
                                    <div class="sl">
                                      <table cellpadding='0' cellspacing='0' width='100%'>
                                      <tr>
                                      <td width="100" align='left'>
                                          {$Application744}
                                      </td>
                                      <td colspan="3" align='left'>
                                          <input type="file" name="comment_image" width="200"/>
                                      </td>
                                      </tr>
                                      </table>
                                    </div>
                                </div>
                                <div class="func-box video">
                                    <div class="sl">
                                      <table cellpadding='0' cellspacing='0' width='100%'>
                                      <tr>
                                      <td width="100" align='left'>
                                          {$Application746}
                                      </td>
                                      <td colspan="3" align='left'>
                                          <input type="text" name="comment_video" width="200"/>
                                      </td>
                                      </tr>
                                      </table>
                                    </div>
                                </div>
                                <div class="leave-msg-box" style="display:block">
                                    <div class="sl">
                                        <div id='comment_error' style='color: #FF0000; display: none;'></div>

                                          <textarea name='comment_body' id='comment_body' rows='2' cols='65' style="width:600px" onfocus='removeText(this)' onblur='addText(this)' class='comment_area'>{$Application230}</textarea>
                                          
                                          <table cellpadding='0' cellspacing='0' width='100%'>
                                          <tr>
                                          {if $setting.setting_comment_code == 1}
                                            <td width='75' valign='top'><img src='./images/secure.php' id='secure_image' border='0' height='20' width='67' class='signup_code'></td>
                                            <td width='68' style='padding-top: 4px;'><input type='text' name='comment_secure' id='comment_secure' class='text' size='6' maxlength='10'></td>
                                            <td width='10'><img src='./images/icons/tip.gif' border='0' class='icon' onMouseover="tip('{$Application235}')"; onMouseout="hidetip()"></td>
                                          {/if}
                                          <td align='right' valign="top" style='padding-top: 5px; padding-left:10px'>
                                          <input type='submit' id='comment_submit' value='{$Application234}'>
                                          <input type='hidden' name='user' value='{$owner->user_info.user_username}'>
                                          <input type='hidden' name='task' value='dopost'>
                                          </form>
                                          </td>
                                          </tr>
                                          </table>
                                    </div>
                                </div>
                                <iframe name='AddCommentWindow' style='width: 100px; height: 100px; display: none' src=''></iframe>
                                </form>
                                {/if}
                             <div id="profile_comments">
                                <div style="float: right; padding:20px; padding-bottom: 0;">
                                    {if $prev}<a href="Profile.php?user={$user->user_info.user_username}&amp;p={$prev}">{$Application241}</a>{/if}
                                    {if $next}<a href="Profile.php?user={$user->user_info.user_username}&amp;p={$next}">{$Application245}</a>{/if}
                                </div>
                                {section name=comment_loop loop=$comments}
                                <div class="row post" id='comment_{$comments[comment_loop].comment_id}'>
                                    <div class="w120 fleft">
                                    {if $comments[comment_loop].comment_author->user_info.user_id != 0}
                                       <a href='{$url->url_create('profile',$comments[comment_loop].comment_author->user_info.user_username)}'><img src='{$comments[comment_loop].comment_author->user_photo('./images/nophoto.gif')}' class='photo' border='0' width='{$misc->photo_size($comments[comment_loop].comment_author->user_photo('./images/nophoto.gif'),'75','75','w')}'></a>
                                    {else}
                                       <img src='./images/nophoto.gif' class='photo' border='0' width='75'>
                                    {/if}
                                    </div>
                                    <div class="fleft w490">
                                    <div class="grey w490 mb10"><div class="f-right">{$datetime->cdate("`$setting.setting_timeformat` `$Application212` `$setting.setting_dateformat`", $datetime->timezone($comments[comment_loop].comment_date, $global_timezone))}</div>{if $comments[comment_loop].comment_author->user_info.user_id != 0}<a href='{$url->url_create('profile',$comments[comment_loop].comment_author->user_info.user_username)}'>{$comments[comment_loop].comment_author->user_info.user_username}</a>{else}{$Application33}{/if}{if $user->user_info.user_id == $owner->user_info.user_id}&nbsp;<a style="margin-left: 250px" href="javascript:deleteComment({$comments[comment_loop].comment_id})">{$Application660}</a>{/if}</div>
                                    <div class="wall-img w490">
                                        {$comments[comment_loop].comment_body|choptext:50:"<br>"}
                                    </div>
                                    {if $user->user_info.user_exists}
                                    <div class="navi blue w490">
                                        {if $comments[comment_loop].comment_author->user_info.user_id != 0}
                                               <a href='{$url->url_create('profile', $comments[comment_loop].comment_author->user_info.user_username)}#comments'>{$Application218}</a>&nbsp;|&nbsp;
                                               <a href='UserMessagesNew.php?to={$comments[comment_loop].comment_author->user_info.user_username}'>{$Application221}</a>{/if}
                                    </div>
                                    {/if}
                                    </div>
                                </div>
                                {/section}
                             </div>
                        {* End Comments *}
                        {/if}
                        </div>
                    </li>
                </ul>
			<div class="block-bot"><span></span></div>
            </div>
            
            <div id="sidebar">
                {include file='MenuSidebar.tpl'}

                {* Friend list *}
                {if $total_friends != 0}
                <div class="block">
                        <ul class="accordion">
                            <li class="form-top active"><a href="#" class="opener active">{$Application222} ({$total_friends})</a>
                            	<div class="slide">
                                	<div class="row-blue blue"><a href="ProfileFriends.php?user={$owner->user_info.user_username}" class="f-right">{$Application217} {$Application211}</a></div>
                                    {section name=friend_loop loop=$friends}
                                	<div class="user"><a href='{$url->url_create('profile',$friends[friend_loop]->user_info.user_username)}'><img src='{$friends[friend_loop]->user_photo('./images/nophoto.gif')}' class='photo' border='0' width='{$misc->photo_size($friends[friend_loop]->user_photo('./images/nophoto.gif'),'75','75','w')}'><br>{$friends[friend_loop]->user_info.user_username}</a></div>
                                    {/section}
                                <div class="block-bot"><span></span></div>
                                </div>
                            </li>
                        </ul>
				</div>
                {/if}
                
                {* Plugins *}
                {section name=profile_loop loop=$global_plugins}{include file="../plugins/`$global_plugins[profile_loop]`/templates/Profile`$global_plugins[profile_loop]`.tpl"}{/section}

			</div>
{include file='Footer.tpl'}