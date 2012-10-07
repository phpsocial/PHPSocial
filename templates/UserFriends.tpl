{include file='Header.tpl'}
<div id="content">

    <div class="grey-head">
        <h2>{$Application485}</h2>
    </div>

    {* DISPLAY PAGINATION MENU IF APPLICABLE *}
    {if $maxpage > 1}
    <div class="wp-pagenavi blue">
        {if $p != 1}<a href='UserFriends.php?s={$s}&amp;search={$search}&amp;p={math equation='p-1' p=$p}'>&#171; {$Application495}</a>{else}<font class='disabled'>&#171; {$Application496}</font>{/if}
        {if $p_start == $p_end}
        &nbsp;|&nbsp; {$Application496} {$p_start} {$Application498} {$total_friends} &nbsp;|&nbsp;
        {else}
        &nbsp;|&nbsp; {$Application497} {$p_start}-{$p_end} {$Application498} {$total_friends} &nbsp;|&nbsp;
        {/if}
        {if $p != $maxpage}<a href='UserFriends.php?s={$s}&amp;search={$search}&amp;p={math equation='p+1' p=$p}'>{$Application499} &#187;</a>{else}<font class='disabled'>{$Application499} &#187;</font>{/if}
    </div>
    {/if}

    <div class="layers">
        <ul class="list01">
            <li {if $uri_page=='UserFriends.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriends.php'>{$Application483}</a></li>
            <li {if $uri_page=='UserFriendsRequests.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsRequests.php'>{$Application484}</a></li>
            <li {if $uri_page=='UserFriendsRequestsOutgoing.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsRequestsOutgoing.php'>{$Application510}</a></li>
            <li {if $uri_page=='UserFriendsSettings.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsSettings.php'>{$Application509}</a></li>
        </ul>
        <p style="padding-left:25px;">{$Application486}</p>
        {* SHOW MESSAGE IF USER HAS NO FRIENDS *}
        {if $total_friends == 0 AND $search == ""}
        <br/><br/>
        <p align="center" style="color:red;">{$Application487}</p>
        <br/><br/><br/>
        {/if}

        {* DISPLAY MESSAGE IF NO FRIENDS *}
        {if $total_friends == 0}

        {* DISPLAY MESSAGE IF NO SEARCHED FRIENDS *}
        {if $search != ""}
        <br/>
        <p align="center" style="color:red;">{$Application494}</p>
        <br/><br/><br/>
        {/if}

        {* DISPLAY FRIENDS *}
        {else}
        <div class="info-cnt tuneddivs">
        {section name=friend_loop loop=$friends}
        {* LOOP THROUGH FRIENDS *}
            <div class="row" {if $smarty.section.friend_loop.last}style="border:none;"{/if}>
                <div class="f-right">
                    {if $show_details != 0}<a href='UserFriendsConfirm.php?user={$friends[friend_loop]->user_info.user_username}&amp;task=edit'>{$Application505}</a><br/>{/if}
                    <a href='UserFriendsConfirm.php?user={$friends[friend_loop]->user_info.user_username}&amp;task=remove'>{$Application506}</a><br/>
                    <a href='UserMessagesNew.php?to={$friends[friend_loop]->user_info.user_username}'>{$Application507}</a><br/>
                    <a href='ProfileFriends.php?user={$friends[friend_loop]->user_info.user_username}'>{$Application508}</a><br/>
                </div>

                <a class="f-left" href="{$url->url_create('profile',$friends[friend_loop]->user_info.user_username)}"><img src="{$friends[friend_loop]->user_photo('./images/nophoto.gif')}" class='img' width="92" alt="{$friends[friend_loop]->user_info.user_username}{$Application500}"/></a>
                <dl>
                    <dt>Name:</dt>
                    <dd><a href="{$url->url_create('profile',$friends[friend_loop]->user_info.user_username)}">{$friends[friend_loop]->user_info.user_username}</a></dd>

                    {if $friends[friend_loop]->user_info.user_dateupdated != ""}
                    <dt>{$Application214}</dt>
                    <dd>{$datetime->time_since($friends[friend_loop]->user_info.user_dateupdated)}</dd>
                    {/if}

                    {if $friends[friend_loop]->user_info.user_lastlogindate != ""}
                    <dt>{$Application215}</dt>
                    <dd>{$datetime->time_since($friends[friend_loop]->user_info.user_lastlogindate)}</dd>
                    {/if}

                    {if $show_details != 0}
                        {if $friends[friend_loop]->friend_type != ""}
                            <dt>{$Application503}</dt>
                            <dd>{$friends[friend_loop]->friend_type}</dd>
                        {/if}

                        {if $friends[friend_loop]->friend_explain != ""}
                            <dt>{$Application504}</dt>
                            <dd>{$friends[friend_loop]->friend_explain}</dd>
                        {/if}
                     {/if}
                </dl>
            </div>
           {/section}
        </div>
        {/if}
    </div>
    <div class="block-bot">
        <span>&nbsp;</span>
    </div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
    <form action='UserFriends.php' method='post' name='searchform' style="padding:0 0;">
        <div class="block">
            <ul class="accordion">
                <li class="form-top active"><a href="#" class="opener active">{$Application488}</a>
                    <div class="slide">
                        <div class="side-form">
                            <label>
                                <input type='text' maxlength='100' size='26' style="border:1px solid #CBD0D2;" id='search' name='search' value='{$search}' onkeyup="suggest('search', 'suggest', '{section name=friend_loop loop=$friends}{$friends[friend_loop]->user_info.user_username}{if $smarty.section.friend_loop.last != true},{/if}{/section}');"/>
                            </label>
                            <input type='hidden' name='s' value='{$s}'/>
                            <input type='hidden' name='p' value='{$p}'/>
                        </div>
                        <div class="block-bot"><span>&nbsp;</span></div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="block">
            <ul class="accordion">
                <li class="form-top active"><a href="#" class="opener active">{$Application490}</a>
                    <div class="slide">
                        <div class="side-form">
                            <label>
                                <select name='s'>
                                    <option value='{$u}'{if $s == "ud"} SELECTED{/if}>{$Application491}</option>
                                    <option value='{$l}'{if $s == "ld"} SELECTED{/if}>{$Application492}</option>
                                    <option value='{$t}'{if $s == "t"} SELECTED{/if}>{$Application493}</option>
                                </select>
                            </label>
                        </div>
                        <div class="block-bot"><span>&nbsp;</span></div>
                    </div>
                </li>
            </ul>
        </div>
        <a href="javascript:void(0);" onclick="document.searchform.submit()" class="submit_button_uf">{$Application489}</a>
    </form>
</div>



{include file='Footer.tpl'}