<?php
session_start();

// Check if the user is logged in
$is_logged_in = isset($_SESSION['email']);

if ($is_logged_in) {
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    if (!$user_id) {
        echo "User ID is not set.";
        exit();
    }

    // Database connection
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Initialize variables to hold counts
        $appointment_count = 0;
        $medicalProductsCount = 0;
        $veterinaryServicesCount = 0;
        $petProductsCount = 0;

        // Count appointments for the current user's veterinaryId
        $sql = "SELECT COUNT(*) AS appointment_count 
                FROM schedule_list 
                WHERE veterinaryId = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $appointment_count = $result['appointment_count'];

        // Count records in medical_products for the current user's veterinaryId
        $sql = "SELECT COUNT(*) AS count 
                FROM medical_products 
                WHERE veterinary_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $medicalProductsCount = $row['count'];

        // Count records in veterinary_services for the current user's veterinaryId
        $sql = "SELECT COUNT(*) AS count 
                FROM veterinary_services 
                WHERE veterinary_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $veterinaryServicesCount = $row['count'];

        // Count records in pet_products for the current user's veterinaryId
        $sql = "SELECT COUNT(*) AS count 
                FROM pet_products 
                WHERE veterinary_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $petProductsCount = $row['count'];

    } catch (PDOException $e) {
        // Handle error and set default values
        $appointment_count = 0;
        $medicalProductsCount = 0;
        $veterinaryServicesCount = 0;
        $petProductsCount = 0;
        // Optionally log the error or show an error message
        // error_log($e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
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
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
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
                <h3><?php echo htmlspecialchars($medicalProductsCount); ?></h3>

                <p>Medical Products</p>
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
                <h3><?php echo htmlspecialchars($veterinaryServicesCount); ?></h3>

                <p>Veterinary Services</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
            </div>
          </div>

            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo htmlspecialchars($petProductsCount); ?></h3>

                <p>Pet Products</p>
              </div>
              <div class="icon">
                <i class="ion-ios-cart" style="margin-top: -25px;"></i>
              </div>
              
            </div>
          </div>
</div>
</section>
</section>

<div class="card mb-4 mx-3 mt-4">
    <div class="card-body">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold">Message User via SMS</h4>
        </div>
        <br>
       <form id="smsForm">
            <div class="form-group">
                <label for="userSelect">Select Customer</label>
                <select id="userSelect" class="form-control" required>
                    <option value="">Select a customer</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="text" id="phoneNumber" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="smsContent">SMS Content</label>
                <textarea id="smsContent" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send SMS</button>
        </form>

      </div>
    </div>

    <div class="row">
    <!-- Card 1 (Medical Product) -->
    <div class="col-md-4">
        <div class="card mb-4 mx-3">
            <div class="card-body">
                <h5 class="card-title mb-2" style="text-align: center; font-weight: bold;">Medical Product</h5> <!-- Updated title -->
<form id="MedicalProductdiscountForm">
    <div class="mb-3">
        <select class="form-select form-control" id="percentage3" name="percentage3" required>
            <option selected disabled>Choose Discount Percentage</option>
            <option value="0">Discounted 0%</option>
            <?php for ($i = 5; $i <= 90; $i += 5): ?>
                <option value="<?php echo $i; ?>">Discounted <?php echo $i; ?>%</option>
            <?php endfor; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary w-100">Save</button>
</form>

            </div>
        </div>
    </div>

    <!-- Card 2 (Veterinary Services) -->
    <div class="col-md-4">
        <div class="card mb-4 mx-3">
            <div class="card-body">
                <h5 class="card-title mb-2" style="text-align: center; font-weight: bold;">Veterinary Services</h5> <!-- Updated title -->
                  <form id="VeterinaryServicesdiscountForm">
                      <div class="mb-3">
                          <select class="form-select form-control" id="percentage2" name="percentage2" required>
                              <option selected disabled>Choose Discount Percentage</option>
                              <option value="0">Discounted 0%</option>
                              <?php for ($i = 5; $i <= 90; $i += 5): ?>
                                  <option value="<?php echo $i; ?>">Discounted <?php echo $i; ?>%</option>
                              <?php endfor; ?>
                          </select>
                      </div>
                      <button type="submit" class="btn btn-primary w-100">Save</button>
                  </form>
            </div>
        </div>
    </div>

    <!-- Card 3 (Pet Supplies) -->
    <div class="col-md-4">
        <div class="card mb-4 mx-3">
            <div class="card-body">
                <h5 class="card-title mb-2" style="text-align: center; font-weight: bold;">Pet Supplies</h5> <!-- Updated title -->
                    <form id="PetProductsdiscountForm">
                      <div class="mb-3">
                          <select class="form-select form-control" id="percentage1" name="percentage1" required>
                              <option selected disabled>Choose Discount Percentage</option>
                              <option value="0">Discounted 0%</option>
                              <?php for ($i = 5; $i <= 90; $i += 5): ?>
                                  <option value="<?php echo $i; ?>">Discounted <?php echo $i; ?>%</option>
                              <?php endfor; ?>
                          </select>
                      </div>
                      <button type="submit" class="btn btn-primary w-100">Save</button>
                  </form>
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
        $('#MedicalProductdiscountForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                type: 'POST',
                url: 'save_percentage_medical_products.php', // The PHP script to handle the AJAX request
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    showToast('Discount updated successfully.','success');
                },
                error: function(xhr, status, error) {
                    showToast('Discount updating failed.','error');// Handle error
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#VeterinaryServicesdiscountForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                type: 'POST',
                url: 'save_percentage_veterinary_services.php', // The PHP script to handle the AJAX request
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    showToast('Discount updated successfully.','success');
                },
                error: function(xhr, status, error) {
                    showToast('Discount updating failed.','error');// Handle error
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#PetProductsdiscountForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                type: 'POST',
                url: 'save_percentage_pet_products.php', // The PHP script to handle the AJAX request
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    showToast('Discount updated successfully.','success');
                },
                error: function(xhr, status, error) {
                    showToast('Discount updating failed.','error');// Handle error
                }
            });
        });
    });
</script>

    <script>
    $(document).ready(function() {
        // Fetch users and populate the dropdown
        $.getJSON('get_users.php', function(data) {
            var $userSelect = $('#userSelect');
            $userSelect.empty().append('<option value="">Select a customer</option>');
            $.each(data, function(index, user) {
                $userSelect.append($('<option>').val(user.id).text(user.full_name));
            });
        });

        // Handle user selection change
        $('#userSelect').on('change', function() {
            var userId = $(this).val();
            if (userId) {
                // Fetch the user data again
                $.getJSON('get_users.php', function(data) {
                    var user = data.find(function(u) { return u.id == userId; });
                    if (user) {
                        $('#phoneNumber').val(user.phone_number);
                    } else {
                        $('#phoneNumber').val('');
                    }
                });
            } else {
                $('#phoneNumber').val('');
            }
        });

    });
    </script>
<script type="text/javascript">
      document.getElementById('smsForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const phoneNumber = document.getElementById('phoneNumber').value;
        const smsContent = document.getElementById('smsContent').value;

        fetch('send_sms.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'phoneNumber': phoneNumber,
                'smsContent': smsContent
            })
        })
        .then(response => response.text())
        .then(data => {
            console.log('Success:', data);
            showToast('SMS sent successfully.','success'); // Assuming you have a showToast function
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to send SMS.','error');
        });
    });

    document.getElementById('userSelect').addEventListener('change', function() {
        const phoneNumber = this.value;
        document.getElementById('phoneNumber').value = phoneNumber;
    });
</script>

</body>
</html>
