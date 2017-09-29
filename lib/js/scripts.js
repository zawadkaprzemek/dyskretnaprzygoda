$(document).ready(function () {
    $("form").submit(function(){
        var $inputs = $('#'+$(this).attr('id')+' :input[type="text"]');
        var $textareas=$('#'+$(this).attr('id')+' textarea');
        var $files=$('#'+$(this).attr('id')+' :input[type="file"]');
        var empty = 0;
        var values = {};
        $inputs.each(function() {
            $(this).val($.trim($(this).val()));
            if($(this).val()==''){
                empty+=1;
            }
            values[this.name] = $(this).val();
        });
        console.log(empty);
        $textareas.each(function() {
            $(this).val($.trim($(this).val()));
            if($(this).val()==''){
                empty+=1;
            }
            values[this.name] = $(this).val();
        });
        console.log(empty);
        $files.each(function() {
            if($(this).val()!=''){
                if($('#avatar').val()==''){
                    empty+=1;
                    $('#btnCrop').addClass('btn-danger');
                }else{
                    $('#btnCrop').removeClass('btn-danger');
                }
            }
            values[this.name] = $(this).val();
        });
        console.log(empty);
        if(empty!=0){
            return false;
        }

    });
    $("textarea[name='message']").keypress(function (e) {
        if(e.which == 13) {
            if(!e.shiftKey){
                $(this).closest("form").submit();
                $(this).css({height:'30px'});
                e.preventDefault();
                return false;
            }else{
                if($(this).outerHeight()<'70'){
                    var nheight=$(this).outerHeight()+20;
                    $(this).css({height:''+nheight+ 'px'});
                }
            }

        }
    });
    $('#chat .panel-body').scrollTop($('.chat').height());
    $('#message-input').focus();
});