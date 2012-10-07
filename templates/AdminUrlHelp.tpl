{include file='AdminHeader.tpl'}

<h2>{$Admin885}</h2>
<p>{$Admin886}</p>
{literal}
<style type="text/css">
    .input-border{
        border-color:#CBD0D2;
        border-style:solid;
        border-width:1px;
    }
</style>
{/literal}

<form action='AdminUrl.php' method='POST'>
<textarea class="input-border" wrap='off' rows='25' cols='60' style='font-family: "Courier New", verdana, arial; width: 100%;'>{$htaccess}</textarea>

<br>

</form>

{include file='AdminFooter.tpl'}