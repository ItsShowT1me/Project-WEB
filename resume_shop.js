const toggleBtn = document.getElementById('toggleBtn');
const sidebar = document.getElementById('sidebar');
const main = document.querySelector('.main');

toggleBtn.addEventListener('click', () => {
  sidebar.classList.toggle('closed');
  main.classList.toggle('expanded');
});

const sampleData = [
  "ISTJ - The Inspector",
  "ISFJ - The Protector",
  "INFJ - The Advocate",
  "INTJ - The Mastermind",
  "ISTP - The Virtuoso",
  "ISFP - The Composer",
  "INFP - The Mediator",
  "INTP - The Architect",
  "ESTP - The Dynamo",
  "ESFP - The Performer",
  "ENFP - The Campaigner",
  "ENTP - The Debater",
  "ESTJ - The Executive",
  "ESFJ - The Consul",
  "ENFJ - The Protagonist",
  "ENTJ - The Commander"
];

const searchBox = document.getElementById('searchBox');
const results = document.getElementById('results');

searchBox.addEventListener('input', function () {
  const query = this.value.toLowerCase();
  const filtered = sampleData.filter(item => item.toLowerCase().includes(query));

  if (query && filtered.length > 0) {
    results.innerHTML = filtered.map(item => `<div>${item}</div>`).join('');
    results.classList.add('visible');
  } else {
    results.innerHTML = '';
    results.classList.remove('visible');
  }
});
