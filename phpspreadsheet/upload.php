<!DOCTYPE html>
<html>
<head>
    <title>Hello</title>
</head>
<body>
    <p>請上傳檔案(xls, xlsx):</p>
    <form action="upload_process.php" method="post" enctype="multipart/form-data">
    	<input name="file" type="file" accept=".xls,.xlsx"/>
		<input type="submit" name="submit" value="上傳檔案" />
	</form>
</body>
</html>