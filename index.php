<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cloud 83 - hosting template ">
    <meta name="keywords" content="cloud, hosting, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="shortcut icon"/>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


    <title>Savanoriavimo Platforma</title>

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
require ("vendor/autoload.php");
session_start();

$servername = "localhost";
$username = "root";
$password = "";


$conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_GET['state'])) {
    $_SESSION['FBRLH_state'] = $_GET['state'];
}
/*Step 1: Enter Credentials*/
$fb = new \Facebook\Facebook([
    'app_id' => '2081443732163904',
    'app_secret' => 'e6e09c33d973ebaccd85a3e13e0450e2',
    'default_graph_version' => 'v4.0',
    //'default_access_token' => '{access-token}', // optional
]);

/*Step 3 : Get Access Token*/
$access_token = $fb->getRedirectLoginHelper()->getAccessToken();
/*Step 4: Get the graph user*/
if(isset($access_token)) {
    try {

        $response = $fb->get('/me',$access_token);
        $fb_user = $response->getGraphUser();
        $vardas = $fb_user->getName();
        echo  '<a href = "logout.php">Atsijungti<a/><br>'.$vardas;

		$response = $fb->get('/me?fields=picture.width(300)', $access_token);
       $user = $response->getGraphUser();
       $name = $user->getPicture();

       $pic_url = $name['url'];
       echo '<br><img src="'.$pic_url.'"><br>';
        //  var_dump($fb_user);

$response = $fb->get('/me?fields=id', $access_token);

// get response
$graphObject = $response->getGraphObject();

$fbid = $graphObject->getProperty('id'); // To Get Facebook Id

    	$_SESSION['user_id']=$fbid;

echo $fbid;    //working as I'm getting facebook ID

$stmt = $conn->prepare("SELECT USER_ID FROM users WHERE USER_ID=$fbid LIMIT 1"); 
$stmt->execute(); 
$row = $stmt->fetch();

if (!($row))
{
				try {
					//insert into database
					$stmt = $conn->prepare('INSERT INTO users (USER_ID,USER_NAME, USER_PHOTO) VALUES (:fbid, :vardas, :pic_url)') ;
					$stmt->execute(array(
						':fbid' => $fbid,
						':vardas' => $vardas,
						':pic_url' => $pic_url,
					));

					header('Location: status.php');
				} catch(PDOException $e)
					{
				   	 echo $e->getMessage();
					}

} else {
			$stmt = $conn->prepare('SELECT USER_TYPE FROM users WHERE USER_ID = :fbid') ;
			$stmt->execute(array(':fbid' => $fbid));
			$row = $stmt->fetch();

			echo "<br>user type - ".$row['USER_TYPE'];
	header('Location: platforma.php');
}

    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        echo  'Graph returned an error: ' . $e->getMessage();
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }
} else { 
/*Step 2 Create the url*/
if(empty($access_token)) {
?>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <!-- Hero section -->
    <section class="hero-section">
        <div class="hero-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="img/bg.jpg">
                <div class="container">
                    <h2>Savanoriavimo Platforma</h2>
                    <div class="clearfix"></div>
<?php
    echo "
    <a href='{$fb->getRedirectLoginHelper()->getLoginUrl("http://localhost/index.php")}' class='site-btn sb-c1'>Prisijungti su Facebook</a>";

} 
}

?>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero section end -->


    <!-- Milestones section -->
    <section class="milestones-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="milestone-icon">
                        <img src="img/milestone-icons/1.png" alt="">
                    </div>
                    <div class="milestone-text text-white">
                        <h2><?php                               try {

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
                    <div class="milestone-text text-white">
                        <h2><?php                               try {

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
                    <div class="milestone-text text-white">
                        <h2>0</h2>
                        <p>Užbaigti projektai</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="milestone-icon">
                        <img src="img/milestone-icons/4.png" alt="">
                    </div>
                    <div class="milestone-text text-white">
                        <h2><?php                               try {

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
    </section>
    <!--====== Javascripts & Jquery ======-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/circle-progress.min.js"></script>
    <script src="js/main.js"></script>

    </body>
</html>