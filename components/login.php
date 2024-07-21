<?php 
include('connection.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];  
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM login WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Redirect to contents page on successful login
        $_SESSION['email'] = $email; // Set this after successful login
        $_SESSION['authenticated'] = true; 
        header("Location: components/contents.php");
        exit();
    } else {
        // Display an error message on failed login
        echo "Login failed. Invalid email or password.";
    }

    $stmt->close();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    header("Location: login.php");    
    session_unset();
    session_destroy();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="">
      <div class="min-h-screen flex fle-col items-center justify-center py-6 px-4">
        <div class="grid md:grid-cols-2 items-center gap-10 max-w-6xl w-full">
          <div>
            <h2 class="lg:text-5xl text-4xl font-extrabold lg:leading-[55px] text-purple-800">
              H-Billing
            </h2>
            <p class="text-sm mt-6 text-gray-800">Billing made easy.</p>
            <p class="text-sm mt-12 text-gray-800">Don't have an account <a href="/chat/components/register.php" class="text-blue-600 font-semibold hover:underline ml-1">Register here</a></p>
          </div>

          <form action="" method="post" class="max-w-md md:ml-auto w-full">
            <h3 class="text-gray-800 text-3xl font-extrabold mb-8">
              Sign in
            </h3>

            <div class="space-y-4">
              <div>
                <input type="email" name="email" autocomplete="email" required class="bg-gray-100 w-full text-sm text-gray-800 px-4 py-3.5 rounded-md outline-blue-600 focus:bg-transparent" placeholder="Email address" />
              </div>
              <div>
                <input type="password" name="password" id="password" autocomplete="current-password" required class="bg-gray-100 w-full text-sm text-gray-800 px-4 py-3.5 rounded-md outline-blue-600 focus:bg-transparent" placeholder="Password" />
              </div>
              <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center">
                  <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                  <label for="remember-me" class="ml-3 block text-sm text-gray-800">
                    Remember me
                  </label>
                </div>
                <div class="text-sm">
                  <a href="jajvascript:void(0);" class="text-blue-600 hover:text-blue-500 font-semibold">
                    Forgot your password?
                  </a>
                </div>
              </div>
            </div>

            <div class="!mt-8">
              <button name="login" type="sumbit" class="w-full shadow-xl py-2.5 px-4 text-sm font-semibold rounded text-white bg-purple-600 hover:bg-purple-700 focus:outline-none">
                Log in
              </button>
            </div>
            
          </form>
        </div>
      </div>
    </div>

    </body>
</html>