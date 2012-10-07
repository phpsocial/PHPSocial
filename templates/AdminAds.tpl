{include file='AdminHeader.tpl'}

<h2>{$Admin80}</h2>
<p>{$Admin81}</p>

{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}
<br>

<table cellpadding="0" cellspacing="0" class="view-users">
<tr>
<th align="left" valign="top" class="col-f"><a class='header' href='AdminAds.php?s={$i}'>{$Admin84}</a></th>
<th align="left" valign="top"><a class='header' href='AdminAds.php?s={$n}'>{$Admin85}</a></th>
<th align="left" valign="top">{$Admin86}</th>
<th align="left" valign="top"><a class='header' href='AdminAds.php?s={$v}'>{$Admin87}</a></th>
<th align="left" valign="top"><a class='header' href='AdminAds.php?s={$c}'>{$Admin88}</a></th>
<th align="left" valign="top" style="width:auto !important;">{$Admin89}</th>
<th align="center" valign="top" class="col-l">{$Admin90}</th>
</tr>
  {section name='ad_loop' loop=$ads}
    {if $ads[ad_loop].ad_total_views == "" OR $ads[ad_loop].ad_total_views == 0}
      {assign var=ad_views value="<font style='color: #AAAAAA;'>---</font>"}
    {else}
      {assign var=ad_views value=$ads[ad_loop].ad_total_views}
    {/if}
    {if $ads[ad_loop].ad_total_clicks == "" OR $ads[ad_loop].ad_total_clicks == 0}
      {assign var=ad_clicks value="<font style='color: #AAAAAA;'>---</font>"}
    {else}
      {assign var=ad_clicks value=$ads[ad_loop].ad_total_clicks}
    {/if}
    {if $ads[ad_loop].ad_name == ""}
      {assign var='ad_name' value="<i>$admin_ads12</i>"}
    {else}
      {assign var='ad_name' value=$ads[ad_loop].ad_name}
    {/if}
    <tr class='{cycle values="1, event"}'>
    <td align="left" class="col-f">{$ads[ad_loop].ad_id}</td>
    <td align="left">{$ad_name}</td>
    <td align="left">{$ads[ad_loop].ad_status}</td>
    <td align="left" style="width:120px !important;">{$ad_views}</td>
    <td align="left" style="width:120px !important;">{$ad_clicks}</td>
    <td align="left" style="width:120px !important;">{$ads[ad_loop].ad_ctr}</td>
    <td align="center" class="col-l">
      <a href='AdminAdsEdit.php?ad_id={$ads[ad_loop].ad_id}'>{$Admin101}</a> |
      {if $ads[ad_loop].ad_paused == 0}
         <a href='AdminAds.php?task=pause&ad_id={$ads[ad_loop].ad_id}'>{$Admin102}</a> |
      {elseif $ads[ad_loop].ad_paused == 1}
        [ <a href='AdminAds.php?task=unpause&ad_id={$ads[ad_loop].ad_id}'>{$Admin103}</a> |
      {/if}
       <a href='AdminAds.php?task=confirm&ad_id={$ads[ad_loop].ad_id}'>{$Admin104}</a> 
    </td>
  {/section}
  {if $ads_total == 0}
    <tr>
    <td colspan='6' class='stat2' align='center'>
      {$Admin105}
    </td>
    </tr>
  {/if}
</table>

<table cellpadding='0' cellspacing='0' width='40%'>
<tr>
<td>
  <form action='AdminAdsAdd.php' method='post'>
  <label class="button"><input type='submit' value='{$Admin82}'/></label>&nbsp;
  </form>
</td>
{if $ads_total > 0}
  <td align='right'>
    <form action='AdminAds.php' method='post'>
    <label class="button"><input type='submit' value='{$Admin83}'/></label>
    </form>
  </td>
{/if}
</tr>
</table>
{include file='AdminFooter.tpl'}