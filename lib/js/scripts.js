$(function () {
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
        //console.log(empty);
        $textareas.each(function() {
            $(this).val($.trim($(this).val()));
            if($(this).val()==''){
                empty+=1;
            }
            values[this.name] = $(this).val();
        });
        //console.log(empty);
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
        //console.log(empty);
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

    $('.permissions_ask').click(function(e){
        e.preventDefault();
        var user=$('input[name="user"]').val();
        var owner=$('input[name="owner"]').val();
        var data = new FormData();
        data.append('type','ask');
        data.append('user',user);
        data.append('owner',owner);
        jQuery.ajax({
            url: 'gallery_permissions.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (data) {
                var resp=JSON.parse(data);
                if(resp.resp=='success'){
                    $('.private-gallery .panel-body .col-sm-8').append('<p class="alert-success alert">Wysłano prośbę o dostęp do galerii</p>')
                    $('.permissions_ask').remove();
                }
            }
        });
    });

    $('.lock').click(function () {
        $('.permissions_ask').trigger('click');
    });

    $('.permissions_answer button').click(function (e) {
        e.preventDefault();
        var parent=$(this).parent();
        var answer='no';
        if($(this).hasClass('btn-primary')){
            answer='yes';
        }
        var user=$(parent).children('input[name="user"]').val();
        var owner=$(parent).children('input[name="owner"]').val();
        var type=$(parent).children('input[name="type"]').val();
        var data = new FormData();
        data.append('type','answer');
        data.append('user',user);
        data.append('owner',owner);
        data.append('notif_type',type);
        data.append('answer',answer);
        jQuery.ajax({
            url: 'gallery_permissions.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (data) {
                var resp=JSON.parse(data);
                if(resp.resp=='success'){
                    var cont=$(parent).parent();
                    if(answer=='yes'){
                        var mess='Zaakceptowano prośbę użytkownika <a href="profile.php?name='+user+'" target="_blank">'+user+'</a> o dostęp do prywatnej galerii';
                    }else{
                        var mess='Odrzucono prośbę użytkownika <a href="profile.php?name='+user+'" target="_blank">'+user+'</a> o dostęp do prywatnej galerii';
                    }
                    $(cont).html(mess);
                    $(cont).append('<button type="button" class="close close-notif" data-dismiss="panel" data-notif="'+resp.id+'" aria-hidden="true">×</button>')
                }
            }
        });
    });
    $('div.notification').on('click','.close.close-notif',function () {
        var notif=$(this).attr('data-notif');
        var parent=$(this).parent().parent();
        var not_cont=$(parent).parent().attr('id');
        var data = new FormData();
        data.append('type','delete');
        data.append('notif',notif);
        jQuery.ajax({
            url: 'gallery_permissions.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (data) {
                var resp=JSON.parse(data);
                if(resp.resp=='success'){
                   $(parent).remove();
                    if($('#'+not_cont+' .notification-panel').length==0){
                        $('#'+not_cont).append('<p>Brak powiadomień</p>');
                    }
                }
            }
        });
    });
    $('.notification.user').click(function () {
        jQuery.ajax({
            url:'my_profile.php?action=notifications',
            method: 'POST',
            type: 'POST'
        });
    });
    $('.pay_checkout button').click(function () {
        var cookie=$('#cookie').val();
        var user=$('#user').val();
        var action='check_payment';
        $.ajax({
            url:"ajax/vip_pay.php",
            type:"POST",
            data: {user:user,cookie:cookie,action:action},
            success:function(result) {
                console.log(result);
            }

        });
    });
    $('.actions').on('click','span',function () {
        var user=$('.user_name a').text();
        var who=$('#user_name').val();
        var span=$(this);
        var action=span.attr('class').split(' ')[0];
        var what;
        if(span.hasClass('on')){
            what='remove';
        }else{
            what='add';
        }
        $.ajax({
            url:"ajax/api.php",
            type:"POST",
            data: {user:user,user2:who,what:what,action:action},
            success:function(result) {
                var resp=JSON.parse(result);
                if(resp.resp=='success'){
                    if(what=='add'){
                        $(span).addClass('on');
                        if(action=='favourite'){
                            $(span).prop('title','Usuń z ulubionych');
                        }else{
                            $(span).prop('title','Odblokuj użytkownika');
                        }
                    }else{
                        $(span).removeClass('on');
                        if(action=='favourite'){
                            $(span).prop('title','Dodaj do ulubionych');
                        }else{
                            $(span).prop('title','Zablokuj użytkownika');
                        }
                    }
                }else{
                    alert('Wystąpił nieoczekiwany błąd, spróbuj ponownie');
                }
            }

        });
    });
});