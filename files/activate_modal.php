<?php if($_SESSION['activate']==0){?>
<div id="activatebox" class="modal modal-popup fade in" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static" style="opacity:1; display:none;">
            <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body text-center">
                <form id="activateform" role="form" method="post">
                    <div class="form-group">
                        <label for="activatekey" class="alert alert-warning">Wprowadź kod aktywacyjny aby odblokować dostęp do serwisu</label>
                    <input class="form-control input-lg" type="text" value="" placeholder="Mój kod aktywacyjny" id="activatekey" name="activatekey" required>
                    </div>
                    <input type="submit" value="Aktywuję moje konto" name="submitkey" class="btn">
                    <p id="activate_error" class="alert alert-danger"></p>
                </form>
            </div>
        </div>
</div>
<script>
    $(document).ready(function () {
        $('#activatebox').modal({backdrop: 'static', keyboard: false}, 'show');
        $('#activateform').submit(function () {
            var key=$('#activatekey').val();
            $.ajax({
                type:"POST",
                url: "activate.php",
                data:{key:key},
                success:function (result) {
                    switch(result.trim()){
                        case '1':
                            $('#activatebox .close-modal').click();
                            break;
                        case '2':
                            $('#activate_error').show().html('Wprowadzono błędny kod aktywacyjny');
                            break;
                        default:
                            $('#activate_error').show().html('Wystąpił nieoczekiwany błąd, spróbuj ponownie później');
                            break;

                    }
                }
            });
            return false;
        });
    });
</script>
<?php }?>