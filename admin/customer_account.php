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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Veterinary Clinic Management System | User Account</title>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

<div class="card mb-4 mx-3 mt-4">
    <div class="card-body">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold">User Account List</h4>
        </div>
        <br>

            <div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Filter Search">
</div>
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Profile</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Status</th>
                                        <th style="width: 90px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
 <?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=u104053626_lemeryvetcare;charset=utf8", 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM users");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($rows as $index => $row) {
        echo "<tr>";
        echo "<td>" . ($index + 1) . "</td>";
        $imageSrc = !empty($row['user_image']) ? htmlspecialchars($row['user_image']) : 'https://www.w3schools.com/w3images/avatar5.png';
        echo "<td><img src='" . $imageSrc . "' alt='Clinic Image' width='50'></td>";
        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        $truncatedPassword = strlen($row['password']) > 10 ? substr($row['password'], 0, 10) . '...' : $row['password'];
        echo "<td>" . htmlspecialchars($truncatedPassword) . "</td>";
        $status = htmlspecialchars($row['status']);
        $badgeClass = '';
        $statusText = '';

        // Determine the badge class and status text based on the status value
        if ($status === 'active') {
            $badgeClass = 'badge bg-success';
            $statusText = 'Active';
        } elseif ($status === 'inactive') {
            $badgeClass = 'badge bg-danger';
            $statusText = 'Block';
        } else {
            $badgeClass = 'badge bg-secondary'; // Default for any unexpected values
            $statusText = 'Unknown';
        }
        echo "<td style='text-align: center;'><span class=\"$badgeClass\">$statusText</span></td>";
        echo "<td>";
        // Use query parameters to pass all necessary data

echo "<a href='edit_user_account.php?id=" . urlencode($row['id']) . 
     "&user_image=" . urlencode($row['user_image']) . 
     "&full_name=" . urlencode($row['full_name']) . 
     "&email=" . urlencode($row['email']) . 
     "&password=" . urlencode($row['password']) . 
     "&status=" . urlencode($row['status']) . 
     "' class='btn btn-warning btn-sm'> <i class='fa fa-edit'></i></a>";
echo "<button class='btn btn-danger btn-sm delete-btn' data-id='" . htmlspecialchars($row['id']) . "'><i class='fa fa-ban'></i></button>";
        echo "</td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "<tr><td colspan='9'>Error: " . $e->getMessage() . "</td></tr>";
}
?>
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
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure you want to block this user account?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, block it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with the deletion
                    fetch('block_user_account.php?id=' + encodeURIComponent(id))
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('User Account block successfully.','success');
                    // Delay redirection by 3 seconds
                    setTimeout(function() {
                        window.location.href = 'customer_account.php'; // Modify this if you need to pass parameters
                    }, 3000);
                            } else {
                                showToast('Error! ' + data.message);
                            }
                        })
                        .catch(error => {
                            showToast('Error! An unexpected error occurred.');
                        });
                }
            });
        });
    });
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
</body>
</html>
