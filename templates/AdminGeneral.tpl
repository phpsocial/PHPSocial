{include file='AdminHeader.tpl'}

<h2>{$Admin379}</h2>
<p>{$Admin380}</p>

{if $result != 0}
<p style="color:green;">{$Admin386}</p>
{/if}

<form action='AdminGeneral.php' method='POST'>
    <div class="row"></div>

    <div class="row">
        <h2>{$Admin387}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin289}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='setting_permission_profile' id='permission_profile_1' value='1'{if $permission_profile == 1} CHECKED{/if}><label for='permission_profile_1'>{$Admin390}</label></p>
                <p><input type='radio' name='setting_permission_profile' id='permission_profile_0' value='0'{if $permission_profile == 0} CHECKED{/if}><label for='permission_profile_0'>{$Admin391}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>

        <div class="block">
            <div class="block-head"><h3>{$Admin392}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='setting_permission_invite' id='permission_invite_1' value='1'{if $permission_invite == 1} CHECKED{/if}><label for='permission_invite_1'>{$Admin393}</label></p>
                <p><input type='radio' name='setting_permission_invite' id='permission_invite_0' value='0'{if $permission_invite == 0} CHECKED{/if}><label for='permission_invite_0'>{$Admin394}</label></p>
                <br/>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>

        <div class="block" style="margin-top:20px !important;">
            <div class="block-head"><h3>{$Admin395}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='setting_permission_search' id='permission_search_1' value='1'{if $permission_search == 1} CHECKED{/if}><label for='permission_search_1'>{$Admin396}</label></p>
                <p><input type='radio' name='setting_permission_search' id='permission_search_0' value='0'{if $permission_search == 0} CHECKED{/if}><label for='permission_search_0'>{$Admin397}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>

        <div class="block" style="margin-top:20px !important;">
            <div class="block-head"><h3>{$Admin398}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='setting_permission_portal' id='permission_portal_1' value='1'{if $permission_portal == 1} CHECKED{/if}><label for='permission_portal_1'>{$Admin399}</label></p>
                <p><input type='radio' name='setting_permission_portal' id='permission_portal_0' value='0'{if $permission_portal == 0} CHECKED{/if}><label for='permission_portal_0'>{$Admin400}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>

        <p>{$Admin388}</p>
    </div>

    <br>

    <div class="row">
        <h2>Default Language</h2>
        <div class="block">
            <div class="block-head"><h3>Default Language</h3></div>
            <div class="block-in">
                <p>
                    <label>
                        <select name='setting_lang_default' class='text'>
                            {section name=lang_loop loop=$lang_options}
                            <option value='{$lang_options[lang_loop]}'{if $lang_value == $lang_options[lang_loop]|lower} SELECTED{/if}>{$lang_options[lang_loop]}</option>
                            {/section}
                        </select>
                    </label>
                </p>
                <br/>
                <p><input type='radio' name='setting_lang_allow' id='lang_allow_1' value='1'{if $lang_allow == 1} checked='checked'{/if}><label for='lang_allow_1'>{$Admin404}</label></p>
                <p><input type='radio' name='setting_lang_allow' id='lang_allow_0' value='0'{if $lang_allow == 0} checked='checked'{/if}><label for='lang_allow_0'>{$Admin405}</label></p>

            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin402}</p>
        <p>{$Admin403}</p>
    </div>

    <div class="row">
        <h2>Timezone</h2>
        <div class="block">
            <div class="block-head"><h3>Timezone</h3></div>
            <div class="block-in">
                <p>
                    <label>
                        <select name='setting_timezone' class='text' style="width:226px !important;">
                            <option value='-8'{if $timezone_value == "-8"} SELECTED{/if}>Pacific Time (US & Canada)</option>
                            <option value='-7'{if $timezone_value == "-7"} SELECTED{/if}>Mountain Time (US & Canada)</option>
                            <option value='-6'{if $timezone_value == "-6"} SELECTED{/if}>Central Time (US & Canada)</option>
                            <option value='-5'{if $timezone_value == "-5"} SELECTED{/if}>Eastern Time (US & Canada)</option>
                            <option value='-4'{if $timezone_value == "-4"} SELECTED{/if}>Atlantic Time (Canada)</option>
                            <option value='-9'{if $timezone_value == "-9"} SELECTED{/if}>Alaska (US & Canada)</option>
                            <option value='-10'{if $timezone_value == "-10"} SELECTED{/if}>Hawaii (US)</option>
                            <option value='-11'{if $timezone_value == "-11"} SELECTED{/if}>Midway Island, Samoa</option>
                            <option value='-12'{if $timezone_value == "-12"} SELECTED{/if}>Eniwetok, Kwajalein</option>
                            <option value='-3.3'{if $timezone_value == "-3.3"} SELECTED{/if}>Newfoundland</option>
                            <option value='-3'{if $timezone_value == "-3"} SELECTED{/if}>Brasilia, Buenos Aires, Georgetown</option>
                            <option value='-2'{if $timezone_value == "-2"} SELECTED{/if}>Mid-Atlantic</option>
                            <option value='-1'{if $timezone_value == "-1"} SELECTED{/if}>Azores, Cape Verde Is.</option>
                            <option value='0'{if $timezone_value == "0"} SELECTED{/if}>Greenwich Mean Time (Lisbon, London)</option>
                            <option value='1'{if $timezone_value == "1"} SELECTED{/if}>Amsterdam, Berlin, Paris, Rome, Madrid</option>
                            <option value='2'{if $timezone_value == "2"} SELECTED{/if}>Athens, Helsinki, Istanbul, Cairo, E. Europe</option>
                            <option value='3'{if $timezone_value == "3"} SELECTED{/if}>Baghdad, Kuwait, Nairobi, Moscow</option>
                            <option value='3.3'{if $timezone_value == "3.3"} SELECTED{/if}>Tehran</option>
                            <option value='4'{if $timezone_value == "4"} SELECTED{/if}>Abu Dhabi, Kazan, Muscat</option>
                            <option value='4.3'{if $timezone_value == "4.3"} SELECTED{/if}>Kabul</option>
                            <option value='5'{if $timezone_value == "5"} SELECTED{/if}>Islamabad, Karachi, Tashkent</option>
                            <option value='5.5'{if $timezone_value == "5.5"} SELECTED{/if}>Bombay, Calcutta, New Delhi</option>
                            <option value='6'{if $timezone_value == "6"} SELECTED{/if}>Almaty, Dhaka</option>
                            <option value='7'{if $timezone_value == "7"} SELECTED{/if}>Bangkok, Jakarta, Hanoi</option>
                            <option value='8'{if $timezone_value == "8"} SELECTED{/if}>Beijing, Hong Kong, Singapore, Taipei</option>
                            <option value='9'{if $timezone_value == "9"} SELECTED{/if}>Tokyo, Osaka, Sapporto, Seoul, Yakutsk</option>
                            <option value='9.3'{if $timezone_value == "9.3"} SELECTED{/if}>Adelaide, Darwin</option>
                            <option value='10'{if $timezone_value == "10"} SELECTED{/if}>Brisbane, Melbourne, Sydney, Guam</option>
                            <option value='11'{if $timezone_value == "11"} SELECTED{/if}>Magadan, Soloman Is., New Caledonia</option>
                            <option value='12'{if $timezone_value == "12"} SELECTED{/if}>Fiji, Kamchatka, Marshall Is., Wellington</option>
                        </select>
                    </label>
                </p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin382}</p>
    </div>

    <div class="row">
        <h2>Date Format</h2>
        <div class="block">
            <div class="block-head"><h3>Date Format</h3></div>
            <div class="block-in">
                <p>
                    <label>
                        <select name='setting_dateformat' class='text'>
                            <option value='n/j/Y'{if $dateformat_value == "n/j/Y"} SELECTED{/if}>7/17/2006</option>
                            <option value='n.j.Y'{if $dateformat_value == "n.j.Y"} SELECTED{/if}>7.17.2006</option>
                            <option value='n-j-Y'{if $dateformat_value == "n-j-Y"} SELECTED{/if}>7-17-2006</option>
                            <option value='Y/n/j'{if $dateformat_value == "Y/n/j"} SELECTED{/if}>2006/7/17</option>
                            <option value='Y-n-j'{if $dateformat_value == "Y-n-j"} SELECTED{/if}>2006-7-17</option>
                            <option value='Y-m-d'{if $dateformat_value == "Y-m-d"} SELECTED{/if}>2006-07-17</option>
                            <option value='Ynj'{if $dateformat_value == "Ynj"} SELECTED{/if}>2006717</option>
                            <option value='j/n/Y'{if $dateformat_value == "j/n/Y"} SELECTED{/if}>17/7/2006</option>
                            <option value='j.n.Y'{if $dateformat_value == "j.n.Y"} SELECTED{/if}>17.7.2006</option>
                            <option value='M. j, Y'{if $dateformat_value == "M. j, Y"} SELECTED{/if}>Jul. 17, 2006</option>
                            <option value='F j, Y'{if $dateformat_value == "F j, Y"} SELECTED{/if}>July 17, 2006</option>
                            <option value='j F Y'{if $dateformat_value == "j F Y"} SELECTED{/if}>17 July 2006</option>
                            <option value='l, F j, Y'{if $dateformat_value == "l, F j, Y"} SELECTED{/if}>Monday, July 17, 2006</option>
                            <option value='D-j-M-Y'{if $dateformat_value == "D-j-M-Y"} SELECTED{/if}>Mon-17-Jul-2006</option>
                            <option value='D j M Y'{if $dateformat_value == "D j M Y"} SELECTED{/if}>Mon 17 Jul 2006</option>
                            <option value='D j F Y'{if $dateformat_value == "D j F Y"} SELECTED{/if}>Mon 17 July 2006</option>
                            <option value='l j F Y'{if $dateformat_value == "l j F Y"} SELECTED{/if}>Monday 17 July 2006</option>
                            <option value='Y-M-j'{if $dateformat_value == "Y-M-j"} SELECTED{/if}>2006-Jul-17</option>
                            <option value='j-M-Y'{if $dateformat_value == "j-M-Y"} SELECTED{/if}>17-Jul-2006</option>
                        </select>
                    </label>
                    <label>
                        <select name='setting_timeformat' class='text'>
                            <option value='g:i A'{if $timeformat_value == "g:i A"} SELECTED{/if}>9:30 PM</option>
                            <option value='h:i A'{if $timeformat_value == "h:i A"} SELECTED{/if}>09:30 PM</option>
                            <option value='g:i'{if $timeformat_value == "g:i"} SELECTED{/if}>9:30</option>
                            <option value='h:i'{if $timeformat_value == "h:i"} SELECTED{/if}>09:30</option>
                            <option value='H:i'{if $timeformat_value == "H:i"} SELECTED{/if}>21:30</option>
                            <option value='H\hi'{if $timeformat_value == "H\hi"} SELECTED{/if}>21h30</option>
                        </select>
                    </label>
                </p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin384}</p>
    </div>

    <div class="row">
        <h2>{$Admin1027}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin1027}</h3></div>
            <div class="block-in">
                <!-- p><input type="checkbox" value="Member Login" name="homepageBlocks[]" {if (in_array('Member Login', $homepageBlocks))}checked="checked"{/if}/><label> Member Login</label></p -->
                <p><input type="checkbox" value="Network statistic" name="homepageBlocks[]" {if in_array('Network statistic', $homepageBlocks)}checked="checked"{/if}/><label> Network statistic</label></p>
                <p><input type="checkbox" value="Newest members" name="homepageBlocks[]" {if in_array('Newest members', $homepageBlocks)}checked="checked"{/if}/><label> Newest members</label></p>
                <p><input type="checkbox" value="Most popular members" name="homepageBlocks[]" {if in_array('Most popular members', $homepageBlocks)}checked="checked"{/if}/><label> Most popular members</label></p>
                <p><input type="checkbox" value="Members last logged in" name="homepageBlocks[]" {if in_array('Members last logged in', $homepageBlocks)}checked="checked"{/if}/><label> Members last logged in</label></p>
                <p><input type="checkbox" value="Members online" name="homepageBlocks[]" {if in_array('Members online', $homepageBlocks)}checked="checked"{/if}/><label> Members online</label></p>
                <p><input type="checkbox" value="Recent news" name="homepageBlocks[]" {if in_array('Recent news', $homepageBlocks)}checked="checked"{/if}/><label> Recent news</label></p>
                <p><input type="checkbox" value="Hello message" name="homepageBlocks[]" {if in_array('Hello message', $homepageBlocks)}checked="checked"{/if}/><label> Hello message</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin1028}</p>
    </div>


    <div class="row" style="border-bottom:none; margin-bottom:0px;">
        <h2>News Page</h2>
        <div class="block">
            <div class="block-head"><h3>News Page</h3></div>
            <div class="block-in">
                <p><input type="checkbox" value="1" name="newsPage"{if $newsPage} checked="checked"{/if}/><label> News page is visible to unregistered users</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
    </div>


    <div style="padding-left:20px;"><label class="button"><input type='submit' value='{$Admin385}'/></label></div>
    <input type='hidden' name='task' value='dosave'>
</form>

{include file='AdminFooter.tpl'}