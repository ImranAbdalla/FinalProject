<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Popup</title>
    <style>
        /* Chatbot button */
        .chatbot-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 20px;
            cursor: pointer;
        }

        /* Chatbot window */
        .chatbot-popup {
            display: none;
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 300px;
            height: 400px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            z-index: 9999;
        }

        /* Chatbot header */
        .chatbot-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        /* Chatbot body */
        .chatbot-body {
            height: 300px;
            overflow-y: auto;
            padding: 10px;
            font-size: 14px;
        }

        /* Chatbot input */
        .chatbot-input {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        /* Input field */
        .chatbot-input input {
            width: 80%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Send button */
        .chatbot-input button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
    <script>
        function toggleChatbot() {
            var chatbotPopup = document.getElementById('chatbot-popup');
            if (chatbotPopup.style.display === 'none' || chatbotPopup.style.display === '') {
                chatbotPopup.style.display = 'block';
            } else {
                chatbotPopup.style.display = 'none';
            }
        }

        function sendMessage() {
            var message = document.getElementById('message').value;
            var responseDiv = document.getElementById('chatbot-body');

            if (message.trim() === '') {
                return;
            }

            // Add the user's message to the chat
            var userMessageDiv = document.createElement('div');
            userMessageDiv.innerHTML = `<strong>You:</strong> ${message}`;
            responseDiv.appendChild(userMessageDiv);

            // Create an AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../chatbot.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var botMessageDiv = document.createElement('div');
                    botMessageDiv.innerHTML = `<strong>Bot:</strong> ${response.response}`;
                    responseDiv.appendChild(botMessageDiv);
                    responseDiv.scrollTop = responseDiv.scrollHeight; // Scroll to the bottom of the chat
                }
            };

            // Send the message to the PHP script
            xhr.send('message=' + encodeURIComponent(message));
            document.getElementById('message').value = ''; // Clear input field
        }
    </script>
</head>
<body>

    <!-- Chatbot button -->
    <button class="chatbot-button" onclick="toggleChatbot()">💬</button>

    <!-- Chatbot popup -->
    <div id="chatbot-popup" class="chatbot-popup">
        <div class="chatbot-header">
            ChatBot
        </div>
        <div id="chatbot-body" class="chatbot-body">
            <!-- Chatbot conversation will appear here -->
        </div>
        <div class="chatbot-input">
            <input type="text" id="message" placeholder="Type a message..." />
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

</body>
</html>
