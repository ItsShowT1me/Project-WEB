document.getElementById('languageSelect').addEventListener('change', function() {
    alert('คุณเลือกภาษา: ' + this.options[this.selectedIndex].text);
});
document.getElementById('languageLevel').addEventListener('change', function() {
    alert('คุณเลือก: ' + this.value);
});

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchType = document.getElementById('searchType');
    const userCards = document.querySelectorAll('.user-card');

    function filterUsers() {
        const query = searchInput.value.trim().toLowerCase();
        const type = searchType.value;

        userCards.forEach(card => {
            const value = card.dataset[type] || '';
            if (value.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterUsers);
    searchType.addEventListener('change', filterUsers);

    // Modal functionality
    const modal = document.getElementById('userModal');
    const closeModal = document.getElementById('closeModal');
    const modalImage = document.querySelector('#modalImage img');
    const modalName = document.getElementById('modalName');
    const modalEmail = document.getElementById('modalEmail');
    const modalPhone = document.getElementById('modalPhone');

    document.querySelectorAll('.user-card').forEach(card => {
        card.addEventListener('click', function() {
            modalImage.src = card.dataset.image;
            modalName.textContent = card.dataset.name;
            modalEmail.textContent = card.dataset.email;
            modalPhone.textContent = card.dataset.phone || '-';
            modal.style.display = 'block';
        });
    });

    closeModal.onclick = function() {
        modal.style.display = 'none';
    };
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
});


