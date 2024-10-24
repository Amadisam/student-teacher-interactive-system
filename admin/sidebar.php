<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<div class="bg-white shadow-lg w-64 h-screen fixed top-0 left-0 z-30">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
        <p class="text-gray-600"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
    </div>
    <nav class="mt-6">
        <ul>
            <li>
                <a href="home.php" class="block p-4 text-gray-800 hover:bg-primary hover:text-white">Home</a>
            </li>
            <li>
                <a href="students.php" class="block p-4 text-gray-800 hover:bg-primary hover:text-white">View Students</a>
            </li>
            <li>
                <a href="teachers.php" class="block p-4 text-gray-800 hover:bg-primary hover:text-white">View Teachers</a>
            </li>
            <li>
                <a href="assignments.php" class="block p-4 text-gray-800 hover:bg-primary hover:text-white">Assignments</a>
            </li>
            <li>
                <a href="announcements.php" class="block p-4 text-gray-800 hover:bg-primary hover:text-white">Announcements</a>
            </li>
            <li>
                <a href="surveys.php" class="block p-4 text-gray-800 hover:bg-primary hover:text-white">Feedback and Surveys</a>
            </li>
            <li>
                <a href="logout.php" class="block p-4 text-gray-800 hover:bg-primary hover:text-white">Logout</a>
            </li>
        </ul>
    </nav>
</div>
