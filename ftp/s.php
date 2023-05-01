<?php
if( !(
  isset($_POST["waitroom"]) ||
  isset($_POST["bh"]) ||
  isset($_POST["newroom"]) ||
  isset($_POST["gotin"]) ||
  isset($_POST["tos"]) ||
  isset($_POST["cancel"]) ))
  {echo 0;header("location: http://thisoe.com");die;}else $_GET['acc']=0;


if(isset($_POST["waitroom"])){
  $fh=$_POST["waitroom"];
  include '_hdl/insu.php';
    $sqlm='SELECT * FROM `lockerpair` WHERE `fileno`="'.$fh.'";';
    $rt=mysqli_query($in_su,$sqlm);
    if($nrows=mysqli_num_rows($rt)){
        if($nrows==1) {
          $row=mysqli_fetch_assoc($rt);
          if($row["ispaired"]==1) echo 1;
          else echo 0;
        } else echo "服务器出现错误。";
    } else echo "服务器未响应。";
    mysqli_free_result($rt);mysqli_close($in_su); exit;
}


elseif(isset($_POST["bh"])){
  $x=$_POST["bh"];
  include '_hdl/insu.php';
  $sqlm='SELECT * FROM `lockerpair` WHERE `roomno`="'.$x.'" AND `ispaired` IS NULL;';
  $rt=mysqli_query($in_su,$sqlm); $nrows=mysqli_num_rows($rt);
  if($nrows==1){ // 已有等待者
    $row=mysqli_fetch_assoc($rt);$no=$row["no"];
    mysqli_free_result($rt);
    $sqlm='UPDATE lockerpair SET ispaired=1 WHERE no='.$no;
    $rt=mysqli_query($in_su,$sqlm);
    echo "m".$row["fileno"];
  }
  elseif ($nrows>1) {echo "服务器出错，请尝试换一个房间号。";}
  elseif ($nrows==0){
    for($i=0;$i<9;$i++) {
      if($i==8){echo "服务器拥挤，请稍后再试。";mysqli_close($in_su);die;}
      $f=rand(1,9999999);
      mysqli_free_result($rt);
      $sqlF='SELECT * FROM `lockerpair` WHERE `fileno`='.$f.';';
      $rt=mysqli_query($in_su,$sqlF);
      if(mysqli_num_rows($rt))continue;else break;
    }
    echo $f;
  }
  mysqli_close($in_su);exit;
}


elseif(isset($_POST["newroom"])){
  $f=intval($_POST["newroom"]);
  include "_hdl/insu.php";
  $stmt = $in_su->prepare("INSERT INTO lockerpair (roomno, fileno, utime) VALUES (?, ?, ?)");
  $stmt->bind_param('sii', $_POST["newbh"],$f,time());
  if($stmt->execute()){
    echo $f;
  }else{
    echo "服务器：房间创建失败。";
  }
  $stmt->close();$in_su->close();exit;
}


elseif(isset($_POST["cancel"])){
  if(intval($_POST["notx"])){
    $where="fileno=";
    $x=$_POST["cancel"];
  }else{
    $where="roomno=";
    $x="'".$_POST["cancel"]."'";
  }
  include_once "_hdl/insu.php";
    if ($ins->query("SELECT * FROM lockerpair WHERE ".$where.$x)->num_rows > 0) {
      $ins->query("DELETE FROM lockerpair WHERE ".$where.$x);
      echo $ins->affected_rows;
    } else {echo 'ng';} // 没有该房
}


elseif(isset($_POST["gotin"])){
  $m=$_POST["gotin"];
  include_once "_hdl/insu.php";
  $ins->query('UPDATE lockerpair SET roomno = "" WHERE ispaired=1 AND fileno='.$m);
  $a=$ins->affected_rows;
// 造locker新表
  if ($a==1) {
    $q = "CREATE TABLE zlockroom".$m;
    $q .= " ( no INT(6) UNSIGNED NOT NULL AUTO_INCREMENT, locks text(999) NOT NULL, locker bool NOT NULL, senttime int UNSIGNED NOT NULL, PRIMARY KEY (`no`) ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    if ($ins->query($q) === TRUE) {
      echo "1".$a;
    } else {echo "0".$ins->error;} // 制表失败
  } else {echo "1".$a;}
}


elseif(isset($_POST["tos"])){
  $m=$_POST["tos"];
  include_once "_hdl/insu.php";
  $q1="DROP TABLE zlockroom".$m;
  mysqli_query($in_su,$q1);
  mysqli_close($in_su);exit;
}


else{echo '000';die;}
