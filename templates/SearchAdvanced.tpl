{include file='Header.tpl'}
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
</style>
{/literal}
<div id="content">
    {* SHOW PAGE TITLE *}
    {if $showfields == 1}
    <div class="grey-head"><h2>{$Application295}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application296}</p>
    </div>
    {elseif $showfields == 0}
    <div class="grey-head"><h2>{$Application310} "{$linkedfield_title}: {$linkedfield_value}"</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application311} {$total_users} {$Application312} "{$linkedfield_title}: {$linkedfield_value}"</p>
    </div>
    {/if}

    {* SHOW RESULTS *}
    {if $task == "browse" OR $task == "dosearch" OR $task == "main"}

    {* SHOW MESSAGE IF NO RESULTS FOUND *}
    {if $total_users == 0}
    <br/>
    <p align="center"> {$Application302}</p>
    <br/>
    {else}

    {* DISPLAY BROWSE RESULTS IN THUMBNAIL FORM *}
    {section name=user_loop loop=$users}
    <div class="row"  {if $smarty.section.user_loop.last == true}style="border:none;"{/if}>
         <div class="f-right">
            <a href='UserMessagesNew.php?to={$users[user_loop]->user_info.user_username}'>{$Application582}</a>
        </div>
        <a href="UserMessagesNew.php?to={$users[user_loop]->user_info.user_username}" class="f-left"><img src='{$users[user_loop]->user_photo('./images/nophoto.gif')}' width='92' class="img" alt="{$users[user_loop]->user_info.user_username}{$Application310}"></a>
        <dl>
            <dt>Name</dt>
            <dd><a href='{$url->url_create('profile',$users[user_loop]->user_info.user_username)}'>{$users[user_loop]->user_info.user_username|truncate:20:"...":true}</a></dd>
            {if $users[user_loop]->user_info.user_online == 1}
            <dt>Is online?</dt>
            <dd>{$Application303}</dd>
            {/if}
        </dl>
    </div>
    {/section}

    {/if}
    {/if}
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}


    {* SHOW FIELDS IF USER IS DOING A MANUAL SEARCH *}
    <form name="searching" action='SearchAdvanced.php' method='POST' style="padding:0 0;">
        {if $showfields == 1}


        {* SHOW PROFILE TABS AND BROWSABLE FIELDS *}
        {* LOOP THROUGH TABS *}
        {section name=tab_loop loop=$tabs}

        {* LOOP THROUGH FIELDS IN TAB *}
        {section name=field_loop loop=$tabs[tab_loop].fields}
        <div class="block">
            <ul class="accordion">
                <li class="form-top active">
                    <a href="#" class="opener active"><h2>{$tabs[tab_loop].fields[field_loop].field_title}</h2></a>
                    <div class="slide">
                        <div class="side-form">
                            {if $tabs[tab_loop].fields[field_loop].field_type == 1 | $tabs[tab_loop].fields[field_loop].field_type == 2}
                            {* TEXT FIELD *}
                            <input style="border:1px solid #CBD0D2;" size="26" type='text' name='field_{$tabs[tab_loop].fields[field_loop].field_id}' value='{$tabs[tab_loop].fields[field_loop].field_value}'/>

                            {elseif $tabs[tab_loop].fields[field_loop].field_type == 3 | $tabs[tab_loop].fields[field_loop].field_type == 4}
                            {* SELECT BOX *}
                            <select name='field_{$tabs[tab_loop].fields[field_loop].field_id}'><option value='-1'></option>
                                {* LOOP THROUGH FIELD OPTIONS *}
                                {section name=option_loop loop=$tabs[tab_loop].fields[field_loop].field_options}
                                <option value='{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id}'{if $tabs[tab_loop].fields[field_loop].field_options[option_loop].option_id == $tabs[tab_loop].fields[field_loop].field_value} SELECTED{/if}>{$tabs[tab_loop].fields[field_loop].field_options[option_loop].option_label|truncate:30:"...":true}</option>
                                {/section}
                            </select>

                            {elseif $tabs[tab_loop].fields[field_loop].field_type == 5}
                            {* DATE FIELD *}

                            <select name='field_{$tabs[tab_loop].fields[field_loop].field_id}_1'>
                                {section name=date1 loop=$tabs[tab_loop].fields[field_loop].date_array1}
                                <option value='{$tabs[tab_loop].fields[field_loop].date_array1[date1].value}'{$tabs[tab_loop].fields[field_loop].date_array1[date1].selected}>{$tabs[tab_loop].fields[field_loop].date_array1[date1].name}</option>
                                {/section}
                            </select>

                            <select name='field_{$tabs[tab_loop].fields[field_loop].field_id}_2'>
                                {section name=date2 loop=$tabs[tab_loop].fields[field_loop].date_array2}
                                <option value='{$tabs[tab_loop].fields[field_loop].date_array2[date2].value}'{$tabs[tab_loop].fields[field_loop].date_array2[date2].selected}>{$tabs[tab_loop].fields[field_loop].date_array2[date2].name}</option>
                                {/section}
                            </select>

                            <select name='field_{$tabs[tab_loop].fields[field_loop].field_id}_3'>
                                {section name=date3 loop=$tabs[tab_loop].fields[field_loop].date_array3}
                                <option value='{$tabs[tab_loop].fields[field_loop].date_array3[date3].value}'{$tabs[tab_loop].fields[field_loop].date_array3[date3].selected}>{$tabs[tab_loop].fields[field_loop].date_array3[date3].name}</option>
                                {/section}
                            </select>
                            {/if}
                        </div>
                        <div class="block-bot"><span></span></div>
                    </div>
                </li>
            </ul>
        </div>
        {/section}
        {/section}

        <div class="block">
            <ul class="accordion">
                <li class="form-top active"><a href="#" class="opener active"><h2>{$Application316}</h2></a>
                    <div class="slide">

                        {* SHOW SUBMIT BUTTON *}
                        <div class='side-form'>
                            <select name='sort' class='small'>
                                <option value='user_dateupdated DESC'{if $sort == "user_dateupdated DESC"} SELECTED{/if}>{$Application317}</option>
                                <option value='user_dateupdated ASC'{if $sort == "user_dateupdated ASC"} SELECTED{/if}>{$Application299}</option>
                                <option value='user_lastlogindate DESC'{if $sort == "user_lastlogindate DESC"} SELECTED{/if}>{$Application318}</option>
                                <option value='user_lastlogindate ASC'{if $sort == "user_lastlogindate ASC"} SELECTED{/if}>{$Application300}</option>
                                <option value='user_signupdate DESC'{if $sort == "user_signupdate DESC"} SELECTED{/if}>{$Application319}</option>
                                <option value='user_signupdate ASC'{if $sort == "user_signupdate ASC"} SELECTED{/if}>{$Application301}</option>
                            </select>


                        </div>

                        <div class="block-bot"><span></span></div>
                    </div>
                </li>

            </ul>
        </div>
        <input type='hidden' name='task' value='dosearch'/>
        <a href="javascript:void(0);" onclick="document.searching.submit()" class="submit_button">{$Application298}</a>
    </form>
    {/if}

</div>







{include file='Footer.tpl'}