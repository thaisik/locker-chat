/*

欢迎查看源代码！指点批评、合作联络 q780309206

*/
$(document).ready(function(){
// pre
let x;
let itv=0;
let ler=-1;
let match="";
let getmitv=0;
let isitverr=0;
let isinroom=false;

// pair
  if(
    (window.performance.navigation && window.performance.navigation.type === 1) ||
     window.performance.getEntriesByType('navigation').map((nav) => nav.type).includes('reload')
  ) {console.log("[RE]");} else {console.log("[YO]");}

  // 提交匹配房间
  const mainpair = (async function(bh){
    let divid="#pairing";
    $(divid).css('display','flex');$("#intro").hide();
    await $.post("s.php", {bh: bh}, re=>{switch(re){
      case "无法连接至服务器。": case "服务器出错，请尝试换一个房间号。": case "服务器拥挤，请稍后再试。":
        errwin(re,divid);x=undefined; return;break;
      default:
        if(re.slice(0,1)=="m"){
          match=re.slice(1); isinroom=true;
          getin(divid);
        }else{
          $.post("s.php", {newroom: re, newbh: bh}, nr=>{switch(nr){
            case "无法连接至服务器。": case "服务器：房间创建失败。": errwin(re,divid);let x=undefined;return;break;
            default:
              match=re; isinroom=true;
              let nth = 0;
              itv=setInterval(async ()=>{
                await $.post("s.php", {waitroom: match}, conb => {
                  switch (conb) {
                    case "无法连接至服务器。": case "服务器未响应。":
                    case "服务器出现错误。": errwin(conb,divid);return;break;
                    case "0": console.log("正在寻找配对方...");break;
                    case "1": clearInterval(itv); getin(divid);
                  }
                });
                nth += 1;
                if(nth > 77){
                  clearInterval(itv);cclr(match,1);
                  $(divid).hide();$("#timeout").css('display','flex');
                  $("#okied").on('click',()=>{
                    $("#timeout").hide(); $("#intro").css('display','flex');
                  });
                }
              },2333);
          }});
        }
    }});
  });
  // 回车以匹配
  $(document).on("keydown","#b", function(i){
    if((x = $("#b").val()) && (i.keyCode==13)) {mainpair(x);}
  });

  // 停止匹配
  const cclr = ( (xn,notx=0) => {
    $.post("s.php", {cancel: xn, notx: notx});
  });
  $("#cancelpair").click(()=>{clearInterval(itv);cclr(match,1);$("#intro").css('display','flex');$("#pairing").hide();});

  // 报错
  const errwin = ((msg,w)=>{
    clearInterval(itv);cclr(x);
    $("#errh2").text(msg);
    $("#errdiv").css('display','flex');
    $(w).hide();
  });
  // setInterval( ()=>{ if(isitverr){clearInterval(itv);cclr(x);isitverr=0;} } , 2333 );
  $("#errbtnout").click(()=>{leaving();window.location.replace("http://thisoe.com");});
  $("#errbtnredo").click(()=>{$("#errdiv").hide();$("#intro").css('display','flex');});

  // 离开
  const leaving = (()=>{
    clearInterval(itv);
    if(isinroom) {cclr(match,1);}
    else {cclr(x);}
  });
  const tos = (()=>{$.post("s.php",{tos: match});});
  $(window).on('beforeunload', function(){
    leaving();
    if(ler!=-1){tos();}
  });

  // 匹配成功，进入房间
  const getin = ( div=>{
    $("#pairing").hide();$("#rooming").css('display','flex');
    $.post("s.php", {gotin: match}, rep=>{
      if(rep.slice(0,1)=="1"){
        ler=parseInt(rep.slice(1));
        gotolocker();
      }else{
        console.error("GETIN BACKING: "+rep.slice(1));
        $("#fatal").css('display','flex');
      }
    });
  });

  const gotolocker = (()=>{
    $('div').hide();
    $('textarea,#sendbtn').prop("disabled", false);
    $('textarea').attr('placeholder',"（上限800字）");
    $('main').prepend('<p class="alerts" id="i0">已进入房间，开始唠嗑吧！</p>');
    runmain();
    // msg("欢迎使用 Locker 送信室。您已进入房间，开始唠嗑儿吧！","sys");
  });


// main
const runmain = (()=>{
  // pre
  let idnow=0;
  let idnxt=1;
  let tz=Intl.DateTimeFormat().resolvedOptions().timeZone;

    // 发送
    const mainsend = ((mainmsg)=>{
      $.post("l.php", {txt: mainmsg, ler: ler, mch: match}, boo=>{
        switch (boo.slice(0,1)) {
          case "1": break;
          case "0": console.error("唠嗑发送失败: "+boo.slice(1));break;
          default : console.error("唠嗑发送 带 失 败 : "+boo);
        }
      });
    });
    $(document).on("click","#sendbtn", () => {
      if(txt = $("textarea").val()) {
        mainsend(txt);
        $("textarea").val('');
      }
    });

    // 接收
    const getmsg=( ()=>{
      $.post("l.php", {mg: match, idn: idnow, tz: tz}, moo=>{
        switch (moo.slice(0,1)) {
          case 'n': break;
          case '1': newlaoke(moo.slice(1));console.log("唠嗑接收到新消息。");break;
          case 'r': runle();break;
          case 'e': console.error("唠嗑接收失败: "+moo.slice(1));break;
          default : console.error("唠嗑接收 带 失 败: "+moo);break;
        }
      });
    });
    const newlaoke = ( laoke=>{
      let lr1 = laoke.slice(0,1);
      let l2; let l3;
      if (lr1==ler){
        lr2='me';l3='jm';
      }else{
        lr2='you';l3='jy';
      }
      let timesent = laoke.slice(1,9);
      let newp = "<p class='"+lr2+"'>"+laoke.slice(9)+"</p><p class='"+l3+"' id='i"+idnxt+"'>"+timesent+"</p>";
      $("#i"+idnow).after(newp);
      idnow+=1; idnxt+=1;
      window.scrollTo(0,document.body.scrollHeight);
    });
    getmitv=setInterval(getmsg,900);

    // 对方退出
    const runle =(()=>{
      window.scrollTo(0,document.body.scrollHeight);
      clearInterval(getmitv);
      getmitv=0; itv=0; ler=-1; match="";
      $('textarea,#sendbtn').prop("disabled", true);
      $("#i"+idnow).after('<p class="alerts">对方已退出房间。<a id="repairfrommain">重新匹配</a>或<a id="bye">退出</a></p>');
      $("textarea").attr("placeholder","对方已退出房间。");
    });

});

  // 处理退出
  $(document).on("click","#repairfrommain",()=>{
    if (confirm("将永久删除此房间的唠嗑记录。\n确定重新匹配？")) {
      $("#cov,#intro").css('display','flex');
      $("main").empty();
      $("textarea").attr("placeholder","");
      isinroom=false;
    }
  });
  $(document).on("click","#bye",()=>{
    if (confirm("将永久删除此房间的唠嗑记录。\n确定退出？")) {leaving();window.location.replace("http://thisoe.com");}
  });


});
