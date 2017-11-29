$(function () {

    function jednostki(howmany){
        var jed='';
        if(howmany==1){
            jed='zdjęcie';
        }else{
            howmany=howmany.toString();
            var l=howmany.length;
            if((howmany.charAt((l-1))>1)&&(howmany.charAt((l-1))<5)){
                if((l==2)&&(howmany.charAt(0))==1){
                    jed='zdjęć';
                }else{
                    jed='zdjęcia';
                }
            }else{
                jed='zdjęć';
            }
        }
        return howmany+' '+jed;
    }

    $('#addfiles').change(function (e) {
        if(this.files.length>20){
            alert('Wybrano za dużą ilość plików, maksymalnie możesz przesłać 20 plików');
        }else{
            var data = new FormData();
            data.append('gallery',$('input[name="gallery"]:checked').val());
            data.append('method',$('input[name="method"]').val());
            data.append('user',$('input[name="user"]').val());
            jQuery.each(jQuery(this)[0].files, function(i, file) {
                data.append('files[]', file);
            });
            $('.loading').show();
            jQuery.ajax({
                url: 'upload_photos.php',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    var resp=JSON.parse(data);
                    var href=$("#fileupload").attr('action');
                    var arr = href.split('/');
                    var php=arr[arr.length-1].split('?');
                    if(php.length==1){
                        href+='?';
                    }else{
                        href+='&';
                    }
                    href+='success='+parseInt(resp.success);
                    if(parseInt(resp.fail)>0){
                        href+='&fail='+parseInt(resp.success);
                    }
                    $('.loading').hide();
                    window.location.href =href;
                }
            });
        }

    });
    $('.private-gallery').on('click','label',function(){
        $('#private').attr('checked',true);
    });
    $('.galleries .delete').click(function (event) {
       event.preventDefault();
        var parent=$(this).parent();
        var link=$(parent).children()[0];
        var gallery_div=$(this).parent().parent().parent().attr('class');
        var gallery='';
        if(gallery_div=='public-gallery'){
            gallery='public';
        }else{
            gallery='private';
        }
        var image=$(link).attr('data-image');
        var data = new FormData();
        data.append('method',$(this).attr('data-type'));
        data.append('image',image);
        data.append('user',$('input[name="user"]').val());
        data.append('gallery',gallery);
        jQuery.ajax({
            url: 'upload_photos.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                var resp=JSON.parse(data);
                if(resp.success>0){
                    $(parent).remove();
                    var images=$('.'+gallery_div+' .preview').length;
                    if(images==0){
                        if($('input[name="user"]').val()==$('.user_name a').text()){
                            var to_append='<p>Nie posiadasz jeszcze żadnych zdjęć w galerii, <label for="addfiles">dodaj je</label> teraz aby bardziej przyciągnąć do siebie randkowiczów</p>';
                        }else{
                            var to_append='<p>Użytkownik nie posiada jeszcze zdjęć w galerii</p>';
                        }

                        $('.'+gallery_div+' .panel-body').append(to_append);
                        $('.'+gallery_div+' .panel-title span').remove();
                    }else{
                        $('.'+gallery_div+' .panel-title span').html('('+jednostki(images)+')');
                    }

                }

            }
        });
    });
});