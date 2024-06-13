<?php

    session_start();

    include_once("../includes/connection.php");

    $cname = $plateNo = $timeIn = $timeOut = $bill = $insertError = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST["insert"])) {

            if(empty($_POST["c-name"]) || empty($_POST["plate-no"]) || empty($_POST["time-in"]) || empty($_POST["time-out"]) || empty($_POST["bill"])) {
                $_SESSION["error"] = "Error!";
            }
            
            if(!empty($_POST["c-name"])) {
                $cname = $_POST["c-name"];
            }
    
            if(!empty($_POST["plate-no"])) {
                $plateNo = $_POST["plate-no"];
            }
    
            if(!empty($_POST["time-in"])) {
                $timeIn = $_POST["time-in"];
            }
            
            if(!empty($_POST["time-out"])) {
                $timeOut = $_POST["time-out"];
            }

            if(!empty($_POST["bill"])) {
                $bill = $_POST["bill"];
            }

            if ($cname && $plateNo && $timeIn && $timeOut && $bill) {
                $select_query = mysqli_query($conn,"SELECT * FROM `$db_tbl_booking` WHERE `date` = CURDATE()");
                $numrows = $select_query -> num_rows;

                $id = date("Ymd")."0".$numrows;

                $query_insert = mysqli_query($conn, "INSERT INTO `$db_tbl_booking` (`id`, `c-name`, `plate-no`, `time-in`, `time-out`, `bill`) 
                                VALUES ('$id', '$cname', '$plateNo', '$timeIn', '$timeOut','$bill')");
                
                if($query_insert) {
                    $_SESSION["popup"] = "Successful!";
                }
            }
        }
    }

    header("location:parking_lot.php");
?>