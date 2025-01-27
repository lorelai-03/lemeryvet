<?php
// Start the session
session_start();

// Include your database connection
include('config.php');

// Check if the user is logged in
$is_logged_in = isset($_SESSION['email']);

if ($is_logged_in) {
    // Get the current user's ID from the session
    $user_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : null;

    if (!$user_id) {
        echo "User ID is not set.";
        exit();
    }

    // Get the selected percentage from the form
    $discount_percentage = isset($_POST['percentage2']) ? intval($_POST['percentage2']) : 0;

    // Fetch services that belong to the logged-in user (based on veterinary_id)
    $query = "SELECT id, veterinary_price, original_price FROM veterinary_services WHERE veterinary_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Loop through all the records and apply the discount or reset the prices
        while ($row = $result->fetch_assoc()) {
            $service_id = $row['id'];
            $original_price = $row['veterinary_price'];

            // Check if the original_price column is empty and set it if needed
            if (empty($row['original_price'])) {
                $update_original_query = "UPDATE veterinary_services SET original_price = ? WHERE id = ?";
                $update_original_stmt = $conn->prepare($update_original_query);
                $update_original_stmt->bind_param("di", $original_price, $service_id);
                $update_original_stmt->execute();
            }

            if ($discount_percentage > 0) {
                // Calculate the discounted price
                $discounted_price = $original_price - ($original_price * ($discount_percentage / 100));

                // Update the veterinary_price column with the new discounted price for each service
                $update_query = "UPDATE veterinary_services SET veterinary_price = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("di", $discounted_price, $service_id);
                $update_stmt->execute();
            } else {
                // Reset to original price
                $update_query = "UPDATE veterinary_services SET veterinary_price = original_price WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("i", $service_id);
                $update_stmt->execute();
            }
        }

        // Insert the selected discount percentage into veterinary_services_percentage table
        if ($discount_percentage >= 0) {
            $insert_percentage_query = "INSERT INTO veterinary_services_percentage (veterinary_id, percentage) VALUES (?, ?)";
            $insert_percentage_stmt = $conn->prepare($insert_percentage_query);
            $insert_percentage_stmt->bind_param("ii", $user_id, $discount_percentage);
            $insert_percentage_stmt->execute();
            $insert_percentage_stmt->close();
        }

        echo "Prices updated successfully and discount percentage saved!";
    } else {
        echo "No services found for this veterinary clinic.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "You are not logged in.";
    exit();
}
?>
