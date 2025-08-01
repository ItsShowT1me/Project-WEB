$(function(){
    function loadMessages() {
        var group_id = $('input[name="group_id"]').val();
        $.get('fetch_messages.php?group_id=' + group_id, function(data) {
            $('#chat-box').html('');
            data.forEach(function(msg) {
                $('#chat-box').append(
                    `<div class="chat-message">
                        <span class="chat-user">${msg.user_name} (${msg.mbti})</span>
                        <span class="chat-time">${msg.created_at}</span><br>
                        ${msg.message}
                    </div>`
                );
            });
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        }, 'json');
    }
    $('#chat-form').submit(function(e){
        e.preventDefault();
        $.post('send_message.php', $(this).serialize(), function(){
            loadMessages();
            $('#chat-form input[name="message"]').val('');
        });
    });
    setInterval(loadMessages, 2000);
    loadMessages();
});