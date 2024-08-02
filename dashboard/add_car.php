<!DOCTYPE html>
<html lang="en">

<head>
    <title>Car Rental | Add Car</title>

    <!-- include Header here -->
    <?php
    require_once('../components/header.php');
    ?>
    <!-- Header Ends here -->

    <?php
    // check if the user is admin otherwise he has no access to this page
    if ($_SESSION['user']['user_role'] != 'admin') {
        echo '
        <script>
            alert(\'Only ADMIN can access this page\');
            window.location.replace(\'index.php\');
        </script>';
        exit(0);
    }
    ?>

    <?php
    // if form is submitted add car to database
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_add_car'])) {
        require_once('../php_processing/db_connect.php');
        extract($_POST);

        $image_name = time() . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/car_images/' . $image_name);

        $sql = "INSERT INTO `car_details`( `model_id`, `model`, `make`, `passenger_capacity`, `luggage_capacity`, `cost_per_day`, `year`, `color`, `status`, `location_name`, `street`, `city`, `image`) VALUES ('$model_id','$model','$make','$passenger_capacity','$luggage_capacity','$cost_per_day','$year','$color','Available','$location_name','$street','$city','$image_name')";

        $qry = $pdo->prepare($sql);
        $qry->execute();
        if ($qry->rowCount()) {
            $query_executed = true;
        } else {
            $query_executed = false;
        }
    }
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Car To List</h1>
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
                        <form action="add_car.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="model_id">Model Id</label>
                                        <input type="text" placeholder="STR20" class="form-control" name="model_id"
                                            id="model_id" required>
                                        <label for="model">Model</label>
                                        <input type="text" placeholder="Corolla" class="form-control" name="model"
                                            id="model" required>
                                        <label for="make">Make</label>
                                        <input type="text" placeholder="Toyota" class="form-control" name="make"
                                            id="make" required>
                                        <label for="passenger_capacity">Passenger Capacity</label>
                                        <input type="number" min="0" placeholder="6" class="form-control"
                                            name="passenger_capacity" id="passenger_capacity" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="luggage_capacity">Luggage Capacity</label>
                                        <input type="text" placeholder="Large" class="form-control"
                                            name="luggage_capacity" id="luggage_capacity" required>
                                        <label for="cost_per_day">Cost Per Day</label>
                                        <input type="number" step="any" min="0" placeholder="6000" class="form-control"
                                            name="cost_per_day" id="cost_per_day" required>
                                        <label for="year">Year</label>
                                        <input type="text" placeholder="2022" class="form-control" name="year" id="year"
                                            required>
                                        <label for="color">Color</label>
                                        <input type="text" placeholder="black" class="form-control" name="color"
                                            id="color" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="location_name">Location Name</label>
                                        <input type="text" placeholder="Kay Rentals" class="form-control"
                                            name="location_name" id="location_name" required>
                                        <label for="street">Street</label>
                                        <input type="text" placeholder="3 Waterway St" class="form-control"
                                            name="street" id="street" required>
                                        <label for="city">City</label>
                                        <input type="text" placeholder="Kingston" class="form-control" name="city"
                                            id="city" required>
                                        <label for="image">Car Image</label>
                                        <input type="file" accept="image/*" class="form-control" name="image" id="image"
                                            required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" name="btn_add_car">ADD
                                        CAR</button>
                                </div>
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
    if (isset($query_executed)) {
        if ($query_executed) {
            echo '
                    <script>toastr.success(\'Car Added Successfully\')</script>
                ';
        } else {
            echo '
                    <script>toastr.error(\'Failed to Add Car. Please Try Again Later\')</script>
                ';
        }
    }
    ?>