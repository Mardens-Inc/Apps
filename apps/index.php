<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Apps - Marden's Surplus & Salvage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/apps.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/main.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/login.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/table.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/scrollbar.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/inputs.min.css?version=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/lib/fontawesome/css/all.min.css">

    <!-- jQuery -->
    <script src="/assets/lib/jquery.min.js"></script>


    <!-- Favicon -->
    <link rel="icon" href="https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_32,h_32/https://www.mardens.com/wp-content/uploads/2019/03/cropped-Mardens-Favicon-1-32x32.png" sizes="32x32">
    <link rel="icon" href="https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_192,h_192/https://www.mardens.com/wp-content/uploads/2019/03/cropped-Mardens-Favicon-1-192x192.png" sizes="192x192">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>

<body>
    <button id="logout"> <i class="fa fa-lock"></i> <span>Logout</span></button>
    <h1>Apps</h1>
    <div class="grid" id="app-list">
        <?php
        $apps = scandir(__DIR__);
        foreach ($apps as $app) {
            if (is_dir($app) && file_exists("$app/app.json") && file_exists("$app/index.php")) {
                $json = json_decode(file_get_contents("$app/app.json"), true);

                $name = $json["name"];
                $icon = $json["icon"];
                if ($icon == null) {
                    $icon = "unknown.svg";
                }
                $description = $json["description"];

                if ($app == "." || $app == ".." || $app == "index.php") continue;
                echo "
                <a class='app-item' href='/apps/$app/' title='$name - $description'>
                <img src='/assets/images/icons/$icon' />
                <p class='name'>$name</p>
                    <p class='description'>$description</p>
                    </a>";
            }
        }
        ?>
    </div>



    <script src="/assets/js/inputs.min.js"></script>

    <script>
        startLoading();
    </script>

    <script type="module" src="/assets/js/auth.js"></script>
</body>

</html>