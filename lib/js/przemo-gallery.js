$(function () {

    $('.img-prev').click(function (event) {
        event.preventDefault();
        var images = new Array();
        var active=$(this).attr('data-image');
        jQuery.each($('.img-prev'), function() {
            images.push($(this).attr('data-image'));
        });
        jQuery.each(images, function () {
            var act='';
            if(active==this.toString()){
                act=' active';
            }
            $('#image-cont .gallery-images').append('<div class="item'+act+'" style="display: inline-block">' +
                '<img alt="" src="lib/images/gallery/'+this.toString()+'">' +
                '</div>');

        });
        $('#image-cont .gallery-images').append('<div class="clearfix"></div>');

        if($('#image-cont .gallery-images .item').length==1){
            $('.gallery-controller.prev').hide();
            $('.gallery-controller.next').hide();
        }
        $('.galleries').hide();
        var maxh=0;
        var img=$('#image-cont .item img');
        $('#image-cont .item img').load(function () {
                if(this.height>maxh){
                    maxh=this.height;
                    $('.gallery').css('height',maxh+'px');
                }
                console.log($(this).attr('src')+' '+this.height);
                $(this).parent().removeAttr('style');
        });

        //$('#image-cont .item').removeAttr('style');
        $('.gallery').removeClass('hidden');

    });
    $('#gallery-prev').click(function (event) {
        event.preventDefault();
        var active=$('.gallery-images .item.active');
        var index=parseInt($('.gallery-images .item').index(active))+1;
        var count=parseInt($('.gallery-images .item').size());
        var prev=index-1;
        if(prev==0){
            prev=count;
        }
        $('.gallery-images .item:nth-of-type('+index+')').removeClass('active');
        $('.gallery-images .item:nth-of-type('+prev+')').addClass('active');
    });
    $('#gallery-next').click(function (event) {
        event.preventDefault();
        var active=$('.gallery-images .item.active');
        var index=parseInt($('.gallery-images .item').index(active))+1;
        var count=parseInt($('.gallery-images .item').size());
        var next=index+1;
        if(next>count){
            next=1;
        }
        $('.gallery-images .item:nth-of-type('+index+')').removeClass('active');
        $('.gallery-images .item:nth-of-type('+next+')').addClass('active');
    });
    $('#gallery-close').click(function (event) {
        event.preventDefault();
        $('.galleries').show();
        $('.gallery-images .item').remove();
        $('.gallery-images .clearfix').remove();
        $('.gallery').addClass('hidden');
    });
    $('body').keypress(function (e) {
        var gallery_off=$('.gallery').hasClass('hidden');
       if(!gallery_off){
           switch (e.keyCode){
               case 27:
                   $('#gallery-close').trigger('click');
                   break;
               case 37:
                   $('#gallery-prev').trigger('click');
                   break;
               case 39:
                   $('#gallery-next').trigger('click');
                   break;
               default:
                   break;
           }
       }
    });


});