window.onload = function() {
    document.onkeydown = function() {
       var e = window.event || arguments[0];
       //屏蔽F12
  if(e.keyCode == 123) {
  console.log('本网站欢迎您！');
      return false;
   //屏蔽Ctrl+Shift+I
   }else if((e.ctrlKey) && (e.shiftKey) && (e.keyCode == 73)){
    console.log('当前提示，本网站禁止审查元素');
      return false;
//屏蔽Ctrl+U(火狐下查看网页源代码快捷键)
}else if((e.ctrlKey) && (e.keyCode == 85)){
console.log('本网站禁止使用审查元素')
return false;
   //屏蔽Shift+F10
   }else if((e.shiftKey) && (e.keyCode == 121)){
      console.log('本网站禁止审查元素！');
return false;
   }else if(event.ctrlKey  &&  window.event.keyCode==83 ){ 
      console.log('本网站禁止保存文件！');
      return false;
   }
   };
   //屏蔽右键单击
if (window.Event)
document.captureEvents(Event.MOUSEUP);
function nocontextmenu()
{
event.cancelBubble = true
event.returnValue = false;
return false;
}
function norightclick(e)
{if (window.Event)
{
if (e.which == 2 || e.which == 3)
return false;
}
else
if (event.button == 2 || event.button == 3)
{
event.cancelBubble = true
event.returnValue = false;
return false;
}
}
document.oncontextmenu = nocontextmenu; // for IE5+
document.onmousedown = norightclick; // for all others
}

// <!--
if (window.Event)
document.captureEvents(Event.MOUSEUP);
function nocontextmenu()
{
event.cancelBubble = true
event.returnValue = false;
return false;
}
function norightclick(e)
{if (window.Event)
{
if (e.which == 2 || e.which == 3)
return false;
}
else
if (event.button == 2 || event.button == 3)
{
event.cancelBubble = true
event.returnValue = false;
return false;
}
}
document.oncontextmenu = nocontextmenu; // for IE5+
document.onmousedown = norightclick; // for all others
//-->

function click() {if (event.button==2) {alert('不许你偷看！');}}document.onmousedown=click