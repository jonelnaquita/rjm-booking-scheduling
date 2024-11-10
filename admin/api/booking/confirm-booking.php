<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Include PHPMailer and autoload dependencies
require '../../../models/conn.php'; // Include your database connection script
include '../../../models/env.php'; // Include environment variables

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];

    // SQL Query to fetch booking, schedule, passenger, bus, and bus type info
    $query = "
        SELECT 
            b.book_id, 
            b.trip_type, 
            p.passenger_code, 
            p.email, 
            p.mobile_number, 
            b.passengers, 
            b.status,
            sd.departure_date, 
            sd.departure_time, 
            sa.departure_date as arrival_date, 
            sa.departure_time as arrival_time,
            dd.destination_from as destination_departure, 
            da.destination_from as destination_arrival,
            bd.bus_number as bus_departure, 
            ba.bus_number as bus_arrival, 
            bt.bus_type, 
            p.firstname, 
            p.middlename, 
            p.lastname,
            CONCAT(p.firstname, ' ', p.lastname) as fullname,
            GROUP_CONCAT(DISTINCT s.seat_number ORDER BY s.seat_number SEPARATOR ', ') as seats_departure,
            GROUP_CONCAT(DISTINCT s_arrival.seat_number ORDER BY s_arrival.seat_number SEPARATOR ', ') as seats_arrival
        FROM 
            tblbooking b
        LEFT JOIN tblpassenger p ON p.passenger_code = b.passenger_id
        LEFT JOIN tblschedule sd ON sd.schedule_id = b.scheduleDeparture_id
        LEFT JOIN tblschedule sa ON sa.schedule_id = b.scheduleArrival_id
        LEFT JOIN tblroutefrom dd ON dd.from_id = sd.destination_from
        LEFT JOIN tblroutefrom da ON da.from_id = sd.destination_to
        LEFT JOIN tblbus bd ON bd.bus_id = sd.bus_id
        LEFT JOIN tblbus ba ON ba.bus_id = sa.bus_id
        LEFT JOIN tblbustype bt ON bt.bustype_id = bd.bus_type
        LEFT JOIN tblseats s ON s.passenger_id = p.passenger_code AND s.schedule_id = b.scheduleDeparture_id
        LEFT JOIN tblseats s_arrival ON s_arrival.passenger_id = p.passenger_code AND s_arrival.schedule_id = b.scheduleArrival_id
        WHERE 
            b.book_id = ?
        GROUP BY 
            b.book_id
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $booking_details = $result->fetch_assoc();

        // Fetch passenger email
        $email = $booking_details['email'];

        // Load the e-ticket content
        ob_start();
        include('e-ticket.php');  // Include the e-ticket template
        $e_ticket_content = ob_get_clean();

        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        try {
            $ticket_number = random_int(100000, 999999);

            // Update booking status to "Confirmed" and set the ticket_number
            $update_query = "UPDATE tblbooking SET status = 'Confirmed', ticket_number = ? WHERE book_id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param('ii', $ticket_number, $booking_id);
            $update_stmt->execute();

            // Ensure booking status was updated
            if ($update_stmt->affected_rows > 0) {
                // Log the action
                if (isset($_SESSION['admin'])) {
                    $staff_id = $_SESSION['admin'];
                    $role = "Admin";
                    $action = "Confirmed Booking"; // Define the action taken, e.g., "Booked ticket"
                    $category = "Booking";
                    $date_created = date('Y-m-d H:i:s'); // Current date and time

                    $log_query = "INSERT INTO tbllogs (staff_id, action_id, category, role, action, date_created) VALUES (?, ?, ?, ?, ?, ?)";
                    $log_stmt = $conn->prepare($log_query);
                    $log_stmt->bind_param('iissss', $staff_id, $booking_id, $category, $role, $action, $date_created);
                    $log_stmt->execute();
                }

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
                $mail->addAddress($email); // Send email to passenger

                // Email Content
                $mail->isHTML(true);
                $mail->Subject = 'Your E-Ticket Confirmation';
                $mail->Body = $e_ticket_content;

                // Send the email
                $mail->send();

                // Send SMS
                include_once 'send-sms.php';
                $sms_receiver = $booking_details['mobile_number'];
                $sms_message = "Hello " . $booking_details['fullname'] . ", your bus booking for RJM Transport Corp. was confirmed and accepted. Your ticket number is: " . $ticket_number . ". Please check your email for your electronic ticket.";
                $response = sendSMS($sms_receiver, $sms_message);

                echo json_encode(['success' => true, 'message' => 'E-ticket has been sent successfully and booking status updated. SMS result: ' . htmlspecialchars($response)]);
            } else {
                echo json_encode(['success' => false, 'message' => 'E-ticket sent, but failed to update booking status.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => "Error sending email: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => "No booking found."]);
    }
} else {
    echo json_encode(['success' => false, 'message' => "Invalid request method."]);
}
?>