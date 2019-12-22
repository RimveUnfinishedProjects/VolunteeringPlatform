<!DOCTYPE html>
<html>
<head>
	<title>Savanoriavimas</title>
</head>
<body>

<?php

$servername = "localhost";
$username = "root";
$password = "";


$conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
		if($USER_ID ==''){
			$error[] = 'Please enter the title.';
		}

		if($DESCRIPTION ==''){
			$error[] = 'Please enter the description.';
		}
		if(!isset($error)){

			try {
					//insert into database
					$stmt = $conn->prepare('INSERT INTO projects (USER_ID,PROJECT_NAME,DESCRIPTION,DATE_START) VALUES (:USER_ID,:PROJECT_NAME,:DESCRIPTION,:DATE_START)') ;
					$stmt->execute(array(
						':USER_ID' => $USER_ID,
						':PROJECT_NAME' => $PROJECT_NAME,
						':DESCRIPTION' => $DESCRIPTION,
						':DATE_START' => $DATE_START,
						
					));

					//redirect to index page
					header('Location: index.php');
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

<h2>Projektai</h2>

<form action='' method='post' enctype="multipart/form-data">
 <br>
<input type="number" name="USER_ID" placeholder="USER_ID" required>
  <br>
<input type="text" name="PROJECT_NAME" placeholder="Pavadinimas ..." required>
   <input type="text" name="DESCRIPTION" placeholder="Pavadinimas ..." required>
<input type="date" name="DATE_START">
  <input type="submit" name="submit" value="Paskelbti">
</form> 
<br><br>
<hr/>

<?php

	try {

		$stmt = $conn->query('
					SELECT * FROM (SELECT * FROM projects WHERE 
					ORDER BY PROJECT_ID DESC
					LIMIT 5) t
ORDER BY PROJECT_ID desc');

		while($row = $stmt->fetch()){
			echo '
							<h3>'.$row['PROJECT_ID'].'</h3>
							
							<span>'.$row['PROJECT_NAME'].'</span>
							<br>
							<i><i>'.$row['DESCRIPTION'].'</i> | '.$row['USER_ID'].' | '.$row['DATE_START'].'</i>
						<hr width="30%" align="left">

				';
					}

	} catch(PDOException $e) {
		echo $e->getMessage();
	}
?>


</body>
</html>