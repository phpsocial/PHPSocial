{include file='Header.tpl'}
<div id="content">
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
           .form_check input{
        border:none !important;
    }
        .block_div{
            padding-top:4px;
        }
    </style>
    {/literal}
    {* JAVASCRIPT FOR ADDING NEW FIELDS TO BLOCK LIST *}
    <script type="text/javascript">
        <!--
        var blocked_id = {$num_blocked};
        {literal}
        function addInput(fieldname) {
            var ni = document.getElementById(fieldname);
            var newdiv = document.createElement('div');
            var divIdName = 'my'+blocked_id+'Div';
            newdiv.setAttribute('id',divIdName);
            newdiv._appendClass('block_div');
            newdiv.innerHTML = "<input type='text' name='blocked" + blocked_id +"' size='25' class='text' maxlength='50'>&nbsp;<br>";
            ni.appendChild(newdiv);
            blocked_id++;
            window.document.info.num_blocked.value=blocked_id;
        }

        // -->
    </script>
    {/literal}

    <div class="grey-head"><h2>{$Application388}</h2></div>
    <div class="row-blue" align="center">
        <p class="blue">{$Application389}</p>
    </div>


    <div class="layers" >
        <ul class="list01" style="margin:1px; width:600px;">

            <li {if $page=='UserAccount'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='UserAccount.php'>{$Application385}</a>
            </li>

            <li {if $page=='UserAccountPass'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='UserAccountPass.php'>{$Application386}</a>
            </li>

            <li {if $page=='UserAccountDelete'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='UserAccountDelete.php'>{$Application387}</a>
            </li>
        </ul>



        {* SHOW SUCCESS MESSAGE *}
        {if $result != ""}
        <br/>
        <p align="center" style="color:green;">{$result}</p>
        <br/>

        {* SHOW ERROR MESSAGE *}
        {elseif $error_message != ""}
        <br/>
        <p align="center" style="color:red;">{$error_message}</p>
        <br/>
        {/if}


        <div id="primary" class="info-cnt tuneddivs" style="margin:1px;">

            <form action="UserAccount.php" method="post" class="settings">
                <table cellpadding='0' cellspacing='0' style="color:#666666;">
                    <tr>
                        <td class='form1'>{$Application390}</td>
                        <td class='form2'>
                            <input name='user_email' type='text' class='text' size='40' maxlength='70' value='{$user->user_info.user_email}'>
                            {if $user->user_info.user_email != $user->user_info.user_newemail & $user->user_info.user_newemail != "" & $setting.setting_signup_verify != 0}<div class='form_desc'>{$Application391} {$user->user_info.user_newemail}</div>{/if}
                            {if $setting.setting_subnet_field1_id == 0 | $setting.setting_subnet_field2_id == 0}<div class='form_desc'>{$Application392} {$user->subnet_info.subnet_name}</div>{/if}
                        </td>
                    </tr>
                    <tr>
                        <td class='form1'>{$Application393}</td>
                        <td class='form2' style="padding-top:4px !important;">
                            <input name='user_username' type='text' class='text' size='40' maxlength='50' value='{$user->user_info.user_username}'>
                            
                                 <div class='form_desc'>{$Application382}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class='form1'>{$Application395}</td>
                        <td class='form2' style="padding-top:4px !important;">
                            <select name='user_timezone'>
                                <option value='-8'{if $user->user_info.user_timezone == "-8"} SELECTED{/if}>Pacific Time (US & Canada)</option>
                                <option value='-7'{if $user->user_info.user_timezone == "-7"} SELECTED{/if}>Mountain Time (US & Canada)</option>
                                <option value='-6'{if $user->user_info.user_timezone == "-6"} SELECTED{/if}>Central Time (US & Canada)</option>
                                <option value='-5'{if $user->user_info.user_timezone == "-5"} SELECTED{/if}>Eastern Time (US & Canada)</option>
                                <option value='-4'{if $user->user_info.user_timezone == "-4"} SELECTED{/if}>Atlantic Time (Canada)</option>
                                <option value='-9'{if $user->user_info.user_timezone == "-9"} SELECTED{/if}>Alaska (US & Canada)</option>
                                <option value='-10'{if $user->user_info.user_timezone == "-10"} SELECTED{/if}>Hawaii (US)</option>
                                <option value='-11'{if $user->user_info.user_timezone == "-11"} SELECTED{/if}>Midway Island, Samoa</option>
                                <option value='-12'{if $user->user_info.user_timezone == "-12"} SELECTED{/if}>Eniwetok, Kwajalein</option>
                                <option value='-3.3'{if $user->user_info.user_timezone == "-3.3"} SELECTED{/if}>Newfoundland</option>
                                <option value='-3'{if $user->user_info.user_timezone == "-3"} SELECTED{/if}>Brasilia, Buenos Aires, Georgetown</option>
                                <option value='-2'{if $user->user_info.user_timezone == "-2"} SELECTED{/if}>Mid-Atlantic</option>
                                <option value='-1'{if $user->user_info.user_timezone == "-1"} SELECTED{/if}>Azores, Cape Verde Is.</option>
                                <option value='0'{if $user->user_info.user_timezone == "0"} SELECTED{/if}>Greenwich Mean Time (Lisbon, London)</option>
                                <option value='1'{if $user->user_info.user_timezone == "1"} SELECTED{/if}>Amsterdam, Berlin, Paris, Rome, Madrid</option>
                                <option value='2'{if $user->user_info.user_timezone == "2"} SELECTED{/if}>Athens, Helsinki, Istanbul, Cairo, E. Europe</option>
                                <option value='3'{if $user->user_info.user_timezone == "3"} SELECTED{/if}>Baghdad, Kuwait, Nairobi, Moscow</option>
                                <option value='3.3'{if $user->user_info.user_timezone == "3.3"} SELECTED{/if}>Tehran</option>
                                <option value='4'{if $user->user_info.user_timezone == "4"} SELECTED{/if}>Abu Dhabi, Kazan, Muscat</option>
                                <option value='4.3'{if $user->user_info.user_timezone == "4.3"} SELECTED{/if}>Kabul</option>
                                <option value='5'{if $user->user_info.user_timezone == "5"} SELECTED{/if}>Islamabad, Karachi, Tashkent</option>
                                <option value='5.5'{if $user->user_info.user_timezone == "5.5"} SELECTED{/if}>Bombay, Calcutta, New Delhi</option>
                                <option value='6'{if $user->user_info.user_timezone == "6"} SELECTED{/if}>Almaty, Dhaka</option>
                                <option value='7'{if $user->user_info.user_timezone == "7"} SELECTED{/if}>Bangkok, Jakarta, Hanoi</option>
                                <option value='8'{if $user->user_info.user_timezone == "8"} SELECTED{/if}>Beijing, Hong Kong, Singapore, Taipei</option>
                                <option value='9'{if $user->user_info.user_timezone == "9"} SELECTED{/if}>Tokyo, Osaka, Sapporto, Seoul, Yakutsk</option>
                                <option value='9.3'{if $user->user_info.user_timezone == "9.3"} SELECTED{/if}>Adelaide, Darwin</option>
                                <option value='10'{if $user->user_info.user_timezone == "10"} SELECTED{/if}>Brisbane, Melbourne, Sydney, Guam</option>
                                <option value='11'{if $user->user_info.user_timezone == "11"} SELECTED{/if}>Magadan, Soloman Is., New Caledonia</option>
                                <option value='12'{if $user->user_info.user_timezone == "12"} SELECTED{/if}>Fiji, Kamchatka, Marshall Is., Wellington</option>
                            </select>
                        </td>
                    </tr>

                    {* SHOW LANG SETTING *}
                    {if $setting.setting_lang_allow == 1}
                    <tr>
                        <td class='form1'>{$Application379}</td>
                        <td class='form2'>
                            <select name='user_lang'>
                                {section name=lang_loop loop=$lang_options}
                                <option value='{$lang_options[lang_loop]}'{if $user->user_info.user_lang == $lang_options[lang_loop]|lower} selected='selected'{/if}>{$lang_options[lang_loop]}</option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                    {/if}

                    {* SHOW ACTION PRIVACY SETTING *}
                    {if $setting.setting_actions_privacy == 1}
                    <tr>
                        <td class='form1' colspan="2" style="padding-top:12px; padding-bottom:10px;">{$Application381}</td>
                    </tr>
                    <tr>
                        <td class='form1' valign="top">{$Application380}</td>
                        <td class='form_check' valign="top">
                            
                            <table cellpadding='0' cellspacing='0' style="width:300px;"  style="color:#666666;">
                                {section name=actiontypes_loop loop=$actiontypes}
                                {if $actiontypes[actiontypes_loop].actiontype_desc != ""}
                                <tr  style="color:#666666;">
                                    <td colspan="2" style="width:300px;"  style="color:#666666;">
                                        <input style="width:15px !important; height:15px !important;" type='checkbox' name='actiontype_id_{$actiontypes[actiontypes_loop].actiontype_id}' id='actiontype_id_{$actiontypes[actiontypes_loop].actiontype_id}' value='{$actiontypes[actiontypes_loop].actiontype_id}'{if $actiontypes[actiontypes_loop].actiontype_selected == 1} checked='checked'{/if}>
                                        {$actiontypes[actiontypes_loop].actiontype_desc}
                                    </td>
                                    
                                </tr>
                                {else}
                                <input type='hidden' name='actiontype_id_{$actiontypes[actiontypes_loop].actiontype_id}' value='{$actiontypes[actiontypes_loop].actiontype_id}'>
                                {/if}
                                {/section}
                            </table>
                            <input type='hidden' name='actiontypes_max_id' value='{$actiontypes_max_id}'>
                        </td>
                    </tr>
                    {/if}

                    {* SHOW BLOCKLIST *}
                    {if $user->level_info.level_profile_block != 0}
                    <tr>
                        <td class='form1' valign="top">{$Application396}</td>
                        <td>
                            <table cellpadding='0' cellspacing='0'>
                                {* SHOW CURRENT BLOCKED USERS *}
                                {section name=blocked_loop loop=$blocked_users}
                                <tr>
                                    <td style="padding-top:4px !important;">
                                        <input type='text' class='text' name='blocked{$smarty.section.blocked_loop.index}' size='25' maxlength='50' value='{$blocked_users[blocked_loop]}'>
                                        {if $smarty.section.blocked_loop.first}<img src='./images/icons/tip.gif' border='0' class='icon' onMouseover="tip('{$Application397}')"; onMouseout="hidetip()">{/if}
                                     </td>
                                </tr>
                                {/section}
                                {if $smarty.section.blocked_loop.total == 0}
                                <tr>
                                    <td>
                                        <input type='text' class='text' name='blocked0' size='25' maxlength='50' value=''>
                                        <img src='./images/icons/tip.gif' border='0' class='icon' onMouseover="tip('{$Application397}')"; onMouseout="hidetip()">
                                    </td>
                                </tr>
                                {/if}
                                <tr>
                                    <td style="padding-top:4px !important;"><p id='newblock'></p></td>
                                </tr>
                                <tr>
                                    <td style="padding-top:4px !important;"><a href="javascript:addInput('newblock')">{$Application398}</a></td>
                                </tr>
                            </table>
                            <input type='hidden' name='num_blocked' value='{$num_blocked}'>
                        </td>
                    </tr>
                    {/if}
                    
                </table>

                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}

                <div class="submits">
                    <label><input type="submit" value="{$Application399}"/></label>
                    <label><input type="button" onclick="location.href='{$redirect_page}'" value="Cancel"/></label>
                </div>

                <input type='hidden' name='task' value='dosave'/>
            </form>
        </div>
    </div>
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>

{include file='Footer.tpl'}