<!DOCTYPE html>
<html lang="utf-8">
	<head>
        <link rel="stylesheet" href="imgupload.css">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="imgupload.js"></script>
	</head>

	<body>
		<form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="file"/>
            <input type="submit" name="submit" id="img-upload" value="上传" />
            <img id="my-img" style="width: 50px; height: 50px; display: none;">
        </form>
	</body>
</html>