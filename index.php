<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Login - Marden's Surplus & Salvage</title>


    <link rel="stylesheet" href="/assets/css/main.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/login.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/table.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/scrollbar.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/inputs.min.css?version=1">

    <!-- Favicon -->
    <link rel="icon" href="https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_32,h_32/https://www.mardens.com/wp-content/uploads/2019/03/cropped-Mardens-Favicon-1-32x32.png" sizes="32x32">
    <link rel="icon" href="https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_192,h_192/https://www.mardens.com/wp-content/uploads/2019/03/cropped-Mardens-Favicon-1-192x192.png" sizes="192x192">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/lib/fontawesome/css/all.min.css">

    <!-- jQuery -->
    <script src="/assets/lib/jquery.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>

<body>

    <form id="login-form" class="col center horizontal vertical" action="javascript:void(0);">
        <h1>Login</h1>
        <h2>Mardens Internal Apps</h2>
        <div class="floating-input">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <label for="username">Username</label>
        </div>
        <div class="floating-input">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>
        <toggle-field id="show-password" value=false>Show Password</toggle-field>
        <button type="submit">Login</button>
    </form>

    <script src="/assets/js/inputs.min.js"></script>

    <script>
        // startLoading();
    </script>

    <script type="module" src="/assets/js/auth.js"></script>
    <script type="module" src="/assets/js/doms/Toggle.js"></script>

</body>

</html>