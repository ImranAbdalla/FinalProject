<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .chat-container { max-width: 600px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; }
        .messages { height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px; }
        .message { margin: 5px 0; }
        .mentor { color: blue; }
        .student { color: green; }
    </style>
</head>
<body>

<div class="chat-container">
    <h2>Chat Room</h2>
    <div class="messages" id="messages"></div>
    <input type="text" id="messageInput" placeholder="Type your message..." />
    <button id="sendButton">Send</button>
    <button id="clearChatButton">Clear Chat</button>
    <input type="hidden" id="appointment_id" value="1"> <!-- Set the appointment ID here -->
    <input type="hidden" id="user_type" value="<?php echo $_SESSION['user_type']; ?>"> <!-- User type from session -->
</div>

<script>
    const messagesContainer = document.getElementById('messages');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const appointmentId = document.getElementById('appointment_id').value;
    const userType = document.getElementById('user_type').value; // Get user type from session

    // Function to load messages
    function loadMessages() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'load_messages.php?appointment_id=' + appointmentId, true);
        xhr.onload = function() {
            if (this.status === 200) {
                messagesContainer.innerHTML = this.responseText;
                messagesContainer.scrollTop = messagesContainer.scrollHeight; // Scroll to the bottom
            }
        }
        xhr.send();
    }

    // Send message on button click
    sendButton.onclick = function() {
        const message = messageInput.value.trim();
        if (message === '') {
            alert("Please enter a message.");
            return; // Don't send empty messages
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_message.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status === 200) {
                messageInput.value = ''; // Clear the input
                loadMessages(); // Reload messages
            } else {
                alert("Failed to send message.");
            }
        }
        xhr.send('message=' + encodeURIComponent(message) + '&user=' + userType + '&appointment_id=' + encodeURIComponent(appointmentId));
    }

    // Load messages every 2 seconds
    setInterval(loadMessages, 2000);
    loadMessages(); // Initial load

    // Clear chat functionality
    document.getElementById('clearChatButton').onclick = function() {
        if (confirm("Are you sure you want to clear the chat?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'clear_chat.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    alert(this.responseText); // Show feedback
                    loadMessages(); // Reload messages
                } else {
                    alert("Failed to clear chat.");
                }
            }
            xhr.send('appointment_id=' + encodeURIComponent(appointmentId));
        }
    }
</script>

</body>
</html>
