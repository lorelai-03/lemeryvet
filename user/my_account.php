<?php
session_start();

// Check if the user is logged in based on the session 'email'
$is_logged_in = isset($_SESSION['email']);

if ($is_logged_in) {
    // Retrieve user information from the session
    $fullname = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : '';
    
    // Database connection parameters
    $host = 'localhost'; // Change to your database host
    $dbname = 'u104053626_lemeryvetcare'; // Change to your database name
    $username = 'u104053626_lemeryvetcare'; // Change to your database username
    $password = 'Lemeryvet4209*'; // Change to your database password

    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Set error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL query with a condition for matching full_name
        $sql = "SELECT id, title, description, start_datetime, end_datetime, veterinaryId, medicalName, full_name, pet_name 
                FROM schedule_list 
                WHERE full_name = :fullname";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->execute();

        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}


// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=u104053626_lemeryvetcare', 'u104053626_lemeryvetcare', 'Lemeryvet4209*');

// Ensure user ID is set in session
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if (!$user_id) {
    echo "No ID set. Please log in.";
    exit;
}

// Fetch user details from the database
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}

// Gender handling (assuming gender is stored as 'Male' or 'Female')
$sex = $user['gender'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Veterinary Clinic Management System | My Account</title>
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
        <!-- SweetAlert CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style type="text/css">
        body{
            background-color: #F0F0F0;
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
        .full-width-container {
            background-color: #212529; /* Dark background color */
            padding: 20px; /* Add padding for better appearance */
            width: 100%; /* Full width */
            box-sizing: border-box; /* Include padding in width calculation */
            height: 200px; /* Fixed height */
            display: flex; /* Enable flexbox layout */
            align-items: center; /* Center items vertically */
            padding-left: 50px; /* Add left padding to container */

        }
        .heading-left {
            font-weight: 1000; /* Extra bold font weight */
            color: #ffffff; /* White text color for better contrast */
            margin-left: 50px; /* Remove default margin */
            font-size: 50px;
        }
                .card-box {
            margin-top: 20px;
        }
        .table-container {
            padding: 20px;
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
    <style type="text/css">

.image-group {
    position: relative;
    display: inline-block;
}

#user-img {
    display: block;
    width: 40%; /* Adjust if needed */
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
                <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="home.php">Medical Products</a></li>
                        <li><a class="dropdown-item" href="home.php">Veterinary Services</a></li>
                        <li><a class="dropdown-item" href="home.php">Pet Products</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="home.php">Contact</a></li>
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

<div class="full-width-container">
    <h1 class="heading-left">My Account</h1>
</div>

<div class="container mt-5">
    <div class="card card-box">
        <div class="card-header">
            <h4 class="mb-0 fw-bold">Update Account Information</h4>
        </div>
        <div class="card-body">
            <form id="userUpdateAcc" enctype="multipart/form-data">
                <div class="form-group mb-2">
                    <label for="email" class="fw-bold">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                </div>

                <div class="form-group mb-2">
                    <label for="full_name" class="fw-bold">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                </div>

                <div class="form-group mb-2">
                    <label for="address" class="fw-bold">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                </div>

                <div class="form-group mb-2">
                    <label for="gender" class="fw-bold">Gender</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="" disabled selected>Choose gender</option>
                        <option value="Male" <?php if ($sex === 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($sex === 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="phone_number" class="fw-bold">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" readonly>
                </div>

                <div class="form-group mb-2">
                    <label for="password" class="fw-bold">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter current password" >
                </div>

                <div class="form-group mb-2">
                    <label for="new_password" class="fw-bold">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New password" >
                </div>

                <div class="form-group mb-2">
                    <label for="confirm_password" class="fw-bold">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" >
                </div>

<div class="form-group mb-2">
    <div class="form-group position-relative">
        <?php
        // Set the image source based on whether the user_image is set
        $userImage = !empty($user['user_image']) ? htmlspecialchars($user['user_image']) : 'https://www.w3schools.com/w3images/avatar5.png';
        ?>
        <img id="user-img" src="<?php echo $userImage; ?>" alt="User Picture" class="img-fluid">
        <input type="file" name="user_image" id="user-upload" accept="image/*" style="display: none;">
        <label for="user-upload" class="btn btn-primary position-absolute start-50 translate-middle-x" style="margin-top: -50px">Choose Clinic Picture</label>
    </div>
</div>


                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>



    <div class="container mt-5">
        <div class="card card-box">
            <div class="card-header">
                <h4 class="mb-0 fw-bold">Appointment Scheduled</h4>
            </div>
            <div class="card-body table-container">
                <?php if (!empty($results)): ?>
                     <div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Filter Search">
</div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Scheduled Appointment Name</th>
                                    <th>Full Name</th>
                                    <th>Pet Name</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Start Datetime</th>
                                    <th>End Datetime</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['medicalName']); ?></td>
                                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['pet_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['start_datetime']); ?></td>
                                        <td><?php echo htmlspecialchars($row['end_datetime']); ?></td>
                                        <td style="display: none;"><?php echo htmlspecialchars($row['veterinaryId']); ?></td>
                                        <td>
                                            <!-- Cancel button with correct data-id attribute -->
                                            <button class="btn btn-danger cancel-btn" data-id="<?php echo htmlspecialchars($row['id']); ?>">Cancel</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center" role="alert">
                        No appointments found for <?php echo htmlspecialchars($fullname); ?>.
                    </div>
                <?php endif; ?>
            </div>
        </div>

<br>
<?php
// Check if the user is logged in
$is_logged_in = isset($_SESSION['email']);

if ($is_logged_in) {
    // Retrieve user information from the session
    $fullname = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : '';
    // Database connection parameters
    $host = 'localhost'; 
    $dbname = 'u104053626_lemeryvetcare'; 
    $username = 'u104053626_lemeryvetcare'; 
    $password = 'Lemeryvet4209*'; 

    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Set error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL query with a condition for matching patient_name
        $sql = "SELECT * FROM canceled_appointments WHERE patient_name = :fullname";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->execute();

        // Fetch all results
        $canceledAppointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}
?>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 fw-bold">Canceled Appointments</h4>
            </div>
            <div class="card-body">
                                     <div class="mb-3">
    <input type="text" id="searchInputs" class="form-control" placeholder="Filter Search">
</div>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-bordered table-striped" id="dataTables">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Original Appointment ID</th>
                                <th>Patient Name</th>
                                <th>Appointment Date</th>
                                <th>Reason</th>
                                <th>Canceled At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($canceledAppointments)): ?>
                                <?php foreach ($canceledAppointments as $appointment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['original_appointment_id']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['reason']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['canceled_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="alert alert-info text-center" role="alert">
                                            No canceled appointments found for <?php echo htmlspecialchars($fullname); ?>.
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<br>
        <!-- Footer-->
<footer class="text-center bg-dark">
    <div class="container text-white py-4 py-lg-5">
        <ul class="list-inline">
            <li class="list-inline-item me-4"><a class="link-light" href="home.php" style="text-decoration: none;">Home</a></li>
            <li class="list-inline-item me-4"><a class="link-light" href="home.php" style="text-decoration: none;">Categories</a></li>
            <li class="list-inline-item"><a class="link-light" href="home.php" style="text-decoration: none;">Contact</a></li>
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
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
        <!-- jQuery for Handling Click and Showing the Appointment Modal -->
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
    $('#userUpdateAcc').on('submit', function(e) {
        e.preventDefault(); // Prevent form from submitting the normal way
        
        // Create a FormData object to hold form data including files
        var formData = new FormData(this);
        
        $.ajax({
            url: 'update_user.php', // Change to your server-side update script
            type: 'POST',
            data: formData,
            contentType: false, // Needed for FormData
            processData: false, // Needed for FormData
            success: function(response) {
                console.log('Success:', response);
                showToast('User information updated successfully.','success');
                                   setTimeout(function() {
                        window.location.href = 'my_account.php'; // Modify this if you need to pass parameters
                    }, 3000);
            },            
            error: function(xhr, status, error) {
                // Handle any errors
                console.log('AJAX Error: ' + status + error);
            }
        });
    });
});

    </script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cancel-btn').forEach(button => {
        button.addEventListener('click', function () {
            const appointmentId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('cancel_appointment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'appointment_id': appointmentId
                        })
                    })
                    .then(response => response.text())
                    .then(data => {
                        showToast('Appointment canceled successfully.', 'success');
                        setTimeout(function() {
                            window.location.href = 'my_account.php'; // Redirect to the my_account page
                        }, 3000);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Failed to cancel the appointment.', 'error');
                    });
                }
            });
        });
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
    document.getElementById('user-upload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('user-img').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
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
    <script>
    document.getElementById('searchInputs').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll('#dataTables tbody tr');
        
        rows.forEach(function(row) {
            let rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(input) ? '' : 'none';
        });
    });
</script>
    </body>
</html>
