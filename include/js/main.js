// accordion etc
function initAccordion(){
    if(!$.ui || typeof($.ui.accordion)!= 'function') return false;
    $('ul.accordion').each(function(){
        var _accordion = $(this);
        var _opener = $('.opener',_accordion);
        _opener.click(function(){
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                var _ths = $(this);
                $(this).parents('li').find('.slide').slideUp(400,function(){
                    _ths.parents('li').removeClass('active');
                });
            }else{
                $(this).addClass('active');
                $(this).parents('li').addClass('active');
                $(this).parents('li').find('.slide').slideDown(400);
            }
            return false;
        });
    });
    $('div.nav').hover(function(){},function(){
        $('ul.accordion').accordion( 'activate' , false );
    });
    $('.centr-nav ul li a').hover(
    function(){
        $(this).parent().addClass('right-bg-hover');
        $(this).parent().parent().addClass('left-bg-hover');
    },
    function(){
        $(this).parent().removeClass('right-bg-hover');
        $(this).parent().parent().removeClass('left-bg-hover');
    });
    $('.nav ul li').hover(
    function(){
        $(this).addClass('nav-li-hover');
    },
    function(){
        $(this).removeClass('nav-li-hover');
    });
    $('.nav ul li.first').hover(
    function(){
        $(this).addClass('first-hover');
    },
    function(){
        $(this).removeClass('first-hover');
    });
    $('.nav ul li.last').hover(
    function(){
        $(this).addClass('last-hover');
    },
    function(){
        $(this).removeClass('last-hover');
    });
    $('.nav ul .slide ul li').hover(
    function(){
        $(this).addClass('sub-hover');
    },
    function(){
        $(this).removeClass('sub-hover');
    });    
}
// header search functionality
function initHeaderSrc() {
    var _hideSrcTime = 1200;
    var _bgSrc = $('div#qfriends');
    var _bgSrcLink = _bgSrc.find('a');
    var _bgSrcInput = _bgSrc.find('input');
    var _srcHide = false;
    var _srcDrop = $('ul.src-cats');
    _bgSrcInput.each(function(){
        $(this).attr('placeholder',$(this).val());
        $(this).focus(function(){
            if($(this).val()==$(this).attr('placeholder')) $(this).val('');
            $(this).addClass('focused');
        }).blur(function(){
            _srcHide = setTimeout(function(){
                $(this).removeClass('focused');
                _srcDrop.hide();
                _bgSrc.hide();
                if($(this).val()=='') {
                    $(this).val($(this).attr('placeholder'));
                }
            },100);
        });
    });
    _bgSrcLink.click(function(){
        if(_srcHide) {
            clearTimeout(_srcHide);
            _srcHide = false;
        }
        _srcDrop.show();
        if(_bgSrcInput.val()==_bgSrcInput.attr('placeholder')) _bgSrcInput.val('');
        _bgSrcInput.addClass('focused').focus();
        return false;
    });
    var _srcInput = $('#qinput');
    _srcInput.click(function(){
        _srcDrop.show();
        _bgSrc.show();
        if(_bgSrcInput.val()==_bgSrcInput.attr('placeholder')) _bgSrcInput.val('');
        _bgSrcInput.addClass('focused').focus();
    });
    var _srcDropLink = _srcDrop.find('a');
    _srcDropLink.click(function(){
        if(_srcHide) {
            clearTimeout(_srcHide);
            _srcHide = false;
        }
        _srcDropLink.removeClass('active');
        $(this).addClass('active');
        $('#t').val($(this).attr('alt'));
        _srcDrop.hide();
        _bgSrcLink.text($(this).text());
        _bgSrcInput.addClass('focused').focus();
        return false;
    });
}
function initTabs(){
    if(!$.ui || typeof($.ui.tabs)!= 'function') return false;
    $('div.content-tabs').tabs({
        fx:{
            opacity: 'toggle'
        }
    });
}
function initContactInfo(){
    var _editLink = $('a.edit-info');
    var _editParent = 'h3';
    var _editNghbr = 'dl';
    var _editNghbrEl = 'dd';
    _editLink.click(function(){
        $(this).parents(_editParent).next(_editNghbr).find(_editNghbrEl).each(function(){
            $(this).addClass('edit-field');
            initEF();
        });
        return false;
    });
    function initEF(){
        $('.edit-field').each(function(){
            var _bTime = false;
            var _ajaxL = $('<div class="ajax-loading">Loading...</div>');
            $(this).find('select').change(function(){
                $(this).keydown(function(e){
                    if(e.keyCode==13){
                        $('.edit-btn').css("display", "block");
                        $('.save-btn').css("display", "none");
                        if($('.save-btn').parents('dd.edit-field').length==0) {
                            $('#content ul.accordion dd').removeClass('edit-field');
                        }
                    }
                });
                $(this).parents('dd.edit-field').find('.field-val').text($(this).find('option').filter(':selected').html());
                $.ajax({
                  type: "GET",
                  url: "Profile.php?user=" + document.getElementById("status_username").value + "&task=profile&field=" + $(this).parents('dd.edit-field').find('.field-val').attr('id') + "&value=" + $(this).val(),
                  dataType: "script"
                });
            });           
            $(this).find('input').each(function(){
                $(this).attr('_placeholder',$(this).val());
                $(this).keyup(function(){
                    //$(this).parents('dd.edit-field').find('.field-val').text($(this).val()+' xxx ');
                    $(this).parents('dd.edit-field').find('.field-val').text($(this).val());
                }).blur(function(){
                    if($(this).val()!=$(this).attr('_placeholder')){
                        $(this).attr('_placeholder',$(this).val());
                        $.ajax({
                          type: "GET",
                          url: "Profile.php?user=" + document.getElementById("status_username").value + "&task=profile&field=" + $(this).parents('dd.edit-field').find('.field-val').attr('id') + "&value=" + $(this).parents('dd.edit-field').find('.field-val').text(),
                          dataType: "script"
                        });
                    }
                }).keydown(function(e){
                    if(e.keyCode==13){
                        $('.edit-btn').css("display", "block");
                        $('.save-btn').css("display", "none");
                        $(this).blur();
                        if($('.save-btn').parents('dd.edit-field').length==0) {
                            $('#content ul.accordion dd').removeClass('edit-field');
                        }
                    }
                });
            });
            $(this).find('input.radio').change(function(){
               
                $(this).keydown(function(e){
                    if(e.keyCode==13){
                        $('.edit-btn').css("display", "block");
                        $('.save-btn').css("display", "none");
                        if($('.save-btn').parents('dd.edit-field').length==0) {
                            $('#content ul.accordion dd').removeClass('edit-field');
                        }
                    }
                });
                var radio_value = $('#field_'+$(this).parents('dd.edit-field').find('.field-val').attr('id')+'_label_'+$(this).val()).html();
                $(this).parents('dd.edit-field').find('.field-val').text(radio_value);
                $.ajax({
                  type: "GET",
                  url: "Profile.php?user=" + document.getElementById("status_username").value + "&task=profile&field=" + $(this).parents('dd.edit-field').find('.field-val').attr('id') + "&value=" + $(this).val(),
                  dataType: "script"
                });
            });              
            $(this).find('textarea').each(function(){
                $(this).attr('_placeholder',$(this).val());
                $(this).keyup(function(){
                    $(this).parents('dd.edit-field').find('.field-val').text($(this).val());
                }).blur(function(){
                    if($(this).val()!=$(this).attr('_placeholder')){
                        $(this).attr('_placeholder',$(this).val());
                        $.ajax({
                          type: "GET",
                          url: "Profile.php?user=" + document.getElementById("status_username").value + "&task=profile&field=" + $(this).parents('dd.edit-field').find('.field-val').attr('id') + "&value=" + $(this).parents('dd.edit-field').find('.field-val').text(),
                          dataType: "script"
                        });
                    }
                });
            });
            $(document).click(function(e){
                if($(e.target).parents('dd.edit-field').length==0) {
                    $('.edit-btn').css("display", "block");
                    $('.save-btn').css("display", "none");
                    $('#content ul.accordion dd').removeClass('edit-field');
                }
            });
            $('.edit-btn').css("display", "none");
            $('.save-btn').css("display", "block");
            $('.save-btn').click(function(e){
                $('.edit-btn').css("display", "block");
                $('.save-btn').css("display", "none");
                if($(e.target).parents('dd.edit-field').length==0) {
                    $('#content ul.accordion dd').removeClass('edit-field');
                }
            });
        });
    }
    var _statusLink = $('a.set-status');
    var _statusParent = 'h3';
    _statusLink.click(function(){
        $(this).parents('h3.stat').addClass('edit-status-active');
        $(this).parents('h3.stat').find('input').select();
        return false;
    });
    $('h3.stat span.status-text').click(function(){
        $(this).parents('h3.stat').addClass('edit-status-active');
        $(this).parents('h3.stat').find('input').select();
    });
    $('h3.stat').find('input').each(function(){
        $(this).attr('_placeholder',$(this).val());
        $(this).keyup(function(){
            $(this).parents('h3.stat').find('span.status-text').text($(this).val());
        }).blur(function(){
            $('h3.stat').removeClass('edit-status-active');
            if($(this).val()!=$(this).attr('_placeholder')){
                $(this).attr('_placeholder',$(this).val());
                $.ajax({
                  type: "GET",
                  url: "Profile.php?user=" + document.getElementById("status_username").value + "&task=status&status=" + $(this).val(),
                  dataType: "script"
                });
            }
        }).keydown(function(e){
            if(e.keyCode==13){
                $('h3.stat').removeClass('edit-status-active');
                if($(this).val()!=$(this).attr('_placeholder')){
                    $(this).attr('_placeholder',$(this).val());
                    $.ajax({
                      type: "GET",
                      url: "Profile.php?user=" + document.getElementById("status_username").value + "&task=status&status=" + $(this).val(),
                      dataType: "script"
                    });
                }
            }
        });
    });
}
function initWall(){
    $('a.leave-msg-link').click(function(){
        $(this).parents('div.slide').find('div.leave-msg-box').slideToggle(300);
        return false;
    });
    $('a.oth-func-link').click(function(){
        $(this).parents('div.slide').find('div.oth-func-box').slideToggle(300);
        return false;
    });
    $('.oth-func-box .sl a').click(function(){
        var _class = $(this).attr('href').replace('#','');
        $('div.func-box').slideUp(0);
        if(_class){
            $(this).parents('div.slide').find('div.'+_class).slideToggle(300);
        }
        return false;
    });
}
$(function(){
    initAccordion();
    initHeaderSrc(); // header search functionality
    initTabs(); // content tabs
    initContactInfo(); // contact information editor
    initWall();
});


function getData(el, url) {
    $(el).html('<div style="padding-left: 30px">loading...</div>');
    $.ajax({
      type: "GET",
      url: url,
      data: "ajax_call=1",
      cache: false,
      success: function(html){
        $(el).html(html);
      }
    });
}

function setActiveLi(el) {
    $('#li1').removeClass('ui-state-active');
    $('#li1').removeClass('ui-tabs-selected');
    $('#li2').removeClass('ui-state-active');
    $('#li2').removeClass('ui-tabs-selected');
    $('#li3').removeClass('ui-state-active');
    $('#li3').removeClass('ui-tabs-selected');
    $('#li' + el).addClass('ui-state-active');
    $('#li' + el).addClass('ui-tabs-selected');

}