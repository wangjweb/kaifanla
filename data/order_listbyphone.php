<?php
/*
*由detail.html调用
*根据客户端提交的电话号码,返回其所有的订单
*/
    header('Content-Type:application/json');
    $output=[];


    @$phone=$_REQUEST['phone'];
    if(empty($phone)){
        echo "[]";//若客户端未提交菜品编号,则返回空
        return;
    }

    //访问数据库
    $conn=mysqli_connect('127.0.0.1','root','','kaifanla',3306);
    $sql='SET NAMES utf8';
    mysqli_query($conn,$sql);
   $sql = "SELECT kf_order.oid,kf_order.user_name,kf_order.order_time,kf_dish.img_sm FROM kf_order,kf_dish WHERE kf_order.did=kf_dish.did AND kf_order.phone='$phone'";
    $result=mysqli_query($conn,$sql);
    //根据标号查询,结果集UI多只有一行记录
   while(($row=mysqli_fetch_assoc($result))!==NULL){
        $output[]=$row;
    }
    /*
    第1页:   从0条开始  取5条
    第2页:   从5条开始  取5条
    第3页:   从10条开始 取5条a
    */

    echo json_encode($output);
?>