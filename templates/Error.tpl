{include file='Header.tpl'}

<div id="content">
    <div class="grey-head"><h2>{$error_header}</h2></div>
    <div class="row-blue">
        <p class="blue">{$error_message}</p>
    </div>

    
    <br/><br/>
    <a style="padding-left: 20px;" href="javascript:void(0)" onClick='history.go(-1)'>{$error_submit}</a>
    <br/><br/>

    <div class="block-bot"><span></span></div>
</div>


{include file='Footer.tpl'}