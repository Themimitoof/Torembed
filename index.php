<?php

// Relay recognition
$finger = $_GET['key'];

// Show informations
$ip = $_GET['ip'];
$fingerprint = $_GET['fingerprint'];
$country = $_GET['country'];
$as_info = $_GET['as_info'];
$hostname = $_GET['hostname'];
$platform = $_GET['platform'];
$contact = $_GET['contact'];

// Customisation collors
$head_color = $_GET['head_color'];

// Creating array with all informations
$data = Array();

if($ip == 1)
    $data['ip'] = 1;

if($fingerprint == 1)
    $data['fingerprint'] = 1;

if($country == 1)
    $data['country'] = 1;

if($as_info == 1)
    $data['as_info'] = 1;

if($hostname == 1)
    $data['hostname'] = 1;

if($platform == 1)
    $data['platform'] = 1;

if($contact == 1)
    $data['contact'] = 1;

if(!empty($head_color))
    $data['head_color'] = $head_color;
else
    $data['head_color'] = "#4971ff";

$api_data = json_encode(file_get_contents("https://onionoo.torproject.org/details?fingerprint=" + $finger));

var_dump($api_data);
if($api_data == true) {
    ?>
    <html>
        <head>
            <title>Totor-embed</title>
            <meta charset="utf-8" />
            <link rel="stylesheet" href="static/css/torembed.css">
        </head>
        <body>
            <div class="panel">
                <div class="panel title">
                    Tor Relay : <?= $api_data["relays"][0]["nickname"] ?></div>
                <div class="panel content">
                    <p><b>IP address: </b> 10.10.0.0</p>
                    <p><b>Status: </b> <span class="online"></span></p>
                    <p><b>Uptime: </b> 12 days 4 hours</p>
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
                    </a> <i class="icon-folder"></i> I U U</p>
                    <p><b>Fingerprint: </b> 12 days 4 hours</p>
                    <p><b>Country: </b> 12 days 4 hours</p>
                    <p><b>AS Name/AS Number: </b> 12 days 4 hours</p>
                    <p><b>Host name: </b> 12 days 4 hours</p>
                    <p><b>Platform: </b> 12 days 4 hours</p>
                    <p><b>Contact: </b> 12 days 4 hours</p>

                </div>
            </div>
        </body>
    </html>
    <?php
}
