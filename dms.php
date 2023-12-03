<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>DProx WebCord</title>
<script>
function disSend(t, c, m){
document.getElementById('mess').value = '';

// Token is not used since it is hard coded into the webserver
fetch("dproxy/messages.php", {
    body: "send=true&id="+c+"&content="+encodeURIComponent(m),
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    },
    method: "post",
});
setTimeout(function(){disUpdate(document.getElementById('token').value, getChannel(), '50')}, 2000);
}

function disLoad(t, v){

    document.getElementById('messages').innerHTML = '';
    // All getting of channels is done by channels.php
fetch("dproxy/channels.php", {
    body: null,
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    },
    method: "get",
}).then((response) => { return response.json(); }).then((data) => {
    // Do stuff with data like this
    for(let i=0; i < data.length; i++){
        var sel = document.getElementById('ids_dm');
        var opt = document.createElement('option');

        opt.appendChild( document.createTextNode(data[i].recipients[0].username) );

        opt.value = data[i].id; 

        sel.appendChild(opt); 
    }
});

// fetch('https://discord.com/api/v9/users/@me/channels', {"credentials":"include","headers":{"accept":"*/*","accept-language":"en-US","authorization": t},"referrer":"https://discordapp.com/api/v9/","referrerPolicy":"no-referrer-when-downgrade","method":"GET","mode":"cors"}).then((response) => {     return response.json();   })   .then((data) => { 
/*    for(let i=0; i < data.length; i++){
        var sel = document.getElementById('ids_dm');
        var opt = document.createElement('option');

        opt.appendChild( document.createTextNode(data[i].recipients[0].username) );

        opt.value = data[i].id; 

        sel.appendChild(opt); 
    }
})
*/
// Hello constant refresh!
window.constantRefresh = setInterval(function(){ document.getElementById('messages').innerHTML = ''; disUpdate(document.getElementById('token').value, getChannel(), '100'); }, 4000);

}

function disUpdate(t, c, v) {

    //document.getElementById('messages').innerHTML = '';
    fetch('dproxy/messages.php', {
        body: "id="+c,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        method: "post"
    }).then((response) => {     return response.json();   }).then((data) => {
        i = 0; for(let i = 0 ; i < data.length; i++){  
            if(data[i].attachments == ''){
                document.getElementById('messages').innerHTML += "<b>" + data[i].author.username + "</b> " + data[i].content + '<br>';
            } else if(data[i].attachments[0].filename.split('.')[1] == ".png" || data[i].attachments[0].filename.split('.')[1] == ".jpg" || data[i].attachments[0].filename.split('.')[1] == ".gif" || data[i].attachments[0].filename.split('.')[1] == ".webp"){
                document.getElementById('messages').innerHTML += "<b>" + data[i].author.username + "</b> " + data[i].content + '<br>' + '<img src="' + data[i].attachments[0].url + '" alt="Download \'' + data[i].attachments[0].filename + '\'" /><br>'; 
            } else {
                document.getElementById('messages').innerHTML += "<b>" + data[i].author.username + "</b> " + data[i].content + ` Attachement: <a href="${data[i].attachments[0].url}" />` + `Download ${data[i].attachments[0].filename}` + '</a><br>';  
            }
        } 
    });

}



function getChannel(){
    var e = document.getElementById("ids_dm");
    return e.options[e.selectedIndex].value;
}    



function keyD(event){
if(event.keyCode == 13){
disSend(document.getElementById('token').value, getChannel(), document.getElementById('mess').value);
}
}
</script>

<style>

    input {
      border-width: 0px;
      border-radius: 0px;
    }

    /*
    button {
      border: 0;
      border-radius: 0px;
      background-color: white;
    }

    button:hover {
      background-color: lightgray;
    }
    */

    .tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  top: 150%;
  left: 50%;
  margin-left: -60px;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  bottom: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent transparent black transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}

.emoji-picker {
  z-index: 999;
}

@import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

* {
  font-family: 'Open Sans', sans-serif;
  font-size: 14px;
}

#layer1 {
	background-color: #292B2F !important;
}

#messages {
	background-color: #36393F !important;
	color: #ffffff !important;
}

#layer4 {
	background-color: #36393F !important;
	color: #ffffff !important;
}

input {
	background-color: #40444B !important;
	color: #ffffff !important;
}

body {
	background-color: #36393F !important;
	color: #ffffff !important;
}
</style>

</head>

<body>

<div style="position: absolute; width: 1007px; height: 469px; z-index: 1; left: 6px; top: 15px; color: #ffffff; background-color: #000000;" id="layer1">
<i style="margin-left: 10px;"></i> <img src="res/logo.png" width="100" height="32"><br>
<i style="margin-left: 10px;"></i> <input type="password" id="token" placeholder="Put your token here" size="42"></input> 
<i style="margin-left: 10px;"></i> <button onclick="disLoad(document.getElementById('token').value, '50')">Load all DMs!</button>

<label for="ids_dm">Pick DM</label>

<select id="ids_dm" onchange="for (var i = 1; i < 3; i++){window.clearInterval(i)}; disUpdate(document.getElementById('token').value, getChannel(), '50'); document.getElementById('messages').innerHTML = '';">
    <option value="test">--Select Option--</option>
</select> 

<div style="position: absolute; width: 975px; height: 350px; z-index: 2; left: 14px; top: 68px; color: #000000; background-color: #ffffff; padding: 5px; overflow-y: scroll; overflow-x: scroll;" id="messages">

<b>undefined</b> this is what your messages will look like</div>

<div style="position: absolute; width: 982px; height: 38px; z-index: 3; left: 10px; top: 432px" id="layer2">
<input id="mess" placeholder="Send message to Undefined" onkeypress="keyD(event)" size="130"></input>&nbsp;<button onclick="disSend(document.getElementById('token').value, getChannel(), document.getElementById('mess').value);" class="tooltip"><i class="fas fa-arrow-right"></i> Send</i></button>
<button id="emoji-button" class="tooltip"><i class="fas fa-smile"></i><span class="tooltiptext">Insert a emoji</span></button>
<button onclick="upload()" class="tooltip"><i class="fas fa-upload"></i><span class="tooltiptext">Upload a file</span></button>
</div>

<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@2.12.1/dist/index.min.js"></script>

<script>
const button = document.querySelector('#emoji-button');
  const picker = new EmojiButton();

  picker.on('emoji', emoji => {
    document.querySelector('#mess').value += emoji;
  });

  button.addEventListener('click', () => {
    picker.pickerVisible ? picker.hidePicker() : picker.showPicker(button);
  });

</script>

</body>

</html>
