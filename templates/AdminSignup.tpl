{include file='AdminHeader.tpl'}

<h2>{$Admin706}</h2>
<p>{$Admin707}</p>


{if $result != 0}
<br>
<p style="color:green;">{$Admin740}</p>
{/if}
<form action='AdminSignup.php' method='POST'>
    
    {section name=tab_loop loop=$tabs}

    {if $smarty.section.tab_loop.first}<div class="row" {if !$smarty.section.tab_loop.last}style="border:none;"{/if}>{/if}
         {if $smarty.section.tab_loop.first}
            <h2>{$Admin708}</h2>
            <p>{$Admin709}</p>
            <br/>
         {/if}
         <div class="block">
            <div class="block-head"><h3>{$tabs[tab_loop].tab_name}</h3></div>
            <div class="block-in">
                {section name=field_loop loop=$tabs[tab_loop].tab_fields}
                <p>
                    <input type='checkbox' name='field_signup_{$tabs[tab_loop].tab_fields[field_loop].field_id}' id='field_signup_{$tabs[tab_loop].tab_fields[field_loop].field_id}' value='1'{if $tabs[tab_loop].tab_fields[field_loop].field_signup == 1} CHECKED{/if}/> <label></label>
                    <label for='field_signup_{$tabs[tab_loop].tab_fields[field_loop].field_id}'>{$tabs[tab_loop].tab_fields[field_loop].field_title}</label>
                </p>
                {/section}
                <br/>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
       
    {if $smarty.section.tab_loop.iteration%2==0 || $smarty.section.tab_loop.last}</div>{/if}
    {if $smarty.section.tab_loop.iteration%2==0 && !$smarty.section.tab_loop.last}<div class="row" {if !$smarty.section.tab_loop.last}style="border:none;"{/if}>{/if}
    {if $smarty.section.tab_loop.last}<p class="line">&nbsp;</p>{/if}
    {/section}

    <div class="row">
        <h2>{$Admin1032}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin1032}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='phone' id='phone_1' value='1'{if $phone == 1} CHECKED{/if}/><label for='phone_1'> {$Admin1029}</label></p>
                <p><input type='radio' name='phone' id='phone_0' value='0'{if $phone == 0} CHECKED{/if}/><label for='phone_0'> {$Admin1030}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin1031}</p>
    </div>

    <div class="row">
        <h2>{$Admin713}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin713}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='photo' id='photo_1' value='1'{if $photo == 1} CHECKED{/if}/><label for='photo_1'> {$Admin742}</label></p>
                <p><input type='radio' name='photo' id='photo_0' value='0'{if $photo == 0} CHECKED{/if}/><label for='photo_0'> {$Admin743}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin741}</p>
    </div>

    <div class="row">
        <h2>{$Admin748}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin748}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='enable' id='enable_1' value='1'{if $enable == 1} CHECKED{/if}/><label for='enable_1'> {$Admin750}</label></p>
                <p><input type='radio' name='enable' id='enable_0' value='0'{if $enable == 0} CHECKED{/if}/><label for='enable_0'> {$Admin751}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin749}</p>
    </div>

    <div class="row">
        <h2>{$Admin744}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin744}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='welcome' id='welcome_1' value='1'{if $welcome == 1} CHECKED{/if}/><label for='welcome_1'> {$Admin746}</label></p>
                <p><input type='radio' name='welcome' id='welcome_0' value='0'{if $welcome == 0} CHECKED{/if}/><label for='welcome_0'> {$Admin747}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin745}</p>
    </div>

    <div class="row" style="border-bottom:none;">
        <h2>{$Admin714}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin1033}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='invite' id='invite_2' value='2'{if $invite == 2} CHECKED{/if}/><label for='invite_2'> {$Admin716}</label></p>
                <p><input type='radio' name='invite' id='invite_1' value='1'{if $invite == 1} CHECKED{/if}/><label for='invite_1'> {$Admin717}</label></p>
                <p><input type='radio' name='invite' id='invite_0' value='0'{if $invite == 0} CHECKED{/if}/><label for='invite_0'> {$Admin718}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin715}</p>
    </div>

    <div class="row" style="border-bottom:none;">
        <div class="block">
            <div class="block-head"><h3>{$Admin1034}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='invite_checkemail' id='invite_checkemail_1' value='1'{if $invite_checkemail == 1} CHECKED{/if}/><label for='invite_checkemail_1'> {$Admin753}</label></p>
                <p><input type='radio' name='invite_checkemail' id='invite_checkemail_0' value='0'{if $invite_checkemail == 0} CHECKED{/if}/><label for='invite_checkemail_0'> {$Admin754}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin752}</p>
    </div>

    <div class="row">
        <div class="block">
            <div class="block-head"><h3>How many invites do users get when they signup?</h3></div>
            <div class="block-in">
                <p><input type='text' name='invite_numgiven' size='2' maxlength='3' class='text' value='{$invite_numgiven}'/><label>&nbsp;{$Admin712}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin711}</p>
    </div>

    <div class="row">
        <h2>{$Admin719}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin719}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='invitepage' id='invitepage_1' value='1'{if $invitepage == 1} CHECKED{/if}/><label for='invitepage_1'> {$Admin721}</label></p>
                <p><input type='radio' name='invitepage' id='invitepage_0' value='0'{if $invitepage == 0} CHECKED{/if}/><label for='invitepage_0'> {$Admin722}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin720}</p>
    </div>

    <div class="row">
        <h2>{$Admin723}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin723}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='verify' id='verify_1' value='1'{if $verify == 1} CHECKED{/if}/><label for='verify_1'> {$Admin725}</label></p>
                <p><input type='radio' name='verify' id='verify_0' value='0'{if $verify == 0} CHECKED{/if}/><label for='verify_0'> {$Admin726}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin724}</p>
    </div>


    <div class="row">
        <h2>{$Admin727}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin727}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='code' id='code_1' value='1'{if $code == 1} CHECKED{/if}/><label for='code_1'>{$Admin729}</label></p>
                <p><input type='radio' name='code' id='code_0' value='0'{if $code == 0} CHECKED{/if}/><label for='code_0'>{$Admin730}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin728}</p>
    </div>

    <div class="row">
        <h2>{$Admin731}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin731}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='randpass' id='randpass_1' value='1'{if $randpass == 1} CHECKED{/if}/><label for='randpass_1'> {$Admin733}</label></p>
                <p><input type='radio' name='randpass' id='randpass_0' value='0'{if $randpass == 0} CHECKED{/if}/><label for='randpass_0'> {$Admin734}</label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin732}</p>
    </div>

    <div class="row" style="border-bottom:none; margin-bottom:0px;">
        <h2>{$Admin735}</h2>
        <div class="block">
            <div class="block-head"><h3>{$Admin735}</h3></div>
            <div class="block-in">
                <p><input type='radio' name='tos' id='tos_1' value='1'{if $tos == 1} CHECKED{/if}/><label for='tos_1'> {$Admin737}</label></p>
                <p><input type='radio' name='tos' id='tos_0' value='0'{if $tos == 0} CHECKED{/if}/><label for='tos_0'> {$Admin738}</label></p>
                <p><label><textarea name='tostext'>{$tostext}</textarea></label></p>
            </div>
            <div class="block-b">&nbsp;</div>
        </div>
        <p>{$Admin736}</p>
    </div>
   
    <div style="padding-left:20px;"><label class="button"><input type='submit' value='{$Admin739}'/></label></div>
    <input type='hidden' name='task' value='dosave'>
</form>


{include file='AdminFooter.tpl'}