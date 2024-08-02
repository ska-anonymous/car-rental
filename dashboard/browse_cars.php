<!DOCTYPE html>
<html lang="en">

<head>
    <title>Car Rental | Browse Cars</title>

    <!-- include Header here -->
    <?php
    require_once('../components/header.php');
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
                        <h1 class="m-0">Browse Cars</h1>
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
                    <div class="card-header">
                        <div class="card-title">
                            Search By:
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="browse_cars.php" method="get">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="make">Make</label>
                                        <input type="text" placeholder="Toyota" class="form-control" name="make"
                                            id="make">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="model">Model</label>
                                        <input type="text" placeholder="Corolla" class="form-control" name="model"
                                            id="model">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <input type="text" placeholder="2020" class="form-control" name="year"
                                            id="year">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block"
                                        name="btn_search">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <?php
                    if (isset($_GET['btn_search'])) {
                        echo '
                            <div class="card-header">
                                <div class="card-title">
                                    Searched For: MAKE = ' . $_GET['make'] . ' | MODEL = ' . $_GET['model'] . ' | Year = ' . $_GET['year'] . '
                                </div>
                            </div>
                            ';
                    }
                    ?>
                    <div class="card-body">
                        <?php
                        $make = "";
                        $model = "";
                        $year = "";
                        if (isset($_GET['btn_search'])) {
                            $make = $_GET['make'];
                            $model = $_GET['model'];
                            $year = $_GET['year'];
                        }
                        $sql = "SELECT * FROM `car_details` WHERE make LIKE '%$make%' AND model LIKE '%$model%' AND year LIKE '%$year%';";
                        $qry = $pdo->prepare($sql);
                        $qry->execute();
                        if ($qry->rowCount()) {
                            $data = $qry->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($data as $row) {
                                if (trim(strtolower($row['status'])) == 'available') {
                                    $book_now_html = '
                                    <a href="book_car.php?car_id=' . $row['car_id'] . '" class="btn btn-success btn-sm">Book Now</a>
                                    ';
                                } else {
                                    $book_now_html = '';
                                }
                                echo '
                                    <div class="row my-1">
                                        <div class="col-md-5">
                                            <img class="img img-fluid rounded" src="../uploads/car_images/' . $row['image'] . '">
                                        </div>
                                        <div class="col-md-7">
                                            <div>
                                                <h4>' . $row['make'] . " " . $row['model'] . '</h4>
                                            </div>
                                            <div class="text-success">
                                               <b>Model Id:</b> ' . $row['model_id'] . '  <b>Year:</b> ' . $row['year'] . '  <b>Color:</b> ' . $row['color'] . ' <br> <b>Status</b> : ' . $row['status'] . '
                                            </div>
                                            <div>
                                                ' . $book_now_html . '
                                            </div>
                                            <div class="text-right">
                                                <a class="btn btn-info" href="car_details.php?car_id=' . $row['car_id'] . '">More Details</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="bg-warning">
                               ';
                            }
                        } else {
                            echo '<h3 class="text-danger">No Data Found</h3>';
                        }
                        ?>
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