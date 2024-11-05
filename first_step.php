<!doctype html>
<html lang="us-en">
	<head>
		<title>FIRST STEP</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8" />
		<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
		<style>
			#box{
				margin-left: 500px; 
				margin-right: 500px; 
				padding: 20px; 
				background-color: #bfbfbf;
				border-radius: 5px;
				padding-left: 30px;
				padding-right: 30px;
			}
		</style>
	</head>
	
	<body>
		<div class="jumbotron" style="background-color: #1a1a1a; color: white;">
			<h1 style="margin-left: 20px;">Register</h1>
		</div>
		<div id="box">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form-horizontal">
				<div class="form-group">
					<label class="control-label">Name:</label>
					<input type="text" class="form-control" name="Name" placeholder="Name" required>
				</div>
				<div class="form-group">
					<label class="control-label">Id:</label>
					<input type="text" class="form-control" name="Id" placeholder="Id" required>
				</div>
				<div class="form-group">
					<label class="control-label">Password:</label>
					<input type="password" class="form-control" name="password" placeholder="Password" required>
				</div>
				<div class="form-group">
					<label class="control-label">Confirm Password:</label>
					<input type="password" class="form-control" name="password1" placeholder="Password" required>
				</div>
				
				<button type="submit" class="btn btn-default" name="submit1" style="color: #000; font-weight: bold; margin-left: 0;">Register</button>
			</form>
		</div>
	</body>
</html>


<?php
session_start();
	include 'connection.php';

	if(isset($_POST["submit1"]))
	{
	  $pass=$_POST['password'];
	  $name=$_POST['Name'];
	  $id=$_POST['Id'];
	  $cpass = $_POST['password1'];
	  if ($pass!="" and $name!="" and $id!="" and $cpass!=""){
		if($pass == $cpass){
			$pass = hash('sha256', $pass);
			$sql = "INSERT INTO details (Name, Id, Password) VALUES ('$name', '$id', '$pass')";
			if (mysqli_query($conn, $sql)){
			echo "<script>alert('New record created successfully');</script>";
			$_SESSION['id']=$id;
			echo $_SESSION['id'];
			echo '<script type="text/javascript"> window.location = "graphical.php" </script>';
			}
			else {
				echo '<script>alert(`Error: " . $sql . "<br>" . mysqli_error($conn)`);</script>';
			}

			mysqli_close($conn);
			}
		}
	}
?>