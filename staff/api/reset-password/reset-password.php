<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../admin/vendor/autoload.php'; // Adjust the path to your autoload.php
include '../../../models/conn.php'; // Your database connection
include '../../../models/env.php';  // Your SMTP credentials

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address']);
        exit;
    }

    // Check if email exists in the `tblstaff`
    $query = "SELECT staff_id, firstname FROM tblstaff WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $staff = $result->fetch_assoc();
        $staff_id = $staff['staff_id'];
        $firstname = $staff['firstname'];

        // Generate a unique token
        $token = bin2hex(random_bytes(50)); // 50 characters long token

        // Save the token to the `tblstaff` table
        $updateQuery = "UPDATE tblstaff SET token = ? WHERE staff_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("si", $token, $staff_id);

        if ($stmt->execute()) {
            // Send the email using the existing email template (email.php)
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $SMTP_EMAIL;
                $mail->Password = $SMTP_PASSWORD;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $SMTP_PORT;

                // Recipients
                $mail->setFrom($SMTP_EMAIL, $SMTP_NAME);
                $mail->addAddress($email, $firstname);

                // Load email template
                ob_start();
                include('email.php'); // Path to your email template
                $email_body = ob_get_clean();

                // Replace placeholders in the template
                $resetLink = "http://localhost/rjm-booking-scheduling/staff/pages/reset-password.php?token=" . $token;
                $email_body = str_replace(['{{name}}', '{{action_url}}'], [$firstname, $resetLink], $email_body);

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Reset your password';
                $mail->Body = $email_body;

                // Send the email
                $mail->send();
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save the token']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Email not found']);
    }
}
?>
