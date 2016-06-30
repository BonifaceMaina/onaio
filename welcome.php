<html>
<head>
	<title>ONA KENYA</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
<div class="container">
	<img src="logo.png" class="img-rounded" alt="Cinque Terre" width="80" height="40">
    
</div>
<div class="container">
	<?php 
		
	require_once './calculate.php';
		//getting the data from the URL
		$string= file_get_contents('https://raw.githubusercontent.com/onaio/ona-tech/master/data/water_points.json');
		$json=json_decode($string, true);
		
		var_dump(Calculator($json));
	 ?>

</div>

</body>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="main_js.js"></script>
</html>