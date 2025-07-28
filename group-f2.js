document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const btnJoin = document.querySelector('.btn-join');
    const btnCreate = document.querySelector('.btn-create');

    // Sample messages for demonstration
    const sampleMessages = [
        { sender: 'John', mbti: 'ENFP', message: 'Hello everyone!', time: '10:00 AM' },
        { sender: 'Sarah', mbti: 'INTJ', message: 'Hi John, how are you?', time: '10:22 AM' },
        { sender: 'Mike', mbti: 'ESFJ', message: 'Good morning team!', time: '10:36 AM' }
    ];

    // Clear existing messages
    chatMessages.innerHTML = '';

    // Display sample messages
    function displaySampleMessages() {
        sampleMessages.forEach(msg => {
            addMessageToChat(msg.sender, msg.mbti, msg.message, msg.time);
        });
    }

    // Add message to chat
    function addMessageToChat(sender, mbti, message, time) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message');
        
        messageElement.innerHTML = `
            <div class="message-header">
                <span class="sender">${sender} (${mbti})</span>
                <span class="time">${time}</span>
            </div>
            <div class="message-content">${message}</div>
        `;
        
        chatMessages.appendChild(messageElement);
        
        // Clear floats after adding messages
        const clearDiv = document.createElement('div');
        clearDiv.style.clear = 'both';
        chatMessages.appendChild(clearDiv);
        
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Send message function
    function sendMessage() {
        const message = messageInput.value.trim();
        if (message) {
            // In a real app, you would send this to a server
            // For now, we'll just add it to the chat
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const formattedHours = hours % 12 || 12; // Convert to 12-hour format
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const time = `${formattedHours}:${minutes < 10 ? '0' : ''}${minutes} ${ampm}`;
            
            // Assuming current user is John with ENFP
            addMessageToChat('John', 'ENFP', message, time);
            
            // Clear input
            messageInput.value = '';
        }
    }

    // Event listeners
    sendButton.addEventListener('click', sendMessage);
    
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    btnJoin.addEventListener('click', function() {
        window.location.href = 'joingroup.html';
    });

    btnCreate.addEventListener('click', function() {
        window.location.href = 'create_group.html';
    });

    // Add animation effects
    function addAnimationEffects() {
        // Animate sidebar items on hover
        const sidebarItems = document.querySelectorAll('#sidebar .sidebar-menu li a');
        sidebarItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.3s ease';
                this.style.transform = 'translateX(5px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
        
        // Animate send button
        sendButton.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
            this.style.transform = 'rotate(15deg)';
        });
        
        sendButton.addEventListener('mouseleave', function() {
            this.style.transform = 'rotate(0)';
        });
    }

    // Initialize
    displaySampleMessages();
    addAnimationEffects();
});