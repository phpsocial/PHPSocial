{include file='AdminHeader.tpl'}
<h2>{$Admin406}</h2>
<p>{$Admin407}</p>



{* SHOW INSTALL FILE EXISTS WARNING *}
{if $install_exists == 1}
<p style="color:red;">{$Admin414}</p>
{/if}

{* SHOW LICENSE INFO *}
<div class="row-blue">
    {if $setting.setting_key}<div class="f-left"><p>{$Admin408}<b>{$setting.setting_key}</b></p></div>{/if}
    <div class="f-left"><p>{$Admin409} <b>{$version_num}</b></p></div>
</div>

{* SHOW QUICK STATS *}

<div class="row">
    <dl class="f-left">
        <dt>{$Admin410}</dt><dd>{$total_users_num}</dd>
        <dt>Subnetworks:</dt><dd>{$total_subnetworks}</dd>
        <dt>Views Today:</dt><dd>{$views_today}</dd>
    </dl>
    <dl class="f-left">
        <dt>{$Admin411}</dt><dd>{$total_comments_num}</dd>
        <dt>{$Admin412}</dt><dd>{$total_messages_num}</dd>
        <dt>{$Admin416}</dt><dd>{$total_user_levels}</dd>
    </dl>
    <dl class="f-left">
        <dt>{$Admin417}</dt><dd>{$total_reports}</dd>
        <dt>{$Admin418}</dt><dd>{$total_friendships}</dd>
        <dt>{$Admin419}</dt><dd>{$total_announcements}</dd>
    </dl>
    <dl class="f-left">
        <dt>{$Admin420}</dt><dd>{$signups_today}</dd>
        <dt>{$Admin421}</dt><dd>{$logins_today}</dd>
        <dt>{$Admin422}</dt><dd>{$total_admins}</dd>
    </dl>

    {* SHOW ONLINE USERS IF MORE THAN ZERO *}
    {if $online_users|@count > 0}
    <div class="clear"><p><b>{$online_users|@count}</b> {$Admin413}&nbsp;
            {section name=online_users_loop loop=$online_users}
            {if $smarty.section.online_users_loop.rownum != 1}, {/if}<b>{$online_users[online_users_loop]}</b>{/section}
    </p></div>
    {/if}

</div>

{$Admin423}

<div class="row2"><img src="images/img1.jpg" alt=""/>
    <div class="row">
        <p><a href="AdminProfile.php" class="blue">{$Admin429}</a><br/>
        {$Admin430}</p>
</div></div>
<div class="row2"><img src="images/img2.jpg" alt=""/>
    <div class="row">
        <a href="AdminSignup.php" class="blue">{$Admin431}</a><br/>
        <p>{$Admin432}</p>
</div></div>
<div class="row2"><img src="images/img3.jpg" alt=""/>
    <div class="row">
        <a href="AdminLevels.php" class="blue">{$Admin433}</a><br/>
        <p>{$Admin434}</p>
</div></div>
<div class="row2"><img src="images/img4.jpg" alt=""/>
    <div class="row">
        <a href="AdminViewplugins.php" class="blue">{$Admin435}</a><br/>
        <p>{$Admin436}</p>
</div></div>
<div class="row2"><img src="images/img5.jpg" alt=""/>
    <div class="row" style="border:none;">
        <a href="AdminTemplates.php" class="blue">{$Admin437}</a><br/>
        <p>{$Admin438}</p>
</div></div>


{include file='AdminFooter.tpl'}