<?php
//$url = http://www.chuyentranh.com
function imageOutputLink($directory, $url = 'http://truyentranhtuan.com'){

	$images = glob($directory . "/*.*");
	$arrImage = array();

	foreach ($images as $key => $image) {
		$arrImage[$key] = $url . '/' . $image;
	}
	return $arrImage;
}


function scan_dir($dir, $sort = true) {
    $ignored = array('.', '..', '.svn', '.htaccess');

    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    // sắp xếp theo thời gian update
    if($sort ==  true){
    	 arsort($files);
    }
   
    $files = array_keys($files);

    return ($files) ? $files : false;
}

if(isset($_GET['action'])){
	if($_GET['action'] == 'scan_dir'){
		if (isset($_GET['dir'])) {
			$subFolders = scan_dir($_GET['dir'], false);
			echo json_encode($subFolders ? $subFolders : []);
		}
	}
	
	if($_GET['action'] == 'imageOutputLink'){
		if (isset($_GET['dir'])) {
			$imageLinks = imageOutputLink($_GET['dir']);
			echo json_encode($imageLinks ? $imageLinks : []);
		}
	}

}