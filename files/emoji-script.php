<script type="text/javascript">
    (function () {
        wdtEmojiBundle.defaults.emojiSheets = {
            'apple'    : 'lib/images/sheet_apple_64_indexed_128.png',
        };
        wdtEmojiBundle.init('.wdt-emoji-bundle-enabled');

        wdtEmojiBundle.on('afterSelect', function (a, b) {
            console.log('afterSelect', a, b);
        });

        var ev = document.createEvent('Event');
        ev.initEvent('input', true, true);

        // ------------------------------------------------------
        document.getElementById('message-input').dispatchEvent(ev);
        // ------------------------------------------------------

        var $mess=$('.chat-message');
        $mess.each(function() {
            $(this).html(wdtEmojiBundle.render($(this).html()));
        });

    })();
</script>