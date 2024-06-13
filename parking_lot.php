<?php 

    session_start();

    include_once("../includes/connection.php");
    include_once("../includes/popup.php");

    if(!$_SESSION["id"]) {
        header('location:../../index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/admin/parking_lot.css">
    <link rel="stylesheet" href="../../style/popup.css">
    <script defer src="../../scripts/script.js"></script>
    <title>Parking</title>
</head>
<body>
    <main>
        <section id="sidebar">
            <div class="top-container">
                <h1>Parking</h1>
                <h3>Management</h3>
                
                <div class="links">
                    <a class="link-style curr"><img src="../../style/icons/book-open-regular-240.png">Booking</a>
                </div>
            </div>

            <div class="bottom-container">
                <a href="../includes/logout.php" class="logout-btn">Log Out</a>
            </div>
        </section>

        <div class="container">
            <header>
                <h1>Booking</h1>

                <button onclick="openInsertForm()" class="ins-btn"></button>
            </header>

            <div class="content">
                <table>
                    <tr>
                        <th>No.</th>
                        <th>Customer Name</th>
                        <th>Plate No.</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Bill</th>
                        <th>Action</th>
                    </tr>

                        <?php 

                            $no = 1;
                            $noData = "";

                            $sql = "SELECT * FROM `$db_tbl_booking`";
                            $result = $conn -> query($sql);

                            if($result -> num_rows > 0) {
                                while($row = $result -> fetch_assoc()) {
                                    if ($no <= 100) {
                                        echo "<tr><td>". $no. 
                                        "<td>". $row["c-name"]. 
                                        "<td>". $row["plate-no"]. 
                                        "<td>". $row["time-in"]. 
                                        "<td>". $row["time-out"]. 
                                        "<td>". $row["bill"]. 
                                        "<td>". 
                                        "<div class='act-container'>".
                                        '<button onclick="openViewForm('.$row["id"].')" class="act-btn view-btn"></button>'.
                                        '<button onclick="openEditForm('.$row["id"].')" class="act-btn edit-btn"></button>'.
                                        '<button onclick="openDeleteForm('.$row["id"].')" class="act-btn delete-btn"></button>'.
                                        "</div>".
                                        "</td></tr>";
                                    }

                                    $no++;
                                }
                            } else {
                                $noData = "No Booking";
                            }
                        ?>
                    </table>
                    
                    <p class="text"><?php echo $noData;?></p>
                </div>
            </div>
        </div>
    </main>

    <div class="form-bg" id="form-insert">
        <div class="sec-container">
            <div class="form-container">    
                <button onclick="closeInsertForm()" class="back-btn">Back</button>

                <form method="post" action="insert.php">
                    <label for="c-name">Customer Name</label><br>
                    <input type="text" name="c-name" placeholder="Customer Name"><br>

                    <label for="plate-no">Plate No.</label><br>
                    <input type="text" name="plate-no" placeholder="Plate No."><br>

                    <label for="time-in">Time In</label><br>
                    <input type="time" name="time-in" placeholder="Time In"><br>

                    <label for="time-out">Time Out</label><br>       
                    <input type="time" name="time-out" placeholder="Time Out"><br>

                    <label for="bill">Bill</label><br>
                    <input type="number" name="bill" placeholder="Bill"><br>

                    <input type="submit" name="insert" value="Add">
                </form>
            </div>
        </div>
    </div>

    <div class="form-bg" id="form-view" style="<?php if(isset($_GET["view_id"])) { echo "display:block;";} ?>">
        <div class="sec-container">
            <div class="form-container">    
                <button onclick="closeForm()" class="back-btn">Back</button>

                <?php 

                    if(isset($_GET["view_id"])) {

                        $viewID = $_GET["view_id"];

                        $select_query = "SELECT * FROM `$db_tbl_booking` WHERE `id` = '$viewID'";
                        $result = $conn -> query($select_query);

                        if($result -> num_rows > 0) {
                            while($row = $result -> fetch_assoc()) {
                                $viewCname = $row["c-name"];
                                $viewPlateNo = $row["plate-no"];
                                $viewTimeIn = $row["time-in"];
                                $viewTimeOut = $row["time-out"];
                                $viewBill = $row["bill"];
                            }
                        }
                    }
                ?>

                <div class="view-container">
                    <div class="view-data">
                        <p>Customer Name:</p>
                        <b><?php echo $viewCname;?></b>
                    </div>

                    <div class="view-data">
                        <p>Plate No.:</p>
                        <b><?php echo $viewPlateNo;?></b>
                    </div>

                    <div class="view-data">
                        <p>Time In:</p>
                        <b><?php echo $viewTimeIn;?></b>
                    </div>

                    <div class="view-data">
                        <p>Time Out:</p>
                        <b><?php echo $viewTimeOut;?></b>
                    </div>

                    <div class="view-data">
                        <p>Bill:</p>
                        <b><?php echo $viewBill;?></b>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-bg" id="form-edit" style="<?php if(isset($_GET["edit_id"])) { echo "display:block;";} ?>">
        <div class="sec-container">
            <div class="form-container">    
                <button onclick="closeForm()" class="back-btn">Back</button>

                <?php 
                
                    if(isset($_GET["edit_id"])) {

                        $editID = $_GET["edit_id"];

                        $select_query = "SELECT * FROM `$db_tbl_booking` WHERE `id` = '$editID'";
                        $result = $conn -> query($select_query);

                        if($result -> num_rows > 0) {
                            while($row = $result -> fetch_assoc()) {
                                $editCname = $row["c-name"];
                                $editPlateNo = $row["plate-no"];
                                $editTimeIn = $row["time-in"];
                                $editTimeOut = $row["time-out"];
                                $editBill = $row["bill"];
                            }
                        }
                    }
                ?>

                <form method="post" action="update.php?update_id=<?php echo $editID;?>">
                <label for="c-name">Customer Name</label><br>
                    <input type="text" name="c-name" value="<?php echo $editCname;?>"><br>

                    <label for="plate-no">Plate No.</label><br>
                    <input type="text" name="plate-no" value="<?php echo $editPlateNo;?>"><br>

                    <label for="time-in">Time In</label><br>
                    <input type="time" name="time-in" value="<?php echo $editTimeIn;?>"><br>

                    <label for="time-out">Time Out</label><br>       
                    <input type="time" name="time-out" value="<?php echo $editTimeOut?>"><br>

                    <label for="bill">Bill</label><br>
                    <input type="number" name="bill" value="<?php echo $editBill;?>"><br>

                    <input type="submit" name="update" value="Update" class="def-btn green-btn max-size-btn">
                </form>
            </div>
        </div>
    </div>

    <div class="form-bg" id="form-delete" style="<?php if(isset($_GET["delete_id"])) { echo "display:block;";} ?>">
        <div class="sec-container">
            <div class="form-container">    

                <?php 

                    if(isset($_GET["delete_id"])) {

                        $deleteID = $_GET["delete_id"];

                        $select_query = "SELECT * FROM `$db_tbl_booking` WHERE `id` = '$deleteID'";
                        $result = $conn -> query($select_query);

                        if($result -> num_rows > 0) {
                            while($row = $result -> fetch_assoc()) {
                                $deleteCname = $row["c-name"];
                                $deletePlateNo = $row["plate-no"];
                                $deleteTimeIn = $row["time-in"];
                                $deleteTimeOut = $row["time-out"];
                                $deleteBill = $row["bill"];
                            }
                        }
                    }
                ?>

                <button onclick="closeForm()" class="back-btn">Back</button>
                
                <br><p class="delete-text">Do you want to <b>"DELETE"</b> this field?</p>

                <form method="post" action="delete.php?remove_id=<?php echo $deleteID;?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </div>
        </div>
    </div>
</body>
</html>