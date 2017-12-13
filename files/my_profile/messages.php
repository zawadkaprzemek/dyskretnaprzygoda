<?php include(__DIR__.'/../vip_pay_checkout.php');?>
<div class="col-sm-12 my_messages">
    <h2>Moje wiadomości:</h2>

<?php
$table="messages";
$table2="users_info";
$user_from=$_SESSION['usr_name'];
$sql2="SELECT * FROM $table
INNER JOIN $table2 ON $table.user_to=$table2.user_name
WHERE user_to='".$_SESSION['usr_name']."' OR user_from='".$_SESSION['usr_name']."' GROUP BY user_to ORDER BY data_mess DESC";
$result = $con->query($sql2);
$arr=[];
if ($result->num_rows > 0) { ?>
    <div class="col-sm-12 messages_container">
        <!--<div class="col-sm-12 messages_top">
            <div class="col-sm-6 col-sm-offset-2"><i class="fa fa-user fa-2x" aria-hidden="true" title="Użytkownik"></i></div>
            <div class="col-sm-1 text-center"><i class="fa fa-comments-o fa-2x" aria-hidden="true" title="Liczba wiadomości"></i></div>
            <div class="col-sm-3 text-center"><i class="fa fa-clock-o fa-2x" aria-hidden="true" title="Ostatnia wiadomość"></i></div>
        </div>-->
    <?php while($messages = $result->fetch_assoc()) {
        $count="SELECT count(id) FROM $table WHERE (user_to='".$messages['user_to']."' AND user_from='".$messages['user_from']."' ) 
            OR (user_from='".$messages['user_to']."' AND user_to='".$messages['user_from']."') ";
        $ile=$con->query($count)->fetch_assoc();
        $sql_last="SELECT max(data_mess) as last FROM $table WHERE (user_to='".$messages['user_to']."' AND user_from='".$messages['user_from']."' ) 
            OR (user_from='".$messages['user_to']."' AND user_to='".$messages['user_from']."') ORDER BY data_mess DESC";
        $last=$con->query($sql_last)->fetch_assoc();

        if($messages['user_to']==$_SESSION['usr_name']){
            $avatar_query="SELECT avatar FROM $table2 WHERE user_name='".$messages['user_from']."'";
            $avatar=$con->query($avatar_query)->fetch_assoc();
            $sql_unread="SELECT count(id) as status FROM $table WHERE user_to='".$_SESSION['usr_name']."' AND user_from='".$messages['user_from']."' AND unread='0'";
            $unread=$con->query($sql_unread)->fetch_assoc();
            $add=array(
                'name'=>$messages['user_from'],
                'count'=>$ile['count(id)'],
                'avatar'=>$avatar['avatar'],
                'unread'=>$unread['status'],
                'date'=>$last['last'],
            );
        }else{
            $sql_unread="SELECT count(id) as status FROM $table WHERE user_to='".$_SESSION['usr_name']."' AND user_from='".$messages['user_to']."' AND unread='0'";
            $unread=$con->query($sql_unread)->fetch_assoc();
            $add=array(
                'name'=>$messages['user_to'],
                'count'=>$ile['count(id)'],
                'avatar'=>$messages['avatar'],
                'unread'=>$unread['status'],
                'date'=>$last['last'],
            );
        }
        if(!in_array($add,$arr)){
            array_push($arr,$add);
        }
        ?>
    <?php }
}else{?>
   <p class="alert alert-info">Jeszcze nie masz żadnych wiadomości, zrób pierwszy krok i napisz do naszych użytkowników</p>
<?php }
usort($arr,'sort_date');
foreach($arr as $ar =>$item){
    if($item['unread']>0){
        $class="bold";
    }else{
        $class="";
    }
    $item['date']=nice_data($item['date'],$month_names);
    ?>
    <div class="col-sm-12 panel panel-default">
        <a class="<?php echo $class;?> panel-body" href="message.php?with=<?php echo $item['name']?>">
            <div class="col-sm-2 col-xs-3"><img src="<?php echo AVATAR_PATH.'/'.$item['avatar']?>"
                                                class="img-responsive img-rounded"></div>
            <div class="col-sm-4 col-xs-3"><i class="fa fa-user fa-2x" aria-hidden="true" title="Użytkownik"></i><?php
                echo $item['name']?></div>
            <div class="col-sm-3 col-xs-2 text-center"><i class="fa fa-comments-o fa-2x" aria-hidden="true"
                                                         title="Liczba wiadomości"></i><?php echo $item['count']?></div>
            <div class="col-sm-3 col-xs-4 text-center"><i class="fa fa-clock-o fa-2x" aria-hidden="true"
                                                          title="Ostatnia wiadomość"></i><?php echo $item['date']?></div>
        </a>
    </div>
<?php }
?>
        </div>
</div>
