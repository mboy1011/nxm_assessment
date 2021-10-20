<?php
    // Database Connection
    require('./asset/php/config.php');
?>
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
        <form method="post" action="/" id="form" class="validate" enctype="multipart/form-data">
            <div class="form-field">
                <label for="full-name">Full Name</label>
                <input type="text" name="full-name" id="fname" placeholder="John Doe" required />
            </div>
            <div class="form-field">
                <label for="password-input">Birthdate</label>
                <input type="date" id="birthday" name="bday" require/>
            </div>
            <div class="form-field">
                <label for="full-name">Complete Address</label>
                <textarea name="cadd" id="" cols="50" rows="10"></textarea>
            </div>
            <div class="form-field">
                <label for="password-input">Profile Picture</label>
                <input type="file" name="img">
            </div>
            <div><h3>Credit Card Info</h3></div>
            <div class="form-field">
                <label for="full-name">Card Number:</label>
                <input type="number" name="cardnum" id="">
            </div>
            <div class="form-field">
                <label for="password-input">Expiration Date</label>
                <input type="date" id="exbirthday" name="expdate" require/>
            </div>
            <div class="form-field">
                <label for=""></label>
                <input type="submit" value="Register" name="reg" class="button"/>
            </div>
        </form>
    </div>
</body>
</html>