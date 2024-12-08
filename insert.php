<?php
include 'Database.php';
include 'User.php';

try {
    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the User class
    $user = new User($db);

    // Check if form was submitted and insert the user into the database
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Insert the new user using POST data
        $user->createUser($_POST['matric'], $_POST['name'], $_POST['password'], $_POST['role']);
        echo "<p>User successfully registered!</p>";
    }

    // Fetch all users from the database to display in a table
    $query = "SELECT matric, name, role AS accessLevel FROM users";
    $stmt = $db->prepare($query);
    $stmt->execute();

    // Get the result and fetch as an associative array
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
} finally {
    // Close the database connection
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <style>
        body {
            text-align: center;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 60%;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }

        .action-links {
            text-align: center;
        }

        .action-links a {
            text-decoration: none;
            margin: 0 10px;
            color: #007BFF;
        }

        /* Style for the Create New User button */
        .create-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .create-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h2>Registered Users</h2>

    <!-- Display Users in Table -->
    <table>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Access Level</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['matric']); ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['accessLevel']); ?></td>
                <td class="action-links">
                    <!-- Link to Update  -->
                    <a href="update_form.php?matric=<?= urlencode($row['matric']); ?>">Update</a>
                    <!-- Link to Delete -->
                    <a href="delete.php?matric=<?= urlencode($row['matric']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Create New User Button -->
    <a href="register_form.php">
        <button class="create-button" type="button">Create New User</button>
    </a>
</body>

</html>
