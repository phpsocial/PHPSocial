{include file='Header.tpl'}

<div id="content">


    {if $step == 4}
    {* SHOW COMPLETION PAGE *}
    <div class="grey-head"><h2>{$Application326}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application327}</p>
    </div>

    <div id="primary" class="info-cnt tuneddivs">
        <br/>
        {if $setting.setting_signup_enable == 0}<p style="padding-left:25px;">{$Application328}</p>{/if}
        {if $setting.setting_signup_randpass == 1}<p style="padding-left:25px;">{$Application329}</p>{/if}
        {if $setting.setting_signup_verify == 0}<p style="padding-left:25px;">{$Application330}</p>{else}<p style="padding-left:25px;">{$Application331}</p>{/if}

        {if $setting.setting_signup_verify == 0 AND $setting.setting_signup_enable != 0 AND $setting.setting_signup_randpass == 0}
        <form action='Login.php' method='get' class="settings" style="color:#666666; margin-top:0px !important;">

           <p class="line">&nbsp;</p>
            <div class="submits" style="margin-left:0px !important;">
                <label><input style="width:100px !important;" type="submit" value="{$Application332}"/></label>
              </div>
           <input type='hidden' name='email' value='{$new_user->user_info.user_email}'/>
        </form>
        {else}
        <form action='Home.php' method='get' class="settings" style="color:#666666; margin-top:0px !important;">
            <p class="line">&nbsp;</p>
            <div class="submits" style="margin-left:0px !important;">
                <label><input style="width:100px !important;" type="submit" value="{$Application333}"/></label>
    
            </div>
        </form>
        {/if}
    </div>


    {* SHOW STEP FOUR *}
    {elseif $step == 3}

    <div class="grey-head"><h2>{$Application334}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application335}</p>
    </div>

    <div id="primary" class="info-cnt tuneddivs">
        <form action='Signup.php' method='post' class="settings" style="color:#666666;" name="invite">

            <div><b>{$Application336}</b></div>
            <div class='form_desc'>{$Application337}</div>
            <textarea style="border:1px solid #CBD0D2; width:600px;"  name='invite_emails' rows='2' cols='60'></textarea>
            <br/><br/>

            <div><b>{$Application338}</b></div>
            <div class='form_desc'>{$Application339}</div>
            <textarea style="border:1px solid #CBD0D2; width:600px;"  name='invite_message' rows='5' cols='60'></textarea>
            <br/><br/>

            <p class="line">&nbsp;</p>


            <div class="submits">
                <a class="button" href="javascript:void(0);" onclick="document.invite.submit();" style="margin-top:0px !important;"><span>{$Application340}</span></a>
                <a class="button" href="Signup.php?task={$next_task}&amp;step={$step}" style="margin-top:0px !important;"><span>{$Application341}</span></a>
            </div>

            <input type='hidden' name='task' value='{$next_task}'/>
        </form>
    </div>
    <div class="block-bot"><span></span></div>


    {* SHOW STEP THREE *}
    {elseif $step == 2}

    <div class="grey-head"><h2>{$Application342}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application343}</p>
    </div>

    <div id="primary" class="">
        {* SHOW ERROR MESSAGE *}
        {if $error_message != ""}
        <p style="color:red; padding-left:25px;">{$error_message}</p>
        {/if}

        <form action='Signup.php' class="settings" method='post' enctype='multipart/form-data'>
            <div class="row" style="border:none;">
                {* SHOW USER PHOTO IF ONE HAS BEEN UPLOADED, OTHERWISE SHOW SKIP BUTTON *}
                {if $new_user->user_photo() != ""}
                <a href="#" class="f-left"><img class="img" alt="" width="92px" src="{$new_user->user_photo()}"/></a>
                {/if}
                <dl style="width:375px !important;">
                    <dt><b>{$Application452}</b></dt>
                    <dd><input type='file' style="height:25px !important; border:1px solid #CBD0D2; height:20px; margin:0 10px 0 0;" name='photo' size='35'/></dd>
                    <br/>
                    <p style="color:#666666; padding-top:10px;">{$Application345} {$new_user->level_info.level_photo_exts}.</p>
                </dl>
            </div>

            <p class="line">&nbsp;</p>
            <div class="submits">
                <label><input style="width:92px !important;" type="submit" value="{$Application344}"/></label>
                {if $new_user->user_photo() != ""}
                <a class="button" href="Signup.php?task={$last_task}" style="margin-top:0px !important;"><span>{$Application346}</span></a>
                {else}
                <a class="button" href="Signup.php?task={$last_task}" style="margin-top:0px !important;"><span>{$Application340}</span></a>
                {/if}

            </div>

            <input type='hidden' name='step' value='{$step}'/>
            <input type='hidden' name='task' value='{$next_task}'/>
            <input type='hidden' name='MAX_FILE_SIZE' value='5000000'/>
        </form>
    </div>

    <div class="block-bot"><span></span></div>



    {* SHOW STEP ONE *}
    {else}
    <div class="grey-head"><h2>{$Application349}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application350}</p>
    </div>
    <div class="layers">
        <div id="primary" class="info-cnt tuneddivs">
            {* SHOW ERROR MESSAGE *}
            {if $error_message != ""}
            <p style="padding-left:25px; color:red;"> {$error_message}</p>
            <br/>
            {/if}

            <form action='Signup.php' method='post' class="settings" style="color:#666666; margin-top:0px !important;">
                <div class='signup_header'><b>{$Application351}</b></div>
                <table cellpadding='0' cellspacing='4' style="color:#666666;">
                    <tr>
                        <td class='form1' width='100' valign="top">{$Application352}</td>
                        <td class='form2'>
                            <input name='signup_email' type='text' class='text' maxlength='70' size='40' value='{$signup_email}' />
                            <div class='form_desc'>{$Application353}</div>
                        </td>
                    </tr>
                    {if $setting.setting_signup_randpass == 0}
                    <tr>
                        <td class='form1' valign="top">{$Application354}</td>
                        <td class='form2'>
                            <input name='signup_password' type='password' class='text' maxlength='50' size='40' value='{$signup_password}' />
                            <div class='form_desc'>{$Application355}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class='form1' valign="top">{$Application356}</td>
                        <td class='form2'>
                            <input name='signup_password2' type='password' class='text' maxlength='50' size='40' value='{$signup_password2}' />
                            <div class='form_desc'>{$Application357}</div>
                        </td>
                    </tr>
                    {else}
                    <input type='hidden' name='signup_password' value='' />
                    <input type='hidden' name='signup_password2' value='' />
                    {/if}
                </table>
                <br />
                <div class='signup_header'><b>{$Application358}</b></div>
                <table cellpadding='0' cellspacing='4' style="color:#666666;">
                    <tr>
                        <td class='form1' valign="top">{$Application359}</td>
                        <td class='form2'>
                            <input name='signup_username' type='text' class='text' maxlength='50' size='40' value='{$signup_username}' />
                           <!-- <img src='./images/icons/tip.gif' border='0' class='icon' onMouseover="tip('{$Application360}')"; onMouseout="hidetip()">-->
                                 <div class='form_desc'>{$Application361}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class='form1' width='100' valign="top">{$Application362}</td>
                        <td class='form2'>
                            <select name='signup_timezone'>
                                <option value='-8'{if $signup_timezone == "-8"} SELECTED{/if}>Pacific Time (US &amp; Canada)</option>
                                <option value='-7'{if $signup_timezone == "-7"} SELECTED{/if}>Mountain Time (US &amp; Canada)</option>
                                <option value='-6'{if $signup_timezone == "-6"} SELECTED{/if}>Central Time (US &amp; Canada)</option>
                                <option value='-5'{if $signup_timezone == "-5"} SELECTED{/if}>Eastern Time (US &amp; Canada)</option>
                                <option value='-4'{if $signup_timezone == "-4"} SELECTED{/if}>Atlantic Time (Canada)</option>
                                <option value='-9'{if $signup_timezone == "-9"} SELECTED{/if}>Alaska (US &amp; Canada)</option>
                                <option value='-10'{if $signup_timezone == "-10"} SELECTED{/if}>Hawaii (US)</option>
                                <option value='-11'{if $signup_timezone == "-11"} SELECTED{/if}>Midway Island, Samoa</option>
                                <option value='-12'{if $signup_timezone == "-12"} SELECTED{/if}>Eniwetok, Kwajalein</option>
                                <option value='-3.3'{if $signup_timezone == "-3.3"} SELECTED{/if}>Newfoundland</option>
                                <option value='-3'{if $signup_timezone == "-3"} SELECTED{/if}>Brasilia, Buenos Aires, Georgetown</option>
                                <option value='-2'{if $signup_timezone == "-2"} SELECTED{/if}>Mid-Atlantic</option>
                                <option value='-1'{if $signup_timezone == "-1"} SELECTED{/if}>Azores, Cape Verde Is.</option>
                                <option value='0'{if $signup_timezone == "0"} SELECTED{/if}>Greenwich Mean Time (Lisbon, London)</option>
                                <option value='1'{if $signup_timezone == "1"} SELECTED{/if}>Amsterdam, Berlin, Paris, Rome, Madrid</option>
                                <option value='2'{if $signup_timezone == "2"} SELECTED{/if}>Athens, Helsinki, Istanbul, Cairo, E. Europe</option>
                                <option value='3'{if $signup_timezone == "3"} SELECTED{/if}>Baghdad, Kuwait, Nairobi, Moscow</option>
                                <option value='3.3'{if $signup_timezone == "3.3"} SELECTED{/if}>Tehran</option>
                                <option value='4'{if $signup_timezone == "4"} SELECTED{/if}>Abu Dhabi, Kazan, Muscat</option>
                                <option value='4.3'{if $signup_timezone == "4.3"} SELECTED{/if}>Kabul</option>
                                <option value='5'{if $signup_timezone == "5"} SELECTED{/if}>Islamabad, Karachi, Tashkent</option>
                                <option value='5.5'{if $signup_timezone == "5.5"} SELECTED{/if}>Bombay, Calcutta, New Delhi</option>
                                <option value='6'{if $signup_timezone == "6"} SELECTED{/if}>Almaty, Dhaka</option>
                                <option value='7'{if $signup_timezone == "7"} SELECTED{/if}>Bangkok, Jakarta, Hanoi</option>
                                <option value='8'{if $signup_timezone == "8"} SELECTED{/if}>Beijing, Hong Kong, Singapore, Taipei</option>
                                <option value='9'{if $signup_timezone == "9"} SELECTED{/if}>Tokyo, Osaka, Sapporto, Seoul, Yakutsk</option>
                                <option value='9.3'{if $signup_timezone == "9.3"} SELECTED{/if}>Adelaide, Darwin</option>
                                <option value='10'{if $signup_timezone == "10"} SELECTED{/if}>Brisbane, Melbourne, Sydney, Guam</option>
                                <option value='11'{if $signup_timezone == "11"} SELECTED{/if}>Magadan, Soloman Is., New Caledonia</option>
                                <option value='12'{if $signup_timezone == "12"} SELECTED{/if}>Fiji, Kamchatka, Marshall Is., Wellington</option>
                            </select>
                        </td>
                    </tr>
                    {if $setting.setting_signup_phone == 1}
                    <tr>
                        <td class='form1' valign="top">{$Application739}:</td>
                        <td class='form2'>
                            <input name='signup_phone' type='text' class='text' maxlength='50' size='40' value='{$signup_phone}' />
                        </td>
                    </tr>
                    {/if}
                    {if $setting.setting_lang_allow == 1}
                    <tr>
                        <td class='form1' valign="top">{$Application322}</td>
                        <td class='form2'>
                            <select name='signup_lang'>
                                {section name=lang_loop loop=$lang_options}
                                <option value='{$lang_options[lang_loop]}'{if $setting.setting_lang_default|lower == $lang_options[lang_loop]|lower} selected='selected'{/if}>{$lang_options[lang_loop]}</option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                    {/if}
                </table><br/>
                {if !$setting.setting_signup_phone == 1}
                <input name='signup_phone' type='hidden' value='' />
                {/if}
                {* LOOP THROUGH TABS *}
                {section name=tab_loop loop=$tabs}
                <div class='signup_header'><b>{$tabs[tab_loop].tab_name}</b></div>
                <table cellpadding='0' cellspacing='4' style="color:#666666;">
                    {* LOOP THROUGH FIELDS IN TAB *}
                    {section name=field_loop loop=$tabs[tab_loop].fields}
                    <tr>
                        <td class='form1' width='100' valign="top">{$tabs[tab_loop].fields[field_loop].field_title}{if $tabs[tab_loop].fields[field_loop].field_required != 0}*{/if}</td>
                        <td class='form2'>
                            {if $tabs[tab_loop].fields[field_loop].field_type == 1}
                            {* TEXT FIELD *}
                            <div><input type='text' class='text' name='field_{$tabs[tab_loop].fields[field_loop].field_id}' value='{$tabs[tab_loop].fields[field_loop].field_value}' style='{$tabs[tab_loop].fields[field_loop].field_style}' maxlength='{$tabs[tab_loop].fields[field_loop].field_maxlength}' /></div>
                            <div class='form_desc'>{$tabs[tab_loop].fields[field_loop].field_desc}</div>
                            {elseif $tabs[tab_loop].fields[field_loop].field_type == 2}
                            {* TEXTAREA *}
                            <div><textarea rows='6' cols='50' name='field_{$tabs[tab_loop].fields[field_loop].field_id}' style='{$tabs[tab_loop].fields[field_loop].field_style}'>{$tabs[tab_loop].fields[field_loop].field_value}</textarea></div>
                            <div class='form_desc'>{$tabs[tab_loop].fields[field_loop].field_desc}</div>
                            {* SELECT BOX *}
                            {elseif $tabs[tab_loop].fields[field_loop].field_type == 3}
                            <div>
                                <select name="field_{$tabs[tab_loop].fields[field_loop].field_id}" id="field_{$tabs[tab_loop].fields[field_loop].field_id}" onchange="ShowHideSelectDeps({$tabs[tab_loop].fields[field_loop].field_id})" style="width:75px !important;">
                                    <option value='-1'>&nbsp;</option>
                                    {* LOOP THROUGH FIELD OPTIONS *}
                                    {section name=option_loop loop=$tabs[tab_loop].fields[field_loop].field_options}
                                    <option id='op{$tabs[tab_loop].fields[field_loop].field_id}_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' value='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}'{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id == $tabs[tab_loop].fields[field_loop].field_value} SELECTED{/if}>{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_label}</option>
                                    {/section}
                                </select>
                            </div>
                            {* LOOP THROUGH DEPENDENT FIELDS *}
                            {section name=option_loop loop=$tabs[tab_loop].fields[field_loop].field_options}
                            {if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_dependency == 1}
                            <div id='field_{$tabs[tab_loop].fields[field_loop].field_id}_option{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' style='margin: 5px 5px 10px 5px;{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id != $tabs[tab_loop].fields[field_loop].field_value} display: none;{/if}'>
                                {$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_title}{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_required != 0}*{/if}
                                <input type='text' class='text' name='field_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_id}' value='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_value}' style='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_style}' maxlength='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_maxlength}' />
                            </div>
                            {else}
                            <div id='field_{$tabs[tab_loop].fields[field_loop].field_id}_option{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' style='display: none;'></div>
                            {/if}
                            {/section}
                            <div class='form_desc'>{$tabs[tab_loop].fields[field_loop].field_desc}</div>
                            {* RADIO BUTTONS *}
                            {elseif $tabs[tab_loop].fields[field_loop].field_type == 4}
                            {* LOOP THROUGH FIELD OPTIONS *}
                            {section name=option_loop loop=$tabs[tab_loop].fields[field_loop].field_options}
                            <div style="clear:both; margin-left: 100px">
                                <input type='radio' class='radio' onclick="ShowHideRadioDeps({$tabs[tab_loop].fields[field_loop].field_id}, {$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}, 'field_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_id}', {$tabs[tab_loop].fields[field_loop].field_options|@count})" style='width: 15px !important; {$tabs[tab_loop].fields[field_loop].field_style}' name='field_{$tabs[tab_loop].fields[field_loop].field_id}' id='label_{$tabs[tab_loop].fields[field_loop].field_id}_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' value='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}'{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id == $tabs[tab_loop].fields[field_loop].field_value} CHECKED{/if} />
                                       <label style="clear: none" for='label_{$tabs[tab_loop].fields[field_loop].field_id}_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}'>{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_label}</label>
                                {* DISPLAY DEPENDENT FIELDS *}
                                {if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_dependency == 1}
                                <div id='field_{$tabs[tab_loop].fields[field_loop].field_id}_radio{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' style='margin: 0px 5px 10px 23px;{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id != $tabs[tab_loop].fields[field_loop].field_value} display: none;{/if}'>
                                    {$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_title}
                                    {if $tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_required != 0}*{/if}
                                    <input type='text' class='text' name='field_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_id}' id='field_{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_id}' value='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_value}' style='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_style}' maxlength='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].dep_field_maxlength}' />
                                </div>
                                {else}
                                <div id='field_{$tabs[tab_loop].fields[field_loop].field_id}_radio{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}' style='display: none;'></div>
                                {/if}

                            </div>
                            {/section}
                            <div class='form_desc'>{$tabs[tab_loop].fields[field_loop].field_desc}</div>
                            {elseif $tabs[tab_loop].fields[field_loop].field_type == 5}
                            {* DATE FIELD *}
                            <div>
                                <select name='field_{$tabs[tab_loop].fields[field_loop].field_id}_1' style="width:75px !important; margin-right:2px !important;">
                                    {section name=date1 loop=$tabs[tab_loop].fields[field_loop].date_array1}
                                    <option value='{$tabs[tab_loop].fields[field_loop].date_array1[date1].value}'{$tabs[tab_loop].fields[field_loop].date_array1[date1].selected}>{$tabs[tab_loop].fields[field_loop].date_array1[date1].name}</option>
                                    {/section}
                                </select>
                                <select name='field_{$tabs[tab_loop].fields[field_loop].field_id}_2' style="width:75px !important; margin-right:2px !important;">
                                    {section name=date2 loop=$tabs[tab_loop].fields[field_loop].date_array2}
                                    <option value='{$tabs[tab_loop].fields[field_loop].date_array2[date2].value}'{$tabs[tab_loop].fields[field_loop].date_array2[date2].selected}>{$tabs[tab_loop].fields[field_loop].date_array2[date2].name}</option>
                                    {/section}
                                </select>
                                <select name='field_{$tabs[tab_loop].fields[field_loop].field_id}_3' style="width:75px !important; margin-right:2px !important;">
                                    {section name=date3 loop=$tabs[tab_loop].fields[field_loop].date_array3}
                                    <option value='{$tabs[tab_loop].fields[field_loop].date_array3[date3].value}'{$tabs[tab_loop].fields[field_loop].date_array3[date3].selected}>{$tabs[tab_loop].fields[field_loop].date_array3[date3].name}</option>
                                    {/section}
                                </select>
                            </div>
                            <div class='form_desc'>{$tabs[tab_loop].fields[field_loop].field_desc}</div>
                            {/if}
                            {if $tabs[tab_loop].fields[field_loop].field_error != ""}<div class='form_error'> {$tabs[tab_loop].fields[field_loop].field_error}</div>{/if}
                        </td>
                    </tr>
                    {/section}
                </table>
                <br />
                {/section}


                {if $setting.setting_signup_code == 1 OR $setting.setting_signup_tos == 1 OR $setting.setting_signup_invite != 0}
                <br />
                <div class='signup_header'><b>{$Application363}</b></div>
                <table cellpadding='0' cellspacing='4'  style="color:#666666;">
                    {/if}

                    {if $setting.setting_signup_invite != 0}
                    <tr>
                        <td class='form1' width='100' valign="top">{$Application364}</td>
                        <td class='form2'><input type='text' name='signup_invite' value='{$signup_invite}' class='text' size='10' maxlength='10' style="width:95px !important;"/></td>
                    </tr>
                    {/if}


                    {if $setting.setting_signup_code == 1}
                    <tr>
                        <td class='form1' width='100' valign="top">{$Application365}</td>
                        <td class='form2'>
                            <table cellpadding='0' cellspacing='0'>
                                <tr>
                                    <td><input type='text' name='signup_secure' class='text' size='6' maxlength='10' style="width:95px !important;"/>&nbsp;</td>
                                    <td>
                                        <table cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td><img src='./images/secure.php' border='0' height='20' width='67' class='signup_code'/>&nbsp;&nbsp;</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    {/if}

                    {if $setting.setting_signup_tos == 1}
                    <tr>
                        <td class='form1' width='100' valign="top" align="center"><input style="width:15px !important; height:15px; border:none;" type='checkbox' name='signup_agree' id='tos' value='1'{if $signup_agree == 1} CHECKED{/if}/></td>
                        <td class='form2'><label for='tos' style="width:250px !important;"> {$Application367}</label></td>
                    </tr>
                    {/if}
                </table>
                <p class="line">&nbsp;</p>
                <div class="submits" style="margin-left:20px !important;">
                    <label><input style="width:100px !important;"type="submit" value="{$Application332}"/></label>
                </div>


                <input type='hidden' name='task' value='{$next_task}' />
                <input type='hidden' name='step' value='{$step}' />
            </form>
        </div>
    </div>
    <div class="block-bot"><span>&nbsp;</span></div>
    {/if}

</div>
<div id="sidebar">

</div>
{include file='Footer.tpl'}