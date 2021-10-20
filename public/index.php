<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NXM ASSESSMENT</title>
    <link rel="stylesheet" href="./asset/css/style.css">
</head>
<body>
    <div class="container">
        <form method="post" action="/" id="form" enctype="multipart/form-data">
            <div class="form-field">
                <label for="fname">Full Name</label>
                <input type="text" name="fname" id="fname" placeholder="John Doe"  />
            </div>
            <div class="form-field">
                <label for="birthday">Birthdate</label>
                <input type="date" id="birthday" name="bday" required/>
            </div>
            <div class="form-field">
                <label for="cadd">Complete Address</label>
                <textarea name="cadd" id="cadd" cols="50" rows="10" required></textarea>
            </div>
            <div class="form-field">
                <label for="fileToUpload">Profile Picture</label>
                <input type="file" name="fileToUpload" id="fileToUpload" required/>
            </div>
            <div><h3>Credit Card Info</h3></div>
            <div class="form-field">
                <label for="cardnum">Card Number:</label>
                <input type="number" name="cardnum" id="cardnum" required/>
            </div>
            <div class="form-field">
                <label for="expdate">Expiration Date</label>
                <input type="date" id="expdate" name="expdate" required/>
            </div>
            <div class="form-field">
                <label for=""></label>
                <input type="submit" value="Register" name="reg" class="button"/>
            </div>
        </form>
    </div>
    <div class="container">
    <?php
        // Database Connection
        require('./asset/php/config.php');
        // Check if image file is a actual image or fake image
        if(isset($_POST["reg"])) {
            // POST Name Values
            $fname = mysqli_real_escape_string($db,$_POST['fname']);
            $bday = mysqli_real_escape_string($db,$_POST['bday']);
            $cadd = mysqli_real_escape_string($db,$_POST['cadd']);
            $cardnum = mysqli_real_escape_string($db,$_POST['cardnum']);
            $expdate = mysqli_real_escape_string($db,$_POST['expdate']);
            // FILE Upload
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                    
                    $sql = mysqli_query($db,"INSERT INTO tbl_regInfo (`fullname`,`bday`,`address`,`card_num`,`exp_date`,`url_image`) VALUES ('".$fname."','".$bday."','".$cadd."','".$cardnum."','".$expdate."','".$target_file."')");
                    if(!$sql){
                        echo "Registration Failed!";
                    }else{
                        echo "Successfully Registered!";
                    }
                    // $arr = array($fname,$bday,$cadd,$cardnum,$expdate,$target_file);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    ?>
    </div>
</body>
</html>