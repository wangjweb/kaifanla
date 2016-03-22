<?php
/*
*由detail.html调用
*根据客户端提交的菜品编号,返回指定菜品的详情
*/
    header('Content-Type:application/json');
    $output=[];

    @$did=$_REQUEST['did'];
    if(empty($did)){
        echo "[]";//若客户端未提交菜品编号,则返回空
        return;
    }

    //访问数据库
    $conn=mysqli_connect('127.0.0.1','root','','kaifanla',3306);
    $sql='SET NAMES utf8';
    mysqli_query($conn,$sql);
    $sql="SELECT did,name,img_lg,material,detail,price FROM kf_dish WHERE did='$did'";
    $result=mysqli_query($conn,$sql);
    //根据标号查询,结果集UI多只有一行记录
    if(($row=mysqli_fetch_assoc($result))!==NULL){
        $output[]=$row;
    }
    /*
    第1页:   从0条开始  取5条
    第2页:   从5条开始  取5条
    第3页:   从10条开始 取5条a
    */

    echo json_encode($output);
?>