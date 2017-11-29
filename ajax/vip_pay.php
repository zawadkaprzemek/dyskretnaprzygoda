<?php
if(isset($_POST)){
    session_start();
    include_once '../conf/config.php';
    include_once '../conf/functions.php';
    include_once '../conf/data_base.php';

    $resp='';
    if($_POST['action']=='get_and_save_order'){

        $country='PL';
        require_once "functions-order.php";
        error_reporting(0);

        $array['api_key'] = '5f07862b59314fb49588a5b4c8683502';			//required - your api_key
////////////////////////////////
        $array['aid']		= '160393';								//required - affiliate_partner_id - your ID
        $array['cid']		= 'abc123';								//creative_id - your data - will be visible in DA interface
        $array['ac']		= 'abc123';								//action_channel - your data - will be visible in DA interface
        $array['order_url']	= 'http://sundaycashsaver.com/48/xplayroom/';	//required - site where the weight loss RO order is sent - each category and country will have its own address
        $array['base_url']	= 'http://www.xplayroom.com/';			//required - site where the order was generated
        $array['price']		= '147';								//required - price listed on your site
////////////////////////////////

        $array['name'] 		= addslashes($_POST['name']);		//test123
        $array['surname'] 	= @addslashes($_POST['name']);	//test123
        $array['phone'] 	= @addslashes($phone);		//00123456789/+123456789
        $array['email'] 	= addslashes($_POST['email']);		//test@test.com
        $array['country'] 	= @addslashes($country);	//RO
        $array['city'] 		= @addslashes($_POST['city']);		//test
        $array['address'] 	= @addslashes($_POST['address']);	//test123 123
        $array['pcode'] 	= @addslashes($_POST['pcode']);		//634
        $array['note'] 		= @addslashes($_POST['note']);		//test123 123
        $array['referer'] 	= $_SERVER['HTTP_REFERER'];
        $array['ip'] 		= $_SERVER['REMOTE_ADDR'];
        $array['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

        if(isset($_POST['name'])){
           $return=makeOrder($array);	// function that will send the order
        }
        $ob=json_decode($return);
        $cookie=$ob->cookie;
        $pay_link=$ob->payment_link;
        $user=$_POST['name'];
        $table="vip_pay";
        $sql="INSERT INTO $table VALUES (NULL,'$user','$cookie','$pay_link','1')";
        try{
            $con->query($sql);
            $result=array('resp'=>'success','link'=>$pay_link);
        }
        catch (Exception $e){
            $result=array('resp'=>'fail');
        }
    }elseif ($_POST['action']=='check_sms'){
        $ch = curl_init();
        @$s=$_POST['s'];
        curl_setopt($ch, CURLOPT_URL, "https://ssl.mobiltek.pl/api/check_code.php?keyword=gmc%&shortcode=48607767767&passwd=sestoka&code=".$s);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $arr = explode(PHP_EOL,trim($output));
        $ar2=explode(':',$arr[1]);
        $result=array('status'=>$arr[0],'code'=>$ar2[0]);
        //$result=array('status'=>'OK','code'=>'1001');
        if($result['status']=='OK'&&$result['code']=='1001'){
            $user=$_POST['user'];
            $points_to_add=1000;
            $table='account_coins';
            $sql="UPDATE $table SET coins=coins+$points_to_add WHERE login='".$user."'";
            if($con->query($sql)===TRUE){
                $sql2="SELECT coins FROM $table WHERE login='".$user."'";
                $coins=$con->query($sql2)->fetch_array()['coins'];
                $result['coins']=$coins;
            }

        }
    }elseif ($_POST['action']=='check_payment'){
        $cookie=$_POST['cookie'];
        $postdata="cookie_confirm=".$cookie;
        $user=$_POST['user'];
        $url='http://sundaycashsaver.com/48/xplayroom/confirm.php';
        $headers = [
            'Referer: '.$_SERVER['HTTP_REFERER'],
            'User-Agent: '.$_SERVER['HTTP_USER_AGENT'],
            'X-Forwarded-For: '.$_SERVER['REMOTE_ADDR']
        ];
        $c=curl_init();
        curl_setopt($c,CURLOPT_URL,$url);
        curl_setopt ($c, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($c,CURLOPT_RETURNTRANSFER,1);
        curl_setopt ($c, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt ($c, CURLOPT_TIMEOUT, 10);
        curl_setopt($c,CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($c,CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec ($c);
        curl_close($c);

        $result=json_decode($response);
    }

    echo json_encode($result);
}