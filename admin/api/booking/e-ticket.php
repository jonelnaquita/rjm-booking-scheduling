<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket</title>

</head>
<body style="font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;">
    <div class="ticket-container" style="max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;">
        <!-- Header Section -->
        <div class="header" style="display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 2px solid #ccc;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 20px;">
            <img src="../../assets/images/logo-mini.png" alt="Company Logo" class="logo" style="max-width: 100px; height: auto; width: 120px;">
            <h1 class="ticket-title" style="font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 0;
            text-align: right;">Bus E-Ticket</h1>
        </div>

        <!-- Ticket Details -->
        <div class="ticket-details" style="padding: 20px;">
            <div class="ticket-info" style="font-size: 14px;
            margin-bottom: 20px;
            color: #333;
            line-height: 10px;">
                <p><strong>Passenger ID:</strong> <?= $booking_details['passenger_code']; ?></p>
                <p><strong>Number of Passenger/s:</strong> <?= $booking_details['passengers']; ?></p>
                <p><strong>Date of Issue:</strong> 15 September 2024</p>
                <p><strong>Status:</strong> <?= $booking_details['status']; ?></p>
            </div>

            <!-- Highlighted Row -->
            <div class="highlighted" style="background-color: #f1f8ff;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #de5108;
            display: flex;
            justify-content: space-between;
            align-items: center;">
                <p style="margin: 0; width: 100%;"><strong><?= $booking_details['bus_departure']; ?></strong> <span style="float: right;"><strong><?= $booking_details['departure_date']; ?></strong></span></p>
            </div>

            <!-- Departure and Destination Info -->
            <div class="departure-info"
            style="font-size: 14px;
            color: #333;
            line-height: 10px;">
                <p><strong>Estimated Time of Departure:</strong> <?= $booking_details['departure_time']; ?></p>
                <p><strong>Departure Terminal:</strong> <?= $booking_details['destination_departure']; ?> Terminal</p>
                <p><strong>Destination:</strong> <?= $booking_details['destination_departure']; ?></p>
            </div>

            <!-- Highlighted Row -->
            <div class="highlighted" style="background-color: #f1f8ff;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #de5108;
            display: flex;
            justify-content: space-between;
            align-items: center;">
                <p style="margin: 0; width: 100%;"><strong><?= $booking_details['bus_arrival']; ?></strong> <span style="float: right;"><strong><?= $booking_details['arrival_date']; ?></strong></span></p>
            </div>

            <!-- Arrival and Destination Info -->
            <div class="arrival-info"
            style="font-size: 14px;
            color: #333;
            line-height: 10px;">
                <p><strong>Estimated Time of Arrival:</strong> <?= $booking_details['arrival_time']; ?></p>
                <p><strong>Arrival Terminal:</strong> <?= $booking_details['destination_arrival']; ?> Terminal</p>
                <p><strong>Destination:</strong> <?= $booking_details['destination_arrival']; ?></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer"
        style="background-color: #f9f9f9;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #888;">
            <p>This is your electronic ticket. Please bring a copy of this email or show it on your mobile device when boarding.</p>
        </div>
    </div>
</body>
</html>
