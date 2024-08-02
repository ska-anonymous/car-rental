<?php
if (!isset($_GET['car_id']) || $_GET['car_id'] == '') {
    die('Please Don\'t Visit This page directly');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Car Rental | Book Car</title>
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
                        <h1 class="m-0">Book Car</h1>
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
                    <div class="card-body">
                        <form action="" method="post" id="booking_form">
                            <div class="row">
                                <?php
                                $car_id = $_GET['car_id'];
                                $user_id = $_SESSION['user_id'];
                                $sql = "SELECT * FROM car_details WHERE car_id='$car_id'";
                                $qry = $pdo->prepare($sql);
                                $qry->execute();
                                if ($qry->rowCount()) {
                                    $row = $qry->fetch(PDO::FETCH_ASSOC);
                                    if (trim(strtolower($row['status'])) != 'available') {
                                        die("This Car is not availabe for booking");
                                    }
                                    echo '
                                    <div class="col-md-6">
                                        <img src="../uploads/car_images/' . $row['image'] . '" class="img img-fluid" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <table style="width:100%">
                                            <tr>
                                                <td colspan="2">
                                                    <h3>
                                                    ' . $row['year'] . " " . $row['make'] . " " . $row['model'] . " (" . $row['model_id'] . ", " . $row['color'] . ")" . '
                                                    </h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Cost Per Day:
                                                </td>
                                                <td>
                                                    ' . $row['cost_per_day'] . '
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Start Date:
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="start_date" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    End Date:
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="end_date" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Amount:
                                                </td>
                                                <td>
                                                    <input type="text" value="0" class="form-control" name="amount" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    License Number:
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="license_number" required>
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td colspan="2">
                                                    <button class="my-2 btn btn-primary btn-block" type="submit" name="btn_book" value="' . $row['car_id'] . '">BOOK</button>
                                                </td>
                                            </tr>                                            
                                        </table>
                                    </div>

                                    <input type="hidden" name="cost_per_day" value="' . $row['cost_per_day'] . '">
                                ';
                                } else {
                                    echo '
                                    <div class="col-md-6">
                                        <h3 class="text-danger">Cannot Load Car Info make sure the car_id is correct</h3>
                                    </div>
                                ';
                                }
                                ?>
                            </div>
                        </form>
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

    <?php
    if (isset($_POST['btn_book'])) {
        $user_id = $_SESSION['user_id'];
        $car_id = $_POST['btn_book'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $license_number = $_POST['license_number'];
        $cost_per_day = $_POST['cost_per_day'];

        $difference = abs(strtotime($end_date) - strtotime($start_date));
        $num_of_days = ceil($difference / (60 * 60 * 24));
        $amount = $num_of_days * $cost_per_day;

        $sql = "INSERT INTO `booking_details`(`user_id`, `car_id`, `start_date`, `end_date`, `license_number`, `amount`) VALUES ('$user_id','$car_id','$start_date','$end_date','$license_number','$amount')";
        $qry = $pdo->prepare($sql);
        $qry->execute();
        if ($qry->rowCount()) {
            $sql = "UPDATE `car_details` SET `status`='Already Booked' WHERE car_id='$car_id'";
            $qry = $pdo->prepare($sql);
            $qry->execute();
            echo '
            <script>
                toastr.success(\'Car Booked Successfully\');
            </script>
            ';
        } else {
            echo '
                <script>
                    toastr.error(\'Booking Failed! Please try Again later\');
                </script>
            
            ';
        }

    }
    ?>

    <script>
        // calculate total ammount when start and end dates are selected
        let form = document.querySelector('#booking_form');
        let startDateInput = form.start_date;
        let endDateInput = form.end_date;
        let amountInput = form.amount;
        let costPerDayInput = form.cost_per_day;

        startDateInput.addEventListener('change', calcAmount);
        endDateInput.addEventListener('change', calcAmount);

        function calcAmount() {
            let startDateString = startDateInput.value;
            let endDateString = endDateInput.value;
            let costPerDay = costPerDayInput.value;

            if (startDateString == '' || endDateString == '') {
                return;
            }

            let startDate = new Date(startDateString);
            let endDate = new Date(endDateString);

            let difference = Math.abs(endDate.getTime() - startDate.getTime());
            let numberOfDays = Math.ceil(difference / (1000 * 60 * 60 * 24));
            let totalAmount = costPerDay * numberOfDays;
            amountInput.value = totalAmount;

        }
    </script>