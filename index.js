// Search functionality
document.addEventListener('DOMContentLoaded', function() {
  const searchBox = document.getElementById('searchBox');
  if (searchBox) {
    searchBox.addEventListener('input', function() {
      const query = this.value.trim().toLowerCase();
      const cards = document.querySelectorAll('.card-container .card');
      cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(query) ? '' : 'none';
      });
    });
  }
});

function openModal() {
  document.getElementById("formModal").style.display = "flex";
}

function closeModal() {
  document.getElementById("formModal").style.display = "none";
}

function showToast(message) {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.style.display = "block";
  setTimeout(() => (toast.style.display = "none"), 3000);
}

function submitForm(event) {
  event.preventDefault();

  // Collect form values
  const name = document.getElementById('fullName').value;
  const dob = document.getElementById('dob').value;
  const address = document.getElementById('address').value;
  const phone = document.getElementById('phone').value;
  const email = document.getElementById('email').value;
  const mbti = document.getElementById('mbti').value;
  const pdfLink = document.getElementById('pdfLink') ? document.getElementById('pdfLink').value : '';
  const imageInput = document.getElementById('image');
  const file = imageInput && imageInput.files ? imageInput.files[0] : null;

  // If image is provided, use FileReader
  if (file) {
    const reader = new FileReader();
    reader.onload = function () {
      const imageSrc = reader.result;
      const card = document.createElement('div');
      card.className = 'card';
      card.innerHTML = `
        <img src="${imageSrc}" alt="Uploaded Image" style="width: 100px; border-radius: 10px;"/>
        <h3>${name}</h3>
        <p><strong>DOB:</strong> ${dob}</p>
        <p><strong>Address:</strong> ${address}</p>
        <p><strong>Phone:</strong> ${phone}</p>
        <p><strong>Email:</strong> ${email}</p>
        <p><strong>MBTI:</strong> ${mbti}</p>
        ${pdfLink ? `<p><a href="${pdfLink}" target="_blank" style="color:#DB504A;font-weight:500;word-break:break-all;"><i class='bx bxs-file-pdf' style='font-size:1.2em;vertical-align:middle;'></i> PDF</a></p>` : ''}
      `;
      document.getElementById('item-list').appendChild(card);
      closeModal();
      document.getElementById('personalForm').reset();
      if (document.getElementById('preview')) document.getElementById('preview').style.display = 'none';
      showToast('Saved successfully!');
    };
    reader.readAsDataURL(file);
  } else {
    // If no image, just create card without image
    const card = document.createElement('div');
    card.className = 'card';
    card.innerHTML = `
      <h3>${name}</h3>
      <p><strong>DOB:</strong> ${dob}</p>
      <p><strong>Address:</strong> ${address}</p>
      <p><strong>Phone:</strong> ${phone}</p>
      <p><strong>Email:</strong> ${email}</p>
      <p><strong>MBTI:</strong> ${mbti}</p>
      ${pdfLink ? `<p><a href="${pdfLink}" target="_blank" style="color:#DB504A;font-weight:500;word-break:break-all;"><i class='bx bxs-file-pdf' style='font-size:1.2em;vertical-align:middle;'></i> PDF</a></p>` : ''}
    `;
    document.getElementById('item-list').appendChild(card);
    closeModal();
    document.getElementById('personalForm').reset();
    if (document.getElementById('preview')) document.getElementById('preview').style.display = 'none';
    showToast('Saved successfully!');
  }
}

// document.getElementById('languageSelect').addEventListener('change', function() {
//     alert('คุณเลือกภาษา: ' + this.options[this.selectedIndex].text);
// });
// document.getElementById('languageLevel').addEventListener('change', function() {
//     alert('คุณเลือก: ' + this.value);
// });