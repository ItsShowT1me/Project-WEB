$(function(){
    function loadMessages() {
        var group_id = $('input[name="group_id"]').val();
        $.get('fetch_messages.php?group_id=' + group_id, function(data) {
            $('#chat-box').html('');
            data.forEach(function(msg) {
                let fileHtml = '';
                if (msg.file_path) {
                    if (/\.(jpg|jpeg|png|gif)$/i.test(msg.file_path)) {
                        fileHtml = `<div><img src="${msg.file_path}" style="max-width:200px;max-height:200px;border-radius:8px;margin-top:8px;"></div>`;
                    } else {
                        let fname = msg.file_path.split('/').pop();
                        fileHtml = `<div><a href="${msg.file_path}" target="_blank">${fname}</a></div>`;
                    }
                }
                $('#chat-box').append(
                    `<div class="chat-message">
                        <div class="chat-header">
                            <span class="chat-user"><b>${msg.user_name}</b> <span class="chat-mbti">(${msg.mbti})</span></span>
                            <span class="chat-time">${formatTime(msg.created_at)}</span>
                        </div>
                        <div class="chat-text">${escapeHtml(msg.message)}</div>
                        ${fileHtml}
                    </div>`
                );
            });
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        }, 'json');
    }
    $('#chat-form').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'send_message.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
                loadMessages();
                $('#chat-form input[name="message"]').val('');
                $('#file-input').val('');
            }
        });
    });
    setInterval(loadMessages, 2000);
    loadMessages();

    // Helper to format time as HH:MM AM/PM
    function formatTime(datetime) {
        if (!datetime) return '';
        var d = new Date(datetime.replace(' ', 'T'));
        var h = d.getHours();
        var m = d.getMinutes();
        var ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        h = h ? h : 12;
        m = m < 10 ? '0'+m : m;
        return h + ':' + m + ' ' + ampm;
    }
    // Helper to escape HTML
    function escapeHtml(text) {
        return $('<div>').text(text).html();
    }
    $('#attach-btn').on('click', function(e) {
        e.preventDefault();
        $('#file-input').click();
    });
});