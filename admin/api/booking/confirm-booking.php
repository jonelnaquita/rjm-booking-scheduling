<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Include PHPMailer and autoload dependencies
require '../../../models/conn.php'; // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];

    // SQL Query to fetch booking, schedule, passenger, bus, and bus type info
    $query = "
        SELECT 
            p.passenger_code, p.email, b.passengers, b.status,
            sd.departure_date, sd.departure_time, sa.departure_date as arrival_date, sa.departure_time as arrival_time,
            dd.destination_from as destination_departure, da.destination_from as destination_arrival,
            bd.bus_number as bus_departure, ba.bus_number as bus_arrival, bt.bus_type, p.firstname, p.middlename, p.lastname
        FROM 
            tblbooking b
        JOIN tblpassenger p ON p.passenger_code = b.passenger_id
        JOIN tblschedule sd ON sd.schedule_id = b.scheduleDeparture_id
        JOIN tblschedule sa ON sa.schedule_id = b.scheduleArrival_id
        JOIN tblroutefrom dd ON dd.from_id = sd.destination_from
        JOIN tblroutefrom da ON da.from_id = sd.destination_to
        JOIN tblbus bd ON bd.bus_id = sa.bus_id
        JOIN tblbus ba ON ba.bus_id = sd.bus_id
        JOIN tblbustype bt ON bt.bustype_id = bd.bus_type
        WHERE 
            b.passenger_id = ?
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
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rjmtransportcorp00@gmail.com';
            $mail->Password = 'rcps bmtr pdrw cmph'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('rjmtransportcorp00@gmail.com', 'RJM Transport Corp');
            $mail->addAddress($email); // Send email to passenger

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = 'Your E-Ticket Confirmation';
            $mail->Body = $e_ticket_content;

            // Send the email
            $mail->send();
            
            // Update booking status to "Confirmed"
            $update_query = "UPDATE tblbooking SET status = 'Confirmed' WHERE passenger_id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param('i', $booking_id);
            $update_stmt->execute();
            
            if ($update_stmt->affected_rows > 0) {
                echo 'E-ticket has been sent successfully and booking status updated.';
            } else {
                echo 'E-ticket sent, but failed to update booking status.';
            }
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        echo "No booking found.";
    }
}
