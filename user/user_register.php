<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Veterinary Clinic Management System | User Register</title>
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
</head>
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


<body class="hold-transition register-page">
<div class="register-box">

  <div class="card">
    <div class="card-body register-card-body">
        <div class="register-logo">
    <a href="index2.html"><b>Register Account</b></a>
  </div>

      <form id="registrationForm">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name" id="fullName" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Address" id="address" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input placeholder="Date of Birth" class="form-control" type="text" name="dob" onfocus="(this.type='date')" onblur="(this.type='text')" id="dob" required />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-calendar"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <select id="gender" class="form-control" required>
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
          <input type="number" class="form-control" placeholder="Phone number" id="phoneNumber" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
        <p class="login-box-msg">Account Information</p>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" id="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" id="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" id="retypePassword" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
      <div class="d-flex justify-content-between mb-3">
        <a href="index.php" class="text-center">I already have a membership</a>
        <button type="submit" class="btn btn-primary">Register</button>
      </div>
    </form>
  </div>
</div>

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
<!-- Custom JS for form submission -->
<script>
$(document).ready(function() {
  $('#registrationForm').on('submit', function(e) {
    e.preventDefault();
    
    var formData = {
      fullName: $('#fullName').val(),
      email: $('#email').val(),
      password: $('#password').val(),
      retypePassword: $('#retypePassword').val(),
      address: $('#address').val(),
      dob: $('#dob').val(),
      gender: $('#gender').val(),
      phoneNumber: $('#phoneNumber').val()
    };

    $.ajax({
      url: 'register.php',
      type: 'POST',
      data: formData,
      dataType: 'json', // Expect JSON response
      success: function(response) {
        console.log('Success:', response);

        if (response.success) {
          showToast('Registration successful. Please check your email for the OTP.', 'success');
          setTimeout(function() {
            window.location.href = 'email_verification.php'; // Redirect on success
          }, 3000);
        } else {
          showToast(response.message || 'Registration failed. Please try again.', 'error'); // Show error message if registration fails
        }
      },
      error: function(xhr, status, error) {
        console.log('AJAX Error:', status, error);
        showToast('Phone number already registered.', 'error'); // Show error message on AJAX failure
      }
    });
  });
});
</script>



</body>
</html>
