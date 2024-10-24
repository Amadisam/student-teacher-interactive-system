<?php
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connect.php'; // Database connection file

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $subject = $_POST["subject"];

    // Insert teacher into the database
    $sql = "INSERT INTO teachers (name, email, phone, subject) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $subject);

    if ($stmt->execute()) {
        $success = "Teacher added successfully!";
    } else {
        $error = "Error adding teacher: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Fetch teachers from the database
include 'connect.php'; // Database connection file
$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
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
<body class="bg-gradient-to-br from-primary to-secondary min-h-screen p-6 flex flex-col items-center">
    <?php include 'sidebar.php'; ?>

    <div class="w-full max-w-md bg-white rounded-lg shadow-xl p-8 mb-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add Teacher</h2>

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

        <form action="teachers.php" method="post">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Enter teacher's name">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Enter teacher's email">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Phone</label>
                <input type="text" id="phone" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Enter teacher's phone">
            </div>

            <div class="mb-4">
                <label for="subject" class="block text-gray-700">Subject</label>
                <input type="text" id="subject" name="subject" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Enter teacher's subject">
            </div>

            <button type="submit" class="w-full bg-primary text-white font-bold py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out">
                Add Teacher
            </button>
        </form>
    </div>

    <div class="w-full max-w-4xl bg-white rounded-lg shadow-xl p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Teacher List</h2>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Phone</th>
                    <th class="border px-4 py-2">Subject</th>
                    <th class="border px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $row['id']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['name']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['email']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['phone']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['subject']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="border px-4 py-2 text-center">No teachers found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
