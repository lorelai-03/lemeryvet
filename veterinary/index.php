<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, password, stats, status FROM veterinarians WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $stats, $status);
        $stmt->fetch();

        // Check if the account is inactive
        if ($stats === 'inactive') {
            $error = "Your account is inactive. Please contact the administrator.";
        } elseif ($status === 'unverified') {
            // Check if the account is unverified
            $error = "Your account is unverified. Please wait for the administrator to update it.";
        } else {
            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Set session variables and redirect
                $_SESSION['id'] = $id; // Store the user ID in session
                $_SESSION['email'] = $email; // Optionally store email in session
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        }
    } else {
        $error = "Invalid email.";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Veterinary Clinic Management System | Log in</title>
  <link rel="icon" type="image/x-icon" href="dist/img/lemery.ico" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
  body, .hold-transition.login-page {
    background-color: transparent !important;
    background-image: url('assets/img/backg.jpg') !important;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100vh; /* Ensure it covers the entire viewport */
  }

  /* Position the login form to the right */
  .login-box {
    position: absolute; /* Allow precise positioning */
    top: 50%; /* Center vertically */
    right: 5%; /* Adjust distance from the right edge */
    transform: translateY(-50%); /* Center correction */
    width: 360px; /* Optional: Set a fixed width for the form */
    z-index: 2; /* Ensure form content is in front of the background */
  }

  /* Additional styling for form */
  .login-card-body {
    border-radius: 10px; /* Optional: Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: Add shadow for effect */
  }

  /* Styling for link and buttons */
  .login-logo a {
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
    .login-box {
      right: 2%; /* Adjust distance from the right edge */
      width: 300px; /* Reduce width */
    }
  }

  @media (max-width: 768px) { /* Small tablets and large phones */
    .login-box {
      right: 0; /* Center horizontally */
      left: 0; /* Center horizontally */
      margin: auto;
      width: 90%; /* Use most of the screen width */
    }
  }

  @media (max-width: 576px) { /* Small phones */
    .login-box {
      top: 30%; /* Adjust vertical position */
      transform: translateY(-30%); /* Recenter correction */
      width: 100%; /* Full width */
      padding: 0 10px; /* Add padding for smaller screens */
    }

    .login-card-body {
      padding: 20px; /* Reduce padding inside the card for smaller screens */
    }
  }
</style>

<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <div class="login-logo">
    <a href="../../index2.html" style="color: black"><b></b>CLINIC ADMIN</a>
  </div>

      <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <form action="index.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
                      <div class="row">
    <div class="col-8 d-flex align-items-center">
        <a href="vet_register.php" class="text-center">Register a new membership</a>
    </div>
    <div class="col-4">
        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
    </div>
</div>
          <!-- /.col -->
        </div>
      </form>

  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Bootstrap 4 -->
</body>
</html>
