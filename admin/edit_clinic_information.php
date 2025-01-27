<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

?>
<?php
// Check if required parameters are present in the URL
if (isset($_GET['id']) && isset($_GET['business_permit_no']) && isset($_GET['clinic_name']) && isset($_GET['address']) && isset($_GET['line_of_business']) && isset($_GET['clinic_image']) && isset($_GET['latitude']) && isset($_GET['longitude'])) {
    // Extract values from URL parameters
    $id = urldecode($_GET['id']);
    $business_permit_no = urldecode($_GET['business_permit_no']);
    $clinic_name = urldecode($_GET['clinic_name']);
    $address = urldecode($_GET['address']);
    $line_of_business = urldecode($_GET['line_of_business']);
    $clinic_image = urldecode($_GET['clinic_image']);
    $latitude = urldecode($_GET['latitude']);
    $longitude = urldecode($_GET['longitude']);
} else {
    // Handle missing parameters, e.g., redirect or show an error
    die('Missing required parameters.');
}

// Process the extracted data here (e.g., save to the database or display on a webpage)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Veterinary Clinic Management System | Edit Clinic Information</title>
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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">

.image-group {
    position: relative;
    display: inline-block;
}

#clinic-img {
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
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://www.w3schools.com/w3images/avatar3.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="dashboard.php" class="d-block">Administrator</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="dashboard.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
          <li class="nav-header">CLINIC MANAGEMENT</li>
          <li class="nav-item">
            <a href="clinic_spatial_data.php" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
               Location Registration
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="clinic_information.php" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Clinic Information
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="clinic_verification_review.php" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Verification Review
              </p>
            </a>
          </li>
          <li class="nav-header">REPORTS</li>
          <li class="nav-item">
            <a href="clinic_graphs_data.php" class="nav-link">
              <i class="nav-icon fa fa-bar-chart"></i>
              <p>
               Graphs
              </p>
            </a>
          </li>
          <li class="nav-header">ACCOUNT LIST</li>
          <li class="nav-item">
            <a href="veterinary_account.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
               Veterinary Account
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="customer_account.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
               User Account
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
            <h4 class="m-0 text-uppercase font-weight-bold">Edit Veterinary Clinic Spatial Data Information</h4>
        </div>
        <br>
<form id="updateclinicForm" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <div class="form-group">
        <label for="business_permit_no">Business Permit No.</label>
        <input type="text" class="form-control" id="business_permit_no" name="business_permit_no" placeholder="Enter business permit number" value="<?php echo htmlspecialchars($business_permit_no); ?>">
    </div>
    <div class="form-group">
        <label for="clinic_name">Name of Veterinary Clinic</label>
        <input type="text" class="form-control" id="clinic_name" name="clinic_name" placeholder="Enter clinic name" value="<?php echo htmlspecialchars($clinic_name); ?>">
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="<?php echo htmlspecialchars($address); ?>">
    </div>
    <div class="form-group">
        <label for="line_of_business">Line of Business</label>
        <input type="text" class="form-control" id="line_of_business" name="line_of_business" placeholder="Enter line of business" value="<?php echo htmlspecialchars($line_of_business); ?>">
    </div>
    <div class="form-group">
        <label for="latitude">Latitude</label>
        <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter latitude" value="<?php echo htmlspecialchars($latitude); ?>" readonly>
    </div>
    <div class="form-group">
        <label for="longitude">Longitude</label>
        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter longitude" value="<?php echo htmlspecialchars($longitude); ?>" readonly>
    </div>
    <div class="form-group">
<div class="form-group position-relative">
    <img id="clinic-img" src="<?php echo htmlspecialchars($clinic_image ?? 'https://www.w3schools.com/w3images/avatar5.png'); ?>" alt="Clinic Picture" class="img-fluid">
    <input type="file" name="clinic_image" id="clinic-upload" accept="image/*" style="display: none;">
    <label for="clinic-upload" class="btn btn-primary position-absolute bottom-0 start-50 translate-middle-x">Choose Clinic Picture</label>
</div>

    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="clinic_information.php" class="btn btn-primary">Back</a>
</form>
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
    $('#updateclinicForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this);

        $.ajax({
            url: 'update_clinic_information.php', // PHP processing file
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // Expecting JSON response
            success: function(response) {
                // Handle success based on JSON response
                if (response.success) {
                    showToast('Clinic information update successfully.','success');
                    // Delay redirection by 3 seconds
                    setTimeout(function() {
                        window.location.href = 'clinic_information.php'; // Modify this if you need to pass parameters
                    }, 3000);
                } else {
                    showToast('Error: ' + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('An error occurred while processing your request: ' + textStatus);
                console.error('AJAX error:', textStatus, errorThrown);
            }
        });
    });
});

</script>

<script>
    document.getElementById('clinic-upload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('clinic-img').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
    </script>
        <script type="text/javascript">
        document.getElementById('address').addEventListener('input', function() {
            const address = this.value.trim();

            if (address) {
                geocodeAddress(address);
            } else {
                // Clear fields if input is empty
                document.getElementById('latitude').value = '';
                document.getElementById('longitude').value = '';
            }
        });

        function geocodeAddress(address) {
            const apiKey = '8a5f9b1e91794c0ba76517be5df71f6d'; // Replace with your API key
            // Coordinates of Lemery, Batangas for bounding box
            const bounds = '13.8919,120.8098,13.9318,120.8837'; // [southwest_lat,southwest_lng,northeast_lat,northeast_lng]
            const url = `https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(address)}&key=${apiKey}&countrycode=PH&bounds=${bounds}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.results && data.results.length > 0) {
                        const result = data.results[0];
                        const latitude = result.geometry.lat;
                        const longitude = result.geometry.lng;

                        // Set the latitude and longitude values
                        document.getElementById('latitude').value = latitude;
                        document.getElementById('longitude').value = longitude;
                    } else {
                        // Clear fields if no results are found
                        document.getElementById('latitude').value = '';
                        document.getElementById('longitude').value = '';
                        console.log('No results found for:', address);
                    }
                })
                .catch(error => console.error('Error fetching location data:', error));
        }
    </script>
</body>
</html>
