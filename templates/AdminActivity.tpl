{include file='AdminHeader.tpl'}

<h2>{$Admin42}</h2>
<p>{$Admin43}</p>

{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}

{if $result != 0}
<p style="color:green;">{$Admin44}</p>
<br/>
{/if}

<form action='AdminActivity.php' method='post'>

<p>{$Admin45}</p>
<p>{$Admin46}<p>


{section name=actiontype_loop loop=$actiontypes}
{if $smarty.section.actiontype_loop.first}<div class="row" {if !$smarty.section.actiontype_loop.last}style="border:none;"{/if}>{/if}
    <div class="block" style="margin-right:114px;">
        <div class="block-head"><h3>Action Type: {$actiontypes[actiontype_loop].actiontype_name}&nbsp;&nbsp;&nbsp;<input align="right" name='actiontype_enabled_{$actiontypes[actiontype_loop].actiontype_id}' type='checkbox' value='1' {if $actiontypes[actiontype_loop].actiontype_enabled == 1} checked='checked'{/if}/></h3></div>
        <div class="block-in">

            <p><label><b>{$Admin47}</b><textarea name='actiontype_text_{$actiontypes[actiontype_loop].actiontype_id}' rows='3' style='width: 100%;' class="input-border">{$actiontypes[actiontype_loop].actiontype_text}</textarea></label></p>
            <p><label><b>{$Admin79}</b><input name='actiontype_desc_{$actiontypes[actiontype_loop].actiontype_id}' type='text' size='37' maxlength='200' class="input-border" value='{$actiontypes[actiontype_loop].actiontype_desc}'/></label></p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    
    {if $smarty.section.actiontype_loop.iteration%2==0 || $smarty.section.actiontype_loop.last}</div>{/if}
    {if $smarty.section.actiontype_loop.iteration%2==0 && !$smarty.section.actiontype_loop.last}<div class="row" {if !$smarty.section.actiontype_loop.last}style="border:none;"{/if}>{/if}
    {if $smarty.section.actiontype_loop.last}<p class="line">&nbsp;</p>{/if}

{/section}
<input type='hidden' name='actiontypes_total' value='{$actiontypes_total}'/>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>How many recent actions do you want to store in the database for each user? </h3></div>
        <div class="block-in">
            <p>
                <label>
                    <select class="input-border" name='actions_actionsonprofile'>
                        <option{if $actions_actionsonprofile == "0"} selected='selected'{/if}>0</option>
                        <option{if $actions_actionsonprofile == "1"} selected='selected'{/if}>1</option>
                        <option{if $actions_actionsonprofile == "2"} selected='selected'{/if}>2</option>
                        <option{if $actions_actionsonprofile == "3"} selected='selected'{/if}>3</option>
                        <option{if $actions_actionsonprofile == "4"} selected='selected'{/if}>4</option>
                        <option{if $actions_actionsonprofile == "5"} selected='selected'{/if}>5</option>
                        <option{if $actions_actionsonprofile == "6"} selected='selected'{/if}>6</option>
                        <option{if $actions_actionsonprofile == "7"} selected='selected'{/if}>7</option>
                        <option{if $actions_actionsonprofile == "8"} selected='selected'{/if}>8</option>
                        <option{if $actions_actionsonprofile == "9"} selected='selected'{/if}>9</option>
                        <option{if $actions_actionsonprofile == "10"} selected='selected'{/if}>10</option>
                    </select>

                    {$Admin51}
                </label>
            </p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin50}</p>
</div>
<br/>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin52}</h3></div>
        <div class="block-in">
            <p>
                <label>
                    <select class="input-border" name='actions_actionsinlist'>
                        <option{if $actions_actionsinlist == "0"} selected='selected'{/if}>0</option>
                        <option{if $actions_actionsinlist == "1"} selected='selected'{/if}>1</option>
                        <option{if $actions_actionsinlist == "2"} selected='selected'{/if}>2</option>
                        <option{if $actions_actionsinlist == "3"} selected='selected'{/if}>3</option>
                        <option{if $actions_actionsinlist == "4"} selected='selected'{/if}>4</option>
                        <option{if $actions_actionsinlist == "5"} selected='selected'{/if}>5</option>
                        <option{if $actions_actionsinlist == "6"} selected='selected'{/if}>6</option>
                        <option{if $actions_actionsinlist == "7"} selected='selected'{/if}>7</option>
                        <option{if $actions_actionsinlist == "8"} selected='selected'{/if}>8</option>
                        <option{if $actions_actionsinlist == "9"} selected='selected'{/if}>9</option>
                        <option{if $actions_actionsinlist == "10"} selected='selected'{/if}>10</option>
                        <option{if $actions_actionsinlist == "15"} selected='selected'{/if}>15</option>
                        <option{if $actions_actionsinlist == "20"} selected='selected'{/if}>20</option>
                        <option{if $actions_actionsinlist == "25"} selected='selected'{/if}>25</option>
                        <option{if $actions_actionsinlist == "30"} selected='selected'{/if}>30</option>
                        <option{if $actions_actionsinlist == "35"} selected='selected'{/if}>35</option>
                        <option{if $actions_actionsinlist == "40"} selected='selected'{/if}>40</option>
                        <option{if $actions_actionsinlist == "45"} selected='selected'{/if}>45</option>
                        <option{if $actions_actionsinlist == "50"} selected='selected'{/if}>50</option>
                    </select>

                    {$Admin54}
                </label>
            </p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin53}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin55|truncate:69:"...":true}</h3></div>
        <div class="block-in">
            <p>
                <label>
                    <select class="input-border" name='actions_showlength'>
                        <option value='60'{if $actions_showlength == "60"} selected='selected'{/if}>1 {$Admin57}</option>
                        <option value='300'{if $actions_showlength == "300"} selected='selected'{/if}>5 {$Admin58}</option>
                        <option value='600'{if $actions_showlength == "600"} selected='selected'{/if}>10 {$Admin58}</option>
                        <option value='1200'{if $actions_showlength == "1200"} selected='selected'{/if}>20 {$Admin58}</option>
                        <option value='1800'{if $actions_showlength == "1800"} selected='selected'{/if}>30 {$Admin58}</option>
                        <option value='3600'{if $actions_showlength == "3600"} selected='selected'{/if}>1 {$Admin59}</option>
                        <option value='10800'{if $actions_showlength == "10800"} selected='selected'{/if}>3 {$Admin60}</option>
                        <option value='21600'{if $actions_showlength == "21600"} selected='selected'{/if}>6 {$Admin60}</option>
                        <option value='43200'{if $actions_showlength == "43200"} selected='selected'{/if}>12 {$Admin60}</option>
                        <option value='86400'{if $actions_showlength == "86400"} selected='selected'{/if}>1 {$Admin61}</option>
                        <option value='172800'{if $actions_showlength == "172800"} selected='selected'{/if}>2 {$Admin62}</option>
                        <option value='259200'{if $actions_showlength == "259200"} selected='selected'{/if}>3 {$Admin62}</option>
                        <option value='604800'{if $actions_showlength == "604800"} selected='selected'{/if}>1 {$Admin63}</option>
                        <option value='1209600'{if $actions_showlength == "1209600"} selected='selected'{/if}>2 {$Admin64}</option>
                        <option value='2629743'{if $actions_showlength == "2629743"} selected='selected'{/if}>1 {$Admin65|truncate:45:"...":true}</option>
                    </select>

                    {$Admin56}
                </label>
            </p>
            <br/>
            <p>
                <label>
                    <select class="input-border" name='actions_actionsperuser'>
                        <option{if $actions_actionsperuser == "0"} selected='selected'{/if}>0</option>
                        <option{if $actions_actionsperuser == "1"} selected='selected'{/if}>1</option>
                        <option{if $actions_actionsperuser == "2"} selected='selected'{/if}>2</option>
                        <option{if $actions_actionsperuser == "3"} selected='selected'{/if}>3</option>
                        <option{if $actions_actionsperuser == "4"} selected='selected'{/if}>4</option>
                        <option{if $actions_actionsperuser == "5"} selected='selected'{/if}>5</option>
                        <option{if $actions_actionsperuser == "6"} selected='selected'{/if}>6</option>
                        <option{if $actions_actionsperuser == "7"} selected='selected'{/if}>7</option>
                        <option{if $actions_actionsperuser == "8"} selected='selected'{/if}>8</option>
                        <option{if $actions_actionsperuser == "9"} selected='selected'{/if}>9</option>
                        <option{if $actions_actionsperuser == "10"} selected='selected'{/if}>10</option>
                    </select>
                    {$Admin66}
                </label>
            </p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin55}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin67}</h3></div>
        <div class="block-in">
            <p><input type='radio' name='actions_selfdelete' id='actions_selfdelete_1' value='1'{if $actions_selfdelete == 1} CHECKED{/if}/> <label for='actions_selfdelete_1'>{$Admin69}</label></p>
            <p><input type='radio' name='actions_selfdelete' id='actions_selfdelete_0' value='0'{if $actions_selfdelete == 0} CHECKED{/if}>&nbsp;<label for='actions_selfdelete_0'>{$Admin70}</label></p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin68}</p>
</div>

<div class="row">
    <div class="block">
        <div class="block-head"><h3>{$Admin70}</h3></div>
        <div class="block-in">
            {section name=visibility_loop loop=$actions_visibility}
            {if $actions_visibility[visibility_loop].privacy_value != 0 AND $actions_visibility[visibility_loop].privacy_value != 3 AND $actions_visibility[visibility_loop].privacy_value != 5}
            <p><input type='radio' name='actions_visibility' id='actions_visibility{$actions_visibility[visibility_loop].privacy_value}' value='{$actions_visibility[visibility_loop].privacy_value}'{if $actions_visibility[visibility_loop].privacy_selected == 1} checked='checked'{/if}>&nbsp;<label for='actions_visibility{$actions_visibility[visibility_loop].privacy_value}'>{$actions_visibility[visibility_loop].privacy_option}</label></p>
            {/if}
            {/section}
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin72}</p>
</div>

<div class="row" style="border-bottom:none; margin-bottom:0px;">
    <div class="block">
        <div class="block-head"><h3>{$Admin74}</h3></div>
        <div class="block-in">
            <p><input type='radio' name='actions_privacy' id='actions_privacy_1' value='1'{if $actions_privacy == 1} CHECKED{/if}>&nbsp;<label for='actions_privacy_1'>{$Admin77}</label></p>
            <br/>
            <p><input type='radio' name='actions_privacy' id='actions_privacy_0' value='0'{if $actions_privacy == 0} CHECKED{/if}>&nbsp;<label for='actions_privacy_0'>{$Admin78}</label></p>
        </div>
        <div class="block-b">&nbsp;</div>
    </div>
    <p>{$Admin75}</p>
</div>

<input type='hidden' name='task' value='dosave'>
<div style="padding-left:20px;"><label class="button"><input type='submit' value='{$Admin76}'/></label></div>
</form>

{include file='AdminFooter.tpl'}