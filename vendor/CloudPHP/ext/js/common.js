function SetCookie(name,value)//两个参数，一个是cookie的名子，一个是值
{
    var minute = 2; //此 cookie 将被保存 2 m
    var exp  = new Date();    //new Date("December 31, 9998");
    exp.setTime(exp.getTime() + minute*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)//取cookies函数        
{
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
     if(arr != null) return unescape(arr[2]); return null;

}
function delCookie(name)//删除cookie
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
function show_hidden(objID)
{
	var obj = document.getElementById(objID);
	if(obj.style.visibility == "hidden")
		obj.style.visibility = "visible";	
	else
		obj.style.visibility = "hidden";
}
function set_empty(objID)
{
		var obj = document.getElementById(objID);
		obj.innerHTML = "";
}
function expendByName(name)
{
	document.getElementById(name).style.display=(document.getElementById(name).style.display =='none')?'':'none'
}
function chooseAnwser(id)
{
	document.getElementById(id)
}
function getFocus(id)
{
	//document.getElementById(id).style.color='orange';
	document.getElementById(id).style.background='#99CC99';
	//document.getElementById(id).style.
	//this.style.font-size='16px';
}
function checkInput(){
	//var checkbox = document.getElementById('checkbox').value;
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	var re1 = /^[0-9]{7}$/;
	var re2 = /^[0-9]{12}$/;
	if(!re1.test(username) && !re2.test(username)){
		alert('用户名错误，请重新输入！');
		return false;
	}
	else if(password.length > 30){
		alert('密码错误，请重新输入！');
		return false;
	}
	return true;
}
function check_password() {
   var psw1      = document.getElementById("newpsw");
   var psw2      = document.getElementById("newpsw2");
   var password1 = psw1.value;
   var password2 = psw2.value;
   var length    = password1.length;
  
   if(password1 != password2) {alert("两次密码不相同");psw2.focus(); return false;}
   else if(password1 == "") {alert("密码不能为空"); psw1.focus();return false;}
   else if(length < 6 || length > 20) {alert("密码长度不合适，长度应在6与20之间！");psw1.focus();return false;}
}
function checkUserAdd(gid){
	if(gid != 1 && gid != 2){alert('对不起，你没有添加用户权限！');return false;}
	var username = document.getElementById("username");
	var number   = document.getElementById("number");
	var aclass   = document.getElementById("class");
	var phone    = document.getElementById("phone");
	var re1 = /^[0-9]{7}$/;
	var re2 = /^[0-9]{12}$/;
	var re3 = /^[0-9]*$/;
	
	if(username.value == ''){alert("姓名不能为空！");username.focus();return false;}
	else if(number.value == ''){alert("学号不能为空！");number.focus();return false;}
	else if(!re1.test(number.value) && !re2.test(number.value)){alert('学号（编号）错误，请重新输入！');number.focus();return false;}
	else if(aclass.value == ''){alert("班级不能为空！");aclass.focus();return false;}
	else if(!re3.test(phone.value)){alert('电话号码错误，请重新输入！');phone.focus();return false;}
	return true;
}
function checkUserChange(gid){
	if(gid == 1 || gid == 2){
		var username = document.getElementById("username");
		var number   = document.getElementById("number");
		var re1 = /^[0-9]{7}$/;
		var re2 = /^[0-9]{12}$/;
		if(username.value == ''){alert("姓名不能为空！");username.focus();return false;}
		else if(number.value == ''){alert("学号不能为空！");number.focus();return false;}
		else if(!re1.test(number.value) && !re2.test(number.value)){
			alert('学号（编号）错误，请重新输入！');
			number.focus();
			return false;
		}
	}
	var aclass = document.getElementById("class");
	var phone = document.getElementById("phone");
	var re3 = /^[0-9]*$/;
	if(aclass.value == ''){alert("班级不能为空！");aclass.focus();return false;}
	else if(!re3.test(phone.value)){
		alert('电话号码错误，请重新输入！');
		phone.focus();
		return false;
	}
	return true;
}
function checkTitle(){
	var title = document.getElementById("title");
	if(title.value == ''){alert("标题不能为空！");title.focus();return false;}
	return true;
}
function checkCorp(){
	var cname  = document.getElementById("cname");
	var corpid = document.getElementById("corpid");
	var dues   = document.getElementById("dues");
	var re = /^[0-9\.]+$/;
	
	if(cname.value == ''){alert("社团名称不能为空！");cname.focus();return false;}
	else if(corpid.value == ''){alert("社团编号不能为空！");corpid.focus();return false;}
	else if(dues.value == ''){alert("会费不能为空！");dues.focus();return false;}
	else if(!re.test(dues.value)){alert("会费应为数字！");dues.focus();return false;}
	return true;
}
function checkCorpUser(){
	var username = document.getElementById("username");
	var number   = document.getElementById("number");
	var phone    = document.getElementById("phone");
	var re  = /^[0-9]*$/;
	var re1 = /^[0-9]{7}$/;
	
	if(username.value == ''){alert("社团名称不能为空！");username.focus();return false;}
	else if(number.value == ''){alert("社团帐号不能为空！");number.focus();return false;}
	else if(!re1.test(number.value)){alert("社团帐号错误！");number.focus();return false;}
	else if(!re.test(phone.value)){alert("电话应为数字！");phone.focus();return false;}
	return true;
}
function checkEmpty(id, ale){
	var t = document.getElementById(id);
	if(t.value == ''){alert(ale + "不能为空！");t.focus();return false;}
	return true;
}
function checkNumber(id){
	var t = document.getElementById(id);
	var re= /^[0-9]{12}$/;
	if(!re.test(t.value)){alert("学号错误，请重新输入！");t.focus();return false;}
	return true;
}
function checkAdmin(gid){
	if(gid != 1){alert('对不起，你没有添加管理员权限！');return false;}
	var username = document.getElementById("username");
	var number   = document.getElementById("number");
	var aclass   = document.getElementById("class");
	var phone    = document.getElementById("phone");
	var re1 = /^[0-9]{7}$/;
	var re2 = /^[0-9]{12}$/;
	var re3 = /^[0-9]*$/;
	
	if(username.value == ''){alert("姓名不能为空！");username.focus();return false;}
	else if(number.value == ''){alert("编号不能为空！");number.focus();return false;}
	else if(!re1.test(number.value) && !re2.test(number.value)){alert('编号错误，请重新输入！');number.focus();return false;}
	else if(aclass.value == ''){alert("班级不能为空！");aclass.focus();return false;}
	else if(!re3.test(phone.value)){alert('电话号码错误，请重新输入！');phone.focus();return false;}
	return true;
}
function changeCheck(){
	document.getElementById('checkImg').src = "include/checkbox.php?"+Math.random();
}