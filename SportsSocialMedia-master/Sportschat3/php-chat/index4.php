<?php
session_start();
include '../connection.php';
if(isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
    $get_user = $con->query("SELECT * FROM users WHERE user_name = '$user'");
    $user_data = $get_user->fetch_assoc();
}
?>
<html>
<head>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font: 1em "Fira Sans", sans-serif;
            background-color: #303030;
        }
        .topnav {
            position: relative;
            overflow: hidden;
            background-color: #333;
        }


        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav-center a {
            float: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .topnav-right {
            float: right;
        }
        .container {
            text-align: center;
        }
        .container button{
            background-color: #717171;
            border: 1px solid black;
            color: white;
            padding: 10px 24px;
            cursor: pointer;
        }

        .container button:hover{
            background-color: #333333;
        }

        button {
            display: inline-block;
        }

        body{font-family:calibri;}
        .error {color:#FF0000;}
        .chat-connection-ack{color: #26af26;}
        .chat-message {border-bottom-left-radius: 4px;border-bottom-right-radius: 4px;
        }
        #btnSend {background: #26af26;border: #26af26 1px solid;	border-radius: 4px;color: #FFF;display: block;margin: 15px 0px;padding: 10px 50px;cursor: pointer;
        }
        #chat-box {background: #ffffff;border: 1px solid #eff0f0;border-radius: 4px;border-bottom-left-radius:0px;border-bottom-right-radius: 0px;min-height: 300px;padding: 10px; height: 40%; overflow-y: scroll;
        }
        .chat-box-html{color: #013369;margin: 10px 0px;font-size:0.8em;}
        .chat-box-message{color: #013369;padding: 5px 10px; background-color: #fff;border: 1px solid #eff0f0;border-radius:4px;display:inline-block;}
        .chat-input{border: 1px solid #eff0f0;border-top: 0px;width: 100%;box-sizing: border-box;padding: 10px 8px;color: #191919;
        }
    </style>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script>

        function showMessage(messageHTML) {
            $('#chat-box').append(messageHTML);
        }

        $(document).ready(function(){
            var websocket = new WebSocket("ws://localhost:8090/demo/php-socket.php");
            websocket.onopen = function(event) {
                showMessage("<div class='chat-connection-ack'>Connection is established!</div>");
            }
            websocket.onmessage = function(event) {
                var Data = JSON.parse(event.data);
                //He also added this if statement so that the message only sends if the room number the user is on is == 2
                if(Data.roomNumber ==4)
                {
                    showMessage("<div class='" + Data.message_type + "'>" + Data.message + "</div>");
                    $('#chat-message').val('');
                }
            };

            websocket.onerror = function(event){
                showMessage("<div class='error'>Problem due to some Error</div>");
            };
            websocket.onclose = function(event){
                showMessage("<div class='chat-connection-ack'>Connection Closed</div>");
            };

            $('#frmChat').on("submit",function(event){
                event.preventDefault();
                $('#chat-user').attr("type","hidden");
                var messageJSON = {
                    //He added roomNumber as a variable on here
                    roomNumber:4,
                    chat_user: $('#chat-user').val(),
                    chat_message: $('#chat-message').val()
                };
                websocket.send(JSON.stringify(messageJSON));
            });
        });
        //This is where I added the autoscroll js
        $(document).ready(function(){

            var autoScroll = true;

            $("#chat-box").eq(0).scroll(function() {
                if ($('#chat-box')[0].scrollTop < $("#chat-box")[0].scrollHeight - $('#chat-box').eq(0).height() - 50) autoScroll = false;
                else autoScroll = true;

                $("#autoScrollDiv").html((autoScroll ? "true" : "false"));
            });

            setInterval(function(){
                if (autoScroll) {
                    $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                }
            }, 100);
        });

    </script>
</head>
<body>
<div class="topnav">
    <a href="../home.php">Home</a>
    <?php
    echo '<a href="../search_user.php">Search User</a>';
    ?>
    <div class="topnav-right">
        <?php
        echo '<a href="../profile.php">Profile</a>';
        ?>
        <?php
        echo '<a href="../logout.php">Log out</a>';
        ?>
    </div>
</div>
<div style="margin-left:15%; margin-right:15%; background-color:#eff0f0; height: 100%;">
    <br>
    <br>
    <div class="container">
        <h3 style="text-align:center">Available Chatrooms</h3>
        <button onclick="window.location.href = 'http://localhost/SportsSocialMedia-master/Sportschat3/php-chat/index.php';">General</button>
        <button onclick="window.location.href = 'http://localhost/SportsSocialMedia-master/Sportschat3/php-chat/index2.php';">We Talk A lot</button>
        <button onclick="window.location.href = 'http://localhost/SportsSocialMedia-master/Sportschat3/php-chat/index6.php';">Fantasy Football</button>
        <button onclick="window.location.href = 'http://localhost/SportsSocialMedia-master/Sportschat3/php-chat/index4.php';">Night Owls</button>
        <button onclick="window.location.href = 'http://localhost/SportsSocialMedia-master/Sportschat3/php-chat/index5.php';">Not too Civil</button>

    </div>

    <h1 style="text-align: center">Night Owl</h1>
    <p style="text-align: center">Is it 2am? Yup, I'm awake and have nothing to do too.</p>


    <div style="padding-left: 20%; padding-right: 20%">
        <form name="frmChat" id="frmChat">
            <div id="chat-box"></div>
            <input type="text" name="chat-user" id="chat-user" placeholder="Name" value="<?php echo $user_data['user_name'] ?>" class="chat-input" disabled />
            <a><?php echo $user_data['user_name'] ?>:<input type="text" name="chat-message" id="chat-message" placeholder="Message"  class="chat-input chat-message" required /></a>
            <input type="submit" id="btnSend" name="send-chat-message" value="Send" >
        </form>
    </div>
</div>
</body>
</html>