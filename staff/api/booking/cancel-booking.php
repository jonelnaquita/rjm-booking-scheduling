<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../admin/vendor/autoload.php'; // Include PHPMailer and autoload dependencies
require '../../../models/conn.php';  // Include your database connection script
include '../../../models/env.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $cancellation_reason = $_POST['cancellation_reason'];

    // SQL Query to fetch booking details
    $query = "
        SELECT 
            b.book_id, p.email, CONCAT(p.firstname, ' ', p.lastname) AS fullname, p.mobile_number
        FROM 
            tblbooking b
        JOIN tblpassenger p ON p.passenger_code = b.passenger_id
        WHERE 
            b.book_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $booking_id);  // Assuming booking_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $booking_details = $result->fetch_assoc();

        // Update booking status to "Cancelled"
        $update_query = "UPDATE tblbooking SET status = 'Cancelled' WHERE book_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('i', $booking_id); // Corrected to use 'i' for integer
        $update_stmt->execute();

        $staff_id = $_SESSION['staff'];
        $role = "Terminal Staff";
        $action = "Cancelled Booking"; // Define the action taken, e.g., "Booked ticket"
        $date_created = date('Y-m-d H:i:s'); // Current date and time
        $category = "Booking";

        $log_query = "INSERT INTO tbllogs (staff_id, action_id, category, role, action, date_created) VALUES (?, ?, ?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param('iissss', $staff_id, $booking_id, $category, $role, $action, $date_created);
        $log_stmt->execute();

        // Check if the update was successful
        if ($update_stmt->affected_rows > 0) {
            // Send Email Notification
            $email = $booking_details['email'];
            $fullname = $booking_details['fullname'];

            $mail = new PHPMailer(true);
            try {
                // SMTP Configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $SMTP_EMAIL;
                $mail->Password = $SMTP_PASSWORD; // Consider using environment variables for security
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $SMTP_PORT;

                // Recipients
                $mail->setFrom('rjmtransportcorp00@gmail.com', 'RJM Transport Corp');
                $mail->addAddress($email);  // Add recipient's email

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Bus Booking Cancellation';
                $mail->Body = "
                    <p>Dear {$fullname},</p>
                    <p>Your bus booking has been cancelled due to the following reason:</p>
                    <p><strong>{$cancellation_reason}</strong></p>
                    <p>We apologize for any inconvenience caused.</p>
                    <p>Best regards,<br>RJM Transport Corp</p>
                ";

                // Send the email
                $mail->send();

                // Send SMS
                include_once 'send-sms.php';
                $sms_receiver = $booking_details['mobile_number'];
                $sms_message = "Hello " . $booking_details['fullname'] . ", your bus booking has been cancelled due to the following reason: " . $cancellation_reason . ". We apologize for any inconvenience caused.";
                $response = sendSMS($sms_receiver, $sms_message);

                echo 'Booking has been successfully cancelled and an email notification has been sent.';
            } catch (Exception $e) {
                echo "Error sending email: {$mail->ErrorInfo}";
            }
        } else {
            echo 'Failed to update booking status.';
        }
    } else {
        echo 'No booking found with the provided ID.';
    }
}
?>