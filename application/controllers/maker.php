<!-- saved from url=(0022)http://kt.theffao.net/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>uCloudBiz OpenAPI Request Maker</title>


<!-----------------------------------------------------------------
입력값 쿠키 저장
------------------------------------------------------------------>
<script language="javascript">
function setCookie(name, value, expires) {
	document.cookie = name + "=" + escape(value) + "; path=/; expires=" + expires.toGMTString();
}
function getCookie(Name) {
	var search = Name + "=";
	if ( document.cookie.length > 0 )
	{
		offset = document.cookie.indexOf(search);
		if ( offset != -1 )
		{
			offset += search.length;
			end = document.cookie.indexOf(";", offset);
			if ( end == -1 )
			{
				end = document.cookie.length;
			}
			return unescape(document.cookie.substring(offset, end));
		}
	}
	return "";
}
function saveValue(form) {
	var expdate = new Date();
	if ( form.checksaveValue.checked )
	{
		expdate.setTime(expdate.getTime() + 1000 * 3600 * 24 * 30);
	}
	else
	{
		expdate.setTime(expdate.getTime() - 1);
	}
	setCookie("saveValue1", form.apikey.value, expdate);
	setCookie("saveValue2", form.ecretkey.value, expdate);
	setCookie("saveValue3", form.command.value, expdate);
}
</script>
</head>
<body onload="getid(document.mainform)">
<h2>uCloudBiz OpenAPI Request Maker</h2><br>

<!-----------------------------------------------------------------
서비스 선택 부분 - 각 API 호출 주소 기재
------------------------------------------------------------------>
<form name="mainform" action="http://kt.theffao.net/callapi.php" method="post" target="ifr">
<p>
<b>Service Type : </b>
<select name="svctype">
<option value="https://api.ucloudbiz.olleh.com/server/v1/client/api?" selected="selected">uCloud Server</option>
<option value="https://api.ucloudbiz.olleh.com/db/v1/client/api?">uCloud DB</option>
<option value="https://api.ucloudbiz.olleh.com/loadbalancer/v1/client/api?">Loadbalancer</option>
<option value="https://api.ucloudbiz.olleh.com/waf/v1/client/api?">WAF</option>
<option value="https://api.ucloudbiz.olleh.com/nas/v1/client/api?">Cloud NAS</option>
<option value="https://api.ucloudbiz.olleh.com/watch/v1/client/api?">uCloud Watch</option>
<option value="https://api.ucloudbiz.olleh.com/messaging/v1/client/api?">uCloud Messaging</option>
<option value="https://api.ucloudbiz.olleh.com/autoscaling/v1/client/api?">uCloud AutoScaling</option>
<option value="https://api.ucloudbiz.olleh.com/cdn/v1/client/api?">uCloud CDN</option>
</select><br>
</p>

<!----------------------------------------------------------
APIKEY, SECRETKEY, COMMAND 입력 창
----------------------------------------------------------->
<p><b>APIKEY : </b><input type="text" style="width:750px;" name="apikey"><br></p>
<p><b>SECRETKEY : </b><input type="text" style="width:750px;" name="secretkey"><br></p>
<p><b>Command : </b>
<textarea row="3" cols="100" name="command"></textarea>
</p><h5>*** 반드시 앞에 command= 를 붙여서 작성하여 주세요. ex) command=listVirtualMachines</h5>
<p></p>
<p><input type="checkbox" name="checksaveValue" onclick="saveValue(this.form)"><font size="2">입력값 저장</font><br></p>
<input type="submit" name="submit" value="API Request 생성">
</form>
<iframe name="ifr" width="100%" height="100%" marginwidth="0" marginheight="0" frameborder="0" src="./uCloudBiz OpenAPI Request Maker_files/saved_resource.html"></iframe>

</body></html>