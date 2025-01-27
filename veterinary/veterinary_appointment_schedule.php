<?php
session_start();
require_once 'db.php'; // Ensure this file establishes the database connection as $conn

// Check if the user is logged in based on the session 'email'
$is_logged_in = isset($_SESSION['email']);

if ($is_logged_in) {
    // User is logged in; retrieve user information
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 'No ID set';

    // Prepare the SQL statement to fetch only pending schedules
    $sql = "SELECT * FROM `schedule_list` WHERE veterinaryId = ? AND `status` = 'pending'";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // If prepare() failed, output an error message
        die('Prepare failed: ' . $conn->error);
    }

    // Bind the parameter
    if (!$stmt->bind_param("i", $user_id)) {
        die('Bind param failed: ' . $stmt->error);
    }

    // Execute the query
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }

    // Get the result
    $result = $stmt->get_result();

    // Initialize schedule results array
    $sched_res = [];
    while ($row = $result->fetch_assoc()) {
        $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
        $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
        $sched_res[$row['id']] = $row;
    }

    // Free the result set and close the statement
    $stmt->free_result();
    $stmt->close();
} else {
    // Handle non-logged-in state
    // Redirect to a login page
    header("Location: index.php");
    exit();
}

// Close the database connection
if (isset($conn)) {
    $conn->close();
}
?>



<?php

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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Veterinary Clinic Management System | Schedule List</title>
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
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
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
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: #fff"></i></a>
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
              <i class="nav-icon fas fa-tachometer-alt" style="color: #fff"></i>
              <p style="color: #fff">
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
                Pet Products
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pet_list_products.php" class="nav-link">
                  <i class="far fa-plus-square nav-icon"></i>
                  <p>List Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pet_view_products.php" class="nav-link">
                  <i class="far fa-edit nav-icon"></i>
                  <p>View Products</p>
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
            <h4 class="m-0 text-uppercase font-weight-bold">Customer Appointment Schedule</h4>
        </div>
        <br>
<div id="calendar"></div>

<?php

// Database connection details
$host = "localhost"; // Change to your database host
$dbname = "u104053626_lemeryvetcare"; // Change to your database name
$username = "u104053626_lemeryvetcare"; // Change to your database username
$password = "Lemeryvet4209*"; // Change to your database password

// Establish a database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the user is logged in based on the session 'email'
$is_logged_in = isset($_SESSION['email']);

if ($is_logged_in) {
    // User is logged in; retrieve user information
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    if ($user_id) {
        // Prepare the SQL statement to filter schedules by veterinaryId
        try {
            $stmt = $pdo->prepare("SELECT * FROM `schedule_list` WHERE veterinaryId = ?");
            $stmt->execute([$user_id]);
            $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    } else {
        die("User ID is not set in the session.");
    }
} else {
    die("You must be logged in to view schedules.");
}
?>

<br>
<!-- Search Box -->
<div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Search table..." onkeyup="filterTable()">
</div>
<div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Pet's Condition</th>
                    <th>Start Datetime</th>
                    <th>End Datetime</th>
                    <th>Medical Name</th>
                    <th>Full Name</th>
                    <th>Pet Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
               <tbody id="tableBody">
                <?php if (!empty($schedules)) : ?>
                    <?php 
                    $counter = 1; // Initialize the counter to start at 1
                    foreach ($schedules as $schedule) : ?>
                        <tr>
                            <td><?= $counter++ ?></td> <!-- Incrementing counter -->
                            <td><?= htmlspecialchars($schedule['title']) ?></td>
                            <td><?= htmlspecialchars($schedule['description']) ?></td>
                            <td><?= htmlspecialchars($schedule['start_datetime']) ?></td>
                            <td><?= htmlspecialchars($schedule['end_datetime']) ?></td>
                            <td><?= htmlspecialchars($schedule['medicalName']) ?></td>
                            <td><?= htmlspecialchars($schedule['full_name']) ?></td>
                            <td><?= htmlspecialchars($schedule['pet_name']) ?></td>
                            <td>    <?php 
    // Determine badge class based on status value
    $status = htmlspecialchars($schedule['status']);
    $badgeClass = '';

    switch ($status) {
        case 'approved':
            $badgeClass = 'bg-success'; // Green for approved
            break;
        case 'pending':
            $badgeClass = 'bg-warning'; // Yellow for pending
            break;
        case 'rejected':
            $badgeClass = 'bg-danger'; // Red for rejected
            break;
        default:
            $badgeClass = 'bg-secondary'; // Gray for any other status
            break;
    }
    ?><span class="badge <?= $badgeClass; ?>"><?= $status; ?></span></td>
                            <td>
<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
    data-id="<?= htmlspecialchars($schedule['id']); ?>" 
    data-status="<?= htmlspecialchars($schedule['status']); ?>">
    <i class='fa fa-edit'></i>
</button>

<a href="delete.php?id=<?= htmlspecialchars($schedule['id']) ?>" class="btn btn-danger btn-sm delete-btn" data-id="<?= htmlspecialchars($schedule['id']); ?>"><i class='fa fa-trash'></i></a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center">No data found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
                </div>
            </div>
        </div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="scheduleId" name="scheduleId">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveChanges" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Event Details Modal -->
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title">Schedule Details</h5>
            </div>
            <div class="modal-body rounded-0">
                <div class="container-fluid">
                    <dl>
                        <dt class="text-muted">Scheduled Appointment Name</dt>
                        <dd id="medicalName" class="fw-bold fs-4"></dd>
                        
                        <dt class="text-muted">Full Name</dt>
                        <dd id="full_name" class="fw-bold fs-4"></dd>
                        
                        <dt class="text-muted">Pet Name</dt>
                        <dd id="pet_name" class="fw-bold fs-4"></dd> <!-- Display pet_name here -->
                        
                        <dt class="text-muted">Title</dt>
                        <dd id="title" class="fw-bold fs-4"></dd>
                        
                        <dt class="text-muted">Pet's Condition</dt>
                        <dd id="description" class=""></dd>
                        
                        <dt class="text-muted">Start</dt>
                        <dd id="start" class=""></dd>
                        
                        <dt class="text-muted">End</dt>
                        <dd id="end" class=""></dd>
                    </dl>
                </div>
            </div>
            <div class="modal-footer rounded-0">
                <div class="text-end">
                    <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- ./wrapper -->
<!-- Bootstrap JavaScript (Make sure this is included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
    // When the modal is triggered, this function will set the values
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var scheduleId = button.getAttribute('data-id'); // Get the schedule ID
        var status = button.getAttribute('data-status'); // Get the current status

        // Populate the modal fields with the data from the button
        var scheduleIdInput = editModal.querySelector('#scheduleId');
        scheduleIdInput.value = scheduleId;

        var statusSelect = editModal.querySelector('#status');
        statusSelect.value = status; // Set the current status in the dropdown
    });

    // Optionally handle save changes or other actions
    document.getElementById('saveChanges').addEventListener('click', function() {
        var scheduleId = document.getElementById('scheduleId').value;
        var status = document.getElementById('status').value;

        // You can send the data via AJAX to update the status or perform any other actions
        console.log('Schedule ID:', scheduleId, 'New Status:', status);

        // Example AJAX call
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_status_ajax.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Handle success, like updating the row in the table or showing a message
                showToast('Status updated successfully!','success');
                                    // Delay redirection by 3 seconds
                    setTimeout(function() {
                        window.location.href = 'veterinary_appointment_schedule.php'; // Modify this if you need to pass parameters
                    }, 3000);
                // Optionally, you can close the modal here
                var myModal = new bootstrap.Modal(document.getElementById('editModal'));
                myModal.hide();
            }
        };
        xhr.send('scheduleId=' + scheduleId + '&status=' + status);
    });
</script>
<script>
    // Attach event listener to all delete buttons
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default action (link navigation)

            var scheduleId = button.getAttribute('data-id'); // Get the schedule ID from data attribute

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms, redirect to delete.php with the schedule ID
                    window.location.href = 'delete.php?id=' + scheduleId;
                }
            });
        });
    });
</script>

<script>
    function filterTable() {
        // Get the search input value
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.getElementsByTagName('tr');

        // Loop through all table rows
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let rowContainsFilter = false;

            // Loop through all cells in the row
            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                if (cell) {
                    // Check if cell content includes the filter text
                    if (cell.textContent.toLowerCase().includes(filter)) {
                        rowContainsFilter = true;
                        break;
                    }
                }
            }

            // Show or hide the row based on the filter
            rows[i].style.display = rowContainsFilter ? '' : 'none';
        }
    }
</script>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="./js/scripts.js"></script>

<script type="text/javascript">
          $('#delete').on('click', function() {
            $('#event-details-modal').modal('hide');
        });
</script>
</body>
</html>