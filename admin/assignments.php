<?php
session_start();
include 'connect.php'; // Include your database connection
include 'sidebar.php'; // Include the sidebar

// Variables for success/error messages
$success = $error = "";

// Handle form submission for adding an assignment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $due_date = $_POST["due_date"];

    // Insert assignment into the database
    $sql = "INSERT INTO assignments (title, description, due_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $description, $due_date);

    if ($stmt->execute()) {
        $success = "Assignment added successfully!";
    } else {
        $error = "Error adding assignment: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch assignments from the database
$sql = "SELECT * FROM assignments ORDER BY due_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Assignments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-primary to-secondary min-h-screen flex">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <div class="flex-grow ml-64 p-6">
        <div class="container mx-auto">
            <div class="w-full max-w-md bg-white rounded-lg shadow-xl p-8 mb-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add Assignment</h2>

                <?php if ($success): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p><?php echo $success; ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>

                <form action="assignments.php" method="post">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700">Title</label>
                        <input type="text" id="title" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Enter assignment title">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700">Description</label>
                        <textarea id="description" name="description" required class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Enter assignment description"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="block text-gray-700">Due Date</label>
                        <input type="date" id="due_date" name="due_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <button type="submit" class="w-full bg-primary text-white font-bold py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out">
                        Add Assignment
                    </button>
                </form>
            </div>

            <div class="w-full max-w-4xl bg-white rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Assignment List</h2>

                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">Title</th>
                            <th class="border px-4 py-2">Description</th>
                            <th class="border px-4 py-2">Due Date</th>
                            <th class="border px-4 py-2">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo $row['id']; ?></td>
                                    <td class="border px-4 py-2"><?php echo $row['title']; ?></td>
                                    <td class="border px-4 py-2"><?php echo $row['description']; ?></td>
                                    <td class="border px-4 py-2"><?php echo $row['due_date']; ?></td>
                                    <td class="border px-4 py-2"><?php echo $row['created_at']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="border px-4 py-2 text-center">No assignments found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
