<?php
session_start();

// Check if the user is logged in based on the session 'email'
$is_logged_in = isset($_SESSION['email']);

if ($is_logged_in) {
    // User is logged in; retrieve user information
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 'No ID set';

    // Database connection
    $pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');

    // Check if a search query is set
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

    // Prepare the SQL query with a WHERE clause for filtering
    $sql = "SELECT id, veterinary_name, veterinary_description, veterinary_price, veterinary_image 
            FROM veterinary_services 
            WHERE veterinary_id = :user_id";
    if ($searchQuery) {
        $sql .= " AND veterinary_name LIKE :searchQuery";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    if ($searchQuery) {
        $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
    }
    $stmt->execute();
} else {
    // Handle non-logged-in state
    // For example, you might want to redirect to a login page
    header("Location: index.php");
    exit();
}
?>

<?php
// Define source directory and destination directories
$sourceDir = 'uploads/veterinary_services'; 
$destDirs = [
    'user/uploads/veterinary_services', 
    'admin/uploads/veterinary_services'
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
  <title>Veterinary Clinic Management System | Veterinary View Services</title>
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
<div class="card mb-4 mx-3 mt-4" style="max-height: 700px; overflow-y: auto;">
    <div class="card-body">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold">View Veterinary Services</h4>
        </div>
        <br>

<!-- Search Form -->
<div class="container mb-4">
  <form method="GET" action="">
    <div class="input-group">
      <input type="text" class="form-control" name="search" placeholder="Search by veterinary services name" value="<?php echo htmlspecialchars($searchQuery); ?>">
      <div class="input-group-append">
        <button class="btn btn-warning" type="submit" style="color: #fff;">Search</button>
      </div>
    </div>
  </form>
</div>

<!-- Display Cards -->
<div class="container">
  <div class="row">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
      <div class="col-md-4 mb-4"> <!-- Each card takes 4 columns, making it 3 cards per row -->
        <div class="card" style="width: 100%; height: 29rem;">
          <img class="card-img-top" src="<?php echo htmlspecialchars($row['veterinary_image']); ?>" alt="Card image cap" style="object-fit: cover; height: 12rem;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title" style="text-align: center; margin-bottom: 10px; font-weight: bold;">
              <?php echo htmlspecialchars($row['veterinary_name']); ?>
            </h5>
            <p class="card-text" style="flex-grow: 1; text-align: justify; text-justify: inter-word; max-height: 100px; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;">
              <?php echo htmlspecialchars($row['veterinary_description']); ?>
            </p>
            <span class="price" style="font-weight: bold; text-align: center;">₱<?php echo number_format($row['veterinary_price'], 2); ?></span>
            <div class="d-flex justify-content-center mt-auto">
              <a href="#" class="btn btn-warning mx-1 edit-btn" data-id="<?php echo $row['id']; ?>"><i class='fa fa-edit'></i></a>
              <a href="#" class="btn btn-danger mx-1 delete-btn" data-id="<?php echo $row['id']; ?>"><i class='fa fa-trash'></i></a>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>




<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Veterinary Services</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form inside the modal -->
        <form id="editForm">
          <input type="hidden" id="editId">
          <div class="form-group">
            <label for="editVeterinaryName">Medical Name</label>
            <input type="text" class="form-control" id="editVeterinaryName">
          </div>
          <div class="form-group">
            <label for="editVeterinaryDescription">Medical Description</label>
            <textarea class="form-control" id="editVeterinaryDescription" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label for="editVeterinaryPrice">Medical Price</label>
            <input type="text" class="form-control" id="editVeterinaryPrice">
          </div>
          <div class="form-group">
            <label for="editVeterinaryImage">Medical Image</label>
            <img id="editVeterinaryImagePreview" src="" alt="Product Image" class="img-fluid mb-2">
            <input type="file" class="form-control" id="editVeterinaryImage" accept="image/*">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
      </div>
    </div>
  </div>
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
<script type="text/javascript">
  $(document).ready(function() {
    // When an edit button is clicked
    $('.edit-btn').on('click', function() {
      var id = $(this).data('id'); // Get the ID from the data-id attribute

      // Send an AJAX request to retrieve the product data
      $.ajax({
        url: 'get_vet_services.php', // The PHP file that will return the product data
        type: 'GET',
        data: { id: id },
        success: function(response) {
          // Parse the JSON response
          var data = JSON.parse(response);

          // Populate the modal fields
          $('#editId').val(data.id);
          $('#editVeterinaryName').val(data.veterinary_name);
          $('#editVeterinaryDescription').val(data.veterinary_description);
          $('#editVeterinaryPrice').val(data.veterinary_price);
          $('#editVeterinaryImagePreview').attr('src', data.veterinary_image);

          // Show the modal
          $('#editModal').modal('show');
        },
        error: function() {
          alert('Failed to fetch product data.');
        }
      });
    });

    // Handle form submission (Save changes)
    $('#saveChanges').on('click', function() {
      var formData = new FormData();
      formData.append('id', $('#editId').val());
      formData.append('veterinary_name', $('#editVeterinaryName').val());
      formData.append('veterinary_description', $('#editVeterinaryDescription').val());
      formData.append('veterinary_price', $('#editVeterinaryPrice').val());

      // Check if a new file has been selected
      var fileInput = $('#editVeterinaryImage')[0];
      if (fileInput.files.length > 0) {
        formData.append('veterinary_image', fileInput.files[0]);
      }

      // Send the data via AJAX to update the product
      $.ajax({
        url: 'update_veterinary_services.php', // The PHP file that will process the update
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          // Handle the response from the server
          if (response === 'success') {
            showToast('Veterinary services updated successfully!', 'success');
            // Redirect after a delay
            setTimeout(function() {
              window.location.href = 'veterinary_view_services.php'; // Modify this if you need to pass parameters
            }, 3000);
          } else {
            showToast('Failed to update product.', 'error');
          }
        },
        error: function() {
          showToast('An error occurred while updating the product.', 'error');
        }
      });
    });
  });
</script>


<script type="text/javascript">
  document.getElementById('editVeterinaryImage').addEventListener('change', function(event) {
  var file = event.target.files[0];
  if (file) {
    var reader = new FileReader();
    reader.onload = function(e) {
      // Set the preview image src attribute to the file data
      document.getElementById('editVeterinaryImagePreview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure you want to delete this veterinary services?',
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
                    fetch('delete_veterinary_services.php?id=' + encodeURIComponent(id))
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Veterinary services deleted successfully.','success');
                    // Delay redirection by 3 seconds
                    setTimeout(function() {
                        window.location.href = 'veterinary_view_services.php'; // Modify this if you need to pass parameters
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
</body>
</html>