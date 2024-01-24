<?php
$_ENV["APP_PATH"] = $_SERVER['DOCUMENT_ROOT'] . "/apps/IT-Computers";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Computers Database - Mardens Apps</title>
    <link rel="stylesheet" href="./assets/css/main.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/main.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/apps.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/table.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/scrollbar.min.css?version=1">
    <link rel="stylesheet" href="/assets/css/inputs.min.css?version=1">
    <link rel="icon" href="https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_32,h_32/https://www.mardens.com/wp-content/uploads/2019/03/cropped-Mardens-Favicon-1-32x32.png" sizes="32x32">
    <link rel="icon" href="https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_192,h_192/https://www.mardens.com/wp-content/uploads/2019/03/cropped-Mardens-Favicon-1-192x192.png" sizes="192x192">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/lib/fontawesome/css/all.min.css">

    <!-- jQuery -->
    <script src="/assets/lib/jquery.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<body>
    <header>
        <a id="go-back-button" class="button" href="/apps/"><i class="fa-solid fa-reply"></i> <span>All Apps</span></a>
        <h1><span class="blue">&lt;</span>IT<span class="blue">&gt;</span> <span class="yellow">Computers</pan>
        </h1>
        <h2> Created for Mardens Surplus & Salvage. </h2>
        <form action="javascript:void(0);" class="search-area">
            <input type="search" name="search" id="search" required placeholder="Search...">
            <button type="submit" name="submit" id="submit"><i class="fas fa-search"></i></button>
            <div class="button" onclick="$('dialog#filter')[0].showModal();"><i class="fa fa-sliders"></i></div>
        </form>
    </header>
    <div class="table-content">

        <table>
            <thead>
                <tr>
                    <td>Asset Number</td>
                    <td>Make</td>
                    <td>Model</td>
                    <td>Condition</td>
                    <td>Device Type</td>
                    <td>Operating System</td>
                    <td>Primary User</td>
                    <td>Location</td>
                    <td>Additional Information</td>
                    <td>Notes</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <dialog id="filter">
        <summary>
            <h2>Filter</h2>
            <button class="close-button" onclick="$('dialog')[0].close()">X</button>
            <div class="content">
                <fieldset>
                    <legend>Device Type</legend>
                    <div class="checkbox">
                        <label for="laptop">Laptop</label>
                        <input type="checkbox" name="laptop" id="laptop">
                    </div>
                    <div class="checkbox">
                        <label for="desktop">Desktop</label>
                        <input type="checkbox" name="desktop" id="desktop">
                    </div>
                    <div class="checkbox">
                        <label for="tablet">Tablet</label>
                        <input type="checkbox" name="tablet" id="tablet">
                    </div>
                    <div class="checkbox">
                        <label for="phone">Phone</label>
                        <input type="checkbox" name="phone" id="phone">
                    </div>
                    <div class="checkbox">
                        <label for="other">Other</label>
                        <input type="checkbox" name="other" id="other">
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Operating System</legend>
                    <div class="checkbox">
                        <label for="windows">Windows</label>
                        <input type="checkbox" name="windows" id="windows">
                    </div>
                    <div class="checkbox">
                        <label for="macos">MacOS</label>
                        <input type="checkbox" name="macos" id="macos">
                    </div>
                    <div class="checkbox">
                        <label for="linux">Linux</label>
                        <input type="checkbox" name="linux" id="linux">
                    </div>
                    <div class="checkbox">
                        <label for="ios">iOS</label>
                        <input type="checkbox" name="ios" id="ios">
                    </div>
                    <div class="checkbox">
                        <label for="android">Android</label>
                        <input type="checkbox" name="android" id="android">
                    </div>
                    <div class="checkbox">
                        <label for="other">Other</label>
                        <input type="checkbox" name="other" id="other">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Condition</legend>
                    <div class="checkbox">
                        <label for="good">Good</label>
                        <input type="checkbox" name="good" id="good">
                    </div>
                    <div class="checkbox">
                        <label for="fair">Fair</label>
                        <input type="checkbox" name="fair" id="fair">
                    </div>
                    <div class="checkbox">
                        <label for="poor">Poor</label>
                        <input type="checkbox" name="poor" id="poor">
                    </div>
                    <div class="checkbox">
                        <label for="broken">Broken</label>
                        <input type="checkbox" name="broken" id="broken">
                    </div>
                </fieldset>

                <!-- Location -->
                <fieldset>
                    <legend>Location</legend>
                    <div class="checkbox">
                        <label for="portland">Portland</label>
                        <input type="checkbox" name="portland" id="portland">
                    </div>
                    <div class="checkbox">
                        <label for="biddeford">Biddeford</label>
                        <input type="checkbox" name="biddeford" id="biddeford">
                    </div>
                    <div class="checkbox">
                        <label for="lewiston">Lewiston</label>
                        <input type="checkbox" name="lewiston" id="lewiston">
                    </div>
                    <div class="checkbox">
                        <label for="waterville">Waterville</label>
                        <input type="checkbox" name="waterville" id="waterville">
                    </div>
                    <div class="checkbox">
                        <label for="bangor">Bangor</label>
                        <input type="checkbox" name="bangor" id="bangor">
                    </div>
                    <div class="checkbox">
                        <label for="presqueisle">Presque Isle</label>
                        <input type="checkbox" name="presqueisle" id="presqueisle">
                    </div>
                    <div class="checkbox">
                        <label for="scarborough">Scarborough</label>
                        <input type="checkbox" name="scarborough" id="scarborough">
                    </div>
                    <div class="checkbox">
                        <label for="sanford">Sanford</label>
                        <input type="checkbox" name="sanford" id="sanford">
                    </div>
                    <div class="checkbox">
                        <label for="gray">Gray</label>
                        <input type="checkbox" name="gray" id="gray">
                    </div>
                    <div class="checkbox">
                        <label for="gardiner">Gardiner</label>
                        <input type="checkbox" name="gardiner" id="gardiner">
                    </div>
                    <div class="checkbox">
                        <label for="belfast">Belfast</label>
                        <input type="checkbox" name="belfast" id="belfast">
                    </div>
                    <div class="checkbox">
                        <label for="ellsworth">Ellsworth</label>
                        <input type="checkbox" name="ellsworth" id="ellsworth">
                    </div>
                </fieldset>

            </div>
        </summary>
    </dialog>

    <script src="./assets/js/computers.js"></script>
    <script src="./assets/js/database.js"></script>
    
    <script src="/assets/js/inputs.min.js"></script>

    <script>
        startLoading();
    </script>

    <script type="module" src="/assets/js/auth.js"></script>

</body>

</html>