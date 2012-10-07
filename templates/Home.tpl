{include file='Header.tpl'}

            <div id="content">
				<div class="block-top"><span>&nbsp;</span></div>

                  {if in_array('Hello message', $homepageBlocks)}
				  <h3 class="stat"><b>{$Application123}</b></h3>

                  <div class="contentblock">{$Application124}</div>
                  {/if}                
                  
                  <ul class="accordion">
                  {* SHOW RECENT NEWS ANNOUNCEMENTS IF MORE THAN ZERO *}  
                  {if $news_total > 0}
                    {if in_array('Recent news', $homepageBlocks)}
                        <li class="active"><a class="opener active" href="#">{$Application141}</a>
                            <div class="slide">
                                  {section name=news_loop loop=$news max=5}
                                    <table cellpadding='0' cellspacing='5'>
                                    <tr>
                                    <td valign='top'><b>{$news[news_loop].item_subject}</b><br/>{$news[news_loop].item_date}<br />{$news[news_loop].item_body}</td>
                                    </tr>
                                    </table>
                                    {if $smarty.section.news_loop.last == false}<br />{/if}
                                  {/section}
                            </div>
                        </li>
                    {/if}
                  {/if}
                
                  {* SHOW ONLINE USERS IF MORE THAN ZERO *}
                  {if $online_users|@count > 0}
                    {if in_array('Members online', $homepageBlocks)}
                        <li class="active"><a href="#" class="opener active">{$Application143} ({$online_users|@count})</a>
                            <div class="slide">
                                {section name=online_users_loop loop=$online_users max=20}{if $smarty.section.online_users_loop.rownum != 1}, {/if}<a href='{$url->url_create('profile',$online_users[online_users_loop])}'>{$online_users[online_users_loop]}</a>{/section}<br/>
                            </div>
                        </li>
                    {/if}
                  {/if}
                
                  {* SHOW LAST SIGNUPS *}
                  {if in_array('Newest members', $homepageBlocks)}
                        <li class="active"><a href="#" class="opener active">{$Application144}</a>
                            <div class="slide">
                                {if $signups|@count > 0}
                                  {section name=signups_loop loop=$signups max=5}
                                    {* START NEW ROW *}
                                    {cycle name="startrow" values="<table cellpadding='0' cellspacing='15' align='center'><tr>,,,,"}
                                    <td class='portal_member' valign='top'><a href='{$url->url_create('profile',$signups[signups_loop]->user_info.user_username)}'>{$signups[signups_loop]->user_info.user_username|truncate:15:"...":true}<br /><img src='{$signups[signups_loop]->user_photo('./images/nophoto.gif')}' class='photo' width='{$misc->photo_size($signups[signups_loop]->user_photo('./images/nophoto.gif'),'90','90','w')}' border='0' /></a></td>
                                    {* END ROW AFTER 5 RESULTS *}
                                    {if $smarty.section.signups_loop.last == true}
                                      </tr></table>
                                    {else}
                                      {cycle name="endrow" values=",,,,</tr></table>"}
                                    {/if}
                                  {/section}
                                {else}
                                  {$Application145}
                                {/if}
                            </div>
                        </li>
                 {/if}
                
                
                {* SHOW MOST POPULAR USERS (MOST FRIENDS) *}
                {if $setting.setting_connection_allow != 0}
                    {if in_array('Most popular members', $homepageBlocks)}
                        <li class="active"><a href="#" class="opener active">{$Application146}</a>
                            <div class="slide">
                              {if $friends|@count > 0}
                                {section name=friends_loop loop=$friends max=5}
                                  {* START NEW ROW *}
                                  {cycle name="startrow2" values="<table cellpadding='0' cellspacing='15' align='center'><tr>,,,,"}
                                  <td class='portal_member' valign='top'><a href='{$url->url_create('profile',$friends[friends_loop].friend->user_info.user_username)}'>{$friends[friends_loop].friend->user_info.user_username|truncate:15}<br /><img src='{$friends[friends_loop].friend->user_photo('./images/nophoto.gif')}' class='photo' width='{$misc->photo_size($friends[friends_loop].friend->user_photo('./images/nophoto.gif'),'90','90','w')}' border='0' /></a><br />{$friends[friends_loop].total_friends} {$Application147}</td>
                                  {* END ROW AFTER 5 RESULTS *}
                                  {if $smarty.section.friends_loop.last == true}
                                    </tr></table>
                                  {else}
                                    {cycle name="endrow2" values=",,,,</tr></table>"}
                                  {/if}
                                {/section}
                              {else}
                                {$Application148}
                              {/if}
                            </div>
                        </li>
                    {/if}
                {/if}
                
                {* SHOW LAST LOGINS *}
                {if in_array('Members last logged in', $homepageBlocks)}
                        <li class="active"><a href="#" class="opener active">{$Application149}</a>
                            <div class="slide">
                                {if $logins|@count > 0}
                                  {section name=login_loop loop=$logins max=5}
                                    {* START NEW ROW *}
                                    {cycle name="startrow3" values="<table cellpadding='0' cellspacing='15' align='center'><tr>,,,,"}
                                    <td class='portal_member' valign='top'><a href='{$url->url_create('profile',$logins[login_loop]->user_info.user_username)}'>{$logins[login_loop]->user_info.user_username}<br /><img src='{$logins[login_loop]->user_photo('./images/nophoto.gif')}' class='photo' width='{$misc->photo_size($logins[login_loop]->user_photo('./images/nophoto.gif'),'90','90','w')}' border='0' /></a></td>
                                    {* END ROW AFTER 5 RESULTS *}
                                    {if $smarty.section.login_loop.last == true}
                                      </tr></table>
                                    {else}
                                      {cycle name="endrow3" values=",,,,</tr></table>"}
                                    {/if}
                                  {/section}
                                {else}
                                  {$Application150}
                                {/if}
                            </div>
                        </li>
                {/if}
                </ul>
                
                <div class="block-bot"><span>&nbsp;</span></div>
            </div>  
            <div id="sidebar">

            	{if $user->user_exists}<a href='{$url->url_create('profile',$user->user_info.user_username)}'><img src='{$user->user_photo("./images/nophoto.gif")}' width='{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'174','174','w')}' border='0' class="img" alt="{$user->user_info.user_username}{$Application130}" /></a>
            	<br/><br/>{/if}
                {* SHOW NETWORK STATISTICS *}
                {include file='MenuSidebar.tpl'}
                {if in_array('Network statistic', $homepageBlocks)}
                <div class="block">
                    <ul class="accordion">
                        <li class="form-top active"><a href="#" class="opener active">{$Application133}</a>
                            <div class="slide">
                                    <div>
                                        {$Application134} {$total_members} {$Application135}
                                        {if $setting.setting_connection_allow != 0}<br />{$Application137} {$total_friends} {$Application138}{/if}
                                        <br />{$Application139} {$total_comments} {$Application140}
                                    </div>
                                    <div class="block-bot"><span>&nbsp;</span></div>
                            </div>
                        </li>
                    </ul>
                </div>
                {/if}

                
			</div>
<div id="sidebar_right">{include file='MenuSidebarRight.tpl'}</div>	    

{include file='Footer.tpl'}