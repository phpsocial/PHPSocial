<html>
<head>
<title>{$Admin567}</title>

{literal}
<style type='text/css'>
body {
	color: #666666;
	text-align: center;
	background-color: #EEEEEE;
}
td { 
	font-family: "Trebuchet MS", tahoma, verdana, serif;
	font-size: 9pt;
}
td.box {
	border: 1px dashed #AAAAAA;
	padding: 15px;
	background: #FFFFFF;
	font-family: "Trebuchet MS", tahoma, verdana, serif;
	font-size: 9pt;
}
td.login {
	font-family: "Trebuchet MS", tahoma, verdana, serif;
	font-size: 9pt;
}
input.text {
	font-family: arial, tahoma, verdana, serif;
	font-size: 9pt; 
}
div.error {
	text-align: center;
	padding-top: 3px;
	font-weight: bold;
}
input.button {
	font-family: arial, tahoma, verdana, serif;
	font-size: 9pt;
	background: #DDDDDD;
	padding: 2px;
	font-weight: bold;
}
div.page_header {
	font-size: 14pt;
}
td.success {
	font-weight: bold;
	padding: 7px 8px 7px 7px;
	background: #f3fff3; 
}
td.error {
	font-weight: bold;
	color: #FF0000;
	padding: 7px 8px 7px 7px;
	background: #FFF3F3;
}
img.icon {
	vertical-align: middle;
	margin-right: 4px;
}
a:link { color: #336699; }
a:visited { color: #336699; }
a:hover { color: #336699; }
</style>
{/literal}

</head>
<body>

<table height='100%' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td>

  <table cellpadding='0' cellspacing='0' align='center' width='600'>
  <tr>
  <td class='box'>

    <div class='page_header'>{$Admin562}</div>

    {if $valid == 1 AND $submitted == 1}
      {$Admin563}
    {elseif $valid == 1 AND $submitted == 0}
      {$Admin564}
      <br><br>

      {if $is_error == 1}

      <table cellpadding='0' cellspacing='0'>
      <tr><td class='error'>
        {$error_message}
      </td></tr></table>
      <br>
      {/if}

    <form action='AdminResetLostpass.php' method='post'>
    <table cellpadding='0' cellspacing='0' align='center'>
    <tr>
    <td align='right'>{$Admin565}&nbsp;</td>
    <td><input type='password' class='text' name='admin_password' maxlength='50' size='40'></td>
    </tr>
    <tr>
    <td align='right'>{$Admin566}&nbsp;</td>
    <td><input type='password' class='text' name='admin_password2' maxlength='50' size='40'></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>
      <table cellpadding='0' cellspacing='0' style='margin-top: 5px;'>
      <tr>
      <td valign='top'>
        <input type='submit' class='button' value='{$Admin567}'>&nbsp;
        <input type='hidden' name='task' value='reset'>
        <input type='hidden' name='r' value='{$r}'>
        <input type='hidden' name='admin_id' value='{$admin_id}'>
        </form>
      </td>
      <td valign='top'>
        <form action='login.php' method='post'>
        <input type='submit' class='button' value='{$Admin568}'>
        </form>
      </td>
      </tr>
      </table>
    </td>
    </tr>
    </table>

  {else}
    {$Admin569}
  {/if}

  </td>
  </tr>
  </table>
</td>
</tr>
</table>

</body>
</html>
