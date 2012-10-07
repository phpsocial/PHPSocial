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
    {literal}
    <script language="javascript">
        <!--
        function showhide(id1) {
            if(document.getElementById(id1).style.display=='none') {
                document.getElementById(id1).style.display='block';
            } else {
                document.getElementById(id1).style.display='none';
            }
        }
        // -->
    </script>
    {/literal}

    <div class="grey-head"><h2>{$Application74}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application75}</p>
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


        <div id="primary" class="info-cnt tuneddivs" style="padding-left:25px; color:#666666;">
            
            <div class='header'>{$Application76}</div>
            <div class='faq_questions'>
                <a href="javascript:void(0);" onClick="showhide('1');">{$Application77}</a><br>
                <div class='faq' style='display: none;' id='1'>{$Application78}</div>
                <a href="javascript:void(0);" onClick="showhide('2');">{$Application79}</a><br>
                <div class='faq' style='display: none;' id='2'>{$Application80}</div>
                <a href="javascript:void(0);" onClick="showhide('3');">{$Application81}</a><br>
                <div class='faq' style='display: none;' id='3'>{$Application82}</div>
                <a href="javascript:void(0);" onClick="showhide('4');">{$Application83}</a><br>
                <div class='faq' style='display: none;' id='4'>{$Application84}</div>
                <a href="javascript:void(0);" onClick="showhide('5');">{$Application85}</a><br>
                <div class='faq' style='display: none;' id='5'>{$Application86}</div>
            </div>

            <br/>

            <div class='header'>{$Application87}</div>
            <div class='faq_questions'>
                <a href="javascript:void(0);" onClick="showhide('6');">{$Application88}</a><br>
                <div class='faq' style='display: none;' id='6'>{$Application89}</div>
                <a href="javascript:void(0);" onClick="showhide('7');">{$Application90}</a><br>
                <div class='faq' style='display: none;' id='7'>{$Application91}</div>
            </div>

            <br/>

            <div class='header'>{$Application92}</div>
            <div class='faq_questions'>
                <a href="javascript:void(0);" onClick="showhide('9');">{$Application93}</a><br>
                <div class='faq' style='display: none;' id='9'>{$Application94}</div>
                <a href="javascript:void(0);" onClick="showhide('10');">{$Application95}</a><br>
                <div class='faq' style='display: none;' id='10'>{$Application96}</div>
                <a href="javascript:void(0);" onClick="showhide('11');">{$Application97}</a><br>
                <div class='faq' style='display: none;' id='11'>{$Application98}</div>
            </div>

            <br/><br/>
        </div>
    </div>
    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>



{include file='Footer.tpl'}