{include file='Header.tpl'}
<div id="content">

    <div class="grey-head"><h2>{$Application178}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application179}</p>
    </div>





<br>

{* SHOW SUCCESS MESSAGE IF NO ERROR *}
{if $submitted == 1 AND $is_error == 0}
    <br/>
    <p style="color:#009900; padding-left:25px;">{$Application180}</p>
    <br/>  
{else}

  {if $is_error == 1}
  
    <br/>
    <p style="color:red; padding-left:25px;">{$Application181}</p>
    <br/>
  
  {/if}
 
  <form action='Lostpass.php' method='post' class="settings">
            <div><b>{$Application182}</b></div>
            <div class='form_desc'></div>
            <input style="width:235px; border:1px solid #CBD0D2;" type='text' class='text' name='user_email' size='30' maxlength='50'/>
            <br/><br/>
  
              <p class="line">&nbsp;</p>
            <div class="submits" style="margin-left:0px !important;">
                <label><input style="width:100px !important;" type="submit" value="{$Application183}"/></label>
                <label><input style="width:100px !important;" type="button" onclick="window.location.href='login.php'" value="{$Application184}"/></label>
                <input type='hidden' name='task' value='send_email'>
            </div>

  </form>
  </table>
  
  
    <div class="block-bot"><span>&nbsp;</span></div>
</div>

{/if}

{include file='Footer.tpl'}