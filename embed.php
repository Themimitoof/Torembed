<?php
/*
 * Torembed : Embed your Tor relay informations on your website!
 * Author: Michael Vieira (@Themimitoof) <contact@mvieira.fr>
 * Version: 1.0
 *
 * --------------------------------------------------------------------------------
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2016 Michael Vieira
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */


error_reporting(0); // Disable any errors

/*
    Variables
*/
$fingerprint = $_GET['fingerprint']; // Get the fingerprint of the relay to get informations from Tor API

// GET Variables with display options
$ip = $_GET['ip']; // Show IP Address
$country = $_GET['country']; // Show the country
$as_info = $_GET['as_info']; // Show the ISP informations with the Autonomous System informations (Name and ASN)
$hostname = $_GET['hostname']; // Show the reverse of the server
$platform = $_GET['platform']; // Show Tor platform
$contact = $_GET['contact']; // Show contact informations

// Colors cutomisations
$head_color = $_GET['head_color'];


// Creating array with all informations
$data = Array();

if($ip == 1 || $ip == true)
    $data['ip'] = 1;

if($country == 1 || $country == true)
    $data['country'] = 1;

if($as_info == 1 || $as_info == true)
    $data['as_info'] = 1;

if($hostname == 1 || $hostname == true)
    $data['hostname'] = 1;

if($platform == 1 || $platform == true)
    $data['platform'] = 1;

if($contact == 1 || $contact == true)
    $data['contact'] = 1;

if(!empty($head_color))
    $data['head_color'] = $head_color;
else
    $data['head_color'] = "#4971ff";


// Call the Tor API
$api_data = json_decode(file_get_contents("https://onionoo.torproject.org/details?fingerprint=" . $fingerprint), true);


/*
    Show informations
*/
if($api_data == true) {
    ?>
    <html>
        <head>
            <title>Totor-embed</title>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="static/css/torembed.css">
            <style>
                .panel.title {background-color: #<?= $head_color; ?>}
            </style>
        </head>
        <body>
            <div class="panel">
                <div class="panel title">
                    Tor Relay: <i><?= $api_data["relays"][0]["nickname"] ?></i></div>
                <div class="panel content">
                    <?php
                        if($data["ip"] == 1) {
                            ?>
                                <p><b>IP address: </b> <?= $api_data["relays"][0]["or_addresses"][0]; ?></p>
                            <?php
                        }
                    ?>

                    <p><b>Status: </b> <?php
                        if($api_data["relays"][0]["running"] == true)
                            echo "<span class=\"online\"></span>";
                        else
                            echo "<span class=\"offline\"></span>";
                    ?></p>
                    <p id="uptime"><b>Uptime: </b></p>
                    <p><a class="tooltip">
                        <b style="border-bottom: 1px dotted #000;">Flags: </b>
                        <span>
                            Flags icons: <br>
                            <i class="icon-ok"></i> Valid relay <br>
                            <i class="icon-shield"></i> Guard-relay <br>
                            <i class="icon-export"></i> Exit relay <br>
                            <i class="icon-rocket"></i> Fast relay <br>
                            <i class="icon-link"></i> Stable relay <br>
                            <i class="icon-plug"></i> Running relay <br>
                            <i class="icon-book"></i> HSDir <br>
                            <i class="icon-folder"></i> V2Dir <br>
                            <i class="icon-shuffle"></i> BadExit <br>
                            <i class="icon-folder-open"></i> BadDirectory <br>
                            <i class="icon-building"></i> Authority relay <br>

                        </span>
                    </a> <?php
                        foreach ($api_data["relays"][0]["flags"] as $value) {
                            switch($value) {
                                case "Valid":
                                    echo "<i class=\"icon-ok\"></i> ". $value ." ";
                                    break;

                                case "Guard":
                                    echo "<i class=\"icon-shield\"></i> ". $value ." ";
                                    break;

                                case "Exit":
                                    echo "<i class=\"icon-export\"></i> ". $value ." ";
                                    break;

                                case "Fast":
                                    echo "<i class=\"icon-rocket\"></i> ". $value ." ";
                                    break;

                                case "Stable":
                                    echo "<i class=\"icon-link\"></i> ". $value ." ";
                                    break;

                                case "Running":
                                    echo "<i class=\"icon-plug\"></i> ". $value ." ";
                                    break;

                                case "HSDir":
                                    echo "<i class=\"icon-book\"></i> ". $value ." ";
                                    break;

                                case "V2Dir":
                                    echo "<i class=\"icon-folder\"></i> ". $value ." ";
                                    break;

                                case "BadExit":
                                    echo "<i class=\"icon-shuffle\"></i> ". $value ." ";
                                    break;

                                case "BadDirectory":
                                    echo "<i class=\"icon-folder-open\"></i> ". $value ." ";
                                    break;

                                case "Authority":
                                    echo "<i class=\"icon-building\"></i> ". $value ." ";
                                    break;
                            };
                        }
                    ?></p>
                    <p><b>Fingerprint: </b> <span id="fingerprint"><?= $api_data["relays"][0]["fingerprint"]; ?></span></p>
                    <?php
                        if($data["country"] == 1) {
                            ?>
                                <p><b>Country: </b> <?= $api_data["relays"][0]["country_name"]; ?></p>
                            <?php
                        }
                    ?>

                    <?php
                        if($data["as_info"] == 1) {
                            ?>
                                <p><b>AS Name/AS Number: </b> <?= $api_data["relays"][0]["as_name"]." / ".$api_data["relays"][0]["as_number"]; ?></p>
                            <?php
                        }
                    ?>

                    <?php
                        if($data["hostname"] == 1) {
                            ?>
                                <p><b>Host name: </b> <?= $api_data["relays"][0]["host_name"]; ?></p>
                            <?php
                        }
                    ?>

                    <?php
                        if($data["platform"] == 1) {
                            ?>
                                <p><b>Platform: </b> <?= $api_data["relays"][0]["platform"]; ?></p>
                            <?php
                        }
                    ?>

                    <?php
                        if($data["contact"] == 1) {
                            ?>
                                <p><b>Contact: </b> <?= $api_data["relays"][0]["contact"]; ?></p>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <p class="footer">Generated with <b><a href="https://torembed.themimitoof.fr" target="_blank">Torembed</a></b></p>
            <script src="static/js/moment.min.js"></script>
            <script type="text/javascript">
                // Parse uptime
                var uptime = "<?= $api_data["relays"][0]["last_restarted"]; ?>".split(" ")
                document.getElementById('uptime').innerHTML = "<b>Uptime:</b> " + moment(uptime[0]).fromNow(true) + " " + moment(uptime[1], "HH:mm:ss").fromNow(true)
            </script>
        </body>
    </html>
    <?php
} else {
    echo "{\"code\": 403, \"message\": \"An error is occured with your request. Please check the fingerprint ('key' variable).\"}";
}
