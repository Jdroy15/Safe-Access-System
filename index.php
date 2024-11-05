<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SignIn&SignUp</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<style>
		#password-strength {
		font-size: 14px;
		margin-top: 5px;
	}
	</style>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="sign-in-form" method="post">
			<h2 class="title">Sign In</h2>
			<div class="input-field">
				<i class="fas fa-user"></i>
				<input type="text" placeholder="Email" name="emailpass" required/>
			</div>
			<div class="input-field">
				<i class="fas fa-lock"></i>
				<input type="password" placeholder="pphrase" name="pphrase" required/>
			</div>
			<div class="input-field">
				<i class="fas fa-lock"></i>
				<input type="password" placeholder="Password" name="logpassword" required/>
			</div>
			<input type="submit" value="Login" class="btn solid" name="submit"/>
		</form>

		<?php
		session_start();
		include 'connection.php';

		function hashPassword1($password, $salt, $number) {
			$hashedPassword1 = hash('sha256', $password . $salt); // Initial hash
		
			// Iterate $number times to apply stretching
			for ($i = 0; $i < $number; $i++) {
				$hashedPassword1 = hash('sha256', $hashedPassword1 . $salt);
				
			}
			//echo $hashedPassword1,"<br>";
			return $hashedPassword1;
		}

		function decryptdata($data, $key) {
			$data = base64_decode($data);
			$ivLength = openssl_cipher_iv_length('aes-256-cbc');
			$iv = substr($data, 0, $ivLength);
			$data = substr($data, $ivLength);
			return openssl_decrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		}

		function generate256BK($userDefinedKey) {
			// Ensure that the input key is a string
			if (!is_string($userDefinedKey)) {
				throw new InvalidArgumentException('Input key must be a string.');
			}
		
			// Hash the user-defined key using SHA-256
			$hashedKey = hash('sha256', $userDefinedKey, true); // true parameter for binary output
		
			// Ensure that the hash is 32 bytes long (256 bits)
			if (strlen($hashedKey) !== 32) {
				throw new RuntimeException('Hashed key length is not 32 bytes (256 bits).');
			}
		
			return $hashedKey;
		}
		
		if(isset($_POST["submit"])){
			$logpass = $_POST['logpassword'];
			$loguname = $_POST['emailpass'];
			$key1 = $_POST['pphrase'];
			if($logpass != "" and $loguname != "" and $key1!=""){
				//$logpass = hash('sha256', $logpass);
				//echo $logpass;
				$key1 = generate256BK($key1);
				//echo "key: ",$key1,"<br>";
				$logsql = "SELECT * FROM details WHERE Email='$loguname'";
				$result = $connect->query($logsql);
				if ($result->num_rows > 0) {
				// Output data of each row
					while($row = $result->fetch_assoc()) {
						//echo "key: ",$key1,"<br>";
						$storedsalt = $row["Salt"];
						$_SESSION['pphrase']=$key1;
						$_SESSION['loguname']=$loguname;
						$storedPassword = $row["Password"];
						
						$decryptsalt3 = decryptdata($storedsalt, $key1);
						$decryptsalt3 = substr($decryptsalt3,0,152);
						
						$decryptsalt2 = decryptdata($decryptsalt3, $key1);
						$decryptsalt2 = substr($decryptsalt2,0,64);
						
						$decryptsalt1 = decryptdata($decryptsalt2, $key1);
						
						//echo $decryptsalt3;
						$logpass1 = hashPassword1($logpass, $decryptsalt1,100);
						//echo $logpass1;
						
						if($logpass1 == $storedPassword){
							echo '<script type="text/javascript"> window.location = "loggraphical.php" </script>';
						}else{
							echo '<script type="text/javascript">alert("User not found")</script>';
						}
						//echo "id: " . $row["Id"]. " - Name: " . $row["Name"]. " " . $row["Salt"];
					}
					
				}
				
				mysqli_close($connect);
			}
		}
		session_commit();
		?>
<!---SIGN UP FORM STARTS FROM HERE--->

          <form class="sign-up-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            <h2 class="title">Sign Up</h2>
			
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="name" required/>
            </div>
			
			<div class="input-field">
			  <i class="fas fa-user"></i>
			  <input type="text" placeholder="UserID" name="id" required/>
			</div>
			
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" name="email" required/>
            </div>

			<div class="input-field">
              <i class="fas fa-user"></i>
              <input type="password" placeholder="Passphrase" name="passphrase" required/>
            </div>
			
            <div class="input-field">
              <i class="fas fa-lock"></i>
			  <input type="password" placeholder="Password" name="password" id="password" oninput="checkPasswordStrength(this.value)" required/>  
			</div>
			<div id="password-strength"></div>
			<!--<span id="passwordStrength" class="fas fa-lock"></span>-->
			
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Confirm Password" name="password1" required/>
            </div>
			<!--
			<input type="submit" value="Submit" id="submitButton" disabled>
			-->
            <input type="submit" value="Sign Up" class="btn solid" name="submit1" />
    
          </form>  
		  <script>
			function checkPasswordStrength(password) {
				var strength = 0;

				if (password.match(/[a-zA-Z0-9][a-zA-Z0-9]+/)) {
					strength += 1;
				}
				if (password.match(/[~<>?]+/)) {
					strength += 1;
				}
				if (password.match(/[!@#$%^&*()]+/)) {
					strength += 1;
				}
				if (password.length > 5) {
					strength += 1;
				}

				var strengthText;
				switch (strength) {
					case 0:
						strengthText = 'Weak';
						break;
					case 1:
						strengthText = 'Medium';
						break;
					case 2:
						strengthText = 'Strong';
						break;
					case 3:
						strengthText = 'Very Strong';
						break;
					case 4:
						strengthText = 'Extremely Strong';
						break;
					default:
						strengthText = '';
				}
				document.getElementById("password-strength").innerText = "Strength: " + strengthText;
			}
		  </script>
		  <?php
			session_start();
			function generateSalt() {
				return bin2hex(random_bytes(8)); 
			}

			function hashPassword($password, $salt, $number) {
				$hashedPassword = hash('sha256', $password . $salt); // Initial hash
			
				// Iterate $number times to apply stretching
				for ($i = 0; $i < $number; $i++) {
					$hashedPassword = hash('sha256', $hashedPassword . $salt);
					
				}
				//xecho $hashedPassword,"<br>";
				return $hashedPassword;
			}

			function generate256BitKey($userDefinedKey) {
				// Ensure that the input key is a string
				if (!is_string($userDefinedKey)) {
					throw new InvalidArgumentException('Input key must be a string.');
				}
			
				// Hash the user-defined key using SHA-256
				$hashedKey = hash('sha256', $userDefinedKey, true); // true parameter for binary output
			
				// Ensure that the hash is 32 bytes long (256 bits)
				if (strlen($hashedKey) !== 32) {
					throw new RuntimeException('Hashed key length is not 32 bytes (256 bits).');
				}
			
				return $hashedKey;
			}
			function encrypt($data, $key) {
				$ivLength = openssl_cipher_iv_length('aes-256-cbc');
				$iv = openssl_random_pseudo_bytes($ivLength);
				$encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
				return base64_encode($iv . $encrypted);
			}
			
			include 'connection.php';
			if(isset($_POST["submit1"])){
				$id = $_POST['id'];
				$pass = $_POST['password'];
				$name = $_POST['name'];
				$Eid  = $_POST['email'];
				$cpass = $_POST['password1'];
				$key = $_POST['passphrase'];
				
				if ($pass!="" and $name!="" and $id!="" and $cpass!=""){
					if($pass == $cpass){
						
						$checkUserIDQuery = "SELECT * FROM details WHERE ID='$id'";
						$checkUserIDResult = $connect->query($checkUserIDQuery); 
						$key = generate256BitKey($key);
						if($checkUserIDResult->num_rows > 0){
							echo '<script>alert("UserID already exists. Please choose a different UserID.");</script>';
						}else{
							$salt = generateSalt();
							// Hash the password with the generated salt
							$hashedPassword = hashPassword($pass, $salt, 100);
							// implication of strectching process
							$salt = encrypt($salt, $key);
							//echo $salt;
							$sql = "INSERT INTO details (Name, Id, Password, Salt, Email) VALUES ('$name', '$id', '$hashedPassword', '$salt', '$Eid')";
							if (mysqli_query($connect, $sql)){
								echo "<script>alert('New record created successfully');</script>";
								$_SESSION['id']=$id;
								$_SESSION['passphrase']=$key;
								//echo $_SESSION['id'];
								echo '<script type="text/javascript"> window.location = "graphical.php" </script>';
							} else {
								echo '<script>alert(`Error: " . $sql . "<br>" . mysqli_error($conn)`);</script>';
							}
						}
						mysqli_close($connect);
						
					}
				}
			}
			session_commit();
		  ?>
        </div>
      </div>
      <div class="panels-container">

        <div class="panel left-panel">
            <div class="content">
                <h3>New here?</h3>
                <p>Join the family and get secured with this authentication protocol!</p>
                <button class="btn transparent" id="sign-up-btn">Sign Up</button>
            </div>
            <img src="./img/log.svg" class="image" alt="">
        </div>

        <div class="panel right-panel">
            <div class="content">
                <h3>One of us?</h3>
                <p>Let's get you authenticated!</p>
                <button class="btn transparent" id="sign-in-btn">Sign In</button>
            </div>
            <img src="./img/register.svg" class="image" alt="">
        </div>
      </div>
    </div>

    <script src="./app.js"></script>
  </body>
</html>