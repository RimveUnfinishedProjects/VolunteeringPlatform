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
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>
<?php
session_start();
//echo $_SESSION['user_id'];
$kodas = $_SESSION["user_id"];
//echo $kodas;
if(isset($kodas))
{
	//savanoris - 0, kuratorius 1
$servername = "localhost";
$username = "root";
$password = "";

$conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = substr($_SERVER['REQUEST_URI'], -1);
	if ($id == '1' || $id == '0') {

					try {

					//insert into database
					$stmt = $conn->prepare('UPDATE users SET USER_TYPE = :id WHERE USER_ID = :kodas') ;
					$stmt->execute(array(
						':id' => $id,
						':kodas' => $kodas,
					));

						header('Location: platforma.php');
					} catch(PDOException $e)
						{
					   	 echo $e->getMessage();
						}
	}
	else {

			$stmt = $conn->prepare('SELECT USER_TYPE, USER_NAME, USER_PHOTO FROM users WHERE USER_ID = :kodas') ;
			$stmt->execute(array(':kodas' => $kodas));
			$row = $stmt->fetch();
			echo "<div align = 'right'>";
if ($row["USER_TYPE"] == '0') echo "Labas Savanori!";
else echo "Labas Koordinatoriau!";
echo '<br><img src="'.$row["USER_PHOTO"].'" width="100px" height="100px"><br>';
echo ' <i>'.$row["USER_NAME"].'</i><br><a href = "logout.php">Atsijungti<a/><br></div>';

if( $row["USER_TYPE"] == '1')
{
	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$check = false;
		// END HERE

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);


		//very basic validation
		if($PROJECT_NAME ==''){
			$error[] = 'Please enter the name.';
		}

		if($DESCRIPTION ==''){
			$error[] = 'Please enter the description.';
		}
		if(!isset($error)){

			try {
					//insert into database
					$stmt = $conn->prepare('INSERT INTO projects (USER_ID,PROJECT_NAME,DESCRIPTION,DATE_START, DATE_END, TIME_START, TIME_END) VALUES (:kodas,:PROJECT_NAME,:DESCRIPTION,:DATE_START,:DATE_END,:TIME_START,:TIME_END)') ;
					$stmt->execute(array(
						':kodas' => $kodas,
						':PROJECT_NAME' => $PROJECT_NAME,
						':DESCRIPTION' => $DESCRIPTION,
						':DATE_START' => $DATE_START,
						':DATE_END' => $DATE_END,
						':TIME_START' => $TIME_START,
						':TIME_END' => $TIME_END,
						
					));

					//redirect to index page
					header('Location: platforma.php');
					exit;
			} catch(PDOException $e)
				{
			   	 echo $e->getMessage();
				}
		}

}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}

?>
	<!-- Element section -->
	<section class="element-section spad">
		<div class="container">
			<!-- element -->
			<div class="element">
				<h3 class="el-title">Sukurkite naują projektą</h3>	
				<div class="row">
					<div class="col-lg-6 mb-5 mb-lg-0">
						<div id="accordion" class="accordion-area">
						<div class="panel">
							<div class="panel-header" id="headingOne">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">Sukurti</button>
							</div>
							<div id="collapse1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
								<div class="panel-body">
								
									<form class="contact-form" action='' method='post' enctype="multipart/form-data">
									<input type="text" name="PROJECT_NAME" placeholder="Pavadinimas">
									<p>Projekto pradžia</p>
									<input type="date" name ="DATE_START" placeholder="Data nuo">
									<input type="time" name="TIME_START" placeholder="nuo">
									<div></div>
									<p>Projekto pabaiga</p>
									<input type="date" name="DATE_END" placeholder="Data iki">
									<input type="time" name="TIME_END" placeholder="iki">
									<div></div>
									<p>Aprašymas</p>
									<textarea name="DESCRIPTION" placeholder="Apie projektą"></textarea>
									<button type="submit" name="submit" class="site-btn sb-c1">Patvirtinti</button>
									<p></p>
									</form>
							
								</div>
							</div>
						</div>
					</div>
				</div>
			<!-- projektai -->
			<div class="element">
				<h3 class="el-title"> Jūsų projektų sąrašas</h3>
				<div class="row">
					<div class="col-lg-6 mb-5 mb-lg-0">
						<div id="accordion" class="accordion-area">
							<div class="panel">
							<div class="panel-header" id="headingTwo">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">Projektai</button>
							</div>
							<div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
<?php
									try {

		$stmt = $conn->query('
					SELECT * FROM (SELECT * FROM projects 
					ORDER BY PROJECT_ID DESC) t
ORDER BY PROJECT_ID desc');

		while($row = $stmt->fetch()){

			echo '<div class="panel-body">
									<p>'.$row["PROJECT_NAME"].'</p></div>';
 
					}

	} catch(PDOException $e) {
		echo $e->getMessage();
	}
} else if ($row["USER_TYPE"] == '0')
{

			echo '	<!-- Element section -->
	<section class="element-section spad">
		<div class="container">
			<!-- element -->
			<!-- projektai -->
			<div class="element">
				<h3 class="el-title"> Visu projektų sąrašas</h3>
				<div class="row">
					<div class="col-lg-6 mb-5 mb-lg-0">
						<div id="accordion" class="accordion-area">
							<div class="panel">
							<div class="panel-header" id="headingTwo">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">Projektai</button>
							</div>
							<div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">';
									try {

		$stmt = $conn->query('
					SELECT * FROM (SELECT * FROM projects 
					ORDER BY PROJECT_ID DESC) t
ORDER BY PROJECT_ID desc');

		while($row = $stmt->fetch()){

			echo '<div class="panel-body">
									<p>'.$row["PROJECT_NAME"].'</p></div>';


	}
} catch(PDOException $e) {
		echo $e->getMessage();
	}
			echo'<h3 class="el-title"> Registracija</h3>';


	try {

		$stmt = $conn->query('
					SELECT * FROM (SELECT * FROM projects
					ORDER BY PROJECT_ID DESC
					LIMIT 5) t
ORDER BY PROJECT_ID desc');
echo '<input id="ChildName" name="ChildName" placeholder="Projekto pavadinimas" list="names" style=" width:450px; height:45px;font-size:20pt;" maxlength="15" size="6" >';
echo '<datalist id="names">';
		while($row = $stmt->fetch()){
			echo "<option value='". $row['PROJECT_NAME']. "'></option>";
   
					}
echo '</datalist><br><button type="submit">Tvirtinti</button>';

	} catch(PDOException $e) {
		echo $e->getMessage();
	}


}
	?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- element -->
			<div class="element">
				<h3 class="el-title">Statistika</h3>
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<div class="milestone-icon">
							<img src="img/milestone-icons/1.png" alt="">
						</div>
						<div class="milestone-text">
							<h2><?php 								try {

		$stmt = $conn->query('SELECT COUNT(*) FROM users WHERE USER_TYPE = "0"');

		$row = $stmt->fetch();
		echo $row["COUNT(*)"];

} catch(PDOException $e) {
		echo $e->getMessage();
	} ?></h2>
							<p>Savanoriai</p>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="milestone-icon">
							<img src="img/milestone-icons/2.png" alt="">
						</div>
						<div class="milestone-text">
							<h2><?php 								try {

		$stmt = $conn->query('SELECT COUNT(*) FROM projects');

		$row = $stmt->fetch();
		echo $row["COUNT(*)"];

} catch(PDOException $e) {
		echo $e->getMessage();
	} ?></h2>
							<p>Projektai</p>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="milestone-icon">
							<img src="img/milestone-icons/3.png" alt="">
						</div>
						<div class="milestone-text">
							<h2>0</h2>
							<p>Užbaigti projektai</p>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="milestone-icon">
							<img src="img/milestone-icons/4.png" alt="">
						</div>
						<div class="milestone-text">
							<h2><?php 								try {

		$stmt = $conn->query('SELECT COUNT(*) FROM users WHERE USER_TYPE = "1"');

		$row = $stmt->fetch();
		echo $row["COUNT(*)"];

} catch(PDOException $e) {
		echo $e->getMessage();
	} ?></h2>
							<p>Koordinatorių</p>
						</div>
					</div>
				</div>
			</div>

<?php
	}

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
