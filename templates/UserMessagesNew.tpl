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

    {* VALIDATION *}
    {literal}
    <script language='Javascript'>
        <!--

        var default_target;
        var default_task;
        var last_to_field = '';

        var in_validation = false;
        var pause_validation = false;
        var validation_result = false;

        function send_validation()
        {
            if( default_target!=document.message_form.target && !typeof(default_target)=="undefined" ) return;
            in_validation = true;

            default_target = document.message_form.target;
            default_task = document.message_form.task.value;

            document.message_form.target = 'validation_frame';
            document.message_form.task.value = 'validate';

            document.message_form.submit();
        }

        function recv_validation(result, message)
        {
            if( default_target==document.message_form.target ) return;

            document.message_form.target = default_target;
            document.message_form.task.value = default_task;

            if( result=='0' )
            {
                showdiv('errordiv');
                document.getElementById('errormessagediv').innerHTML = message;
                validation_result = false;
            }
            else
            {
                hidediv('errordiv');
                validation_result = true;
            }
        }






        // Modified suggest script
        function multisuggest(fieldname, divname, match_string)
        {
            var keyword_string_raw = document.getElementById(fieldname).value;
            var keyword_string = keyword_string_raw.toLowerCase();

            var keyword_array_raw = keyword_string_raw.split(/[\s;,]+/ig);
            var keyword_array = keyword_string.split(/[\s;,]+/ig);

            var match_array = match_string.split(/[\s;,]+/ig);

            var result_count = 0;
            var suggestion_list_html = "";

            var keyword_index;
            var username_index;

            //alert(keyword_array_raw.join("&&"));

            for(keyword_index in keyword_array)
            {
                if( keyword_array[keyword_index]=="" || typeof(keyword_array[keyword_index])=="undefined" ) continue;

                for(match_index in match_array)
                {
                    var match_item = match_array[match_index].toLowerCase();

                    if( match_item.indexOf(keyword_array[keyword_index])==-1 ) continue;

                    var match_regex = new RegExp("("+keyword_array[keyword_index]+")", "i");
                    var match_label = match_array[match_index].replace(match_regex, "<b>$1</b>");

                    suggestion_list_html +=
                        "<div class='suggest_item'>" +
                        "<a class='suggest' href=\"javascript:insertTo('" + fieldname + "', '" + divname + "', '" + keyword_index + "', '" + match_array[match_index] + "')\">" +
                        match_label +
                        "</a>" +
                        "</div>";

                    result_count++;
                }
            }

            if( result_count>0)
            {
                document.getElementById(divname).innerHTML = suggestion_list_html;
                document.getElementById(divname).style.display = "block";
            }
            else
            {
                document.getElementById(divname).innerHTML = "";
                document.getElementById(divname).style.display = "none";
            }
        }

        function insertTo(fieldname, divname, keyword_index, matched_string)
        {
            var keyword_string_raw = document.getElementById(fieldname).value;
            var keyword_array = keyword_string_raw.split(/[\s;,]+/ig);

            keyword_array[keyword_index] = matched_string;


            document.getElementById(fieldname).value = keyword_array.join('; ');
            document.getElementById(divname).style.display = "none";
        }




        function submit_validation()
        {
            if( validation_result==false || in_validation==true )
            {
                showdiv('errordiv');
                document.getElementById('errormessagediv').innerHTML = "{/literal}{$Application663}{literal}";
                return false;
            }

            else if( document.message_form.message.value=='' || typeof(document.message_form.message.value)=="undefined" )
            {
                showdiv('errordiv');
                document.getElementById('errormessagediv').innerHTML = "{/literal}{$Application664}{literal}";
                return false;
            }

            return true;
        }

        //-->
    </script>
    {/literal}


    <div class="grey-head"><h2>{$Application669}</h2></div>
    <div class="row-blue">
        <p class="blue">{$Application670}</p>
    </div>


    {* SHOW ERROR MESSAGE *}
    {if $is_error}
    <br/>
    <p align="center" style="color:red;">{$error_message}</p>
    <br/>
    {/if}

    {* VALIDATION IFRAME *}
    <iframe name="validation_frame" id="validation_frame" src="about:blank" style="display:none;" onload="in_validation=false;"></iframe>

    <div id="primary" class="info-cnt tuneddivs">
        <form action="UserMessagesNew.php" method="POST" name="message_form" onsubmit="return submit_validation();" class="settings" style="color:#666666;">

            <div><b>{$Application671}</b> <b><a href="{$url->url_create('profile',$user->user_info.user_username)}">{$user->user_info.user_username}</a></b></div>
            <br/>


            <div>
                <b>{$Application672} </b>
            </div>

             <div id="errordiv" style="display:none; color:red;" class="result">
                    <div class='error' id="errormessagediv" style="display:inline;"></div>
             </div>
            <div class='form_desc'></div>
            <input
                type='text'
                class='text'
                name='to'
                id='to'
                value='{$to}'
                tabindex='1'
                size='30'
                maxlength='50'
                autocomplete='off'
                onblur='setTimeout("send_validation();", 500);'
                onkeyup="multisuggest('to', 'suggest', '{section name=friends_loop loop=$friends}{$friends[friends_loop]->user_info.user_username}{if $smarty.section.friends_loop.last != true},{/if}{/section}');" style="border:1px solid #CBD0D2;"/>
            <br/><br/>

            {literal}
            <script language='Javascript'>
                <!--
                window.onload = document.getElementById('to').focus();
                //-->
            </script>
            {/literal}

            <div id="suggest" class='suggest'></div>

            <div><b>{$Application673}</b></div>
            <div class='form_desc'></div>
            <input type='text' class='text' name='subject' tabindex='2' value='{$subject}' size='30' maxlength='250' onfocus="hidediv('suggest');" style="border:1px solid #CBD0D2;"/>
            <br/><br/>

            <div><b>{$Application674}</b></div>
            <div class='form_desc'></div>
            <textarea style="border:1px solid #CBD0D2; width:600px;" rows="10" name='message'>{$message}</textarea>
            <br/><br/>

            <p class="line">&nbsp;</p>
            {assign var="redirect_page" value=$url->url_create('profile', $user->user_info.user_username)}

            <div class="f-left">
                <a class="button" href="javascript:void(0)" onclick="document.message_form.submit();"><span>{$Application675}</span></a>
                <a class="button" href="javascript:void(0)" onClick="history.go(-1)"><span>{$Application676}</span></a>

            </div>
            <input type='hidden' name='task' value='send'/>
            <input type='hidden' name='convo_id' value='{$convo_id}'/>

        </form>

    </div>

    <div class="block-bot"><span></span></div>
</div>
<div id="sidebar">
    {include file='MenuSidebar.tpl'}
</div>



{include file='Footer.tpl'}