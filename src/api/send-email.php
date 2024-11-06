<?php
require '../../admin/vendor/autoload.php'; // Make sure PHPMailer is included
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../models/env.php';

// Initialize PHPMailer
$mail = new PHPMailer(true);

try {
    // Fetch departure and arrival details
    $departure_query = "
        SELECT 
            s.schedule_id,
            s.departure_date, 
            s.departure_time, 
            departureRoute.destination_from AS departure_destination, 
            arrivalRoute.destination_from AS arrival_destination 
        FROM 
            tblschedule AS s 
        LEFT JOIN 
            tblroutefrom AS departureRoute ON s.destination_from = departureRoute.from_id
        LEFT JOIN
            tblroutefrom AS arrivalRoute ON s.destination_to = arrivalRoute.from_id
        WHERE 
            s.schedule_id = ? OR s.schedule_id = ?;
    ";

    $stmt = $conn->prepare($departure_query);
    $stmt->bind_param('ii', $scheduleDeparture_id, $scheduleArrival_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize variables
    $departureInfo = [];
    $arrivalInfo = [];

    // Fetch results
    while ($row = $result->fetch_assoc()) {
        if ($row['schedule_id'] == $scheduleDeparture_id) {
            $departureInfo = [
                'date' => $row['departure_date'],
                'time' => $row['departure_time'],
                'from' => $row['departure_destination'],
                'to' => $row['arrival_destination']
            ];
        } elseif ($row['schedule_id'] == $scheduleArrival_id) {
            $arrivalInfo = [
                'date' => $row['departure_date'],
                'time' => $row['departure_time'],
                'from' => $row['departure_destination'],
                'to' => $row['arrival_destination']
            ];
        }
    }

    // Email content
    ob_start(); // Start output buffering
    ?>
    <div style="font-family: 'Roboto', sans-serif; background-color: #f5f5f5; margin: 0; padding: 20px;">
        <div
            style="background-color: #ffffff; border-radius: 8px; padding: 20px; max-width: 600px; margin: auto; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
            <div
                style="text-align: center; background-color: #de5108; color: #fff; padding: 10px; border-radius: 8px 8px 0 0; line-height: 5px;">
                <h3>RJM Transport Corp</h3>
                <p>Online Scheduling and Booking System</p>
            </div>
            <div style="margin-top: 20px; line-height: 1.4; color: #333333;">
                <h2>Booking Received!</h2>
                <p>Thank you for your booking with RJM Transport Corp. We have received your booking and are currently
                    processing it.</p>

                <div
                    style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background-color: #f9f9f9; margin-bottom: 20px;">
                    <p style="font-weight: bold; margin: 0;">Departure Details:</p>
                    <?php if (!empty($departureInfo)): ?>
                        <p style="margin: 5px 0;">
                            Date: <?php
                            // Format the date
                            $departureDate = new DateTime($departureInfo['date']);
                            echo $departureDate->format('F j, Y'); // e.g., September 12, 2024
                            ?>
                        </p>
                        <p style="margin: 5px 0;">
                            Time: <?php
                            // Format the time
                            $departureTime = new DateTime($departureInfo['time']);
                            echo $departureTime->format('g:i A'); // e.g., 10:00 PM
                            ?>
                        </p>
                        <p style="margin: 5px 0;">From: <?php echo $departureInfo['from']; ?></p>
                        <p style="margin: 5px 0;">To: <?php echo $departureInfo['to']; ?></p>
                    <?php else: ?>
                        <p style="margin: 5px 0;">No departure information available.</p>
                    <?php endif; ?>
                </div>

                <div
                    style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background-color: #f9f9f9; margin-bottom: 20px;">
                    <p style="font-weight: bold; margin: 0;">Arrival Details:</p>
                    <?php if (!empty($arrivalInfo)): ?>
                        <p style="margin: 5px 0;">
                            Date: <?php
                            // Format the date
                            $arrivalDate = new DateTime($arrivalInfo['date']);
                            echo $arrivalDate->format('F j, Y'); // e.g., September 12, 2024
                            ?>
                        </p>
                        <p style="margin: 5px 0;">
                            Time: <?php
                            // Format the time
                            $arrivalTime = new DateTime($arrivalInfo['time']);
                            echo $arrivalTime->format('g:i A'); // e.g., 10:00 PM
                            ?>
                        </p>
                        <p style="margin: 5px 0;">From: <?php echo $arrivalInfo['from']; ?></p>
                        <p style="margin: 5px 0;">To: <?php echo $arrivalInfo['to']; ?></p>
                    <?php else: ?>
                        <p style="margin: 5px 0;">No arrival information available.</p>
                    <?php endif; ?>
                </div>


                <p>We will notify you via SMS and Email when your booking is confirmed.</p>
                <p>Thank you for your support!</p>
            </div>

            <div style="margin-top: 20px; text-align: center; font-size: 14px; color: #777777;">
                <p>&copy; 2024 RJM Transport Corp. All rights reserved.</p>
            </div>
        </div>
    </div>
    <?php
    $e_ticket_content = ob_get_clean(); // Get the content and clean the buffer

    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $SMTP_EMAIL; // Set your SMTP email
    $mail->Password = $SMTP_PASSWORD; // Set your SMTP password
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
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>