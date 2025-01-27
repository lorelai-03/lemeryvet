<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Veterinary Clinic Management System | Veterinary Register</title>
  <link rel="icon" type="image/x-icon" href="dist/img/lemery.ico" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.14.1/Toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<style type="text/css">
  .hidden {
    display: none;
  }

  .broken-page {
    text-align: center;
    padding: 50px;
    font-size: 1.5em;
  }

  /* Remove default background color */
  body, .hold-transition.register-page {
    background-color: transparent !important;
    background-image: url('assets/img/backg.jpg') !important;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100vh; /* Ensure it covers the entire viewport */
  }

  /* Position the register form to the right */
  .register-page {
    position: absolute; /* Allow precise positioning */
    top: 50%; /* Center vertically */
    right: 5%; /* Adjust distance from the right edge */
    transform: translateY(-50%); /* Center correction */
    width: 360px; /* Optional: Set a fixed width for the form */
    z-index: 2; /* Ensure form content is in front of the background */
  }

  /* Additional styling for form */
  .register-card-body {
    border-radius: 10px; /* Optional: Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: Add shadow for effect */
  }

  /* Styling for link and buttons */
  .register-logo a {
    color: black;
    font-size: 1.5em;
  }

  a.text-center {
    color: #007bff;
    text-decoration: none;
  }

  a.text-center:hover {
    text-decoration: underline;
  }

  /* Media Queries for Responsiveness */
  @media (max-width: 992px) { /* Tablets and below */
    .register-page {
      right: 2%; /* Adjust distance from the right edge */
      width: 320px; /* Slightly smaller width */
    }
  }

  @media (max-width: 768px) { /* Small tablets and large phones */
    .register-page {
      right: 0; /* Center horizontally */
      left: 0; /* Center horizontally */
      margin: auto;
      width: 90%; /* Use most of the screen width */
    }
  }

  @media (max-width: 576px) { /* Small phones */
    .register-page {
      top: 30%; /* Adjust vertical position */
      transform: translateY(-30%); /* Recenter correction */
      width: 100%; /* Full width */
      padding: 0 10px; /* Add padding for smaller screens */
    }

    .register-card-body {
      padding: 20px; /* Reduce padding inside the card for smaller screens */
    }

    .register-logo a {
      font-size: 1.2em; /* Reduce font size for smaller screens */
    }
  }
</style>

</head>
<body class="hold-transition register-page">
<div class="register-box">

<div class="card">
  <div class="card-body register-card-body">
      <div class="register-logo">
    <a href="index2.html"><b>Email Verification</b></a>
  </div>
      <p class="login-box-msg">Owner Information</p>

      <form id="registerVet" enctype="multipart/form-data">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="fullname" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
         <select id="gender" name="gender" class="form-control" required>
                    <option value="" disabled selected>Choose gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-venus-mars"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input placeholder="Date of Birth" class="form-control" type="text" name="dob" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-calendar"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="clinic_name" placeholder="Clinic name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-clinic-medical"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="address" placeholder="Address">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map"></span>
            </div>
          </div>
        </div>
        <p class="login-box-msg">Attach Documents (PDF only)</p>
<div class="input-group mb-3">
    <input type="file" class="form-control" name="vet_license" id="fileInputVetLicense" style="display: none;">
    <input type="text" class="form-control" placeholder="Upload Veterinary License" id="filePlaceholderVetLicense">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-file-pdf"></span>
        </div>
    </div>
</div>

<div class="input-group mb-3">
    <input type="file" class="form-control" name="business_permit" id="fileInputBusinessPermit" style="display: none;">
    <input type="text" class="form-control" placeholder="Upload Business Permit" id="filePlaceholderBusinessPermit">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-file-pdf"></span>
        </div>
    </div>
</div>

        <p class="login-box-msg">Account Information</p>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="retype_password" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="index.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
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
    // Function to handle file input and placeholder interaction
    function setupFileInput(fileInputId, filePlaceholderId) {
        const fileInput = document.getElementById(fileInputId);
        const filePlaceholder = document.getElementById(filePlaceholderId);

        // Show file input when the placeholder is clicked
        filePlaceholder.addEventListener('click', function() {
            fileInput.click();
        });

        // Update file name when a file is selected
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                filePlaceholder.value = this.files[0].name;
            } else {
                filePlaceholder.value = 'No file selected';
            }
        });

        // Prevent manual input in the placeholder field
        filePlaceholder.addEventListener('input', function(event) {
            event.preventDefault(); // Prevent any input
            this.value = ''; // Clear the value
        });
    }

    // Initialize file input fields
    setupFileInput('fileInputVetLicense', 'filePlaceholderVetLicense');
    setupFileInput('fileInputBusinessPermit', 'filePlaceholderBusinessPermit');
</script>
<script>
$(document).ready(function() {
    $('#registerVet').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Create a FormData object from the form
        var formData = new FormData(this);

        $.ajax({
            url: 'register_vet.php', // Replace with your server script path
            type: 'POST',
            data: formData,
            contentType: false, // Let the browser set the content type
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            success: function(response) {
                // Handle the response from the server
                console.log('Success:', response);
                showToast('Registration successful!','success');
                                   setTimeout(function() {
                        window.location.href = 'vet_register.php'; // Modify this if you need to pass parameters
                    }, 3000);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error:', status, error);
                showToast('An error occurred. Please try again.','error');
            }
        });
    });
});
</script>
</body>
</html>
