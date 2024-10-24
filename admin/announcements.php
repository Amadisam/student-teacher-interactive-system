<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'connect.php';

// Insert Announcement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $announcement = $_POST["announcement"];

    $sql = "INSERT INTO announcements (announcement) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $announcement);
    $stmt->execute();
    $stmt->close();
}

// View Announcements
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - HenryPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include 'sidebar.php'; ?>

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold">Announcements</h1>

        <form action="Announcements.php" method="post" class="bg-white rounded-lg shadow-md p-6 mt-4">
            <h2 class="text-2xl font-semibold mb-4">Add Announcement</h2>
            <div class="mb-4">
                <label for="announcement" class="block text-gray-700">Announcement</label>
                <textarea id="announcement" name="announcement" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <button type="submit" class="bg-primary text-white py-2 px-4 rounded">Add Announcement</button>
        </form>

        <h2 class="text-2xl font-semibold mt-8">View Announcements</h2>
        <table class="min-w-full bg-white mt-4 border border-gray-300">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Announcement</th>
                    <th class="border px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($row['announcement']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
