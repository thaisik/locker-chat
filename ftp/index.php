<!DOCTYPE HTML><!--7

欢迎查看源代码。指点批评、合作联络 q780309206

-->
<html lang="zh"><head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.8">
  <meta name="author" content="Thisoe, Illiase"><meta name="discription" content="西索笔记Thisoe是TSK的个人博客，以及HTML、CSS、PHP、Python、MicroPython的编程笔记。"><meta name="keywords" content="TSK个人博客,Thisoe,西索笔记,伊利亚斯编年史,Illiase,TSK">
  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script><script async src="s.js?v=<?php echo (time()-1666777888); ?>"></script>
  <title>Locker | Thisoe</title><link rel="icon" href="http://thisoe.com/-1c.png"><meta name="theme-color" content="#178577"><link rel="stylesheet" href="s.css?v=<?php echo (time()-1666777888); ?>">
</head><body>
<!-- 房间外 -->
<div id="intro" style="display:flex">
  <h1>Locker 送信室</h1>
  <h2>您与您的朋友输入相同的房间号，即可进入一间送信室，开始聊天。<br>房间号上限11个字符，回车以匹配。</h2>
    <label for="b">房间号</label>
    <input id="b" type="text" maxlength="11">
</div><div id="timeout">
  <h1>匹配超时</h1><h2>配对时长超过3分钟，已自动取消。</h2>
  <button type="button" id="okied">返回</button>
</div><div id="pairing">
  <h2>正在等待对方进入房间……<br>配对超过3分钟将自动取消。</h2>
  <button type="button" id="cancelpair">取消</button>
</div><div id="fatal">
  <h1>房间出错</h1><h2>请刷新页面。</h2>
</div><div id="errdiv">
  <h1>出现错误</h1><h2 id="errh2"></h2>
  <aside>
    <button type="button" id="errbtnout">退出</button>
    <button type="button" id="errbtnredo">返回配对</button>
  </aside>
</div><div id="rooming">
  <h1>匹配成功</h1><h2>正在创建并进入房间……</h2>
</div>
<div id="cov" style="display:flex"></div>
<!-- 房间内 -->
<main></main>
<section>
  <textarea disabled maxlength="800" placeholder=""></textarea>
  <button disabled id="sendbtn" type="button">送信</button>
</section>
<footer><p><a href="http://thisoe.com">Thisoe主页</a><br><a href="http://illiase.ltd">伊利亚斯</a><br><cite>津ICP备2022006275号</cite></p></footer></body>
