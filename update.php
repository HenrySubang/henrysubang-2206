<?php 

    session_start();

    include_once("../includes/connection.php");

    $cname = $plateNo = $timeIn = $timeOut = $bill = "";

    if(isset($_GET["update_id"])) {

        $updateID = $_GET["update_id"];

        if($_SERVER["REQUEST_METHOD"] == "POST") {

            if(isset($_POST["update"])) {
                
                if(empty($_POST["c-name"]) || empty($_POST["plate-no"]) || empty($_POST["time-in"]) || empty($_POST["time-out"]) || empty($_POST["bill"])) {
                    $_SESSION["error"] = "Error!";
                } else {

                    $select_query = "SELECT * FROM `$db_tbl_booking` WHERE `id` = $updateID";
                    $result = $conn -> query($select_query);

                    $cname = $_POST["c-name"];
                    $plateNo = $_POST["plate-no"];
                    $timeIn = $_POST["time-in"];
                    $timeOut = $_POST["time-out"];
                    $bill = $_POST["bill"];

                    while($row = $result -> fetch_assoc()) {
                        if($row["c-name"] == $cname && $row["plate-no"] == $plateNo && $row["time-in"] == $timeIn && $row["time-out"] == $timeOut && $row["bill"] == $bill) {
                            $_SESSION["warn"] = "No Changes";
                        } else {
                            $update_query = mysqli_query($conn, "UPDATE `$db_tbl_booking` SET `c-name` = '$cname', `plate-no` = '$plateNo', `time-in` = '$timeIn', `time-out` = '$timeOut', `bill` = '$bill' WHERE `id` = $updateID");

                            if($update_query) {
            
                                $_SESSION["popup"] = "Update Successful";
                            }
                        }
                    }
                }
            }
        }
    }

    header("location:parking_lot.php");
?>