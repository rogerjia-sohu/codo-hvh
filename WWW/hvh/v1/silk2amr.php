<?php
require_once 'hvh/hvh.class.php';
use hvh\{Silk2AmrFileManager,Utils};

$pagename = 'Test Upload silk and transcode to amr';
printf('<head><title>%s</title></head>', $pagename);
printf('%s<p/>', $pagename);

if (!empty($_FILES)) {
	$files = $_FILES['filelist'];
	$fm = new Silk2AmrFileManager();
	$filenames = $_FILES['filelist']['name'];
	$cnt = 0;
	foreach ($filenames as $fname) {
		if (!empty($fname)) {
			$orgext = '.'.pathinfo($fname, PATHINFO_EXTENSION);
			$tmpfile = $_FILES['filelist']['tmp_name'][$cnt];
			$tmpfile_w_orgext = $tmpfile . $orgext;
			rename($tmpfile, $tmpfile_w_orgext);
			$ret = $fm->SaveFile($tmpfile_w_orgext);
			unlink($tmpfile_w_orgext);
			printf('%s => "%s"<br/>', $fname, $ret);
		}
		$cnt++;
	}

	$url = sprintf('http://%s%s', $_SERVER['SERVER_NAME'],$_SERVER['REQUEST_URI']);
	printf('<p/><input type="button" onclick="JavaScript:window.location.assign(\'%s\')" value="返回"/><br/>',$url);

} else {
?>
<html>
<head>
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
</script>
</head>
<body onload='addLabelAndFile(1)'>
<form id="frmUpload" action="/hvh/v1/api/silk2amr" method="post" enctype="multipart/form-data">
<input type="submit" name="submit" value="上传" />
<input type="button" name="addFile" value="+file (max=10)" onclick="addLabelAndFile(1)" />
<p/>
</form>
</body>
</html>
<?php
}
?>
