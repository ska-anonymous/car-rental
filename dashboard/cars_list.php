<!DOCTYPE html>
<html lang="en">

<head>
    <title>Car Rental | Cars List</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

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

    // include database for fetching data
    require_once('../php_processing/db_connect.php');
    ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Cars List</h1>
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
                            <div class="col-12">
                                <table class="table table-striped" id="cars_list_table">
                                    <thead>
                                        <tr>
                                            <th>Model ID</th>
                                            <th>Model</th>
                                            <th>Make</th>
                                            <th>Passenger Capacity</th>
                                            <th>Luggage Capacity</th>
                                            <th>Cost Per Day</th>
                                            <th>Year</th>
                                            <th>Color</th>
                                            <th>Location Name</th>
                                            <th>Street</th>
                                            <th>City</th>
                                            <th>Image</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM car_details";
                                        $qry = $pdo->prepare($sql);
                                        $qry->execute();
                                        if ($qry->rowCount()) {
                                            $data = $qry->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($data as $row) {
                                                echo '
                                                <tr>
                                                    <td>' . $row['model_id'] . '</td>
                                                    <td>' . $row['model'] . '</td>
                                                    <td>' . $row['make'] . '</td>
                                                    <td>' . $row['passenger_capacity'] . '</td>
                                                    <td>' . $row['luggage_capacity'] . '</td>
                                                    <td>' . $row['cost_per_day'] . '</td>
                                                    <td>' . $row['year'] . '</td>
                                                    <td>' . $row['color'] . '</td>
                                                    <td>' . $row['location_name'] . '</td>
                                                    <td>' . $row['street'] . '</td>
                                                    <td>' . $row['city'] . '</td>
                                                    <td><img class="rounded" width="70" src="../uploads/car_images/' . $row['image'] . '"></td>
                                                    <td><button>EDIT</button></td>
                                                    <td><button>DELETE</button></td>
                                                </tr>
                                                ';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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

    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/jszip/jszip.min.js"></script>
    <script src="../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        // $("#cars_list_table").DataTable({
        //     "responsive": true, "lengthChange": false, "autoWidth": false,
        //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#cars_list_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": false,
        });
    </script>