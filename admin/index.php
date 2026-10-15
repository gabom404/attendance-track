<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
include('includes/header.php');
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include('includes/sidebar.php');
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include('includes/navbar.php');
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                    if (isset($_REQUEST['permiso'])) {
                        if ($_REQUEST['permiso'] == 'nope') {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Oops!</strong> Tu usuario no tiene permiso para acceder a ese modulo.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                    }

                    ?>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php
            include('includes/footer.php');
            ?>

</body>

</html>
