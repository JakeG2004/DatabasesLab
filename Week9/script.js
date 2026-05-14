document.querySelector('form').addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    if (checkboxes.length === 0) {
        e.preventDefault();
        alert("Please select at least one language known.");
    }
});

// Interactive UI: Real-time greeting
const firstNameInput = document.getElementById('firstname');
const titleRadios = document.querySelectorAll('input[name="title"]');

const updateGreeting = () => {
    const title = document.querySelector('input[name="title"]:checked')?.value || "";
    const name = firstNameInput.value;
    if(name) {
        console.log(`Preparing registration for ${title} ${name}...`);
    }
};

firstNameInput.addEventListener('input', updateGreeting);
titleRadios.forEach(r => r.addEventListener('change', updateGreeting));