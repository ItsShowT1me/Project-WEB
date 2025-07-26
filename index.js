// const toggleBtn = document.getElementById('toggleBtn');
// const sidebar = document.getElementById('sidebar');
// const main = document.querySelector('.main');

// toggleBtn.addEventListener('click', () => {
//   sidebar.classList.toggle('closed');
//   main.classList.toggle('expanded');
// });

// searchBox.addEventListener('input', function () {
//   const query = this.value.toLowerCase();
//   const filtered = sampleData.filter(item => item.toLowerCase().includes(query));

//   if (query && filtered.length > 0) {
//     results.innerHTML = filtered.map(item => `<div>${item}</div>`).join('');
//     results.classList.add('visible');
//   } else {
//     results.innerHTML = '';
//     results.classList.remove('visible');
//   }
// });



document.getElementById('languageSelect').addEventListener('change', function() {
    alert('คุณเลือกภาษา: ' + this.options[this.selectedIndex].text);
});
document.getElementById('languageLevel').addEventListener('change', function() {
    alert('คุณเลือก: ' + this.value);
});



