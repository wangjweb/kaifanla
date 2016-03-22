<?php
/*
*由main.html调用
*根据客户端提交的查询关键字,返回菜名或原料中包含指定关键字的菜品
*/
    header('Content-Type:application/json');
    $output=[];

    $count=5;//一次最多返回的记录条数
    @$start=$_REQUEST['start'];//客户端提交的起始记录
    /*@用于压制改行代码产生的错误/警告消息*/
    if( empty($start)){
        $start=0;
    }
    //var_dump("$start");
    //访问数据库
    $conn=mysqli_connect('127.0.0.1','root','','kaifanla',3306);
    $sql='SET NAMES utf8';
    mysqli_query($conn,$sql);
    $sql="SELECT did,name,img_sm,material,price FROM kf_dish LIMIT $start,$count";
    $result=mysqli_query($conn,$sql);
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