<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to count records
    $stmt = $pdo->query('SELECT COUNT(*) AS count FROM clinic_info');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $clinicCount = $row['count'];
} catch (PDOException $e) {
    $clinicCount = 'Error fetching count'; // Fallback error message
}
?>
<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');

// SQL query to get counts
$stmt = $pdo->query("SELECT
    (SELECT COUNT(*) FROM medical_products) AS medical_products_count,
    (SELECT COUNT(*) FROM veterinary_services) AS veterinary_services_count,
    (SELECT COUNT(*) FROM pet_products) AS pet_products_count
");

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$total_count = $result['medical_products_count'] +
               $result['veterinary_services_count'] +
               $result['pet_products_count'];
?>
<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');

// SQL query to get the count of records from schedule_list
$stmt = $pdo->query("SELECT COUNT(*) AS appointment_count FROM schedule_list");
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$appointment_count = $result['appointment_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Veterinary Clinic Management System | Dashboard</title>
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

     <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

    <!-- Leaflet Locate CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Leaflet Routing Machine JavaScript -->
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

    <!-- Leaflet Locate JavaScript -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://unpkg.com/leaflet-locatecontrol/dist/L.Control.Locate.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
    <script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js"></script>
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
        #map {
            height: 600px;
            width: 100%;
        }

        .controls {
            position: absolute;
            top: 10px;
            left: 30px;
            z-index: 1000;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .search-controls{
            position: absolute;
            top: 10px;
            left: 30px;
            z-index: 1000;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .spatial-form {
            width: 225px;
            margin-bottom: 10px;
        }
        #imagePreview {
            max-width: 100%;
            height: auto;
        }
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
              <i class="nav-icon fas fa-tachometer-alt" style="color: #fff;"></i>
              <p style="color: #fff;">
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
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo htmlspecialchars($clinicCount); ?></h3>

                <p>Veterinary Clinic</p>
              </div>
              <div class="icon">
                <i class="ion ion-map"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $appointment_count; ?></h3>

                <p>Clinic Appointment</p>
              </div>
              <div class="icon">
                <i class="ion ion-calendar"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $total_count; ?></h3>

                <p>Clinic Services</p>
              </div>
              <div class="icon">
                <i class="ion-ios-cart" style="margin-top: -25px;"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>1</h3>

                <p>Administrator</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
            </div>
          </div>

</div>
</section>
</section>

<div class="modal fade" id="clinicModal" tabindex="-1" role="dialog" aria-labelledby="clinicModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="clinicModalLabel">Update Clinic Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="clinicForm">
            <div class="form-group">
                <label for="business_permit_no">Business Permit No.</label>
                <input type="text" class="form-control" id="business_permit_no" name="business_permit_no" placeholder="Enter business permit number" required>
            </div>
            <div class="form-group">
                <label for="clinic_name">Name of Veterinary Clinic</label>
                <input type="text" class="form-control" id="clinic_name" name="clinic_name" placeholder="Enter clinic name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
            </div>
            <div class="form-group">
                <label for="line_of_business">Line of Business</label>
                <input type="text" class="form-control" id="line_of_business" name="line_of_business" placeholder="Enter line of business" required>
            </div>
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter latitude" required>
            </div>
            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter longitude" required>
            </div>
            <div class="form-group image-group">
                <label for="clinic_image">Upload Clinic Image</label>
                <input type="file" class="form-control-file" id="clinic_image" name="clinic_image" accept="image/*" onchange="previewImage(event)" required>
                <div id="imagePreviewContainer" class="mt-2">
                    <img id="imagePreview" src="" alt="Image Preview" style="display: none;">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


        <div class="container-fluid">
            <div class="card mb-4 mx-3 mt-4">
    <div class="card-body p-0">
        <div class="search-controls" style="margin-top: 200px;">
            <div class="input-group">
                <input type="text" id="plantation-sites" class="form-control" placeholder="Find Veterinary Clinic" style="font-size: 14px; color: black;">
                <span class="input-group-text">
                    <i id="searchBtn" class="fa fa-search"></i>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4 mx-3 mt-4">
    <div class="card-body">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold"></h4>
               </div>
        <div class="controls" style="margin-top: 240px;">
            <div class="form-group">
                <label for="start" style="font-size: 14px; color: black;">Start Location:</label>
                <input type="text" id="start" class="form-control spatial-form" placeholder="Find address or place"style="font-size: 14px; color: black;">
            </div>
            <div class="form-group">
                <label for="end" style="font-size: 14px; color: black;">End Location:</label>
                <input type="text" id="end" class="form-control spatial-form" placeholder="Find address or place" style="font-size: 14px; color: black;">
            </div>
            <button id="routeBtn" class="btn btn-light"><i class="fa fa-location-arrow"></i></button>
            <button id="markLocationBtn" class="btn btn-light "><i class="fa fa-map-marker"></i></button>
            <button class="btn btn-light" onclick="location.reload();"><i class="fa fa-refresh"></i> </button>
        </div>
        <div id="map"></div>
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
<script>
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

// Initialize the map
var map = L.map('map').setView([13.9532, 120.8843], 12); // Default view coordinates

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var markers = []; // Store markers to use in search

// Fetch locations from the server
fetch('fetch_locations.php')
    .then(response => response.json())
    .then(locations => {
        locations.forEach(function(location) {
            var marker = L.marker([location.lat, location.lng]).addTo(map)
                .bindPopup(`
                    <div style="text-align: center;">
                        <img src="${location.imgSrc}" alt="${location.title}" style="width: 100%; height: auto; max-width: 300px;">
                        <h4 style="margin: 10px 0;">${location.title}</h4>
                        <p style="text-align: justify; margin: 0 10px;">${location.description}</p>
                    </div>
                `);

            marker.on('click', function() {
                var endLatLng = marker.getLatLng();
                document.getElementById('end').value = `Lat: ${endLatLng.lat.toFixed(6)}, Lng: ${endLatLng.lng.toFixed(6)}`;

                if (startLatLng) {
                    control.setWaypoints([
                        L.latLng(startLatLng.lat, startLatLng.lng),
                        L.latLng(endLatLng.lat, endLatLng.lng)
                    ]);
                }
            });

            markers.push({
                title: location.title.toLowerCase(),
                marker: marker
            });
        });
    })
    .catch(error => {
        console.error('Error fetching locations:', error);
        showToast('Failed to load locations.', 'error');
    });

// Initialize routing control
var control = L.Routing.control({
    waypoints: [],
    routeWhileDragging: true
}).addTo(map);

var geocoder = L.Control.Geocoder.nominatim();
var startLatLng; 

document.getElementById('routeBtn').addEventListener('click', function() {
    var startLocation = document.getElementById('start').value.trim();
    var endLocation = document.getElementById('end').value.trim();

    if (startLocation && endLocation) {
        geocoder.geocode(startLocation, function(results) {
            if (results.length === 0) {
                if (startLocation.length > 0) {
                    showToast('Start location not found.','error');
                }
                return;
            }
            startLatLng = results[0].center; 

            geocoder.geocode(endLocation, function(results) {
                if (results.length === 0) {
                    showToast('End location not found.','error');
                    return;
                }
                var endLatLng = results[0].center;

                control.setWaypoints([
                    L.latLng(startLatLng.lat, startLatLng.lng),
                    L.latLng(endLatLng.lat, endLatLng.lng)
                ]);
            });
        });
    } else {
        showToast('Please enter both start and end locations.' , 'error');
    }
});

function searchLocation() {
    var searchValue = document.getElementById('plantation-sites').value.trim().toLowerCase();

    var foundLocation = markers.find(function(location) {
        return location.title === searchValue;
    });

    if (foundLocation) {
        var marker = foundLocation.marker;

        map.setView(marker.getLatLng(), 15);
        marker.openPopup();
    } else {
        showToast('Veterinary Clinic not found.','error');
    }
}

document.getElementById('searchBtn').addEventListener('click', function() {
    searchLocation();
});

document.getElementById('plantation-sites').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchLocation();
    }
});

L.control.locate({
    position: 'topleft',
    drawCircle: true,
    follow: true,
    setView: true,
    metric: false,
    icon: 'fa fa-map-marker',
    strings: {
        title: "Show me where I am"
    }
}).addTo(map);

document.getElementById('markLocationBtn').addEventListener('click', function() {
    map.locate({ setView: true, maxZoom: 16 });
});

map.on('locationfound', function(e) {
    var marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map)
        .bindPopup('You are here!')
        .openPopup();
    
    document.getElementById('start').value = `Lat: ${e.latlng.lat.toFixed(6)}, Lng: ${e.latlng.lng.toFixed(6)}`;
    startLatLng = e.latlng; 
});

map.on('locationerror', function() {
    showToast('Unable to locate your position.','error');
});

map.on('click', function(e) {
    if (startLatLng) {
        var clickedLatLng = e.latlng;
        control.setWaypoints([
            L.latLng(startLatLng.lat, startLatLng.lng),
            L.latLng(clickedLatLng.lat, clickedLatLng.lng)
        ]);
        document.getElementById('end').value = `Lat: ${clickedLatLng.lat.toFixed(6)}, Lng: ${clickedLatLng.lng.toFixed(6)}`;
    } else {
        showToast('Please set a start location first.', 'error');
    }
});

</script>


</body>
</html>
