<!DOCTYPE html>
<html>
<head>
<title>Upload</title>
<script type="text/javascript" src="jquery-2.1.1.min.js"></script>
<script type="text/javascript">

<?php
$user = mysql_real_escape_string($_GET['u']);
$pw = mysql_real_escape_string($_GET['p']);
?>


$(document).ready(function(e) {
    $("#uploadbtn").click(function(e) {
        var xhr = new XMLHttpRequest();
		var file = document.getElementById('fileToUpload').files[0];
		var fd = new FormData();
		fd.append("file", file);
		fd.append("username", "<?php echo($user); ?>");
		fd.append("password", "<?php echo($pw); ?>");
		fd.append("title", $("#title").val());
		fd.append("desc", $("#desc").val());
		fd.append("tags", $("#tags").val());

		xhr.upload.addEventListener("progress", uploadProgress, false);
		xhr.addEventListener("load", uploadComplete, false);
		xhr.addEventListener("error", uploadFailed, false);
		xhr.addEventListener("abort", uploadCanceled, false);
		xhr.open("POST", "upload_.php");
		xhr.send(fd);
	});
});


function fileSelected() {
  var file = document.getElementById('fileToUpload').files[0];
  if (file) {
    var fileSize = 0;
    if (file.size > 1024 * 1024)
      fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
    else
      fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
          
    document.getElementById('fileName').innerHTML = 'Name: ' + file.name;
    document.getElementById('fileSize').innerHTML = 'Size: ' + fileSize;
    document.getElementById('fileType').innerHTML = 'Type: ' + file.type;
  }
}


function uploadProgress(evt) {
  if (evt.lengthComputable) {
    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
    document.getElementById('progressNumber').innerHTML = percentComplete.toString() + '%';
  }
  else {
    document.getElementById('progressNumber').innerHTML = 'unable to calculate progress.';
  }
}

function uploadComplete(evt) {
  alert(evt.target.responseText);
  location.href = "index.php";
}

function uploadFailed(evt) {
  alert("There was an error attempting to upload the file.");
}

function uploadCanceled(evt) {
  alert("The upload has been cancelled by the user or the browser dropped the connection.");
}  
</script>
</head>
<body>
Content WIP. <br>
  <form id="form1" enctype="multipart/form-data" method="post" action="Upload.aspx">
    <div class="row">
      <label for="fileToUpload">Select a Video</label><br />
      <input type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();"/>
      <input type="text" id="title" placeholder="Title"/>
      <textarea id="desc">Description</textarea>
      <input type="text" id="tags" placeholder="Tags"/>
    </div>
    <div id="fileName"></div>
    <div id="fileSize"></div>
    <div id="fileType"></div>
    <div class="row">
      <input type="button" id="uploadbtn" value="Upload" />
    </div>
    <div id="progressNumber"></div>
  </form>
</body>
</html>