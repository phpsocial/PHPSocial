{include file='AdminHeader.tpl'}
<h2>{$Admin857}</h2>
<p>{$Admin858}</p>


<p class="line">&nbsp;</p>
<div class="row2" style="border:none;">
    <div class="f-left">
        {$Admin859}
        <ul>
            {section name=file_loop loop=$user_files}
            <li><a href="AdminEditTemplates.php?t={$user_files[file_loop].filename}">{$user_files[file_loop].filename}</a></li>
            {/section}
        </ul>
    </div>
    <div class="f-left">
        {$Admin860}
        <ul>
            {section name=file_loop loop=$base_files}
            <li><a href="AdminEditTemplates.php?t={$base_files[file_loop].filename}">{$base_files[file_loop].filename}</a></li>
            {/section}
        </ul>
    </div>
    <div class="f-left">
        {$Admin861}
        <ul>
            {section name=file_loop loop=$head_files}
            <li><a href="AdminEditTemplates.php?t={$head_files[file_loop].filename}">{$head_files[file_loop].filename}</a></li>
            {/section}
        </ul>
    </div>
</div>

{include file='AdminFooter.tpl'}