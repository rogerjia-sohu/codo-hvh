<html>
<head>
<title>Test uploadavatar</title>
<script type="text/javascript">
	var max_files = 10;
	var cnt = 0;

	function addLabelAndFile(n = 1){
		if (cnt >= max_files) return;

		if (n < 0) n = 1;
		
		for (i = 0; i < n; i++) {
			cnt++;
			var objLabel = document.createElement('label');
			objLabel.innerHTML = '文件' + cnt;
			objLabel.htmlFor = 'file' + cnt;
			document.getElementById("frmUpload").appendChild(objLabel);
			objLabel = null;

			var objFile = document.createElement('input');
			objFile.type = 'file';
			objFile.id = 'file' + cnt;
			objFile.name = 'filelist[]';
			document.getElementById("frmUpload").appendChild(objFile);
			objFile = null;			

			var objBr = document.createElement('br');
			document.getElementById("frmUpload").appendChild(objBr);
			objBr = null;
		}
	}
	function preSidInput(sender) {
		sender.select();
	}

</script>
</head>
<body onload='addLabelAndFile(1);preSidInput(document.getElementById("sid"))'>
Test uploadavatar<p/>
<form id="frmUpload" action="/hvh/v1/api/uploadavatar?mobile=13683514096" method="post" enctype="multipart/form-data">
sessionid=
<input
	type="text"
	id="sid"
	name="sessionid"
	maxLength=32
	size=40
	value="NOT FINISHED YET!必须输入已登录用户的sessionid"
	onfocus="preSidInput(this)"
/>
<p/>
<input type="submit" name="submit" value="上传" />
<input type="button" name="addFile" value="+file (max=10)" onclick="addLabelAndFile(1)" />
<p/>
</form>
</body>
</html>
