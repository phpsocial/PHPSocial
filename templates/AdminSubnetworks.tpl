{include file='AdminHeader.tpl'}

<h2>{$Admin797}</h2>
<p>{$Admin798}</p>


{literal}
<script language='JavaScript'>
    <!--
    function showdiv(id1, id2) {
        document.getElementById(id1).style.display='block';
        document.getElementById(id2).style.display='none';
    }
    //-->
</script>
{/literal}

<div id='button1' style='display: block;'>
    [ <a href="javascript:showdiv('help', 'button1')">{$Admin820}</a> ]
    <br><br>
</div>

<div id='help' style='display: none;'>
    <p>{$Admin818}</p>
    
</div>


{if $result != ""}
<p style="color:green;">{$result}</p>
{/if}



<div class="row-blue">
    <form>
        <div class="f-left"><label style="padding-left:0;">{$Admin799}</label><br/>
            <select class='text' name='field2_id' style="padding-left:0; width:144px;">
                <option></option>
                <option value='0'{if $secondary_field_id == "0"} SELECTED{/if}>{$Admin812}</option>
                {section name=field_loop loop=$fields}
                <option value='{$fields[field_loop].field_id}'{if $secondary_field_id == $fields[field_loop].field_id} SELECTED{/if}>{$fields[field_loop].field_title}</option>
                {/section}
            </select>
        </div>
        <div class="f-left">
            <label style="padding-left:0;">{$Admin800}</label><br/>
            <select class='text' name='field2_id' style="padding-left:0; width:161px;">
                <option></option>
                <option value='0'{if $secondary_field_id == "0"} SELECTED{/if}>{$Admin812}</option>
                {section name=field_loop loop=$fields}
                <option value='{$fields[field_loop].field_id}'{if $secondary_field_id == $fields[field_loop].field_id} SELECTED{/if}>{$fields[field_loop].field_title}</option>
                {/section}
            </select>
        </div>
        <div class="f-left" style="margin:0;"><label class="button"><input type="submit" value="{$Admin801}"/></label></div>

        <input type='hidden' name='task' value='doupdate'><input type='hidden' name='s' value='{$s}'>
    </form>
</div>

<br/>



<table cellpadding="0" cellspacing="0" class="view-users">
    <tr>
        <th align="left" valign="top" class="col-f"><a class='header' href='AdminSubnetworks.php?s={$i}'>{$Admin803}</a></th>
        <th align="left" valign="top"><a class='header' href='AdminSubnetworks.php?s={$n}'>{$Admin804}</a></th>
        <th align="left" valign="top" width="200px"><a class='header' href='AdminSubnetworks.php?s={$u}'>{$Admin805}</a></th>
        <th align="left" valign="top">{$Admin806}</th>
        <th align="center" valign="top" class="col-l">{$Admin807}</th>
    </tr>
    <tr class='event'>
        <td align="left" class="col-f">0</td>
        <td align="left">{$Admin810}</td>
        <td align="left"><a href='AdminViewusers.php?f_subnet=0'>{$default_users}</a></td>
        <td align="left">{$Admin811}</td>
        <td align="center" class="col-l">&nbsp;</td>
    </tr>
   {section name=subnet_loop loop=$subnets}
    <tr class='{cycle values="1, event"}'>
        <td align="left" class="col-f">{$subnets[subnet_loop].subnet_id}</td>
        <td align="left">{$subnets[subnet_loop].subnet_name}</td>
        <td align="left"><a href='AdminViewusers.php?f_subnet={$subnets[subnet_loop].subnet_id}'>{$subnets[subnet_loop].subnet_users}</a></td>
        <td align="left">{$primary_field_title} {$subnets[subnet_loop].subnet_field1_qual} {$subnets[subnet_loop].subnet_field1_value}<br>{$subnets[subnet_loop].subnet_field2_title} {$subnets[subnet_loop].subnet_field2_qual} {$subnets[subnet_loop].subnet_field2_value}</td>
        <td align="center" class="col-l"><a href='AdminSubnetworksEdit.php?s={$s}&subnet_id={$subnets[subnet_loop].subnet_id}'>{$Admin808}</a> | <a href='AdminSubnetworks.php?s={$s}&task=confirm&subnet_id={$subnets[subnet_loop].subnet_id}'>{$Admin809}</a></td>
    </tr>
    {/section}

</table>


<form action='AdminAddSubnetworks.php' method='GET'>
    <label class="button"><input type='submit' value='{$Admin802}'/></label>
    <input type='hidden' name='s' value='{$s}'>
</form>
{include file='AdminFooter.tpl'}