<?php
session_start();
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : null;
$loguname = isset($_SESSION["loguname"]) ? $_SESSION["loguname"] : null;
$key1 = isset($_SESSION["pphrase"]) ? $_SESSION["pphrase"] : null;
?>
<!doctype html>
<html lang="us-en">
<head>
    <title>Picture Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8" />
    <link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/picture.css">

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
        #pic{
            height: 420px;
            width: 510px;
            margin-left: 50px;
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4), 0 6px 20px 0 rgba(0, 0, 0, 0.5);
            margin-top: 20px;
        }

        .small_box{
            height: 140px;
            width: 170px;
            border-radius: 3px;
            margin-left: 10px;
            margin-top: 10px;
            padding: 0;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4), 0 6px 20px 0 rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        #input{
            margin-top: 30px;
            width: 400px;
        }

        .row{
            display: flex;
            justify-content: center;
        }
        .part-column {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 2px;
        }
    </style>
</head>
<body>
<div id="video-background">
    <video autoplay muted loop>
        <source src="pattern_-_85590 (720p).mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

<div class="text-container">
    <h1><center>SAS Layer-III</center></h1>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="part-column">
		<?php
		// Fetching and cropping the image
		$imagePath = "C:/xampp/htdocs/newsas/diagrams/" . $id . ".png"; // Path to the image based on user_id
		$imageData = file_get_contents($imagePath);
		if ($imageData !== false) {
			$originalImage = imagecreatefromstring($imageData); // Suppress warnings
			if ($originalImage !== false) {
				// Resize the image to 510x420
				$resizedImage = imagescale($originalImage, 510, 420);
				if ($resizedImage !== false) {
					$width = imagesx($resizedImage);
					$height = imagesy($resizedImage);
					$segmentWidth = $width / 3;
					$segmentHeight = $height / 3;

					// Loop through segments and display them
					for ($i = 0; $i < 3; $i++) {
						for ($j = 0; $j < 3; $j++) {
							$segment = imagecrop($resizedImage, ['x' => $j * $segmentWidth, 'y' => $i * $segmentHeight, 'width' => $segmentWidth, 'height' => $segmentHeight]);
							if ($segment) {
								// Start output buffering to capture image data
								ob_start();
								imagepng($segment); // Output the image as PNG to buffer
								$imageData = ob_get_clean(); // Capture the buffered image data
								echo '<div class="small_box col-sm-4"><img id="' . $i . $j . '" src="data:image/png;base64,' . base64_encode($imageData) . '"></div>';
								imagedestroy($segment); // Clean up
							} else {
								echo "Error cropping image segment.";
							}
						}
					}
					imagedestroy($resizedImage); // Clean up
				} else {
					echo "Error resizing image.";
				}
			} else {
				$lasterror = error_get_last();
				echo "Error creating image from PNG: " . $lasterror['message'];
			}
		} else {
			echo "Image file not found.";
		}
		?>
        </div>
    </div>
</div>
<form style="margin-left: 500px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <input type="password" class="form-control" id="input" name="pic" placeholder="Pattern Here" readonly/>
    <button class="btn btn-info" id="submit" name="submit">Login</button>
</form>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

    $('#00').click(function(){
        $('#input').val($('#input').val()+'00');
        document.getElementById('00').style.opacity='0.5';
    });

    $('#01').click(function(){
        $('#input').val($('#input').val()+'01');
        document.getElementById('01').style.opacity='0.5';
    });

    $('#02').click(function(){
        $('#input').val($('#input').val()+'02');
        document.getElementById('02').style.opacity='0.5';
    });

    $('#10').click(function(){
        $('#input').val($('#input').val()+'10');
        document.getElementById('10').style.opacity='0.5';
    });

    $('#11').click(function(){
        $('#input').val($('#input').val()+'11');
        document.getElementById('11').style.opacity='0.5';
    });

    $('#12').click(function(){
        $('#input').val($('#input').val()+'12');
        document.getElementById('12').style.opacity='0.5';
    });

    $('#20').click(function(){
        $('#input').val($('#input').val()+'20');
        document.getElementById('20').style.opacity='0.5';
    });

    $('#21').click(function(){
        $('#input').val($('#input').val()+'21');
        document.getElementById('21').style.opacity='0.5';
    });

    $('#22').click(function(){
        $('#input').val($('#input').val()+'22');
        document.getElementById('22').style.opacity='0.5';
    });

    // Repeat similar blocks for other grid cells...
</script>
</body>
</html>
<?php
include 'connection.php';
if(isset($_POST["submit"])) {
    $pic = isset($_POST['pic']) ? $_POST['pic'] : '';

    if($pic != '') {
        $logsql = "SELECT * FROM details WHERE Email='$loguname'";
        $result = $connect->query($logsql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $storedsalt = $row["Salt"];
                $storedPicture = $row["Picture"];
                $decryptsalt3 = decryptdata($storedsalt, $key1);
                $decryptsalt3 = substr($decryptsalt3, 152);

                $logpass1 = hashPassword($pic, $decryptsalt3, 1000);
                if($logpass1 == $storedPicture) {
                    echo '<script>alert("WELCOME YOU ENTERED SAFE ACCESS SYSTEM");</script>';
					echo '<script type="text/javascript"> window.location = "index.php" </script>';
                } else {
                    echo '<script type="text/javascript">alert("User not found")</script>';
                }
            }
        }
        mysqli_close($connect);
    }
}

function hashPassword($password, $salt, $number) {
    $hashedPassword = hash('sha256', $password . $salt);

    for ($i = 0; $i < $number; $i++) {
        $hashedPassword = hash('sha256', $hashedPassword . $salt);
    }
    return $hashedPassword;
}

function decryptdata($data, $key) {
    $data = base64_decode($data);
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $ivLength);
    $data = substr($data, $ivLength);
    return openssl_decrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}
?>