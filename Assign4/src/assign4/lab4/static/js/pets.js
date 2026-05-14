document.addEventListener('click', function (event) {
    // Determine if we clicked Update or Delete
    const isUpdate = event.target.classList.contains('update-btn');
    const isDelete = event.target.classList.contains('delete-btn');

    if (!isUpdate && !isDelete) return;

    const row = event.target.closest('tr');
    const data_url = event.target.dataset.url;
    const csrftoken = document.querySelector('[name=csrfmiddlewaretoken]').value;

    // --- HANDLE DELETE ---
    if (isDelete) {
        if (!confirm("Are you sure?")) return;

        fetch(data_url, {
            method: 'POST',
            headers: { 'X-CSRFToken': csrftoken }
        }).then(response => {
            if (response.ok) row.remove(); // Remove row from UI
        });
    }

    // --- HANDLE UPDATE ---
    if (isUpdate) {
        const pet_name = row.querySelector('.pet-name').value;
        const pet_age = row.querySelector('.pet-age').value;
        const pet_street = row.querySelector('.pet-street').value;
        const pet_city = row.querySelector('.pet-city').value;
        const pet_zipcode = row.querySelector('.pet-zipcode').value;
        const pet_state = row.querySelector('.pet-state').value;
        const pet_type = row.querySelector('.pet-type').value;

        fetch(data_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRFToken': csrftoken
            },
            body: JSON.stringify({
                'pet_name': pet_name,
                'pet_age': pet_age,
                'pet_street': pet_street,
                'pet_city': pet_city,
                'pet_zipcode':pet_zipcode,
                'pet_state': pet_state,
                'pet_type': pet_type,
            })
        }).then(response => {
            if (response.ok) alert("Pet updated!");
        });
    }
});