<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'connect.php';

// Insert Feedback
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST["feedback"];

    $sql = "INSERT INTO feedback (feedback) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $feedback);
    $stmt->execute();
    $stmt->close();
}

// View Feedback
$sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback and Surveys - HenryPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include 'sidebar.php'; ?>

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold">Feedback and Surveys</h1>

        <form action="Feedback and Surveys.php" method="post" class="bg-white rounded-lg shadow-md p-6 mt-4">
            <h2 class="text-2xl font-semibold mb-4">Submit Feedback</h2>
            <div class="mb-4">
                <label for="feedback" class="block text-gray-700">Feedback</label>
                <textarea id="feedback" name="feedback" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md"></textarea>
            </div>
            <button type="submit" class="bg-primary text-white py-2 px-4 rounded">Submit Feedback</button>
        </form>

        <h2 class="text-2xl font-semibold mt-8">View Feedback</h2>
        <table class="min-w-full bg-white mt-4 border border-gray-300">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Feedback</th>
                    <th class="border px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($row['feedback']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
