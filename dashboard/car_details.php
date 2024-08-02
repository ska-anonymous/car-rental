<?php
if (!isset($_GET['car_id']) || $_GET['car_id'] == '') {
    die('Please Don\'t Visit This page directly');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Car Rental | Car Details</title>
    <!-- include Header here -->
    <?php
    require_once('../components/header.php');

    // include db connection
    require_once('../php_processing/db_connect.php');
    ?>
    <!-- Header Ends here -->



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Car Details</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Main Content Starts Here -->
                <div class="card">
                    <div class="card-body" style="overflow-x:auto;">
                        <div class="row">
                            <?php
                            $car_id = $_GET['car_id'];
                            $sql = "SELECT * FROM car_details WHERE car_id='$car_id'";
                            $qry = $pdo->prepare($sql);
                            $qry->execute();
                            if ($qry->rowCount()) {
                                $row = $qry->fetch(PDO::FETCH_ASSOC);
                                if (trim(strtolower($row['status'])) == 'available') {
                                    $book_now_html = '
                                    <a href="book_car.php?car_id=' . $row['car_id'] . '" class="btn btn-success btn-block">Book Now</a>
                                    ';
                                } else {
                                    $book_now_html = '';
                                }
                                echo '
                                    <div class="col-md-6">
                                        <div class="my-2">
                                            <img src="../uploads/car_images/' . $row['image'] . '" class="img img-fluid" alt="">
                                        </div>
                                        ' . $book_now_html . '
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tr>
                                                <th>Model ID</th>
                                                <td>' . $row['model_id'] . '</td>
                                                <th>Model</th>
                                                <td>' . $row['model'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>Make</th>
                                                <td>' . $row['make'] . '</td>
                                                <th>Passenger Capacity</th>
                                                <td>' . $row['passenger_capacity'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>Luggage Capacity</th>
                                                <td>' . $row['luggage_capacity'] . '</td>
                                                <th>Cost Per Day</th>
                                                <td>' . $row['cost_per_day'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>Year</th>
                                                <td>' . $row['year'] . '</td>
                                                <th>Color</th>
                                                <td>' . $row['color'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>' . $row['status'] . '</td>
                                                <th>Location</th>
                                                <td>' . $row['location_name'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>Street</th>
                                                <td>' . $row['street'] . '</td>
                                                <th>City</th>
                                                <td>' . $row['city'] . '</td>
                                            </tr>
                                        </table>
                                    </div>
                                
                                    ';
                            } else {
                                echo '
                                    <div class="col-12">
                                        <h3 class="text-danger">Car Details Not Loaded. Please make sure that the car_id in the url is correct.</h3>
                                    </div>
                                    ';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Main Content Ends Here -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Include Footer Here -->
    <?php
    require_once('../components/footer.php');
    ?>