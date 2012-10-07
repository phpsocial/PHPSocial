{include file='Header.tpl'}
<div id="content">
    <div class="grey-head">
        <h2>{$Application611}</h2>
    </div>
    <div class="layers">
        <ul class="list01">
            <li {if $uri_page=='UserFriends.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriends.php'>{$Application483}</a></li>
            <li {if $uri_page=='UserFriendsRequests.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsRequests.php'>{$Application484}</a></li>
            <li {if $uri_page=='UserFriendsRequestsOutgoing.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsRequestsOutgoing.php'>{$Application510}</a></li>
            <li {if $uri_page=='UserFriendsSettings.php'}class="ui-state-active ui-tabs-selected"{/if}><a href='UserFriendsSettings.php'>{$Application509}</a></li>
        </ul>
        <p style="padding-left:25px;">{$Application615}</p>



        {* SHOW SUCCESS MESSAGE *}
        {if $result != 0}
        <br/>
        <p style="padding-left:25px; color:green;">{$Application613}</p>
        {/if}

        <div id="primary" class="info-cnt tuneddivs">
            <form action='UserFriendsSettings.php' method='post' name="set_form" class="settings">
                <p>
                   <input style="float:left; width:15px; height:15px; margin-left:15px !important; margin-right:15px !important;" type='checkbox' value='1' id='friendrequest' name='usersetting_notify_friendrequest'{if $user->usersetting_info.usersetting_notify_friendrequest == 1} CHECKED{/if} />
                   <label style="width:447px; clear:none;">{$Application616}</label>
                </p>
                
                <p class="line">&nbsp;</p>
                <div class="submits">
                    <label><input type="submit" value="Save"/></label>
                    <label><input type="button" class="submit_button_uf" value="Cancel" onclick="location.href='UserFriends.php'"/></label>
                </div>
                 <input type='hidden' name='task' value='dosave'/>
            </form>
        </div>
</div>
<div class="block-bot">
    <span>&nbsp;</span>
</div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>






{include file='Footer.tpl'}