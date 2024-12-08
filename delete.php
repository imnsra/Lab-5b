<?php
include 'Database.php';
include 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Dapatkan nilai matrik daripada permintaan GET
    $matric = $_GET['matric'] ?? null;

    if ($matric) {
        try {
            // Buat contoh kelas Pangkalan Data dan dapatkan sambungan
            $database = new Database();
            $db = $database->getConnection();

            // Buat contoh kelas Pengguna
            $user = new User($db);

            // Padam pengguna
            $user->deleteUser($matric);

            // Tutup sambungan
            $db->close();

            // Ubah hala semula ke insert.php
            header("Location: insert.php");
            exit();
        } catch (Exception $e) {
            echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p>Error: Matric number is missing.</p>";
    }
} else {
    echo "<p>Error: Invalid request method.</p>";
}
?>
