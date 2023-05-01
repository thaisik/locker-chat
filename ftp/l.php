<?php
if( !(
  isset($_POST["txt"]) ||
  isset($_POST["mg"]) ||
  isset($_POST["asdffdsa"]) ))
  {echo 0;header("location: http://thisoe.com");die;}else $_GET['acc']=0;


if(isset($_POST["txt"])){
  $xx=$_POST["mch"];
  if(strlen($xx)>7){echo "0BRUH";die;}else{$x = "zlockroom".$xx;}
  include_once "_hdl/insu.php";
  $stmt = $ins->prepare("INSERT INTO `".$x."` (`locks`, `locker`, `senttime`) VALUES (?, ?, ?)");
  $stmt->bind_param('sii',$p1,$p2,$p3);
  $p1=$_POST["txt"];
  $p2=intval($_POST["ler"]);
  $p3=time();
  if($stmt->execute()){echo 11;}
  else{echo "0服务器未将消息送达。";}
  $stmt->close();$ins->close();exit;
}


elseif(isset($_POST["mg"])){
  $xx=$_POST["mg"];
  $getrows=$_POST["idn"];
  if(strlen($xx)>7){echo "eBRUH";die;}else{$x = "zlockroom".$xx;}
  include_once "_hdl/insu.php";
  $q='DESC '.$x;
  if( mysqli_query($in_su,$q) ) {
    $q='SELECT * FROM '.$x;
    if($rt=mysqli_query($in_su,$q)){
      $newrows = mysqli_num_rows( $rt );
      if ($newrows > $getrows) {
        $p1=1+$getrows;
        $q='SELECT * FROM '.$x.' WHERE no='.$p1;
        if($row=mysqli_fetch_assoc(mysqli_query($in_su,$q))) {
          date_default_timezone_set($_POST["tz"]);
          echo '1'.$row["locker"];
          echo date("H:i:s",$row["senttime"]);
          echo nl2br(htmlspecialchars($row["locks"]));
        }else{echo "e服务器出错:1。".'SELECT * FROM '.$x.' WHERE no='.$getrows;}
      }else{echo "n";}
    }else{echo "e服务器出错:2。";}
  }else{echo 'r对方退出。';}
 exit;
}


else{echo '7';die;}
