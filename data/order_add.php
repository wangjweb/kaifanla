<?php
/*
*��order.html����
*���ݿͻ��˶�����Ϣ���򶩵����в���һ����¼��������ݿⷵ�صĶ������
*/
header('Content-Type: application/json');
$output = [];

@$user_name = $_REQUEST['user_name'];
@$sex = $_REQUEST['sex'];
@$phone = $_REQUEST['phone'];
@$addr = $_REQUEST['addr'];
@$did = $_REQUEST['did'];
$order_time = time()*1000;   //PHP�е�time()�������ص�ǰϵͳʱ���Ӧ������ֵ

if(empty($phone) || empty($user_name) || empty($sex) || empty($addr) || empty($did) ){
    echo "[]"; //���ͻ����ύ��Ϣ���㣬�򷵻�һ�������飬
    return;    //���˳���ǰҳ���ִ��
}

//�������ݿ�
$conn = mysqli_connect('127.0.0.1','root','','kaifanla');
$sql = 'SET NAMES utf8';
mysqli_query($conn, $sql);
$sql = "INSERT INTO kf_order VALUES(NULL,'$phone','$user_name','$sex','$order_time','$addr', '$did')";
$result = mysqli_query($conn, $sql);

$arr = [];
if($result){    //INSERT���ִ�гɹ�
    $arr['msg'] = 'succ';
    $arr['did'] = mysqli_insert_id($conn); //��ȡ���ִ�е�һ��INSERT������ɵ���������
}else{          //INSERT���ִ��ʧ��
    $arr['msg'] = 'err';
    $arr['reason'] = "SQL���ִ��ʧ�ܣ�$sql";
}
$output[] = $arr;

echo json_encode($output);
?>