{include file='Header.tpl'}
<div id="content">
     {section name=tab_loop loop=$tabs}
          {if $tabs[tab_loop].tab_id == $tab_id}{assign var="pagename" value=$tabs[tab_loop].tab_name}{/if}
     {/section}
    <div class="grey-head"><h2>{$Application423} {$pagename}</h2></div>

 <div class="layers">
        <ul class="list01">
            {section name=tab_loop loop=$tabs}
            <li {if $uri_page==$tabs[tab_loop].tab_id}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='UserEditprofile.php?tab_id={$tabs[tab_loop].tab_id}'>{$tabs[tab_loop].tab_name}</a>
            </li>
            {if $tabs[tab_loop].tab_id == $tab_id}{assign var="pagename" value=$tabs[tab_loop].tab_name}{/if}
            {/section}
            {if $user->level_info.level_profile_status != 0} <li {if $uri_page=='UserEditprofileStatus.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserEditprofileStatus.php'>{$Application419}</a></li>{/if}
            {if $user->level_info.level_photo_allow != 0} <li {if $uri_page=='UserEditprofilePhoto.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserEditprofilePhoto.php'>{$Application420}</a></li>{/if}
            <li {if $uri_page=='UserEditprofileSettings.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserEditprofileSettings.php'>{$Application422}</a></li>
        </ul>
        
        <div id="primary" class="info-cnt tuneddivs">

            <p style="padding-left:25px;">{$Application424}</p>

            {* SHOW RESULT MESSAGE *}
            {if $result != ""}
            <p style="color:green; padding-left:25px;"> {$result}</p>
            {/if}

            {* SHOW ERROR MESSAGE *}
            {if $error_message != ""}
            <p style="color:red; padding-left:25px;">{$error_message}</p>
            {/if}
            
            {if $tab_num_fields == 0}<br/><br/><br/>{/if}
            {if $tab_num_fields != 0}
            <form action='UserEditprofile.php' method='POST' name='profile' class="settings">

                {* LOOP THROUGH FIELDS IN TAB *}
                {section name=field_loop loop=$fields}
                <p>
                    <label>{$fields[field_loop].field_title}{if $fields[field_loop].field_required != 0}*{/if}</label>&nbsp;

                    {* TEXT FIELD *}
                    {if $fields[field_loop].field_type == 1}
                    <input type='text' class='text' name='field_{$fields[field_loop].field_id}' value='{$fields[field_loop].field_value}' style='{$fields[field_loop].field_style}' maxlength='{$fields[field_loop].field_maxlength}'/>

                    {* TEXTAREA *}
                    {elseif $fields[field_loop].field_type == 2}
                    <textarea rows='6' cols='50' name='field_{$fields[field_loop].field_id}' style='{$fields[field_loop].field_style}'>{$fields[field_loop].field_value}</textarea>
                    <div class='form_desc'>{$fields[field_loop].field_desc}</div>

                    {* SELECT BOX *}
                    {elseif $fields[field_loop].field_type == 3}
                    <select name='field_{$fields[field_loop].field_id}' id='field_{$fields[field_loop].field_id}' onchange="ShowHideSelectDeps({$fields[field_loop].field_id})" style='{$fields[field_loop].field_style}'>
                        <option value='-1'></option>
                        {* LOOP THROUGH FIELD OPTIONS *}
                        {section name=option_loop loop=$fields[field_loop].field_options}
                        <option id='op' value='{$fields[field_loop].field_options[option_loop].option_id}'{if $fields[field_loop].field_options[option_loop].option_id == $fields[field_loop].field_value} SELECTED{/if}>{$fields[field_loop].field_options[option_loop].option_label}</option>
                        {/section}
                    </select>

                    {* LOOP THROUGH DEPENDENT FIELDS 
                    {section name=option_loop loop=$fields[field_loop].field_options}
                    {if $fields[field_loop].field_options[option_loop].option_dependency == 1}
                    <div id='field_{$fields[field_loop].field_id}_option{$fields[field_loop].field_options[option_loop].option_id}' style='margin: 5px 5px 10px 5px;{if $fields[field_loop].field_options[option_loop].option_id != $fields[field_loop].field_value} display: none;{/if}'>
                        {$fields[field_loop].field_options[option_loop].dep_field_title}{if $fields[field_loop].field_options[option_loop].dep_field_required != 0}*{/if}
                        <input type='text' class='text' name='field_{$fields[field_loop].field_options[option_loop].dep_field_id}' value='{$fields[field_loop].field_options[option_loop].dep_field_value}' style='{$fields[field_loop].field_options[option_loop].dep_field_style}' maxlength='{$fields[field_loop].field_options[option_loop].dep_field_maxlength}'>
                    </div>
                    {else}
                    <div id='field_{$fields[field_loop].field_id}_option{$fields[field_loop].field_options[option_loop].option_id}' style='display: none;'></div>
                    {/if}
                    {/section}
                    *}

                    {* RADIO BUTTONS *}
                    {elseif $fields[field_loop].field_type == 4}

                    {* LOOP THROUGH FIELD OPTIONS *}
                    <div style="clear:right; float: left;">
                    {section name=option_loop loop=$fields[field_loop].field_options}

                        <div style="clear:both;">
                            <input type='radio' class='radio' style="border: none; width:14px;" onclick="ShowHideRadioDeps({$fields[field_loop].field_id}, {$fields[field_loop].field_options[option_loop].option_id}, 'field_{$fields[field_loop].field_options[option_loop].dep_field_id}', {$fields[field_loop].field_options|@count})" style='{$fields[field_loop].field_style}' name='field_{$fields[field_loop].field_id}' id='label_{$fields[field_loop].field_id}_{$fields[field_loop].field_options[option_loop].option_id}' value='{$fields[field_loop].field_options[option_loop].option_id}'{if $fields[field_loop].field_options[option_loop].option_id == $fields[field_loop].field_value} CHECKED{/if}>
                            <label style="clear: none" for='label_{$fields[field_loop].field_id}_{$fields[field_loop].field_options[option_loop].option_id}'>{$fields[field_loop].field_options[option_loop].option_label}</label>
                        </div>
                        {* DISPLAY DEPENDENT FIELDS 
                        {if $fields[field_loop].field_options[option_loop].option_dependency == 1}
                        <div id='field_{$fields[field_loop].field_id}_radio{$fields[field_loop].field_options[option_loop].option_id}' style='margin: 0px 5px 10px 23px;{if $fields[field_loop].field_options[option_loop].option_id != $fields[field_loop].field_value} display: none;{/if}'>
                            {$fields[field_loop].field_options[option_loop].dep_field_title}
                            {if $fields[field_loop].field_options[option_loop].dep_field_required != 0}*{/if}
                            <input type='text' class='text' name='field_{$fields[field_loop].field_options[option_loop].dep_field_id}' id='field_{$fields[field_loop].field_options[option_loop].dep_field_id}' value='{$fields[field_loop].field_options[option_loop].dep_field_value}' style='{$fields[field_loop].field_options[option_loop].dep_field_style}' maxlength='{$fields[field_loop].field_options[option_loop].dep_field_maxlength}'>
                        </div>
                        {else}
                        <div id='field_{$fields[field_loop].field_id}_radio{$fields[field_loop].field_options[option_loop].option_id}' style='display: none;'></div>
                        {/if}
                        *}
                    {/section}
                    </div>


                    {* DATE FIELD *}
                    {elseif $fields[field_loop].field_type == 5}

                    <select name='field_{$fields[field_loop].field_id}_1' style='border:1px solid #CBD0D2; height:20px; margin:0 10px 0 0; width:57px;'>
                        {section name=date1 loop=$fields[field_loop].date_array1}
                        <option value='{$fields[field_loop].date_array1[date1].value}'{$fields[field_loop].date_array1[date1].selected}>{$fields[field_loop].date_array1[date1].name}</option>
                        {/section}
                    </select>

                    <select name='field_{$fields[field_loop].field_id}_2' style='border:1px solid #CBD0D2; height:20px; margin:0 10px 0 0; width:57px;'>
                        {section name=date2 loop=$fields[field_loop].date_array2}
                        <option value='{$fields[field_loop].date_array2[date2].value}'{$fields[field_loop].date_array2[date2].selected}>{$fields[field_loop].date_array2[date2].name}</option>
                        {/section}
                    </select>

                    <select name='field_{$fields[field_loop].field_id}_3' style='border:1px solid #CBD0D2; height:20px; margin:0 10px 0 0; width:57px;'>
                        {section name=date3 loop=$fields[field_loop].date_array3}
                        <option value='{$fields[field_loop].date_array3[date3].value}'{$fields[field_loop].date_array3[date3].selected}>{$fields[field_loop].date_array3[date3].name}</option>
                        {/section}
                    </select>
                </p>
                <div class='form_desc'>{$fields[field_loop].field_desc}</div>
                {/if}

                {if $fields[field_loop].field_id == $setting.setting_subnet_field1_id | $fields[field_loop].field_id == $setting.setting_subnet_field2_id}{$UserProfile} {$user->subnet_info.subnet_name}{/if}

                {* SHOW FIELD ERROR MESSAGE *}
                {if $fields[field_loop].field_error != ""}<div class='form_error'><img src='./images/icons/error16.gif' border='0' class='icon'> {$fields[field_loop].field_error}</div>{/if}

                {/section}
                <p class="line">&nbsp;</p>
                {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}
                
                <div class="submits">
                    <label><input type="submit" value="{$Application425}"/></label>
                    <label><input type="button" onclick="location.href='{$redirect_page}'" value="Cancel"/></label>
                </div>
          
                <input type='hidden' name='task' value='dosave'>
                <input type='hidden' name='tab_id' value='{$tab_id}'>
            </form>
            {/if}
        </div>
    </div>
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>


{include file='Footer.tpl'}