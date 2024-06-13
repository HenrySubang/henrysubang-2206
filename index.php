<?php 

    session_start();

    include_once("pages/includes/connection.php");
    
    $email = $password = "";
    $emailErr = $passwordErr = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST["log-btn"])) {

            if(empty($_POST["email"])) {
                $emailErr = "Email is required!";
            } else {
                $email = $_POST["email"];
            }
    
            if(empty($_POST["password"])) {
                $passwordErr = "Password is required!";
            } else {
                $password = $_POST["password"];
            }
    
            if($email && $password) {
                $check_email = mysqli_query($conn, "SELECT * FROM `$db_tbl` WHERE email = '$email'");
                $check_email_row = mysqli_num_rows($check_email);
    
                if($check_email_row > 0) {
                    while($row = mysqli_fetch_assoc($check_email)) {
                        $db_password = $row["password"];
                        $db_account_type = $row["account_type"];
    
                        if($password == $db_password) {
                            if($db_account_type == "1") {
                                header("location:pages/admin/parking_lot.php");
    
                                $db_id = $row["id"];
                                $_SESSION["id"] = $db_id;
                                $_SESSION["popup"] = "Login Successful!";
                            } else {
                                header("location:pages/customer/home.php");
    
                                $db_id = $row["id"];
                                $_SESSION["id"] = $db_id;
                                $_SESSION["popup"] = "Login Successful!";
                            }
                        } else {
                            $passwordErr = "Password is incorrect!";
                        }
                    }
                } else {
                    $emailErr = "Email is incorrect!";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/login.css">
    <title>Parking</title>
</head>
<body>
    <main>
        <div class="container">
            <section id="sec-1">
                <h1>PARKING <br> MANAGEMENT</h1>
            </section>

            <section id="sec-2">
                <h2>LOG IN</h2>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <span class="error"><?php echo $emailErr;?></span>
                    <input type="email" name="email" placeholder="Email" value="<?php echo $email;?>"><br>

                    <span class="error"><?php echo $passwordErr;?></span>
                    <input type="password" name="password" placeholder="Password" value="<?php echo $password;?>"><br>

                    <input type="submit" name="log-btn" value="LOG IN">
                </form>
            </section>
        </div>
    </main>
</body>
</html>