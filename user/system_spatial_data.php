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
        $sql = "SELECT id, title, description, start_datetime, end_datetime, veterinaryId, medicalName, full_name 
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
        <title>Veterinary Clinic Management System | Map</title>
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
        #map {
            height: 600px;
            width: 100%;
        }

        .controls {
            position: absolute;
            top: 10px;
            left: 30px;
            z-index: 1000;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .search-controls{
            position: absolute;
            top: 10px;
            left: 30px;
            z-index: 1000;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .spatial-form {
            width: 225px;
            margin-bottom: 10px;
        }
        #imagePreview {
            max-width: 100%;
            height: auto;
        }
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
    <h1 class="heading-left">Veterinary Clinic Spatial Data</h1>
</div>

<div class="container mt-5">
     <div class="card mb-4 mx-3 mt-4">
    <div class="card-body p-0">
        <div class="search-controls" style="margin-top: 200px;">
            <div class="input-group">
                <input type="text" id="plantation-sites" class="form-control" placeholder="Find Veterinary Clinic" style="font-size: 14px; color: black;">
                <span class="input-group-text">
                    <i id="searchBtn" class="fa fa-search"></i>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4 mx-3 mt-4">
    <div class="card-body">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold"></h4>
               </div>
        <div class="controls" style="margin-top: 240px;">
            <div class="form-group">
                <label for="start" style="font-size: 14px; color: black;">Start Location:</label>
                <input type="text" id="start" class="form-control spatial-form" placeholder="Find address or place"style="font-size: 14px; color: black;">
            </div>
            <div class="form-group">
                <label for="end" style="font-size: 14px; color: black;">End Location:</label>
                <input type="text" id="end" class="form-control spatial-form" placeholder="Find address or place" style="font-size: 14px; color: black;">
            </div>
            <button id="routeBtn" class="btn btn-light"><i class="fa fa-location-arrow"></i></button>
            <button id="markLocationBtn" class="btn btn-light "><i class="fa fa-map-marker"></i></button>
            <button class="btn btn-light" onclick="location.reload();"><i class="fa fa-refresh"></i> </button>
        </div>
        <div id="map"></div>
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

// Initialize the map
var map = L.map('map').setView([13.9532, 120.8843], 12); // Default view coordinates

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var markers = []; // Store markers to use in search

// Fetch locations from the server
fetch('fetch_locations.php')
    .then(response => response.json())
    .then(locations => {
        locations.forEach(function(location) {
            var marker = L.marker([location.lat, location.lng]).addTo(map)
                .bindPopup(`
                    <div style="text-align: center;">
                        <img src="${location.imgSrc}" alt="${location.title}" style="width: 100%; height: auto; max-width: 300px;">
                        <h4 style="margin: 10px 0;">${location.title}</h4>
                        <p style="text-align: justify; margin: 0 10px;">${location.description}</p>
                    </div>
                `);

            marker.on('click', function() {
                var endLatLng = marker.getLatLng();
                document.getElementById('end').value = `Lat: ${endLatLng.lat.toFixed(6)}, Lng: ${endLatLng.lng.toFixed(6)}`;

                if (startLatLng) {
                    control.setWaypoints([
                        L.latLng(startLatLng.lat, startLatLng.lng),
                        L.latLng(endLatLng.lat, endLatLng.lng)
                    ]);
                }
            });

            markers.push({
                title: location.title.toLowerCase(),
                marker: marker
            });
        });
    })
    .catch(error => {
        console.error('Error fetching locations:', error);
        showToast('Failed to load locations.', 'error');
    });

// Initialize routing control
var control = L.Routing.control({
    waypoints: [],
    routeWhileDragging: true
}).addTo(map);

var geocoder = L.Control.Geocoder.nominatim();
var startLatLng; 

document.getElementById('routeBtn').addEventListener('click', function() {
    var startLocation = document.getElementById('start').value.trim();
    var endLocation = document.getElementById('end').value.trim();

    if (startLocation && endLocation) {
        geocoder.geocode(startLocation, function(results) {
            if (results.length === 0) {
                if (startLocation.length > 0) {
                    showToast('Start location not found.','error');
                }
                return;
            }
            startLatLng = results[0].center; 

            geocoder.geocode(endLocation, function(results) {
                if (results.length === 0) {
                    showToast('End location not found.','error');
                    return;
                }
                var endLatLng = results[0].center;

                control.setWaypoints([
                    L.latLng(startLatLng.lat, startLatLng.lng),
                    L.latLng(endLatLng.lat, endLatLng.lng)
                ]);
            });
        });
    } else {
        showToast('Please enter both start and end locations.' , 'error');
    }
});

function searchLocation() {
    var searchValue = document.getElementById('plantation-sites').value.trim().toLowerCase();

    var foundLocation = markers.find(function(location) {
        return location.title === searchValue;
    });

    if (foundLocation) {
        var marker = foundLocation.marker;

        map.setView(marker.getLatLng(), 15);
        marker.openPopup();
    } else {
        showToast('Veterinary Clinic not found.','error');
    }
}

document.getElementById('searchBtn').addEventListener('click', function() {
    searchLocation();
});

document.getElementById('plantation-sites').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchLocation();
    }
});

L.control.locate({
    position: 'topleft',
    drawCircle: true,
    follow: true,
    setView: true,
    metric: false,
    icon: 'fa fa-map-marker',
    strings: {
        title: "Show me where I am"
    }
}).addTo(map);

document.getElementById('markLocationBtn').addEventListener('click', function() {
    map.locate({ setView: true, maxZoom: 16 });
});

map.on('locationfound', function(e) {
    var marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map)
        .bindPopup('You are here!')
        .openPopup();
    
    document.getElementById('start').value = `Lat: ${e.latlng.lat.toFixed(6)}, Lng: ${e.latlng.lng.toFixed(6)}`;
    startLatLng = e.latlng; 
});

map.on('locationerror', function() {
    showToast('Unable to locate your position.','error');
});

map.on('click', function(e) {
    if (startLatLng) {
        var clickedLatLng = e.latlng;
        control.setWaypoints([
            L.latLng(startLatLng.lat, startLatLng.lng),
            L.latLng(clickedLatLng.lat, clickedLatLng.lng)
        ]);
        document.getElementById('end').value = `Lat: ${clickedLatLng.lat.toFixed(6)}, Lng: ${clickedLatLng.lng.toFixed(6)}`;
    } else {
        showToast('Please set a start location first.', 'error');
    }
});

</script>
    </body>
</html>
