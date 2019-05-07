<?php

	$upload_path = 'C:\xampp\htdocs\phpspreadsheet\upload';
	$file_full_name = $_FILES['file']['name']; # XXX.xls
	$file_extension = substr( $file_full_name, strrpos( $file_full_name, '.') + 1 ); # xls
	$upload_file = $upload_path . '\input.' . $file_extension; # C:\xampp\htdocs\phpspreadsheet\upload\input.xls

	# Determine if the folder exists
	if ( !is_dir( $upload_path ) ) {
		// echo 'not exist!\n';
		if ( !mkdir( $upload_path, 0777 ) ) { #預設的 mode 是 0777，意味著最大可能的訪問權
			echo "Failed to create a folder! ";
		}
	}

	if ( $_FILES['file']['error']>0 ) {
        echo "檔案上傳失敗";
    } else {
    	if ( $file_extension=='xls' || $file_extension=='xlsx' ) {
        	if ( !move_uploaded_file( $_FILES['file']['tmp_name'], $upload_file ) ){
 				echo "檔案上傳失敗!";
        	} else {
        		echo "檔案上傳成功!";
        		header('location:transform.php?file=' . $upload_file . '&path=' . $upload_path);
        	}
    	} else {
    		echo '檔案類型不符合!';
    	}
    }

?>