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
  <title>Veterinary Clinic Management System | Clinc Graphs Data</title>
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
        .btn-inline {
            display: inline-block;
            margin-right: 10px; /* Adjust margin as needed */
        }
                .hidden {
            display: none;
        }
                .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .section-title h4 {
            font-family: 'Roboto', sans-serif;
            color: #343a40;
            font-weight: 700;
        }
  .chart-container {
    position: relative;
    height: 500px; /* Adjust the height as needed */
    width: 600px; /* Adjust the width as needed */
    margin: auto;
  }
  canvas {
    height: 100% !important;
    width: 100% !important;
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
        <h1 style="font-weight: 1000; font-size: 45px;">Veterinary Clinic Statistics</h1>
        <hr style="border: 0; height: 2px; background-color: #333;">

        <div class="d-flex justify-content-center mt-3">
            <div class="form-inline">
                <button class="btn btn-primary btn-inline" onclick="showSection('medical-products')">Medical Products</button>
                <button class="btn btn-primary btn-inline" onclick="showSection('veterinary-services')">Veterinary Services</button>
                <button class="btn btn-primary btn-inline" onclick="showSection('pet-supplies')">Pet Supplies</button>
            </div>
        </div>

        <div id="medical-products" class="hidden mt-4">
            <div class="card mb-4 mx-3">
                <div class="card-body">
                    <div class="section-title">
                        <h4 class="m-0 text-uppercase font-weight-bold">Medical Products Records</h4>
                    </div>
                    <br>
                                                      <div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Filter Search">
</div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto; overflow-x: auto; display: inline-block; width: 100%;">
                        <table class="table table-bordered" id="dataTable" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medical Image</th>
                                    <th>Medical Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            try {
                                $pdo = new PDO("mysql:host=localhost;dbname=u104053626_lemeryvetcare;charset=utf8", 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $pdo->query("SELECT * FROM medical_products");
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($rows as $index => $row) {
                                    echo "<tr>";
                                    echo "<td>" . ($index + 1) . "</td>";
                                    echo "<td><img src='" . htmlspecialchars($row['medical_image']) . "' alt='Medical Image' width='50'></td>";
                                    echo "<td>" . htmlspecialchars($row['medical_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['medical_description']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['medical_price']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='6'>Error: " . $e->getMessage() . "</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="veterinary-services" class="hidden mt-4">
            <div class="card mb-4 mx-3">
                <div class="card-body">
                    <div class="section-title">
                        <h4 class="m-0 text-uppercase font-weight-bold">Veterinary Services Records</h4>
                    </div>
                    <br>
                                                                          <div class="mb-3">
    <input type="text" id="searchInputs" class="form-control" placeholder="Filter Search">
</div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto; overflow-x: auto; display: inline-block; width: 100%;">
                        <table class="table table-bordered" id="dataTables">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Veterinary Image</th>
                                    <th>Veterinary Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            try {
                                $pdo = new PDO("mysql:host=localhost;dbname=u104053626_lemeryvetcare;charset=utf8", 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $pdo->query("SELECT * FROM veterinary_services");
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($rows as $index => $row) {
                                    echo "<tr>";
                                    echo "<td>" . ($index + 1) . "</td>";
                                    echo "<td><img src='" . htmlspecialchars($row['veterinary_image']) . "' alt='Veterinary Image' width='50'></td>";
                                    echo "<td>" . htmlspecialchars($row['veterinary_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['veterinary_description']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['veterinary_price']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='6'>Error: " . $e->getMessage() . "</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="pet-supplies" class="hidden mt-4">
            <div class="card mb-4 mx-3">
                <div class="card-body">
                    <div class="section-title">
                        <h4 class="m-0 text-uppercase font-weight-bold">Pet Supplies Records</h4>
                    </div>
                    <br>
                                                                          <div class="mb-3">
    <input type="text" id="searchInputss" class="form-control" placeholder="Filter Search">
</div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto; overflow-x: auto; display: inline-block; width: 100%;">
                        <table class="table table-bordered" id="dataTabless">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pet Image</th>
                                    <th>Pet Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            try {
                                $pdo = new PDO("mysql:host=localhost;dbname=u104053626_lemeryvetcare;charset=utf8", 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $pdo->query("SELECT * FROM pet_products");
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($rows as $index => $row) {
                                    echo "<tr>";
                                    echo "<td>" . ($index + 1) . "</td>";
                                    echo "<td><img src='" . htmlspecialchars($row['pet_image']) . "' alt='Pet Image' width='50'></td>";
                                    echo "<td>" . htmlspecialchars($row['pet_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['pet_description']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['pet_price']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='6'>Error: " . $e->getMessage() . "</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=u104053626_lemeryvetcare;charset=utf8", 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Fetch veterinarians
        $stmt = $pdo->query("SELECT id, fullname FROM veterinarians");
        $veterinarians = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($veterinarians as $vet) {
            $vetId = $vet['id'];
            $name = $vet['fullname'];

            // Count records in each table
            $medicalCount = $pdo->query("SELECT COUNT(*) FROM medical_products WHERE veterinary_id = $vetId")->fetchColumn();
            $serviceCount = $pdo->query("SELECT COUNT(*) FROM veterinary_services WHERE veterinary_id = $vetId")->fetchColumn();
            $petCount = $pdo->query("SELECT COUNT(*) FROM pet_products WHERE veterinary_id = $vetId")->fetchColumn();

            $data[] = [
                'name' => $name,
                'medical_count' => $medicalCount,
                'service_count' => $serviceCount,
                'pet_count' => $petCount
            ];
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
    ?>
    <div class="card mb-4 mx-3">
                <div class="card-body">
                    <div class="section-title">
                        <h4 class="m-0 text-uppercase font-weight-bold">Veterinary Clinic Listed Services</h4>
                    </div>
                    <br>
                      <canvas id="veterinaryChart"></canvas>
                    </div>
                </div>
            </div>

         <div class="card mb-4 mx-3">
                <div class="card-body">
                    <div class="section-title">
                        <h4 class="m-0 text-uppercase font-weight-bold">Veterinary Clinic Listed Services</h4>
                    </div>
                    <br>
                      <div class="chart-container">
  <canvas id="veterinaryPieChart"></canvas>
</div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.14.1/Toastify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('#medical-products, #veterinary-services, #pet-supplies').forEach(section => section.classList.add('hidden'));

            // Show the selected section
            document.getElementById(sectionId).classList.remove('hidden');
        }

        // Optionally, you can show the first section by default
        document.addEventListener('DOMContentLoaded', () => {
            showSection('medical-products');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('veterinaryChart').getContext('2d');

            // PHP Data to JavaScript
            var data = <?php echo json_encode($data); ?>;

            // Chart Data
            var labels = data.map(function (item) { return item.name; });
            var medicalCounts = data.map(function (item) { return item.medical_count; });
            var serviceCounts = data.map(function (item) { return item.service_count; });
            var petCounts = data.map(function (item) { return item.pet_count; });

            // Chart
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Medical Products',
                            data: medicalCounts,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Veterinary Services',
                            data: serviceCounts,
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Pet Supplies',
                            data: petCounts,
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx1 = document.getElementById('veterinaryPieChart').getContext('2d');

    // Fetch data from the PHP script
    fetch('fetch_data.php')
        .then(response => response.json())
        .then(data => {
            // Pie Chart
            var myPieChart = new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: ['Medical Products', 'Veterinary Services', 'Pet Supplies'],
                    datasets: [{
                        data: [data.medical_count, data.service_count, data.pet_count],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 14,
                                    family: 'Arial',
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#333',
                            bodyColor: '#666',
                            borderColor: '#ddd',
                            borderWidth: 1,
                            caretSize: 6
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutBounce'
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
</script>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll('#dataTable tbody tr');
        
        rows.forEach(function(row) {
            let rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(input) ? '' : 'none';
        });
    });
</script>
<script>
    document.getElementById('searchInputs').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll('#dataTables tbody tr');
        
        rows.forEach(function(row) {
            let rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(input) ? '' : 'none';
        });
    });
</script>
<script>
    document.getElementById('searchInputss').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll('#dataTabless tbody tr');
        
        rows.forEach(function(row) {
            let rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(input) ? '' : 'none';
        });
    });
</script>

</body>
</html>
