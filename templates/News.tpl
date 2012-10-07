{include file='Header.tpl'}
<div id="content">
    {* SHOW PAGE TITLE *}
    <div class="grey-head"><h2>{$Application620}</h2></div>

    <br/><ul class="list01">

        <li {if $tab!='Groups' && $tab!='Comments'}class="ui-state-active ui-tabs-selected"{/if}>
            <a href='News.php'>Network</a>
        </li>

        <li {if $tab=='Groups'}class="ui-state-active ui-tabs-selected"{/if}>
            <a href='News.php?tab=Groups'>Groups</a>
        </li>

        <li {if $tab=='Comments'}class="ui-state-active ui-tabs-selected"{/if}>
            <a href='News.php?tab=Comments'>Comments</a>
        </li>
    </ul>

    {* SHOW MESSAGE IF NO ACTIONS*}
    {if !$actions}
    <br/>
    <p align="center" style="color:red;">{$Application628}</p>
    <br/>
    {/if}

    {* DISPLAY ACTIONS IN THUMBNAIL FORM *}
    {section name=actions_loop loop=$actions}
    <div class="row"  {if $smarty.section.actions_loop.last == true}style="border:none;"{/if}>
         <div class="f-right">
            {$datetime->time_since($actions[actions_loop].action_date)}
        </div>
       
        <dl>
            <dt></dt>
            <dd>{$actions[actions_loop].action_text|choptext:50:"..."}</dd>
        </dl>
    </div>
    {/section}


    <div class="block-bot"><span>&nbsp;</span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
    {if $tab!='Groups' && $tab!='Comments'}
    <form method="post" name="newsfrom" action="News.php" style="padding:0 0;">
        <input type="hidden" name="filter" value="1" />
        <div class="block">
            <ul class="accordion">
                <li class="form-top active"><a href="#" class="opener active">{$Application742}</a>
                    <div class="slide">
                        <div class="side-form" style="padding:10px 10px 10px 16px !important;">
                            {section name=loop loop=$action_types}
                            <label style="font-size: 11px">
                                {* DISPLAY ACTION *}
                                <input type="checkbox" onchange="document.newsfrom.submit()" style="border: none; width: auto !important; height: auto !important;" name="actiontype[{$action_types[loop].actiontype_id}]" {if $action_types[loop].actiontype_checked}checked{/if} />&nbsp;{$action_types[loop].actiontype_desc_other}<br/>
                            </label>
                            {/section}
                        </div>
                        <div class="block-bot"><span>&nbsp;</span></div>
                    </div>
                </li>
            </ul>
        </div>
    </form>
    {/if}
</div>


{include file='Footer.tpl'}