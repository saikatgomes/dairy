<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CS 784 - Data Integration Project</title>

	<!-- Bootstrap -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<link href="noUISlider/jquery.nouislider.css" rel="stylesheet">
	<!--<link href="simpleSlider/bootstrap-slider.css" rel="stylesheet">-->
	<!--
	<link href="noUISlider/jquery.nouislider.min.css" rel="stylesheet">
	<link href="noUISlider/jquery.nouislider.pips.css" rel="stylesheet">
	<link href="noUISlider/jquery.nouislider.pips.min.css" rel="stylesheet">
	-->

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>



<?php
	/** Include PHPExcel */
	require_once 'PHPExcel/Classes/PHPExcel.php';
	#print "request --- ";
	#var_dump($_REQUEST);
	#print "post --- ";
	#var_dump($_POST);
	#print "\r\n";
	#print "get --- ";
	#var_dump($_GET);
	#print "\r\n";
	#print "files --- ";
	#var_dump($_FILES);
	#print "\r\n";
?>


    <body>	


	<!-- Modal START -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="index.php" method="post" enctype="multipart/form-data">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h4 class="modal-title" id="myModalLabel">Upload data from excel</h4>
		  </div>
		  <div class="modal-body">
			  <div class="form-group">
				<label for="exampleInputFile">Select a file to upload:</label>
				<input type="file" name="fileToUpload" id="fileToUpload">
				<p class="help-block">Only Excel Spreadsheets allowed and asumed.</p>
			  </div>
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input class="btn btn-primary" type="submit" value="Upload Data" name="submit">
		  </div>
		</div>
	  </div>
	</form>
	</div>
	<!-- Modal END -->

	<!-- TOP NAVBAR START-->
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		    <span class="sr-only">Toggle navigation</span>
		    <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="#">Saikat R. Gomes</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
		    <li class=""><a href="mailto:saikat@cs.wisc.edu">saikat@cs.wisc.edu</a></li>
		    <li><a href="#" data-toggle="modal" data-target="#myModal" >Upload</a></li>
		    <li><a href="https://github.com/saikatgomes/dairy" target="_blank">Git Repo</a></li>
		  </ul>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<!-- TOP NAVBAR END-->
	
	<center>
	<?php
	$target_dir = "uploads/";
	$target_file = $target_dir . 'data.xls';
	$uploadOk = 1;
	$imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {

		// Allow certain file formats
		if($imageFileType != "xls" && $imageFileType != "xlsx") {
			echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				echo "Sorry, only XLS & XLSX files are allowed.";
			echo "</div>";			
			$uploadOk = 0;
		}
		else{
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
					echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
					echo "Sorry, your file was not uploaded.";
				echo "</div>";	
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo "The file <strong>". basename( $_FILES["fileToUpload"]["name"]). "</strong> has been uploaded.";
					echo "</div>";	
				} else {
					echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo "Sorry, there was an error uploading your file.";
					echo "</div>";	
				}
			}
		}
		unset($_FILES["fileToUpload"]);
		unset($_POST["submit"]);
		/*	
			print "files --- ";
			var_dump($_FILES);
			print "post --- ";
			var_dump($_POST);
		*/
	}
	?>


	<?php
		include 'PHPExcel/Classes/PHPExcel/IOFactory.php';
		$inputFileName = 'uploads/data.xls';

		if (file_exists($inputFileName)) {
			
			//  Read your Excel workbook
			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch (Exception $e) {
				// print better messages

				echo "<div class=\"col-md-12\">";		
					echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo 'Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME). '": ' . $e->getMessage();
					echo "</div>";	
				echo "</div>";

				#die();
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$xMax=0;
			$yMax=0;

			//  Loop through each row of the worksheet in turn
			for ($row = 1; $row <= $highestRow; $row++) {
				//  Read a row of data into an array
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
				NULL, TRUE, FALSE);
				if($row==1){
					$tableColHr1=$rowData[0][0];
					$tableColHr2=$rowData[0][1];
				}
				else{
					$tableData[$row-1][0]=$rowData[0][0];
					$tableData[$row-1][1]=$rowData[0][1];
					if($rowData[0][0]>$xMax){
						$xMax=$rowData[0][0];
					}
					if($rowData[0][1]>$yMax){
						$yMax=$rowData[0][1];
					}
				}
			}
			#echo "<br> c1 ".$tableColHr1;
			#echo "<br> c2 ".$tableColHr2."<br><br>";
			#print_r($tableData);

		}
		
	?>	


	</center>

	<!-- Button trigger modal -->
	<center>
	<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
	  Upload Data
	</button>
	</center>

	<br>

	<center>
	<div class="row">

		<?php
			if (file_exists($target_file)) {
				echo "<div class=\"col-md-1\">&nbsp;</div>";
				echo "<div class=\"col-md-5\">";	
					include 'graph.php';	
				echo "</div>";
				echo "<div class=\"col-md-5\">";		
					include 'table.php';				
				echo "</div>";
				echo "<div class=\"col-md-1\">&nbsp;</div>";
			}else{
				echo "<div class=\"col-md-12\">";		
					echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						echo "<strong>No Data file uploaded!</strong><br>Please upload a data file.";
					echo "</div>";	
				echo "</div>";
			}
		?>	

	</div>
	</center>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="bootstrap/js/bootstrap.min.js"></script>


<script src="noUISlider/jquery.nouislider.all.js"></script>
<!--<script type="text/javascript" src="simpleSlider/bootstrap-slider.js"></script>-->

    </body>
</html>
