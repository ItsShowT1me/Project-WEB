document.getElementById('languageSelect').addEventListener('change', function() {
    alert('คุณเลือกภาษา: ' + this.options[this.selectedIndex].text);
});
document.getElementById('languageLevel').addEventListener('change', function() {
    alert('คุณเลือก: ' + this.value);
});