<?php include(__DIR__.'/../vip_pay_checkout.php');?>
<div class="col-sm-12 visitors text-center">


    <?php if($_SESSION['account_type']==2) { ?>
        <video id="video" class="video-js" controls preload="auto" width="640" height="264"
               poster="lib/video/1/thumb.jpg" data-setup="{}">
            <source src="lib/video/1/video.mp4" type='video/mp4'>
            <p class="vjs-no-js">
                To view this video please enable JavaScript, and consider upgrading to a web browser that
                <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
        </video>

<div class="video-list">
<?php
$dirs=array_diff(scandir(VIDEOS_PATH),array('..','.'));
//var_dump($dirs);

foreach ($dirs as $dir){?>
    <div class="col-sm-4">
        <?php
        $files=array_diff(scandir(VIDEOS_PATH.DIRECTORY_SEPARATOR.$dir),array('..','.'));
        foreach ($files as $file){
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if($ext=='jpg'){
                $image=$file;
            }elseif ($ext=='mp4'){
                $video=$file;
            }
        }
        ?>
        <a href="#" data-movie="<?php echo VIDEOS_PATH . DIRECTORY_SEPARATOR .$dir
            .DIRECTORY_SEPARATOR.$video?>">
        <img src="<?php echo VIDEOS_PATH . DIRECTORY_SEPARATOR .$dir.DIRECTORY_SEPARATOR.$image?>"
             class="img-responsive">
        </a>
    </div>
<?php }
?>
</div>



        <script src="lib/js/video.js"></script>


<script>
    $(document).ready(function () {
        var width=$('#video').width();
        var height=parseInt(width)/16*9;
        $('#video').css('height',height+'px');
        var first=$('.video-list div').first();
        $(first).addClass('active');
        var fm=$(first).children('a').attr('data-movie');
        var fi=$(first).children('a').children('img').attr('src');
        $('#video_html5_api').attr('poster',fi);
        $('#video').attr('poster',fi);
        $('.vjs-poster').css('background-image','url("'+fi+'")');
        $('#video_html5_api').attr('src',fm);

        $('.video-list').on('click','a',function (e) {
            e.preventDefault();
            var movie=$(this).attr('data-movie');
            var img=$(this).children('img').attr('src');
            $('#video_html5_api').attr('poster',img);
            $('#video').attr('poster',img);
            $('.vjs-poster').css('background-image','url("'+img+'")');
            $('#video_html5_api').attr('src',movie);
            $('video')[0].play();
            $('.video-list .active').removeClass('active');
            $(this).parent().addClass('active');
            $('html, body').animate({
                scrollTop: $("#video").offset().top-70
            }, 10);
        });
    });
</script>
        <?php }else{
        echo '<p class="alert alert-warning">Opcja dostępna wyłącznie dla posiadaczy konta VIP, 
<a href="doladuj.php">zmień swoje konto na VIP</a></p>';
    }?>

</div>