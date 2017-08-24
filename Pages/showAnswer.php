<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Namnlöst dokument</title>
</head>

<body>
<?php
	require('../Scripts/dbConnect.php');
	
	$data = file_get_contents( "php://input" ); //$data is now the string '[1,2,3]';
	$data = json_decode( $data ); //$data is now a php array array(1,2,3)
	
	echo $data[1][0] . "BALLLS";
	
	//foreach ($listArray as $list) {
//		echo $list[0] . " | " . $list[1] . "<br>";
//	}
	
	mysqli_close($conn);
?>
</body>
</html>