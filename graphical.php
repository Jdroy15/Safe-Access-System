<?php
session_start();
$ses = isset($_SESSION["id"]) ? $_SESSION["id"] : null;
$key = isset($_SESSION["passphrase"]) ? $_SESSION["passphrase"] : null;
//echo $key;
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
</head>

<body>
    <div id="video-background">
        <video autoplay muted loop>
            <source src="wave_-_87787 (720p).mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
<div class="text-container">
    <h1><center>SAS Layer-II</center></h1>
  </div>
  
    <div id="container">
        <button id="red_box" class="btn btn-danger"></button>
        <button id="blue_box" class="btn btn-primary"></button>
        <button id="green_box" class="btn btn-success"></button>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="password" class="form-control" id="input" name="graph" placeholder="Pattern Here" />
            <button class="btn btn-info" id="submit" name="submit">Save</button>
        </form>
    </div>
    
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
    $('#red_box').click(function () {
        $('#input').val($('#input').val() + '#Q9rd43k#Q9rd43k');
    });
    $('#blue_box').click(function () {
        $('#input').val($('#input').val() + '#R10be43L#R10be43L');
    });
    $('#green_box').click(function () {
        $('#input').val($('#input').val() + '#S11gn43M#S11gn43M');
    });
</script>
</html>
<?php
include 'connection.php';
function generateSalt() {
    return bin2hex(random_bytes(8)); // Generate a 16-byte (128-bit) random salt
}

function hashPassword($password, $salt) {
    return hash('sha256', $password . $salt); // Concatenate password and salt before hashing
}

function encrypt($data, $key) {
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivLength);
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted);
}

if (isset($_POST["submit"])) {
    $graph = mysqli_real_escape_string($connect, $_POST['graph']); // Prevent SQL Injection
    
    $logsql = "SELECT * FROM details WHERE id='$ses'";
    $result = $connect->query($logsql);
    if ($result->num_rows > 0) {
    // Output data of each row
        while($row = $result->fetch_assoc()) {
            $storedsalt = $row["Salt"];
            //echo "stored salt: ",$storedsalt,"<br>";
        }
    }
    $saltgraph = generateSalt();
    //echo "New Salt: ", $saltgraph,"<br>";
    // Hash the password with the generated salt
    $hashgraph = hashPassword($graph, $saltgraph);
    $saltgraph = $storedsalt.$saltgraph;
    $saltgraph = encrypt($saltgraph, $key);
    //echo strlen($salt),"<br>";
    //echo $salt,"<br>";
    //echo "Sub str:",substr($salt, 0,16);
    $sql = "UPDATE details SET Salt='$saltgraph', Graphical='$hashgraph' WHERE id='$ses'";
    if (mysqli_query($connect, $sql)) {
        echo '<script>alert("Graphical Password Added");</script>';
        echo '<script type="text/javascript"> window.location = "picture_pass.php" </script>';
    } else {
        // Handle errors appropriately
    }

    mysqli_close($connect);
}
?>
