<?php
include 'Database.php';
include 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve the data from the POST request
        $matric = $_POST['matric'];
        $name = $_POST['name'];
        $role = $_POST['role'];

        // Create an instance of the Database class and get the connection
        $database = new Database();
        $db = $database->getConnection();

        // Create an instance of the User class and update the user
        $user = new User($db);
        $user->updateUser($matric, $name, $role);

        // Close the connection
        $db->close();

        // Redirect to the insert.php page after successful update
        header("Location: insert.php");
        exit();
    } catch (Exception $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>Error: Invalid request method.</p>";
}
?>
