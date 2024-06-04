<?php
session_start();
require_once '../config/Database.php';
require_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();

$userModel = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["profile"]["name"]);
    move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file);

    if ($userModel->addUser($username, $target_file)) {
        $_SESSION['username'] = $username;
        $_SESSION['profile_picture'] = $target_file;
        header("Location: chat.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }
    </style>
</head>


<body>
    <section class="w-screen h-screen flex justify-center items-center">
        <div class="max-w-md relative flex flex-col p-4 rounded-md text-black bg-white">
            <div class="text-2xl font-bold mb-2 text-[#1e0e4b] text-center">Welcome back to <span
                    class="text-[#7747ff]">App Chat</span> Bro</div>
            <div class="text-sm font-normal mb-4 text-center text-[#1e0e4b]">Input the data first, Brother</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="flex flex-col gap-5" method="post" enctype="multipart/form-data">
                <div class="block relative">
                    <label for="username"
                        class="block text-gray-600 cursor-text text-sm leading-[140%] font-normal mb-2">Username</label>
                    <input type="text" id="username" name="username" required
                        class="rounded border border-gray-200 text-sm w-full font-normal leading-[18px] text-gray-600 tracking-[0px] appearance-none block h-11 m-0 p-[11px] focus:ring-2 ring-offset-2  ring-blue-700 outline-none">

                </div>
                <div class="block relative">
                    <label for="profile"
                        class="block text-gray-600 cursor-text text-sm leading-[140%] font-normal mb-2">Profile
                        Photo</label>
                    <input type="file" accept="image/png, image/jpg, image/jpeg, image/gif" id="profile" name="profile" required
                        class="rounded border border-gray-200 text-sm w-full font-normal leading-[18px] text-black tracking-[0px] appearance-none block h-11 m-0 p-[11px] focus:ring-2 ring-offset-2 ring-blue-700 outline-none">

                </div>

                <button type="submit"
                    class="bg-[#7747ff] w-max m-auto px-36 py-3 rounded text-white text-sm font-normal hover:bg-[#5b25ee]"
                    req>Submit</button>

            </form>
        </div>
    </section>

</body>
</html>
