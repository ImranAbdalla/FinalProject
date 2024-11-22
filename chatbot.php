<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user's input
    $userMessage = strtolower(trim($_POST['message']));

    // Extensive responses for mental health chatbot
    $responses = [
        // General Greetings
        'hello' => 'Hello! I’m here to listen. How are you feeling today?',
        'hi' => 'Hi! I’m here for you. What’s on your mind?',
        'hey' => 'Hey! I’m glad you reached out. How can I help?',
        'good morning' => 'Good morning! How has your day been so far?',
        'good evening' => 'Good evening! How are you feeling tonight?',
        
        // Self-reflective prompts
        'i feel sad' => 'I’m sorry to hear that. Do you want to share more about what’s causing this sadness?',
        'i feel down' => 'It’s okay to feel down sometimes. Is there something specific on your mind?',
        
        // Anxiety and stress responses
        'i feel anxious' => 'Anxiety can feel overwhelming. Let’s take a moment to breathe deeply. Would you like to discuss what’s causing this feeling?',
        'i am stressed' => 'I hear you. Stress can build up quickly. Sometimes, taking things one step at a time can help. Do you want to talk about what’s on your plate right now?',
        'how do i calm down' => 'Let’s try a grounding exercise: Look around you and name five things you can see, four things you can touch, three things you can hear, two things you can smell, and one thing you can taste. How are you feeling after trying that?',
        
        // Coping and grounding techniques
        'how do i manage stress' => 'Managing stress can involve regular breaks, deep breathing, and self-care routines. Do any of these sound helpful?',
        'how do i relax' => 'Relaxation looks different for everyone. Some find deep breathing, meditation, or light stretching helpful. What do you enjoy doing to unwind?',
        
        // Depression-related scenarios
        'i feel depressed' => 'I’m really sorry you’re feeling this way. It’s tough, but you don’t have to go through it alone. Would it help to share more about what’s on your mind?',
        'i feel empty' => 'I’m here for you. That feeling can be really hard to navigate. What’s been on your mind lately?',
        
        // Encouragement for difficult emotions
        'i feel lonely' => 'Feeling lonely can be challenging. You’re not alone, though, and I’m here to talk whenever you need.',
        'i feel hopeless' => 'I know it can feel like things won’t get better, but with support, things often improve. Would you like to discuss what’s making you feel this way?',
        'i feel overwhelmed' => 'That’s understandable. It’s okay to take things one step at a time. What’s weighing on you the most right now?',
        
        // Self-doubt and motivation
        'i feel like a failure' => 'I’m sorry you’re feeling this way. Remember, setbacks don’t define you. Can you tell me what’s led you to feel this way?',
        'i am struggling' => 'Thank you for sharing that. Everyone struggles sometimes, and it’s okay to feel this way. Would you like to talk about what’s going on?',
        'i feel unmotivated' => 'Lack of motivation can be hard to deal with. Have you tried doing small, manageable tasks to get started?',
        
        // Proactive mental health advice
        'how do i improve my mental health' => 'Improving mental health can involve setting small goals, maintaining a balanced routine, staying connected with friends, and engaging in activities that bring joy. Would you like some ideas on specific areas?',
        'what can i do to feel better' => 'Trying out self-care routines, like journaling, spending time outside, or talking with supportive people, can sometimes help. Is there something that usually brings you comfort?',
        
        // Burnout and rejection
        'i feel burned out' => 'Burnout can be exhausting. It’s important to take breaks and give yourself permission to rest. Are there any small ways you can reduce your workload?',
        'i feel rejected' => 'Rejection can be painful, and it’s okay to feel hurt by it. Is there a specific situation that’s been on your mind?',
        
        // Fear and insecurity
        'i feel scared' => 'It’s okay to feel scared. Sometimes, sharing our fears makes them feel more manageable. Would you like to talk about what’s worrying you?',
        'i feel insecure' => 'Insecurities are natural and affect everyone at times. Is there a specific aspect of this feeling that you’d like to explore?',
        
        // Positive reinforcement and self-esteem
        'i want to feel better' => 'You deserve to feel well. Let’s take things one step at a time. What’s one thing you’d like to improve in your life?',
        'i want to be happy' => 'Happiness is a journey, and it’s okay to take small steps toward it. What brings you joy or a sense of peace?',
        
        // Seeking connection
        'i need someone to talk to' => 'I’m here to listen. Take your time and feel free to share what’s on your mind.',
        'i feel disconnected' => 'Feeling disconnected can be challenging. Have you considered reaching out to friends or family, or even just spending time in nature?',
        
        // Self-care and grounding exercises
        'how can i practice self-care' => 'Self-care can involve relaxation, setting boundaries, or simply taking a few moments each day to do something you enjoy. What sounds appealing to you?',
        'what are grounding techniques' => 'Grounding can help bring you back to the present. One simple method is the 5-4-3-2-1 exercise: Name five things you can see, four you can touch, three you can hear, two you can smell, and one you can taste. Give it a try!',
        
        // Closing statements and gratitude
        'thank you' => 'You’re very welcome! I’m here anytime you need to talk.',
        'goodbye' => 'Goodbye for now. Take care, and remember, I’m here whenever you need to chat.',
        'see you later' => 'See you later! Take care of yourself.',
        
        // Unrecognized input default response
        'default' => "I’m here to listen. Could you tell me a bit more about what’s on your mind?"
    ];

    // Check the user's input for keywords or similar phrases
    $botResponse = $responses['default']; // Set default response first
    foreach ($responses as $key => $response) {
        if (strpos($userMessage, $key) !== false) {
            $botResponse = $response;
            break;
        }
    }

    // Return the response as JSON
    echo json_encode(['response' => $botResponse]);
} else {
    // If the request method is not POST, return an error message
    echo json_encode(['response' => 'Invalid request method.']);
}
?>
