<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav>
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/orders') }}">Cart</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/chat') }}">Chat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/chatDriver') }}">ChatDriver</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <div class="row border">
            <div class="col-12 border">
                <div id="chat-messages" class="border py-1"></div>
            </div>
            <div class="col-12 border">
                <div class="input-group input-group-sm mb-3">
                    <input type="text" id="message-input" class="form-control" placeholder="Type your message...">
                    <button id="send-btn" class="btn btn-primary btn-sm ml-2" type="button">Send</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Initialize Firebase
        var firebaseConfig = {
            apiKey: "AIzaSyBJK-ziJOe-oMgSkjI5MJK16OO0LjQDMQQ",
            authDomain: "tester-6b415.firebaseapp.com",
            databaseURL: "https://tester-6b415-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "tester-6b415",
            storageBucket: "tester-6b415.appspot.com",
            messagingSenderId: "829911681243",
            appId: "1:829911681243:web:f6e4657da628304752e4fe",
            measurementId: "G-7PCGVXL2MX"
        };
        firebase.initializeApp(firebaseConfig);

        // Get a reference to the Firebase database
        var database = firebase.database();

        // Function to send a message
        function sendMessage(message) {
            var timestamp = new Date().toISOString(); // Get current UTC timestamp
            database.ref('messages').push().set({
                sender: 'driver',
                message: message,
                timestamp: timestamp
            });
        }

        // Function to display messages
        function displayMessage(sender, message, timestamp) {
            // Create a container div for the message and sender information
            var containerDiv = $('<div>');

            // Create a paragraph or div for the sender
            var senderDiv = $('<p>').text(sender).addClass('mb-0');

            var date = new Date(timestamp);
            var hours = date.getHours().toString().padStart(2, '0');
            var minutes = date.getMinutes().toString().padStart(2, '0');
            // Create a paragraph or div for the message and timestamp
            var messageDiv = $('<p>').text(message + ' (' + hours + ':' + minutes + ')');

            // Append the sender and message to the container div
            containerDiv.append(senderDiv, messageDiv);

            // If the sender is the driver, align the container div to the right
            if (sender === 'driver') {
                containerDiv.addClass('text-end');
            }

            // Append the container div to the chat messages
            $('#chat-messages').append(containerDiv);
        }

        database.ref('messages').on('child_removed', function(snapshot) {
            // This function will be called whenever a child is removed from the 'messages' node

            // Retrieve the key of the removed message
            var messageId = snapshot.key;

            // Remove the corresponding message from the UI
            removeMessage(messageId);
        });

        // Listen for new messages
        database.ref('messages').on('child_added', function(snapshot) {
            var messageData = snapshot.val();
            var sender = messageData.sender;
            var message = messageData.message;
            var timestamp = messageData.timestamp;
            displayMessage(sender, message, timestamp);
        });

        // Send message when Send button is clicked
        $('#send-btn').click(function() {
            var message = $('#message-input').val().trim();
            if (message !== '') {
                sendMessage(message);
                $('#message-input').val('');
            }
        });
    </script>
</body>

</html>