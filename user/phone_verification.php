<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Phone Verification</title>
  <link rel="icon" type="image/x-icon" href="dist/img/lemery.ico" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.14.1/Toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index2.html"><b>Phone Verification</b></a>
  </div>

<div class="card">
  <div class="card-body register-card-body">
    <p class="login-box-msg">Enter the OTP sent to your phone</p>

    <form id="phoneOtpForm">
      <div class="input-group mb-3">
        <input type="number" class="form-control" placeholder="Enter OTP" id="phoneOtp" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-key"></span>
          </div>
        </div>
      </div>
      
      <div class="d-flex justify-content-between mb-3">
        <a href="user_login.php" class="text-center">Back to Login</a>
        <button type="submit" class="btn btn-primary">Verify OTP</button>
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
<!-- Custom JS for phone OTP verification -->
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
  $('#phoneOtpForm').on('submit', function(e) {
    e.preventDefault();
    var phoneOtp = $('#phoneOtp').val();

    $.ajax({
      url: 'verify_phone_otp.php',
      type: 'POST',
      data: { phoneOtp: phoneOtp },
      dataType: 'json', // Ensure the response is treated as JSON
      success: function(response) {
        console.log('Success:', response);

        if (response.success) {
          showToast(response.message, 'success');
          setTimeout(function() {
            window.location.href = 'index.php'; // Redirect on success
          }, 3000);
        } else {
          showToast(response.message, 'error'); // Show error message if OTP is invalid
        }
      },
      error: function() {
        showToast('An error occurred.', 'error'); // Show error message on AJAX failure
      }
    });
  });
});
</script>

</body>
</html>
