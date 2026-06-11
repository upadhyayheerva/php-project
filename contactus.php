<?php
// Step 1: Database connection details
$servername = "localhost";  // Adjust if your database is on a remote server
$username = "root";         // Your database username (default is root for local)
$password = "";             // Your database password (leave blank if no password is set)
$dbname = "phozogydb";  // Replace with your actual database name

// Step 2: Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Step 3: Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 4: Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the inputs
    $name = $conn->real_escape_string($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $message = $conn->real_escape_string($_POST['message']);

    // Validate email format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Prepare the SQL query to insert the form data into the database
        $sql = "INSERT INTO contacts (name, email, phone_number, message) 
                VALUES ('$name', '$email', '$phone_number', '$message')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Your message has been received. Thank you!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid email address.";
    }
}

// Step 5: Close the connection
$conn->close();
?>
