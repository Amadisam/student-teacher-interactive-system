<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HenryPortal</title>
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
    <?php include 'sidebar.php'; ?>

    <div class="flex-1 ml-64 p-10">
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-white">Welcome to the Dashboard</h1>
            <p class="text-white text-opacity-80">Manage your students and teachers effectively.</p>
        </header>

        <section>
            <h2 class="text-2xl font-semibold text-white mb-4">Statistics</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">Total Students</h3>
                    <p class="text-4xl font-bold">150</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">Total Teachers</h3>
                    <p class="text-4xl font-bold">20</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">Pending Assignments</h3>
                    <p class="text-4xl font-bold">5</p>
                </div>
            </div>
        </section>

        <footer class="mt-10 text-center text-white text-opacity-80">
            <p>&copy; 2024 Henry. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
