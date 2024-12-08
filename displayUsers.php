<?php
include 'Database.php';

try {
    // Create a database connection
    $database = new Database();
    $db = $database->getConnection();

    // Fetch data from the 'users' table
    $query = "SELECT matric, name, role AS accessLevel FROM users";
    $stmt = $db->prepare($query);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        throw new Exception("Error preparing the statement: " . implode(", ", $db->errorInfo()));
    }

    // Execute the statement
    $stmt->execute();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
</head>
<body>
    <h2>Users List</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Access Level</th>
        </tr>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($row['matric']); ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['accessLevel']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
// Close the database connection
$db = null;
?>
