<?php
session_start();
$loguname = isset($_SESSION["loguname"]) ? $_SESSION["loguname"] : null;
$key1 = isset($_SESSION["pphrase"]) ? $_SESSION["pphrase"] : null;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Level 2 Authentication</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/graphical.css">
	<style>
        body {
				background-color: #403060;
				background-image: radial-gradient( circle, rgba(  0, 0, 0, 0 ) 0%, rgba( 0, 0, 0, 0.8 ) 100% );
				background-position: center center;
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-size: cover;
			}
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
            }
            #video-background {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                overflow: hidden;
            }
            #video-background video {
                min-width: 100%;
                min-height: 100%;
            }
            #content {
                position: relative;
                z-index: 1;
                text-align: center;
                color: white;
                padding: 20px;
            }
	</style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Raleway:900" rel="stylesheet">
</head>

<body>
	<div id="video-background">
        <video autoplay muted loop>
            <source src="wave_-_87787 (720p).mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
  <div class="text-container">
	<h1><center>SAS LAYER-II</center></h1>
  </div>

<div id="container">
	<button id="red_box" class="btn btn-danger"></button>
	<button id="blue_box" class="btn btn-primary"></button>
	<button id="green_box" class="btn btn-success"></button>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
		<input type="password" class="form-control" id="input" name="graph" placeholder="Pattern Here" readonly/>
		<button class="btn btn-info" id="submit" name="submit">Login</button>
	</form>
</div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
	$('#red_box').click(function(){
		$('#input').val($('#input').val()+'#Q9rd43k#Q9rd43k');
	});
	$('#blue_box').click(function(){
		$('#input').val($('#input').val()+'#R10be43L#R10be43L');
	});
	$('#green_box').click(function(){
		$('#input').val($('#input').val()+'#S11gn43M#S11gn43M');
	});
</script>
</html>
<?php
include 'connection.php';
function hashPassword1($password, $salt) {
	return hash('sha256', $password . $salt); // Concatenate password and salt before hashing
}

function decryptdata($data, $key) {
	$data = base64_decode($data);
	$ivLength = openssl_cipher_iv_length('aes-256-cbc');
	$iv = substr($data, 0, $ivLength);
	$data = substr($data, $ivLength);
	return openssl_decrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

if(isset($_POST["submit"]))
	{
		$graph=$_POST['graph'];
		
		if($graph!=""){
			$logsql = "SELECT * FROM details WHERE Email='$loguname'";
			$result = $connect->query($logsql);
			if ($result->num_rows > 0) {
				// Output data of each row
				while($row = $result->fetch_assoc()) {
					$storedsalt = $row["Salt"];
					//$storedsalt = substr($storedsalt,16,16);
					//echo "stored salt: ",$storedsalt,"<br>";
					$storedGraphical = $row["Graphical"];
					$decryptsalt3 = decryptdata($storedsalt, $key1);
					$decryptsalt3 = substr($decryptsalt3,0,152);
					
					$decryptsalt2 = decryptdata($decryptsalt3, $key1);
					$decryptsalt2 = substr($decryptsalt2,64,152);
					$logpass1 = hashPassword1($graph, $decryptsalt2);
					if($logpass1 == $storedGraphical){
						echo '<script type="text/javascript"> window.location = "logpicture_pass.php" </script>';
					}else{
						echo '<script type="text/javascript">alert("User not found")</script>';
					}
				}
			}
		mysqli_close($connect);
		}
	}
?>