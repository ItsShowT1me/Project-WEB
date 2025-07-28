document.addEventListener('DOMContentLoaded', function() {
      var openBtn = document.getElementById('openModalBtn');
      var closeBtn = document.getElementById('closeModalBtn');
      var modal = document.getElementById('groupModal');
      var form = document.getElementById('projectForm');
      var groupsList = document.getElementById('groups-list');
      var numPeopleSelect = document.getElementById('numPeople');
      var groupPhotoInput = document.getElementById('groupPhoto');
      var groupPhotoPreview = document.getElementById('groupPhotoPreview');
      // Populate number of people select
      for(let i=1;i<=20;i++){
        var opt = document.createElement('option');
        opt.value = i;
        opt.textContent = i;
        numPeopleSelect.appendChild(opt);
      }
      if (groupPhotoInput && groupPhotoPreview) {
        groupPhotoInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              groupPhotoPreview.src = e.target.result;
              groupPhotoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
          } else {
            groupPhotoPreview.src = '';
            groupPhotoPreview.style.display = 'none';
          }
        });
      }
      if (openBtn && closeBtn && modal) {
        openBtn.onclick = function() {
          modal.style.display = 'flex';
        };
        closeBtn.onclick = function() {
          modal.style.display = 'none';
        };
        window.onclick = function(event) {
          if (event.target === modal) {
            modal.style.display = 'none';
          }
        };
      }
      if (form && groupsList) {
        form.onsubmit = function(e) {
          e.preventDefault();
          const name = document.getElementById('projectName').value;
          const numPeople = document.getElementById('numPeople').value;
          const mbti = form.querySelector('.mbti-choose').value;
          const detail = document.getElementById('projectDetail').value;
          const groupPhotoFile = groupPhotoInput && groupPhotoInput.files ? groupPhotoInput.files[0] : null;
          let imageSrc = '';
          // Check if editing
          const editingCard = document.querySelector('.group-card-flex.editing');
          if (editingCard) {
            // Editing existing card
            function updateCard(finalImageSrc) {
              const imgElem = editingCard.querySelector('.group-card-photo img');
              imgElem.src = finalImageSrc;
              editingCard.querySelector('h4').textContent = name;
              editingCard.querySelector('p:nth-of-type(1)').innerHTML = `<strong>People:</strong> ${numPeople}`;
              editingCard.querySelector('p:nth-of-type(2)').innerHTML = `<strong>MBTI:</strong> ${mbti}`;
              editingCard.querySelector('p:nth-of-type(3)').innerHTML = `<strong>Detail:</strong> ${detail}`;
              modal.style.display = 'none';
              form.reset();
              groupPhotoPreview.src = '';
              groupPhotoPreview.style.display = 'none';
              editingCard.classList.remove('editing');
              form.onsubmit = originalSubmit;
            }
            if (groupPhotoFile) {
              const reader = new FileReader();
              reader.onload = function(e) {
                imageSrc = e.target.result;
                updateCard(imageSrc);
              };
              reader.readAsDataURL(groupPhotoFile);
            } else {
              // Use preview if available, else keep current image
              imageSrc = groupPhotoPreview.src || editingCard.querySelector('.group-card-photo img').src || 'https://via.placeholder.com/120x120?text=No+Photo';
              updateCard(imageSrc);
            }
          } else {
            // Creating new card
            if (groupPhotoFile) {
              const reader = new FileReader();
              reader.onload = function(e) {
                imageSrc = e.target.result;
                addGroupCard(name, numPeople, mbti, detail, imageSrc);
              };
              reader.readAsDataURL(groupPhotoFile);
            } else {
              imageSrc = 'https://via.placeholder.com/120x120?text=No+Photo';
              addGroupCard(name, numPeople, mbti, detail, imageSrc);
            }
          }
          function addGroupCard(name, numPeople, mbti, detail, imageSrc) {
            const groupCard = document.createElement('div');
            groupCard.className = 'group-card-flex';
            groupCard.innerHTML = `
              <div class="group-card-photo">
                <img src="${imageSrc}" alt="Group Photo" />
              </div>
              <div class="group-card-info">
                <h4>${name}</h4>
                <p><strong>People:</strong> ${numPeople}</p>
                <p><strong>MBTI:</strong> ${mbti}</p>
                <p><strong>Detail:</strong> ${detail}</p>
                <div class="group-card-actions">
                  <button class="group-btn edit-btn">Edit</button>
                  <button class="group-btn delete-btn">Delete</button>
                </div>
              </div>
            `;
            groupsList.prepend(groupCard);
            modal.style.display = 'none';
            form.reset();
            groupPhotoPreview.src = '';
            groupPhotoPreview.style.display = 'none';
            alert(`Project Created!\nName: ${name}\nPeople: ${numPeople}\nMBTI: ${mbti}\nDetail: ${detail}`);
          }
        };
        // Event delegation for Edit/Delete buttons
        groupsList.addEventListener('click', function(e) {
          if (e.target.classList.contains('delete-btn')) {
            const card = e.target.closest('.group-card-flex');
            if (card) card.remove();
          } else if (e.target.classList.contains('edit-btn')) {
            const card = e.target.closest('.group-card-flex');
            if (card) {
              // Remove highlight from any other card
              document.querySelectorAll('.group-card-flex.editing').forEach(c => c.classList.remove('editing'));
              card.classList.add('editing');
              // Get current values
              const img = card.querySelector('.group-card-photo img');
              const name = card.querySelector('h4').textContent;
              const people = card.querySelector('p:nth-of-type(1)').textContent.replace('People:', '').trim();
              const mbti = card.querySelector('p:nth-of-type(2)').textContent.replace('MBTI:', '').trim();
              const detail = card.querySelector('p:nth-of-type(3)').textContent.replace('Detail:', '').trim();
              // Fill modal with current values
              document.getElementById('projectName').value = name;
              document.getElementById('numPeople').value = people;
              document.querySelector('.mbti-choose').value = mbti;
              document.getElementById('projectDetail').value = detail;
              // Show preview if image is not placeholder
              if (img && !img.src.includes('placeholder.com')) {
                groupPhotoPreview.src = img.src;
                groupPhotoPreview.style.display = 'block';
              } else {
                groupPhotoPreview.src = '';
                groupPhotoPreview.style.display = 'none';
              }
              modal.style.display = 'flex';
              // Save original submit handler
              var originalSubmit = form.onsubmit;
            }
          }
        });
      }
    });