{include file='Header.tpl'}
 <div id="content">
 <div class="grey-head">
	 <h2>
		 {$Application733}
	 </h2>
 </div>
 <div class="layers">
     <div class="album-padding">
		<p>{$Application734}</p>
		
		{* SHOW RETURN BUTTON IF URL IS SET *}
		{if $return_url != ""}
		  <br>
		  <form action='{$return_url}' method='POST'>
		  <input type='submit' class='submit_button_uf2' value='{$Application735}'>
		  </form>
		{/if}

     </div>
    </div>
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>
{include file='Footer.tpl'}