<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch current user data
    $stmt = $pdo->prepare('SELECT email, password FROM veterinarians WHERE email = :email');
    $stmt->execute(['email' => $_SESSION['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Handle case where the user is not found
        echo "User not found!";
        exit();
    }
} catch (PDOException $e) {
    echo 'Error fetching user data: ' . $e->getMessage();
    exit();
}
?>
<?php
// Define source directory and destination directories
$sourceDir = 'uploads/medical_product'; 
$destDirs = [
    'user/uploads/medical_product', 
    'admin/uploads/medical_product'
];

// Function to handle file copying
function copyFiles($sourceFile, $sourceDir, $destDirs) {
    $sourcePath = $sourceDir . DIRECTORY_SEPARATOR . $sourceFile;

    if (!file_exists($sourcePath)) {
        die("Source file does not exist.");
    }

    foreach ($destDirs as $destDir) {
        // Create destination directory if it does not exist
        $destPath = $destDir . DIRECTORY_SEPARATOR . $sourceFile;
        
        if (!is_dir($destDir)) {
            if (!mkdir($destDir, 0777, true)) {
                die("Failed to create destination directory: $destDir.");
            }
        }

        // Copy the file
        if (!copy($sourcePath, $destPath)) {
            echo "Failed to copy " . $sourceFile . " to $destPath.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Veterinary Clinic Management System | Medical List Products</title>
  <link rel="icon" type="image/x-icon" href="dist/img/lemery.ico" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.14.1/Toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">

.image-group {
    position: relative;
    display: inline-block;
}

#medical-img {
    display: block;
    width: 50%; /* Adjust if needed */
    margin-left: auto; 
    margin-right: auto;
}

.position-absolute {
    position: absolute;
}

.bottom-0 {
    bottom: 0;
}

.start-50 {
    left: 50%;
}

.translate-middle-x {
    transform: translateX(-50%);
}

        @media (max-width: 576px) {
        .search-controls{
            top: -120px;
            left: 70px;
        }
        .controls{
            top: -70px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">



  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #FFC107;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: #fff;"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->

      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://www.w3schools.com/w3images/avatar3.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="dashboard.php" class="d-block">Clinic Admin</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="dashboard.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt" style="color: #fff;"></i>
              <p style="color: #fff;">
                Dashboard
              </p>
            </a>
          </li>
          
          <li class="nav-header">CLINIC OFFER</li>
         <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Medical Products
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="medical_list_products.php" class="nav-link">
                  <i class="far fa-plus-square nav-icon"></i>
                  <p>List Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="medical_view_products.php" class="nav-link">
                  <i class="far fa-edit nav-icon"></i>
                  <p>View Products</p>
                </a>
              </li>
            </ul>
         <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Veterinary Services
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="veterinary_list_services.php" class="nav-link">
                  <i class="far fa-plus-square nav-icon"></i>
                  <p>List Services</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="veterinary_view_services.php" class="nav-link">
                  <i class="far fa-edit nav-icon"></i>
                  <p>View Services</p>
                </a>
              </li>
            </ul>
         <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Pet Supplies
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pet_list_products.php" class="nav-link">
                  <i class="far fa-plus-square nav-icon"></i>
                  <p>List Supplies</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pet_view_products.php" class="nav-link">
                  <i class="far fa-edit nav-icon"></i>
                  <p>View Supplies</p>
                </a>
              </li>
            </ul>
            <li class="nav-header">BOOKING INFORMATION</li>
          <li class="nav-item">
            <a href="veterinary_appointment_schedule.php" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
                Appointment Schedule
              </p>
            </a>
          </li>
          <li class="nav-header">OPTIONS</li>
          <li class="nav-item">
            <a href="my_account.php" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>
                My Account
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fa fa-sign-out"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

<div class="card mb-4 mx-3 mt-4">
    <div class="card-body">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold">List Medical Products</h4>
        </div>
        <br>
<form id="medicalProductForm" enctype="multipart/form-data">
    <div class="form-group">
        <label for="medical_name">Medical Products Name</label>
        <input type="text" class="form-control" id="medical_name" name="medical_name" placeholder="Enter medical product name">
    </div>
    <div class="form-group">
        <label for="medical_description">Medical Product Description</label>
        <textarea class="form-control" id="medical_description" name="medical_description" placeholder="Enter medical product description" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="medical_price">Medical Product Price</label>
        <input type="text" class="form-control" id="medical_price" name="medical_price" placeholder="Enter medical product price">
    </div>
    <div class="form-group position-relative">
        <img id="medical-img" src="https://via.placeholder.com/400x300.png?text=Medical+Product+Image" alt="Medical Picture" class="img-fluid">
        <input type="file" name="medical_image" id="medical-upload" accept="image/*" style="display: none;">
        <label for="medical-upload" class="btn btn-primary position-absolute bottom-0 start-50 translate-middle-x">Choose Image</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="dashboard.php" class="btn btn-primary">Back</a>
</form>

                </div>
            </div>
        </div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.14.1/Toastify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script type="text/javascript">
  // Function to show toast notifications
function showToast(message, type) {
    const successGradient = 'linear-gradient(to right, #00b09b, #96c93d)'; // Green gradient
    const errorGradient = 'linear-gradient(to right, #ff5f6d, #ffc371)'; // Red gradient

    Toastify({
        text: `<i class="fa fa-exclamation-circle"></i> ${message}`,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: type === 'success' ? successGradient : errorGradient,
        escapeMarkup: false // Ensure HTML is rendered correctly
    }).showToast();
}
</script>
<script>
    $(document).ready(function() {
        $('#medicalProductForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting via the browser

            // Create a FormData object to handle file uploads
            var formData = new FormData(this);

            $.ajax({
                url: 'save_medical_product.php', // The URL of your PHP file to handle the form data
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Parse the response if it's JSON
                    try {
                        var res = JSON.parse(response);

                        if (res.status === 'success') {
                            // Show success toast
                            showToast('Medical product saved successfully!', 'success');

                            // Redirect after a delay
                            setTimeout(function() {
                                window.location.href = 'medical_view_products.php'; // Modify this if you need to pass parameters
                            }, 3000);
                        } else {
                            // Handle other statuses (e.g., 'error')
                            showToast(res.message, 'error');
                        }
                    } catch (e) {
                        // Handle cases where the response is not JSON
                        showToast('An unexpected error occurred.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    showToast('An error occurred: ' + error, 'error');
                }
            });
        });

        // Image preview on file select
        $('#medical-upload').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#medical-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>

</body>
</html>