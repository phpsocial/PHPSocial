{include file='AdminHeader.tpl'}

<h2>{$Admin310}</h2>
<p>{$Admin311}</p>

{* SHOW SUCCESS MESSAGE *}
{if $result != 0}
<p style="color:green;">{$Admin333}</p>
{/if}

{* JAVASCRIPT FOR ADDING FRIENDSHIP TYPES *}
{literal}
<script type="text/javascript">
    {/literal}
    <!-- Begin
    var friendtype_id = {$num_friendtypes};
    {literal}
    function addInput(fieldname) {
        var ni = document.getElementById(fieldname);
        var newdiv = document.createElement('div');
        var divIdName = 'my'+friendtype_id+'Div';
        newdiv.setAttribute('id',divIdName);
        newdiv.innerHTML = "<input type='text' name='friendtype_label" + friendtype_id +"' class='text' size='30' maxlength='50'>&nbsp;<br>";
        ni.appendChild(newdiv);
        friendtype_id++;
        window.document.info.num_friendtypes.value=friendtype_id;
    }
    // End -->
</script>
{/literal}


<form action='AdminConnections.php' method='POST' name='info'>
    <div class="row">
        <h2>{$Admin312}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin312}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='setting_connection_allow' id='invitation_0' value='0'{if $invitation == 0} CHECKED{/if}/><label for='invitation_0'> <b>{$Admin317}</b><br/>{$Admin313}</label></p><br/>
                <p><input type='radio' name='setting_connection_allow' id='invitation_3' value='3'{if $invitation == 3} CHECKED{/if}/><label for='invitation_3'> <b>{$Admin318}</b><br/>{$Admin314}</label></p><br/>
                <p><input type='radio' name='setting_connection_allow' id='invitation_2' value='2'{if $invitation == 2} CHECKED{/if}/><label for='invitation_2'> <b>{$Admin319}</b><br/>{$Admin315}</label></p><br/>
                <p><input type='radio' name='setting_connection_allow' id='invitation_1' value='1'{if $invitation == 1} CHECKED{/if}/><label for='invitation_1'> <b>{$Admin320}</b><br/>{$Admin316}</label></p><br/>
                <br/>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin313}</p>
    </div>

    <div class="row">
        <h2>{$Admin321}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin321}</h3></div>
            <div class="block-in">
                <p>
                    <input type='radio' name='setting_connection_framework' id='framework_0' value='0'{if $framework == 0} CHECKED{/if}/>
                           <label for='framework_0'><b>{$Admin323}</b><br/>{$Admin324}</label>
                </p>
                    <br/>
                <p>
                    <input type='radio' name='setting_connection_framework' id='framework_1' value='1'{if $framework == 1} CHECKED{/if}/>
                           <label for='framework_1'><b>{$Admin325}</b><br>{$Admin328}</label>
                </p>
                    <br/>
                <p>
                    <input type='radio' name='setting_connection_framework' id='framework_2' value='2'{if $framework == 2} CHECKED{/if}/>
                           <label for='framework_2'><b>{$Admin326}</b><br>{$Admin329}</label>
                </p>
                    <br/>
                <p>
                    <input type='radio' name='setting_connection_framework' id='framework_3' value='3'{if $framework == 3} CHECKED{/if}/>
                           <label for='framework_3'><b>{$Admin327}</b><br>{$Admin330}</label>
                </p>
                <br/>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin322}</p>
    </div>

    <div class="row" style="border:none;">
        <h2>{$Admin334}</h2>
        <p>{$Admin335}</p>
        <br/>
        <div class="block">
            <div class="block-head"><h3>{$Admin336}</h3></div>
            <div class="block-in">
                {section name=type_loop loop=$types}
                <p>
                    <input type='text' class='text' name='friendtype_label{$types[type_loop].friendtype_id}' value='{$types[type_loop].friendtype_label}' size='30' maxlength='50'/>
                </p>
                {/section}
                <input type='hidden' name='num_friendtypes' value='{$num_friendtypes}'>
                <p id='newtype'></p>
                <p><a href="javascript:addInput('newtype')" style="color:white;">{$Admin337}</a></p>
                <p></p>

            </div>
            <div class="block-b">&nbsp;</div>
        </div>

        <div class="block">
            <div class="block-head"><h3>{$Admin338}</h3></div>
            <div class="block-in">
                <p>
                    <input type='radio' name='setting_connection_other' id='other_1' value='1'{if $other == 1} CHECKED{/if}/>
                           <label for='other_1'>{$Admin339}</label>
                </p>
                <p>
                    <input type='radio' name='setting_connection_other' id='other_0' value='0'{if $other == 0} CHECKED{/if}/>
                           <label for='other_0'>{$Admin340}</label>
                </p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
    </div>

    <div class="row" style="border:none; margin-bottom:0px;">
        <div class="block">
            <div class="block-head"><h3>{$Admin341}</h3></div>
            <div class="block-in">
                <p>
                    <input type='radio' name='setting_connection_explain' id='explain_1' value='1'{if $explain == 1} CHECKED{/if}/>
                           <label for='explain_1'>{$Admin342}</label>
                </p>
                <p>
                    <input type='radio' name='setting_connection_explain' id='explain_0' value='0'{if $explain == 0} CHECKED{/if}/>
                           <label for='explain_0'>{$Admin343}</label>
                </p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
    </div>
    
    <div style="padding-left:20px;"><label class="button"><input type='submit' value='{$Admin332}'/></label></div>
    <input type='hidden' name='task' value='dosave'>
</form>
{include file='AdminFooter.tpl'}