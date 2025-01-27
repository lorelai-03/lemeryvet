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
  <title>Veterinary Clinic Management System | Clinic Verification Review</title>
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
      }
      .bg-danger {
    background-color: #dc3545; /* Red for unverified */
    color: white;
    padding: 2px 5px;
    border-radius: 3px;
}

.bg-success {
    background-color: #28a745; /* Green for verified */
    color: white;
    padding: 2px 5px;
    border-radius: 3px;
}

.badge {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 700;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    line-height: 1;
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
            <h4 class="m-0 text-uppercase font-weight-bold">Veterinary Clinic Spatial Data Information</h4>
        </div>
        <br>

                                  <div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Filter Search">
</div>
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=u104053626_lemeryvetcare;charset=utf8", 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to fetch all records from the veterinarians table
    $stmt = $pdo->query("SELECT * FROM veterinarians");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate the table
    echo "<table class='table table-bordered' id='dataTable'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>Full Name</th>";
    echo "<th>Gender</th>";
    echo "<th style='width: 100px;'>Date of Birth</th>";
    echo "<th>Clinic Name</th>";
    echo "<th>Address</th>";
    echo "<th>Email</th>";
    echo "<th>License</th>";
    echo "<th>Permit</th>";
    echo "<th>Status</th>";
    echo "<th style='width: 100px;'>Actions</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // Loop through each row to generate table rows
    foreach ($rows as $index => $row) {
        $vetLicense = htmlspecialchars($row['vet_license']);
        $businessPermit = htmlspecialchars($row['business_permit']);
        $status = htmlspecialchars($row['status']);
        $id = htmlspecialchars($row['id']);
        
        // Determine the status class based on the value
        $statusClass = ($status === 'unverified') ? 'bg-danger' : 'bg-success';
        $statusText = ($status === 'unverified') ? 'Unverified' : 'Verified';
        
        echo "<tr>";
        echo "<td>" . ($index + 1) . "</td>";
        echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
        echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
        echo "<td>" . htmlspecialchars($row['clinic_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td><a href='download.php?file=" . urlencode($vetLicense) . "' download>Download License</a></td>";
        echo "<td><a href='download.php?file=" . urlencode($businessPermit) . "' download>Download Permit</a></td>";
        echo "<td><span class='badge $statusClass'>$statusText</span></td>";
        echo "<td>";
        echo "<a href='#' class='btn btn-warning btn-sm edit-btn' data-toggle='modal' data-target='#statusModal' data-id='$id'><i class='fa fa-edit'></i></a>";
        echo "<button class='btn btn-danger btn-sm delete-btn' data-id='$id'><i class='fa fa-trash'></i></button>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

} catch (PDOException $e) {
    echo "<tr><td colspan='11'>Error: " . $e->getMessage() . "</td></tr>";
}
?>



 
                </div>
            </div>
<!-- Modal Structure -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Veterinarian Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="statusForm"> <!-- Added form ID -->
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <div class="form-group">
                        <label for="status">Select Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="unverified" <?php if ($status === 'unverified') echo 'selected'; ?>>Unverified</option>
                            <option value="verified" <?php if ($status === 'verified') echo 'selected'; ?>>Verified</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
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
    $('#statusForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize(); // Serialize the form data

        $.ajax({
            type: 'POST',
            url: 'update_status.php', // The PHP file to handle the update
            data: formData,
            success: function(response) {
                // Handle the response
                if (response === 'success') {
                            $('#statusModal').modal('hide');
                    showToast('Clinic status successfully update.','success');
                    // Delay redirection by 3 seconds
                    setTimeout(function() {
                        window.location.href = 'clinic_verification_review.php'; // Modify this if you need to pass parameters
                    }, 3000);
                } else {
                    showToast('Error updating status','error');
                }
            },
            error: function(xhr, status, error) {
                console.error(error); // Log any error for debugging
                alert('An error occurred. Please try again.');
            }
        });
    });

    // Pass data to the modal when the edit button is clicked
    $('#statusModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userId = button.data('id'); // Extract the ID from the clicked button
        var modal = $(this);
        modal.find('.modal-body #user_id').val(userId); // Set the ID in the hidden input field
    });
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure you want to delete this clinic?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with the deletion
                    fetch('clinic_delete.php?id=' + encodeURIComponent(id))
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Clinic deleted successfully.','success');
                    // Delay redirection by 3 seconds
                    setTimeout(function() {
                        window.location.href = 'clinic_verification_review.php'; // Modify this if you need to pass parameters
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
