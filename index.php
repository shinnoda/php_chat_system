<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="style.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>
<body>


    <div id="wrapper">
        <h1>Welcome <?php session_start(); echo $_SESSION['username']; ?> to my website</h1>

        <div class="chat_wrapper">

            <div id="chat"></div>

            <form method="POST" id="messageForm">
                <textarea name="message" cols="30" rows="7" class="textarea"></textarea>
            </form>

        </div>

    </div>

    <script>

        LoadChat();

        setInterval(function() {
            LoadChat();
        }, 1000);

        function LoadChat() {
            $.post('handlers/messages.php?action=getMessages', function(response) {

                var scrollpos = $('#chat').scrollTop();
                var scrollpos = parseInt(scrollpos) + 520;
                var scrollHeight = $('#chat').prop('scrollHeight');

                $('#chat').html(response);

                if (scrollpos < scrollHeight) {
                    // Do not do anything
                } else {
                    $('#chat').scrollTop($('#chat').prop('scrollHeight'));
                }
            });
        }

        $('.textarea').keyup(function(e){
            // ASCII code for the Enter key is 13
            if (e.which == 13) {
                $('form').submit();
            }
        });

        $('form').submit(function() {

            var message = $('.textarea').val();
            
            $.post('handlers/messages.php?action=sendMessage&message='+message, function(
                response) {
                    
                    if (response == 1) {
                        LoadChat();
                        document.getElementById('messageForm').reset();
                    }
                });

            return false;
        });

    </script>

</body>
</html>