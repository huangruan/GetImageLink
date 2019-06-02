<?php 
	include 'functions.php';

	$folders = scan_dir('manga');
	// $subFolders = scan_dir('manga/one-piece', false);

	if(isset($_GET['action'])){
		if (isset($_GET['dir'])) {
			$subFolders = scan_dir($_GET['dir'], false);
			echo json_encode($subFolders);
		}

	}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assert/css/styles.css">

    <title>Output Image Link</title>
  </head>
  <body>
    <div class="container gray">
    	<div>
    		<label class="bold">Path</label>
    	</div>
    	<div>
    		<label>Path Folder: Manga</label>
    	</div>

    	<div class="row">
    		<div class="col-md-12">
				<input type="text" id="inputPath" class="form-control" value="manga">
    		</div>
    	</div>

    	<div class="row margin-top-5">
    		<div class="col-md-8">
    			<select class="custom-select" multiple id="directory">
				  <?php 
				  		foreach ($folders as $key => $value) {
				  			echo '<option value="' .$value. '">' .$value. '</option>';
				  		}
				  ?>
				</select>
    		</div>

    		<div class="col-md-4">
    			<select class="custom-select" multiple id="subDirName">
				  	<option></option>
				</select>
    		</div>
    	</div>

    	<div class="margin-top-20 row">
    		<div class="col-md-8">
	    		<label class="bold">Url Path</label>
	    	</div>

	    	<div class="col-md-4">
	    		<button onclick="copyToClipboard('#links')" class="btn btn-primary btn-copy">Copy</button>
	    	</div>
    	</div>

    	<div class="row">
    		<div class="col-md-12">
    			<textarea id="links" class="form-control" rows="5"></textarea>
    		</div>
    	</div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript">
    	function copyToClipboard(element) {
		  var $temp = $("<input>");
		  $("body").append($temp);
		  $temp.val($(element).val()).select();
		  document.execCommand("copy");
		  $temp.remove();
		}

    	$('#directory').change(function () {
    		var dirValue = document.getElementById('directory').value;
    		$('#inputPath').val('manga/' + dirValue);
    		$('#links').val('');
    		$.ajax({
    			url: 'functions.php',
    			type: 'GET',
    			data: {action: 'scan_dir', dir: 'manga/' + dirValue },
    			success: function (data) {
    				var dirName = JSON.parse(data);
    				var subDirName = $('#subDirName');
    				subDirName.empty();
		            for(var i = 0; i<dirName.length; i++){
		            	subDirName.append('<option id="' + dirName[i] + '" value="' + dirName[i] + '" >' + dirName[i] + '</option>');
		            }
		        }
    		});
    		
    	});

    	$('#subDirName').change(function () {
    		var dirValue = $('#subDirName').val();
    		var inputPathName = $('#directory').val();
    		$('#inputPath').val('manga/' + inputPathName + '/' + dirValue);
    		$('#inputPath').empty();
    		// alert(dirValue);

    		$.ajax({
    			url: 'functions.php',
    			type: 'GET',
    			data: {action: 'imageOutputLink', dir: 'manga/' + inputPathName + '/' + dirValue },
    			success: function (data) {
    				var imageLinks = JSON.parse(data);
    				$('#links').empty();
    				var links = '';
    				for(var i = 0; i<imageLinks.length; i++){
    					if(i == 0){
    						links = imageLinks[i];
    					} else {
    						links = links + ',' + imageLinks[i];
    					}
		            }
		            $('#links').val(links);
		        }
    		});
    	});
    </script>
  </body>
</html>