<?php 

    session_start();

    include_once("../includes/connection.php");

    if(isset($_GET["remove_id"])) {

        $deleteID = $_GET["remove_id"];

        $delete_query = mysqli_query($conn, "DELETE FROM `$db_tbl_booking` WHERE `id` = '$deleteID'");

        if($delete_query) {
            $_SESSION["popup"] = "Deleted Successful";
        } else {
            $_SESSION["error"] = "Error";
        }
    }

    header("location:parking_lot.php");
?>