<?php if(!isset($_GET['acc'])){header('location: http://thisoe.com');die;}
$D1="";
$D2="";
$D3="";
$D4="";
$DP=;

$in_su=mysqli_connect($D1,$D2,$D3,$D4,$DP);
$ins = new mysqli($D1,$D2,$D3,$D4,$DP);
if (mysqli_connect_errno()||$ins->connect_errno) {echo "无法连接至服务器。";die;}
