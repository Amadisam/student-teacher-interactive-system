<?php
$login = 0;
$invalid = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $row = mysqli_fetch_assoc($result);
            $admin_id = $row['admin_id'];
            $hashed_password = $row['password'];
            if (password_verify($password, $hashed_password)) {
                $login = 1;
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['admin_id'] = $admin_id;
                header('location: home.php');
            } else {
                $invalid = 1;
            }
        } else {
            $invalid = 1;
        }
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HenryPortal</title>
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
<body class="bg-gradient-to-br from-primary to-secondary min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <header class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-white mb-2">Henry System</h1>
            <p class="text-white text-opacity-80">Admin Login</p>
        </header>

        <form action="login.php" method="post" class="bg-white rounded-lg shadow-xl p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Welcome Back</h2>
            
            <?php if (isset($invalid) && $invalid == 1): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p>Invalid username or password.</p>
                </div>
            <?php endif; ?>

            <div class="mb-6">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" id="username" name="username" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                       placeholder="Enter your username">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                       placeholder="Enter your password">
            </div>

            <button type="submit" 
                    class="w-full bg-primary text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline transition duration-300 ease-in-out">
                Login
            </button>
        </form>

        <footer class="mt-8 text-center text-white text-opacity-80">
            <p>&copy; 2024 Henry. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>