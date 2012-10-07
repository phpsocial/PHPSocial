{include file='AdminHeader.tpl'}

<h2>{$Admin874}</h2>
<p>{$Admin875}</p>


{if $result != 0}
<p style="color:green;">{$Admin881}</p>
{/if}

<table cellpadding='0' cellspacing='0' width='600' style="color:#666666;">
<form action='AdminUrl.php' method='POST'>
<tr><td class='header'>{$Admin882}</td></tr>
<tr>
<td class='setting1'>
{$Admin876}
<br><br>
{$Admin883}
<br>
{section name=url_loop loop=$urls}
{$urls[url_loop].url_title}: {$urls[url_loop].url_regular}<br>
{/section}
<br>
{$Admin884}
<br>
{section name=url_loop loop=$urls}
{$urls[url_loop].url_title}: {$urls[url_loop].url_subdirectory}<br>
{/section}
</td></tr><tr><td class='setting2'>
  <table cellpadding='0' cellspacing='0'>
  <tr><td><input type='radio' name='setting_url' id='setting_url_0' value='0'{if $setting_url == 0} CHECKED{/if}>&nbsp;</td><td><label for='setting_url_0'>{$Admin877}</label></td></tr>
  <tr><td><input type='radio' name='setting_url' id='setting_url_1' value='1'{if $setting_url == 1} CHECKED{/if}>&nbsp;</td><td><label for='setting_url_1'>{$Admin878}</label>{if $setting_url == 1}{$Admin880}{/if}</td></tr>
  </table>
</td></tr></table>
<br>

<label class="button"><input type='submit' value='{$Admin879}'/></label>
<input type='hidden' name='task' value='dosave'>
</form>

{include file='AdminFooter.tpl'}