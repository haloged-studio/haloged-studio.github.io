var fso;
try { 
fso=new ActiveXObject("Scripting.FileSystemObject"); 
} catch (e) { 
alert("当前浏览器不支持");
return;
} 
var f1 = fso.createtextfile("./code.txt",true);
var openf1 = fso.OpenTextFile("code.txt");
var str1 = openf1.ReadLine();