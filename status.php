<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Savanoriavimo Platforma</title>
	<meta charset="UTF-8">
	<meta name="description" content="Cloud 83 - hosting template ">
	<meta name="keywords" content="cloud, hosting, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->
	<link href="img/favicon.ico" rel="shortcut icon"/>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/magnific-popup.css"/>
	<link rel="stylesheet" href="css/owl.carousel.min.css"/>
	<link rel="stylesheet" href="css/style.css"/>
	<link rel="stylesheet" href="css/animate.css"/>


	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
<?php
//check to see what page user first visited
session_start();
//echo $_SESSION['user_id'];
if(isset($_SESSION['user_id']))
{
	?>
	<!-- Services section -->
	<section class="blog-section spad">
		<div class="container">
			<div class="blog-post">
				<img src="img/savanoriai_kaman.lt_.jpg" alt="" class="center">
				<div class="row">
					<div class="col-lg-10 offset-lg-1">
						<div class="post-content">
							<a href="platforma.php?=0">
							<div class="post-date">Prisijungti</div></a>
							<h4>Prisijunk prie savanorių komandos ir išsirink sau patinkantį projektą</h4>
						</div>
					</div>
				</div>
			</div>
			<div class="blog-post">
				<img src="img/Coordinator.jpg" alt="" class="center">
				<div class="row">
					<div class="col-lg-10 offset-lg-1">
						<div class="post-content">
							<a href="platforma.php?=1">
							<div class="post-date">Prisijungti</div></a>
							<h4>Pradėk savo projektą būdamas koordinatorius</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Services section end -->
<?php
//savanoris - 0, kuratorius 1
/*echo 'Pasirinkite savo statusą:<hr/>
<a href="platforma.php?=0" target="_blank">Savanoris</a><br>
<a href="platforma.php?=1" target="blank">Kuratorius</a>';
*/
}
else
{
	header('Location: index.php');
}
?>

	<!--====== Javascripts & Jquery ======-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/circle-progress.min.js"></script>
	<script src="js/main.js"></script>

	</body>
</html>
