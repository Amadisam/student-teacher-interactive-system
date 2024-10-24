<?php
session_start();
include 'connect.php';

// Insert student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    $sql = "INSERT INTO students (name, email, phone) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $phone);

    if ($stmt->execute()) {
        echo "<script>alert('Student added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Fetch students
$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
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
<body class="bg-gradient-to-br from-primary to-secondary min-h-screen flex items-center justify-center p-6">
     <?php include 'sidebar.php'; ?>
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-xl p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add Student</h2>
        
        <form action="students.php" method="post" class="mb-6">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter student's name">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter student's email">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Phone</label>
                <input type="text" id="phone" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter student's phone number">
            </div>
            <button type="submit" class="w-full bg-primary text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline transition duration-300 ease-in-out">
                Add Student
            </button>
        </form>

        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Students List</h2>
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 p-4">ID</th>
                    <th class="border border-gray-300 p-4">Name</th>
                    <th class="border border-gray-300 p-4">Email</th>
                    <th class="border border-gray-300 p-4">Phone</th>
                    <th class="border border-gray-300 p-4">Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="border border-gray-300 p-4"><?php echo $row['id']; ?></td>
                            <td class="border border-gray-300 p-4"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="border border-gray-300 p-4"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="border border-gray-300 p-4"><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td class="border border-gray-300 p-4"><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="border border-gray-300 p-4 text-center">No students found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
