
<?php
session_start();
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : null;
$key = isset($_SESSION["passphrase"]) ? $_SESSION["passphrase"] : null;
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
			<div class="col-md-5">
				<div><img id="pic" /></div>
			</div>
			<div class="col-md-1">
				<button class="btn btn-warning" style="margin-left:25px; margin-right:20px; margin-top: 230px;" onclick="image_crop()">Crop</button>
			</div>
		
			<div class="col-md-6">
				<div class="part-column">
					<div class="small_box col-sm-4"><img id="00"></div>
					<div class="small_box col-sm-4"><img id="01"></div>
					<div class="small_box col-sm-4"><img id="02"></div>
				</div>	
				<div class="part-column">
					<div class="small_box col-sm-4"><img id="10"></div>
					<div class="small_box col-sm-4"><img id="11"></div>
					<div class="small_box col-sm-4"><img id="12"></div>
				</div>
				<div class="part-column">
					<div class="small_box col-sm-4"><img id="20"></div>
					<div class="small_box col-sm-4"><img id="21"></div>
					<div class="small_box col-sm-4"><img id="22"></div>
				</div>
			</div>
		</div>
		<form style="margin-left: 500px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
			<input type="file" accept="image/*" name="image" id="image" onchange="loadImage()" />
			<input type="password" class="form-control" id="input" name="pic" placeholder="Pattern Here" required/>
			<button class="btn btn-info" id="submit" name="submit">Save</button>
		</form>
	<script>
		function loadImage() {
				var input = document.getElementById('image');
				var img = document.getElementById('pic');
				img.src = URL.createObjectURL(input.files[0]);
			}

		function image_crop(){
			// Get the original image
			var originalImage = document.getElementById('pic');

			// Create a canvas element
			var canvas = document.createElement('canvas');
			var ctx = canvas.getContext('2d');

			// Set canvas dimensions to desired final image size
			var width = 510;
			var height = 420;
			canvas.width = width;
			canvas.height = height;

			// Calculate the scaling factor to fit the original image into the canvas
			var scaleX = width / originalImage.width;
			var scaleY = height / originalImage.height;
			var scale = Math.min(scaleX, scaleY);

			// Calculate the scaled dimensions
			var scaledWidth = originalImage.width * scale;
			var scaledHeight = originalImage.height * scale;

			// Calculate the x and y coordinates for centering the scaled image on the canvas
			var offsetX = (width - scaledWidth) / 2;
			var offsetY = (height - scaledHeight) / 2;

			// Draw the scaled image onto the canvas
			ctx.drawImage(originalImage, offsetX, offsetY, scaledWidth, scaledHeight);

			// Get the data URL of the resized image
			var resizedImgSrc = canvas.toDataURL();

			// Now, you can crop the resized image using the logic from your original function
			var mLeft = 0;
			var mTop = 0;
			for (var i = 0; i < 3; i++) {
				mLeft = 0;
				for (var j = 0; j < 3; j++) {
					var tempId = i.toString() + j.toString();
					var imgId = '#' + tempId;

					// Set the src and position for each smaller image
					$(imgId).attr('src', resizedImgSrc);
					$(imgId).css('marginLeft', mLeft + 'px');
					$(imgId).css('marginTop', mTop + 'px');
					mLeft -= 170; // Adjust as needed
				}
				mTop -= 140; // Adjust as needed
			}
		}
        
	</script>
	
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
	</script>
</html>
<?php
include 'connection.php';

function generateSalt() {
    return bin2hex(random_bytes(8)); // Generate a 16-byte (128-bit) random salt
}
function hashPassword($password, $salt, $number) {
    $hashedPassword = hash('sha256', $password . $salt); // Initial hash

    // Iterate $number times to apply stretching
    for ($i = 0; $i < $number; $i++) {
        $hashedPassword = hash('sha256', $hashedPassword . $salt);
        
    }
    //echo $hashedPassword,"<br>";
    return $hashedPassword;
}
function encrypt($data, $key) {
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivLength);
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted);
}
if(isset($_POST["submit"]) && isset($_FILES["image"]))
	{
		$pic=$_POST['pic'];
		$uploadFolder = 'C:\xampp\htdocs\newsas\diagrams\\';
		$tempFile1 = $_FILES["image"]["tmp_name"];
		$originalFile1 = $id.".png";
		$destination1 = $uploadFolder.$originalFile1;
		move_uploaded_file($tempFile1, $destination1);
        //echo $key;
		$logsql = "SELECT * FROM details WHERE id='$id'";
		$result = $connect->query($logsql);
		if ($result->num_rows > 0) {
		// Output data of each row
			while($row = $result->fetch_assoc()) {
				$storedsalt = $row["Salt"];
				//echo "while loop stored salt: ",$storedsalt,"<br>";
			}
            //echo "stored salt: ",$storedsalt,"<br>";
		}
		$saltpic = generateSalt();
		// Hash the password with the generated salt
		$hashpic = hashPassword($pic, $saltpic, 1000);
		//concatenation of the salt 
        //echo $storedsalt;
        $salt = $storedsalt.$saltpic;
        $salt = encrypt($salt, $key);

		//echo "<br> Salt length: ",strlen($salt),"<br>";
		//echo $salt,"<br>";
		//echo "Sub str:",substr($salt, 16,32);
		
		$sql = "UPDATE details SET Salt='$salt', Picture='$hashpic' WHERE id='$id'";
		//echo mysqli_query($connect, $sql);
		
		if (mysqli_query($connect, $sql)) {
		    echo '<script>alert("Pictorial Password Added");</script>';
		    echo '<script type="text/javascript"> window.location = "index.php" </script>';
		} 
		
		else {
			}

		mysqli_close($connect);
	}
?>
