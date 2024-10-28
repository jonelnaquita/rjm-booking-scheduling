<?php
// Load Composer's autoloader for PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Adjust the path to your composer autoload.php
include '../../../models/conn.php';
include '../../../models/env.php';


if (isset($_POST['email'], $_POST['firstname'], $_POST['from_id'], $_POST['to_id'], $_POST['departure_dates'], $_POST['departure_time'], $_POST['bus_id'])) {
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $from_id = $_POST['from_id'];
    $to_id = $_POST['to_id'];
    $departure_dates = $_POST['departure_dates'];
    $departure_time = $_POST['departure_time'];
    $bus_id = $_POST['bus_id'];

    // Fetch destination_from based on from_id using MySQLi
    $from_query = "SELECT destination_from FROM tblroutefrom WHERE from_id = '$from_id'";
    $from_result = mysqli_query($conn, $from_query);

    if ($from_result && mysqli_num_rows($from_result) > 0) {
        $from_row = mysqli_fetch_assoc($from_result);
        $destination_from = $from_row['destination_from'];
    } else {
        $destination_from = "Unknown destination";
    }

    // Fetch destination_from based on to_id using MySQLi
    $to_query = "SELECT destination_from FROM tblroutefrom WHERE from_id = '$to_id'";
    $to_result = mysqli_query($conn, $to_query);

    if ($to_result && mysqli_num_rows($to_result) > 0) {
        $to_row = mysqli_fetch_assoc($to_result);
        $destination_to = $to_row['destination_from'];
    } else {
        $destination_to = "Unknown destination";
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $SMTP_EMAIL;
        $mail->Password = $SMTP_PASSWORD; // Consider using environment variables for security
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $SMTP_PORT;

        // Sender info
        $mail->setFrom($SMTP_EMAIL, $SMTP_NAME);
        $mail->addAddress($email, $firstname);  // Add a recipient

        // Email subject and body content
        $mail->isHTML(true);
        $mail->Subject = 'New Schedule Created for Bus ' . $bus_id;

        // Customize the email content
        $mail->Body = "
        <h3>New Bus Schedule</h3>
        <p>Hello <b>{$firstname}</b>,</p>
        <p>A new schedule has been created for bus <b>{$bus_id}</b>:</p>
        <ul>
            <li>From: {$destination_from}</li>
            <li>To: {$destination_to}</li>
            <li>Departure Dates: {$departure_dates}</li>
            <li>Departure Time: {$departure_time}</li>
        </ul>
        <p>Thank you for your attention!</p>
        ";

        // Send SMS
        include_once '../booking/send-sms.php';
        $sms_receiver = $booking_details['mobile_number'];
        $sms_message = "Hello " . $firstname . ", here are your travel details with RJM Transport Corp: " .
               "Bus No. " . $bus_id . 
               ". Departure Date: " . $departure_dates . 
               " at " . $departure_time . ".";
        $sms_result = gw_send_sms($ONEWAYUSERNAME, $ONEWAYPASSWORD, $ONEWAYFROM, $sms_receiver, $sms_message);

        // Send the email
        if ($mail->send()) {
            echo json_encode(['success' => 'Email sent successfully']);
        } else {
            echo json_encode(['error' => 'Email sending failed']);
        }
    } catch (Exception $e) {
        // Catch PHPMailer exceptions
        echo json_encode(['error' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['error' => 'Missing required POST data.']);
}
?>