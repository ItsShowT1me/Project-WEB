// เพิ่ม options ใน select#numPeople แบบไดนามิก (ถ้าจำเป็น)
document.addEventListener("DOMContentLoaded", function() {
    const numPeopleSelect = document.getElementById("numPeople");

    if (numPeopleSelect.children.length === 0) { // ป้องกันการเพิ่มซ้ำ
        for (let i = 1; i <= 10; i++) {
            let option = document.createElement("option");
            option.value = i;
            option.textContent = `${i} People`;
            numPeopleSelect.appendChild(option);
        }
    }
});

// เพิ่ม Event Listener ให้กับ Form
document.getElementById('projectForm').addEventListener('submit', function(event) {
    event.preventDefault(); // ป้องกันการรีเฟรชหน้า
    createGroup(); // เรียกใช้ฟังก์ชันสร้างกลุ่ม
});

// ฟังก์ชันสร้างกลุ่มและ Generate PIN
function createGroup() {
    let projectName = document.getElementById("projectName").value;
    let numPeople = document.getElementById("numPeople").value;
    let mbti = document.querySelector(".mbti-choose").value;
    let projectDetail = document.querySelector("textarea[name='projectDetail']").value;
    let pinDisplay = document.getElementById("pinDisplay");

    if (!projectName || !numPeople || !mbti || !projectDetail) {
        alert("Please fill in all fields.");
        return;
    }

    let pin = Math.floor(1000 + Math.random() * 9000);

    // แสดง PIN บนหน้าเว็บ
    if (pinDisplay) {
        pinDisplay.innerText = "Group PIN: " + pin;
        pinDisplay.style.display = "block"; // แสดง PIN ถ้าถูกซ่อน
    } else {
        alert("Error: PIN display element not found.");
    }

    alert(`Project Created!\nName: ${projectName}\nPeople: ${numPeople}\nMBTI: ${mbti}\nDetail: ${projectDetail}\nPIN: ${pin}`);
}
