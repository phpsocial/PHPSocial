{include file='Header.tpl'}
 <div id="content">
 <div class="grey-head">
	 <h2>
		 {$Application720}
	 </h2>
 </div>
 <div class="layers">
     <div class="album-padding">

		<p>{$Application721}</p>
		
		<form action='UserReport.php' method='POST'>
		
		<div><b>{$Application722}</b></div>
		
		<table cellpadding='0' cellspacing='0'>
		<tr>
		<td>&nbsp;<input type='radio' name='report_reason' id='report_type1' value='1' checked='checked'></td>
		<td><label for='report_type1'>{$Application723}</td>
		</tr>
		<tr>
		<td>&nbsp;<input type='radio' name='report_reason' id='report_type2' value='2'></td>
		<td><label for='report_type2'>{$Application724}</td>
		</tr>
		<tr>
		<td>&nbsp;<input type='radio' name='report_reason' id='report_type3' value='3'></td>
		<td><label for='report_type3'>{$Application725}</td>
		</tr>
		<tr>
		<td>&nbsp;<input type='radio' name='report_reason' id='report_type0' value='0'></td>
		<td><label for='report_type0'>{$Application726}</td>
		</tr>
		</table>
		
		<br>
		
		<div><b>{$Application727}</b></div>
		<textarea name='report_details' rows='5' cols='70'></textarea>
		
		<br><br>
		
		<table cellpadding='0' cellspacing='0'>
		<tr>
		<td>
		  <input type='submit' class='submit_button_uf2' value='{$Application728}'>&nbsp;
		  <input type='hidden' name='task' value='dosend'>
		  <input type='hidden' name='return_url' value='{$return_url}'>
		  </form>
		</td>
		<td>
		  <form action='{$return_url}' method='POST'>
		  <input type='submit' class='submit_button_uf2' value='{$Application729}'>
		  </form>
		</td>
		</tr>
		</table>

     </div>
    </div>
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>
{include file='Footer.tpl'}