{include file='AdminHeader.tpl'}

<h2>{$Admin570}</h2>
<p>{$Admin571}</p>
{section name=tab_loop loop=$tabs}
            {if $tabs[tab_loop].tab_fields}
                    {assign var=field_flag value=$smarty.section.tab_loop.iteration}
            {/if}
 {/section}
{literal}
<script language=javascript type="text/javascript">
    function show_hide() {
        {/literal}
        if (document.getElementById('field_tree_{$field_flag}').style.display=='none')
        {literal}        { {/literal}
            
            {section name=tab_loop loop=$tabs}
            {if $tabs[tab_loop].tab_fields}
                document.getElementById('field_tree_{$smarty.section.tab_loop.iteration}').style.display='block';
            {/if}
            {/section}
            {literal}
        }
        else{
            {/literal}
            {section name=tab_loop loop=$tabs}
            {if $tabs[tab_loop].tab_fields}
                document.getElementById('field_tree_{$smarty.section.tab_loop.iteration}').style.display='none';
            {/if}
            {/section}
            {literal}
        }
    }
</script>
{/literal}


<div class="row row2" style="border:none;">
    <p>Profile Categories - <a href="AdminProfileAddtab.php">Add Category</a></p><br/>
    {if $num_tabs != "0"}
    <table cellpadding='0' cellspacing='0'>
        <tr>
            <td><img src="images/papka-first-laver.jpg" border='0'></td>
            <td style='padding-left: 3px;'><a href="AdminProfileAddtab.php?o={$o_url}">[{$Admin572}]</a> - <a href="AdminProfileAddfield.php?o={$o_url}">[{$Admin573}]</a>
                - <a href='javascript:void(0);' onclick="show_hide();">[Collapse/Expand All]</a>
        </td></tr>
    </table>
    {else}
    <p>{$Admin576}</p>
    {/if}
    {if $tabs}
    <ul class="sortable-cats">
        {* LOOP THROUGH TABS *}
        {section name=tab_loop loop=$tabs}
        <li {if $smarty.section.tab_loop.last}class="last"{/if}>
            <span><a href='AdminProfileEdittab.php?tab_id={$tabs[tab_loop].tab_id}&o={$o_url}'>{$tabs[tab_loop].tab_name}</a></span>
            {if $tabs[tab_loop].tab_fields}
            <ul id="field_tree_{$smarty.section.tab_loop.iteration}" style="display:none;">
                {* LOOP THROUGH FIELDS *}
                {section name=field_loop loop=$tabs[tab_loop].tab_fields}
                <li>
                    <span><a href='AdminProfileEditfield.php?field_id={$tabs[tab_loop].tab_fields[field_loop].field_id}'>{$tabs[tab_loop].tab_fields[field_loop].field_title}</a>{if $tabs[tab_loop].tab_fields[field_loop].field_birthday == 1} {$Admin579}{/if} <a onclick="if (!confirm('Are you sure?')) return false;" href="AdminProfileEditfield.php?task=deletefield&field_id={$tabs[tab_loop].tab_fields[field_loop].field_id}" style="color:#e00000">&times;</a></span>
                    {* LOOP THROUGH DEPENDENT FIELDS *}
                    {if $tabs[tab_loop].tab_fields[field_loop].dep_fields}
                    <ul style="padding: 10px 0 0 30px">
                        {section name=dep_field_loop loop=$tabs[tab_loop].tab_fields[field_loop].dep_fields}
                        <li style="padding-left: 7px">
                            <a href='AdminProfileEditdepfield.php?field_id={$tabs[tab_loop].tab_fields[field_loop].dep_fields[dep_field_loop].dep_field_id}'>{if $tabs[tab_loop].tab_fields[field_loop].dep_fields[dep_field_loop].dep_field_title != ""}{$tabs[tab_loop].tab_fields[field_loop].dep_fields[dep_field_loop].dep_field_title}{else}{$Admin578}{/if}</a>
                        </li>
                        {/section}
                    </ul>
                    {/if}
                </li>
                {/section}
            </ul>
            {/if}
        </li>
        {/section}
    </ul>
    {/if}

</div>


<br/>
{include file='AdminFooter.tpl'}