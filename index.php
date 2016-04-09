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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Torembed &mdash; Customisation tool</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
        <link rel="stylesheet" href="static/css/custom-tool-page.css">
        <style media="screen">

        </style>
    </head>
    <body>
        <div class="container">
            <h2>Torembed &mdash; Customisation tool</h2>
            <div class="grid-sm-12 grid-lg-6">
                <h3>Kitchen</h3>
                <form class="pure-form pure-form-aligned" id="kitchen">
                    <fieldset>
                        <div class="pure-control-group">
                            <label for="name">Fingerprint</label>
                            <input id="fingerprint" type="text" placeholder="Fingerprint">
                        </div>

                        <div class="pure-control-group">
                            <label for="name">Header color</label>
                            <input id="head_color" type="text" placeholder="Color in hex">
                        </div>

                        <div class="pure-controls">
                            <label class="pure-checkbox">
                                <input id="ip" type="checkbox" value="ip">
                                Show IP address
                            </label>
                            <label class="pure-checkbox">
                                <input id="country" type="checkbox" value="country">
                                Show country
                            </label>
                            <label class="pure-checkbox">
                                <input id="as_info" type="checkbox" value="as_info">
                                Show ISP informations (AS Name/AS Number)
                            </label>
                            <label class="pure-checkbox">
                                <input id="hostname" type="checkbox" value="hostname">
                                Show the reverse
                            </label>
                            <label class="pure-checkbox">
                                <input id="platform" type="checkbox" value="platform">
                                Show the Tor platform
                            </label>
                            <label class="pure-checkbox">
                                <input id="contact" type="checkbox" value="contact">
                                Show contact informations
                            </label>
                            <input type="button" class="pure-button pure-button-primary" value="Generate" onclick="generate()">
                        </div>
                    </fieldset>
                </form>
            </div><div class="grid-sm-12 grid-lg-6">
                <h3>Preview</h3>
                <iframe src="/torembed/embed.php?head_color=444&ip=1&country=1&as_info=1&hostname=1&contact=1&platform=1&fingerprint=2B0DACBB3FAB6FE2E461D9DCE20D95497D75F2A1" width="100%" height="350px" frameborder="0" allowTransparency="true"></iframe>
                <p>
                    Code:
                </p>

                <form class="pure-form">
                    <div class="pure-control-group">
                        <textarea id="generated_code" type="text" placeholder="Generated core here" style="width:100%; height:100px" readonly>

                        </textarea>
                    </div>
                </form>
            </div>
        </div>
        <script src="static/js/jquery.min.js"></script>
        <script type="text/javascript">
            function generate() {
                    var URI = document.location.protocol + "/" + window.location.host + "/embed.php";
                    console.log(URI)
                    // Check the fingerprint input
                    if($("#fingerprint").val() != "") {
                        URI += "?fingerprint=" + $("#fingerprint").val();

                        // Check checkboxes
                        if($("#ip").is(":checked") == true)
                            URI += "&ip=1";
                        if($("#country").is(":checked") == true)
                            URI += "&country=1";
                        if($("#as_info").is(":checked") == true)
                            URI += "&as_info=1";
                        if($("#hostname").is(":checked") == true)
                            URI += "&hostname=1";
                        if($("#platform").is(":checked") == true)
                            URI += "&platform=1";
                        if($("#contact").is(":checked") == true)
                            URI += "&contact=1";
                        if($("#head_color").val() != "") {
                            if($("#head_color").val()[0] == "#")
                                URI += "&head_color=" + $("#head_color").val().split("#")[1];
                            else
                                URI += "&head_color=" + $("#head_color").val();
                        }

                        // Update iframe
                        $("iframe").attr("src", URI)

                        // Update code textarea
                        $("#generated_code").html("<iframe src=\"" + URI + "\" width=\"100\" height=\"400px\" frameborder=\"0\" allowTransparency=\"true\"></iframe>")
                    } else {
                        alert("You need to add the fingerprint of the Tor relay.")
                    }
            }

            // Color form color changing
            $("#head_color").on("change", function(){
                $("#head_color").css("background-color", $("#head_color").val());
            });
        </script>
    </body>
</html>
