<?php
session_start();

// Check if the user is logged in based on the session 'email'
$is_logged_in = isset($_SESSION['email']);

if ($is_logged_in) {
    // User is logged in; display user information
    $fullname = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'No name set';
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 'No ID set';

    // You can now use $fullname and $user_id in your HTML or further PHP logic
} else {
    // Handle non-logged-in state
    // For example, you might want to redirect to a login page
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Veterinary Clinic Management System | Home</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="dist/img/lemery.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
          <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
              <!-- Bootstrap JS -->
              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.14.1/Toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <style type="text/css">
        body{
            background-color: #343a40;
        }
        /* Custom navbar styles */
        .navbar {
            background-color: #28a745; /* Green background for e-commerce theme */
        }

        .navbar-brand {
            font-size: 1.5rem; /* Larger brand text */
            font-weight: 700; /* Bold brand text */
            color: #fff; /* White text color */
            text-shadow: 1px 1px 1px black
        }

        .navbar-nav .nav-link, .list-inline {
            color: #fff; /* White text color for nav links */
            font-weight: 500; /* Slightly bold nav links */
            text-shadow: 1px 1px 1px black
        }

        .navbar-nav .nav-link.active {
            color: #f8f9fa; /* Slightly lighter white for active link */
            font-weight: 700; /* Bold active link */
        }

        .navbar-nav .nav-link:hover {
            color: #e2e6ea; /* Light color on hover */
        }

        .button-container {
            display: flex;
            align-items: center;
        }

        .btn-custom {
            color: #fff; /* White text color for buttons */
            background-color: #343a40; /* Dark background for buttons */
            border: 1px solid #fff; /* White border for buttons */
            border-radius: 0; /* Square corners */
            margin-left: 0.5rem; /* Space between buttons */
            padding: 0.5rem 1rem; /* Padding for buttons */
        }

        .btn-custom:hover {
            color: #343a40; /* Dark text color on hover */
            background-color: #fff; /* White background on hover */
            border-color: #343a40; /* Dark border on hover */
        }

        .navbar-toggler-icon {
            background-image: url('data:image/svg+xml;charset=utf8,<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16"><path d="M2 3h12a1 1 0 0 1 0 2H2a1 1 0 0 1 0-2zm0 4h12a1 1 0 0 1 0 2H2a1 1 0 0 1 0-2zm0 4h12a1 1 0 0 1 0 2H2a1 1 0 0 1 0-2z"/></svg>');
        }

        .navbar-toggler {
            border: none; /* Remove border from toggler */
        }

        .hero-section {
            background: url('assets/img/hero-bg.jpg') no-repeat center center; /* Background image */
            background-size: cover;
            color: #fff;
            text-align: center;
            padding: 5rem 0;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 900;
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .hero-section .btn-primary {
            background-color: #ff5722;
            border: none;
        }

        .hero-section .btn-primary:hover {
            background-color: #e64a19;
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 15rem;
            object-fit: cover;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
        }

        .footer a {
            color: #fff;
        }

        .footer a:hover {
            text-decoration: underline;
        }
        h2 {
  font-size: 2rem;
}

.card {
  border-radius: 15px;
  padding: 20px;
}

.bs-icon-md {
  width: 50px;
  height: 50px;
  font-size: 1.5rem;
}

input, textarea {
  padding: 10px 15px;
  font-size: 1rem;
}

input::placeholder, textarea::placeholder {
  color: #adb5bd;
}

button {
  font-weight: bold;
  transition: all 0.3s;
}

button:hover {
  background-color: #0069d9;
}

.text-muted {
  font-size: 0.9rem;
}
/* Sticky Navbar */
.navbar.sticky {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 999;
    background-color: #28a745; /* Navbar background color when sticky */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional shadow for sticky effect */
    transition: background-color 0.3s, padding 0.3s;
}

.navbar.sticky .navbar-brand,
.navbar.sticky .nav-link {
    color: #fff; /* Adjust text color when navbar is sticky */
}

    </style>
<nav class="navbar navbar-expand-md navbar-light bg-warning">
    <div class="container">
<a class="navbar-brand d-flex align-items-center" href="home.php">
    <!-- Icon -->
    <span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon"></span>
    <!-- Brand Text -->
    <span class="d-none d-sm-inline">Veterinary Clinic Management System</span>
</a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-3">
            <span class="visually-hidden">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navcol-3" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" id="medical-products-link" href="#">Medical Products</a></li>
                        <li><a class="dropdown-item" id="veterinary-services-link" href="#veterinary">Veterinary Services</a></li>
                        <li><a class="dropdown-item" id="pet-supplies-link" href="#pet">Pet Supplies</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="system_spatial_data.php">Map</a></li>
            </ul>
            <div class="button-container">
                <?php if (!$is_logged_in): ?>
                    <a href="index.php" class="btn btn-custom" type="button">Login</a>
                    <a href="user_register.php" class="btn btn-custom" type="button">Register</a>
                <?php else: ?>
                    <a href="my_account.php" class="btn btn-custom" type="button">My Account</a>
                    <a href="logout.php" class="btn btn-custom" type="button">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

        <!-- Header-->
<?php
// Database connection
$connection = new mysqli('localhost', 'u104053626_lemeryvetcare', 'Lemeryvet4209*', 'u104053626_lemeryvetcare');

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch all veterinarians' records
$query = "SELECT id, fullname, address, clinic_name, vet_image, stats FROM veterinarians";
$result = $connection->query($query);
?>

<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="bg-dark border rounded border-0 border-dark overflow-hidden">
            <div class="row g-0">

                <h2 style="font-weight: 1000; font-size: 40px; text-align: center; color: #FFC107; text-shadow: 1px 1px 1px black">Lemery Veterinary Clinic</h2>
                <hr style="border: 0; height: 5px; background-color: #FFC107;">

                <div class="col-md-12">
                    <div class="text-white p-4 p-md-5">
                        <div class="row">
                            <?php 
                            $counter = 0;
                            while ($row = $result->fetch_assoc()) { 
                                // Start a new row every 3 cards
                                if ($counter % 3 == 0 && $counter != 0) {
                                    echo '</div><div class="row">';
                                }
                            ?>
                                <div class="col-md-4 mb-4">
                                    <!-- Clickable Card Box -->
                                    <a href="services.php?id=<?php echo $row['id']; ?>&clinic_name=<?php echo urlencode($row['clinic_name']); ?>" class="text-decoration-none">
                                        <div class="card bg-light text-center" style="width: 18rem; height: 25rem;">
                                            <!-- Vet Image on top -->
                                            <img src="<?php echo htmlspecialchars($row['vet_image']); ?>" class="img-fluid rounded-top" alt="Vet Image" style="height: 50%; object-fit: cover;">
                                            
                                            <div class="card-body text-dark">
                                                <!-- Clinic Name -->
                                                <h5 class="card-title" style="font-weight: bold;"><?php echo htmlspecialchars($row['clinic_name']); ?></h5>

                                                <!-- Full Name -->
                                                <p class="card-text" style="font-size: 14px;"><?php echo htmlspecialchars($row['fullname']); ?></p>

                                                 <p class="card-text" style="font-size: 14px;"><?php echo htmlspecialchars($row['address']); ?></p>

                                                <!-- Status Badge -->
                                                <?php if ($row['stats'] == 'active') { ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php } else { ?>
                                                    <span class="badge bg-danger">Inactive</span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php 
                                $counter++;
                            } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<?php
$connection->close();


?>


<section class="position-relative py-4 py-xl-5" id="contact">
  <div class="container position-relative">
    <div class="card shadow-sm border-0 bg-dark">
      <div class="row mb-5">
        <div class="col-md-8 col-xl-6 text-center mx-auto">
          <h2 class="fw-bold" style="font-weight: 1000; font-size: 40px; text-align: center; color: #FFC107; text-shadow: 1px 1px 1px black">Contact Us</h2>
          <p class="d w-lg-50 mx-auto" style="color: #fff">Feel free to reach out. We’re here to assist you with your needs.</p>
          <hr style="color: #fff">
        </div>
      </div>
      <div class="row d-flex justify-content-center" style="margin-top: -50px;">
        <div class="col-md-6 col-lg-4 col-xl-4">
          <div class="d-flex flex-column justify-content-center align-items-start h-100">
            <!-- Contact Info Items -->
            <div class="d-flex align-items-center p-3 border-bottom">
              <div class="bs-icon-md bs-icon-rounded bs-icon-primary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bg-warning">
                <!-- Phone Icon -->
                <i class="bi bi-telephone-fill"></i>
              </div>
              <div class="px-3" style="color: #fff">
                <h6 class="mb-0 fw-semibold">Phone</h6>
                <p class="mb-0 ">+123456789</p>
              </div>
            </div>
            <div class="d-flex align-items-center p-3 border-bottom">
              <div class="bs-icon-md bs-icon-rounded bs-icon-primary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bg-warning">
                <!-- Email Icon -->
                <i class="bi bi-envelope-fill"></i>
              </div>
              <div class="px-3" style="color: #fff">
                <h6 class="mb-0 fw-semibold">Email</h6>
                <p class="mb-0 ">info@example.com</p>
              </div>
            </div>
            <div class="d-flex align-items-center p-3">
              <div class="bs-icon-md bs-icon-rounded bs-icon-primary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bg-warning">
                <!-- Location Icon -->
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <div class="px-3" style="color: #fff">
                <h6 class="mb-0 fw-semibold">Location</h6>
                <p class="mb-0 ">Lemery, Batangas</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Contact Form -->
        <div class="col-md-6 col-lg-5 col-xl-4">
          <div>
            <form id="contact-form" class="p-3 p-xl-4" method="post">
                <div class="mb-3">
                    <input id="name-1" class="form-control rounded-pill border-grey" type="text" name="name" placeholder="Name" required />
                </div>
                <div class="mb-3">
                    <input id="email-1" class="form-control rounded-pill border-grey" type="email" name="email" placeholder="Email" required />
                </div>
                <div class="mb-3">
                    <textarea id="message-1" class="form-control border-grey rounded" name="message" rows="6" placeholder="Message" required></textarea>
                </div>
                <div>
                    <button class="btn btn-warning d-block w-100 rounded-pill" type="submit">Send Message</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

        <!-- Footer-->
<footer class="text-center bg-dark">
    <div class="container text-white py-4 py-lg-5">
        <ul class="list-inline">
            <li class="list-inline-item me-4"><a class="link-light" href="#" style="text-decoration: none;">Home</a></li>
            <li class="list-inline-item me-4"><a class="link-light" href="#" style="text-decoration: none;">Categories</a></li>
            <li class="list-inline-item"><a class="link-light" href="#contact" style="text-decoration: none;">Contact</a></li>
        </ul>
        <ul class="list-inline">
            <li class="list-inline-item me-4"><svg class="bi bi-facebook text-light" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>
                </svg></li>
            <li class="list-inline-item me-4"><svg class="bi bi-twitter text-light" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path>
                </svg></li>
            <li class="list-inline-item"><svg class="bi bi-instagram text-light" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                </svg></li>
        </ul>
        <p class="mb-0" style="color: #ffc107">Copyright © 2024 Veterinary Clinic Management System</p>
    </div>
</footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
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
    document.getElementById('contact-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(this);

        fetch('send_mail.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log('Success:', data);
            showToast('Message has been sent successfully.', 'success');
            setTimeout(function() {
                window.location.href = 'home.php'; // Redirect to the desired page
            }, 3000);
        })
        .catch(error => {
            console.log('AJAX Error:', error);
            showToast('An error occurred. Please try again.', 'error');
        });
    });
});
</script>

<script>
$(document).ready(function() {
  $('.appointment-btn').on('click', function() {
    // Get the veterinary_id from the button's data attribute
    var veterinaryId = $(this).data('veterinary-id');
    var medicalName = $(this).data('medical-name');

    // Set the veterinary_id in the input field
    $('#veterinaryId').val(veterinaryId);
    $('#medicalName').val(medicalName);

    // Show the appointment modal
    $('#appointmentModal').modal('show');
  });
});
</script>
<script type="text/javascript">
    // Form submission handling
$('#schedule-form').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: 'save_schedule.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            // Close the modal
            $('#appointmentModal').modal('hide');
            
            console.log('Success:', response);
                showToast('Schedule Successfully Saved.','success');
                                   setTimeout(function() {
                        window.location.href = 'my_account.php'; // Modify this if you need to pass parameters
                    }, 3000);
            },
        error: function() {
            // Close the modal
            $('#appointmentModal').modal('hide');

            showToast('An Error Occurred: There was a problem with the request.'); // Show error message
        }
    });
});

</script>
<script type="text/javascript">
    window.addEventListener('scroll', function() {
    var navbar = document.querySelector('.navbar');
    var stickyClass = 'sticky';

    if (window.scrollY > 50) { // Add sticky class after scrolling 50px
        navbar.classList.add(stickyClass);
    } else {
        navbar.classList.remove(stickyClass);
    }
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const medicalProductsLink = document.getElementById('medical-products-link');

    medicalProductsLink.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action

        Swal.fire({
            title: 'Information',
            text: 'Please select a veterinary clinic from the list to view the medical products.',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Veterinary Services link
    const veterinaryServicesLink = document.getElementById('veterinary-services-link');
    veterinaryServicesLink.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action

        Swal.fire({
            title: 'Information',
            text: 'Please select a veterinary clinic from the list to view the veterinary services.',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    });

    // Pet Supplies link
    const petSuppliesLink = document.getElementById('pet-supplies-link');
    petSuppliesLink.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action

        Swal.fire({
            title: 'Information',
            text: 'Please select a veterinary clinic from the list to view the pet supplies.',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    });
});
</script>

    </body>
</html>
