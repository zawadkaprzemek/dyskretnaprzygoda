<header class="navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-8">
                    <form class="navbar-form navbar-left" role="search" action="search.php">
                        <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Szukaj..." required>
                        </div>
                    </form>
                </div>
                <div class="col-sm-4 text-right">
                    <div><a href="logout.php" title="Wyloguj"><i class="fa fa-sign-out" aria-hidden="true"></i></a></div>
                </div>
            </div>
        </div>
    </div>
</header>