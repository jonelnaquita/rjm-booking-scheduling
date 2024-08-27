<?php
    // Include your database connection file
    include '../../../models/conn.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve POST data
        $to_id = isset($_POST['to_id']) ? $_POST['to_id'] : '';
        $from_id = isset($_POST['from_id']) ? $_POST['from_id'] : '';

        if (!empty($to_id) && !empty($from_id)) {
            // Prepare SQL query to get the destination name
            $destinationNameSql = "
                SELECT from_id 
                FROM tblroutefrom
                WHERE destination_from = ?
            ";

            if ($stmt = $conn->prepare($destinationNameSql)) {
                // Bind parameters
                $stmt->bind_param('s', $to_id);

                // Execute the statement
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($destination_from_id);
                    $stmt->fetch();
                    $stmt->close();

                    // Prepare SQL query to delete the entry
                    $sql = "
                        DELETE FROM tblrouteto
                        WHERE from_id = ? 
                        AND destination_to = ?
                    ";

                    if ($stmt = $conn->prepare($sql)) {
                        // Bind parameters
                        $stmt->bind_param('ii', $from_id, $destination_from_id);

                        // Execute the statement
                        if ($stmt->execute()) {
                            echo 'Success';
                        } else {
                            echo 'Error executing the query.';
                        }

                        // Close the statement
                        $stmt->close();
                    } else {
                        echo 'Error preparing the delete query.';
                    }
                } else {
                    echo 'No matching destination found.';
                }
            } else {
                echo 'Error preparing the destination query.';
            }
        } else {
            echo 'Invalid data provided.';
        }

        // Close the database connection
        $conn->close();
    } else {
        echo 'Invalid request method.';
    }
?>
