const gamePinInput = document.getElementById('gamePin');
        const enterBtn = document.getElementById('enterBtn');
        const errorText = document.getElementById('errorText');

        gamePinInput.addEventListener('input', function() {
            if (gamePinInput.value.trim().length >= 4) {
                enterBtn.disabled = false;
                errorText.style.display = 'none';
            } else {
                enterBtn.disabled = true;
            }
        });

        enterBtn.addEventListener('click', function() {
            if (gamePinInput.value.trim().length < 4) {
                errorText.style.display = 'block';
            } else {
                alert('Entering game with PIN: ' + gamePinInput.value);
            }
        });