<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#download").click(function() {
			$.ajax({
				dataType: 'html',
				url: 'http://localhost/catAnhVeTinh/getDownload/sendData.php',
				success: function(datas) {
					data = JSON.parse(datas);
					console.log(data);
					$("#showResult").append("<iframe src='" + data[0]['image'] + "' style='width: 200px; height: 300px' ></iframe>");
					
					//$("#showResult").load('http://localhost/catAnhVeTinh/getDownload/sendData.php');
					//alert("<iframe src='" + response.url + "' style='display: none;' ></iframe>");
					//$("#showResult").append(response);
					//data = JSON.parse(response);
					//alert("<iframe src='" + data['imageTests'].url + "' style='width: 200px; height: 300px' ></iframe>");
					//return response;
					//window.open(response, "resizeable,scrollbar");
					//alert(response);
					
				}
			})
		})
	})
	</script>
</head>
<body>
    <button id="download">DOWNLOAD</button>
	<div id="showResult"></div>
</body>
</html>
<!--
$.post('/create_binary_file.php', postData, function(retData){
 $("body").append("<iframe src='" + retData.url; + "' style='display: none;' ></iframe>")
}); 


$.post('/create_binary_file.php', postData, function(retData) {
  $("body").append("<iframe src='" + retData.url+ "' style='display: none;' ></iframe>");
}); 

$.post('/create_binary_file.php', postData, function(retData) {
  var iframe = document.createElement("iframe");
  iframe.setAttribute("src", retData.url);
  iframe.setAttribute("style", "display: none");
  document.body.appendChild(iframe);
}); 


Error	6	error LNK1112: module machine type 'x64' conflicts with target machine type 'X86'	E:\Working\WorkSpace\Visual Studio 2012\libdash-master\libdash\qtsampleplayer\Qt5Cored.lib(Qt5Cored.dll)	qtsampleplayer

-->