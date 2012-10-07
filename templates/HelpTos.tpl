{include file='Header.tpl'}
<div id="content">
    {literal}
    <style type="text/css">
        .submit_button{
            background:transparent url(../images/link-btn.gif) no-repeat scroll 0 0;
            color:#FFFFFF;
            display:block;
            font-weight:bold;
            height:23px;
            line-height:23px;
            margin-top:10px;
            text-align:center;
            width:129px;
            text-decoration:none;
            margin-left:25px;
        }
    </style>
    {/literal}

    <div class="grey-head"><h2>{$Application122}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application122}</p>
    </div>

    <div class="layers">
        <ul class="list01">

            <li {if $page=='Help'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='Help.php'>{$Application119}</a>
            </li>
            
            <li {if $page=='HelpTos'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='HelpTos.php'>{$Application120}</a>
            </li>

            <li {if $page=='HelpContact'}class="ui-state-active ui-tabs-selected"{/if}>
                <a href='HelpContact.php'>{$Application121}</a>
            </li>
        </ul>

 

        <div id="primary" class="info-cnt tuneddivs">

            <p style="padding-left:25px">{$terms_of_service}</p>
            <br/>  <br/>  <br/>  

        </div>
  
    </div>
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>

{include file='Footer.tpl'}