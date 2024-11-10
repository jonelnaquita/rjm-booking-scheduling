<?php
session_start();
include '../../../models/conn.php';  // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $departure_schedule_id = $_POST['departure_schedule_id'];
    $arrival_schedule_id = $_POST['arrival_schedule_id'];
    $departure_seats = $_POST['departure_seats']; // Get departure seats
    $arrival_seats = $_POST['arrival_seats'];     // Get arrival seats

    // Start transaction
    $conn->begin_transaction();

    try {
        // SQL query to update the booking
        $sql = "UPDATE tblbooking 
                SET scheduleDeparture_id = ?, 
                    scheduleArrival_id = ? 
                WHERE book_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            // If arrival_schedule_id is empty or not set, use 0
            $arrival_schedule_id = $arrival_schedule_id ?: 0;

            // Bind the parameters
            $stmt->bind_param("iii", $departure_schedule_id, $arrival_schedule_id, $booking_id);

            // Execute the query
            if (!$stmt->execute()) {
                throw new Exception("Failed to update booking.");
            }

            // Delete existing seats for the passenger
            $delete_sql = "DELETE FROM tblseats WHERE passenger_id = (SELECT passenger_id FROM tblbooking WHERE book_id = ?)";
            if ($delete_stmt = $conn->prepare($delete_sql)) {
                $delete_stmt->bind_param("i", $booking_id);
                if (!$delete_stmt->execute()) {
                    throw new Exception("Failed to delete existing seats.");
                }
                $delete_stmt->close();
            }

            // Insert new departure seats
            if (!empty($departure_seats)) {
                $departure_seat_array = explode(',', $departure_seats); // Convert to array
                foreach ($departure_seat_array as $seat_number) {
                    $insert_sql = "INSERT INTO tblseats (passenger_id, schedule_id, seat_number) VALUES ((SELECT passenger_id FROM tblbooking WHERE book_id = ?), ?, ?)";
                    if ($insert_stmt = $conn->prepare($insert_sql)) {
                        $insert_stmt->bind_param("iii", $booking_id, $departure_schedule_id, $seat_number);
                        if (!$insert_stmt->execute()) {
                            throw new Exception("Failed to insert departure seat number.");
                        }
                        $insert_stmt->close();
                    }
                }
            }

            // Insert new arrival seats if they exist
            if (!empty($arrival_seats)) {
                $arrival_seat_array = explode(',', $arrival_seats); // Convert to array
                foreach ($arrival_seat_array as $seat_number) {
                    $insert_sql = "INSERT INTO tblseats (passenger_id, schedule_id, seat_number) VALUES ((SELECT passenger_id FROM tblbooking WHERE book_id = ?), ?, ?)";
                    if ($insert_stmt = $conn->prepare($insert_sql)) {
                        $insert_stmt->bind_param("iii", $booking_id, $arrival_schedule_id, $seat_number);
                        if (!$insert_stmt->execute()) {
                            throw new Exception("Failed to insert arrival seat number.");
                        }
                        $insert_stmt->close();
                    }
                }
            }

            $staff_id = $_SESSION['admin'];
            $role = "Admin";
            $action = "Rescheduled a Booking"; // Define the action taken, e.g., "Booked ticket"
            $date_created = date('Y-m-d H:i:s'); // Current date and time
            $category = "Booking";

            $log_query = "INSERT INTO tbllogs (staff_id, action_id, category, role, action, date_created) VALUES (?, ?, ?, ?, ?, ?)";
            $log_stmt = $conn->prepare($log_query);
            $log_stmt->bind_param('iissss', $staff_id, $booking_id, $category, $role, $action, $date_created);
            $log_stmt->execute();

            // Commit transaction
            $conn->commit();
            echo json_encode(["status" => "success", "message" => "Booking updated successfully."]);
        } else {
            throw new Exception("Database error.");
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }

    // Close the connection
    $conn->close();
}
?>