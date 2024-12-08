<?php
include 'Database.php';
include 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve the matric value from the GET request
    $matric = $_GET['matric'] ?? null;

    if ($matric) {
        try {
            // Create an instance of the Database class and get the connection
            $database = new Database();
            $db = $database->getConnection();

            // Create an instance of the User class and fetch the user details
            $user = new User($db);
            $userDetails = $user->getUser($matric);

            // Close the database connection
            $db->close();

            if (!$userDetails) {
                throw new Exception("User not found.");
            }
        } catch (Exception $e) {
            echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            exit();
        }
    } else {
        echo "<p>Error: Matric number is missing.</p>";
        exit();
    }
} else {
    echo "<p>Error: Invalid request method.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            text-align: center;
        }

        form {
            display: inline-block;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

    </style>
</head>

<body>
    <div class="container">
        <h2>Update User</h2>
        <form action="update.php" method="post">
            <!-- Matric No (read-only) -->
            <label for="matric">Matric No:</label>
            <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($userDetails['matric']); ?>" readonly>

            <!-- Name -->
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userDetails['name']); ?>" required>

            <!-- Role -->
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="">Please select</option>
                <option value="lecturer" <?php if ($userDetails['role'] == 'lecturer') echo "selected"; ?>>Lecturer</option>
                <option value="student" <?php if ($userDetails['role'] == 'student') echo "selected"; ?>>Student</option>
            </select>

            <!-- Submit Button -->
            <input type="submit" value="Update">
        </form>
    </div>
</body>

</html>
