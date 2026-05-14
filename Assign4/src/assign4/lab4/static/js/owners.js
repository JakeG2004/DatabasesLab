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
        const name = row.querySelector('.owner-name').value;
        const street = row.querySelector('.owner-street').value;
        const city = row.querySelector('.owner-city').value;
        const zipcode = row.querySelector('.owner-zipcode').value;
        const state = row.querySelector('.owner-state').value;
        const age = row.querySelector('.owner-age').value;
        const income = row.querySelector('.owner-income').value;

        fetch(data_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRFToken': csrftoken
            },
            body: JSON.stringify({
                'name': name,
                'age': age,
                'street': street,
                'city': city,
                'zipcode':zipcode,
                'state': state,
                'income': income
            })
        }).then(response => {
            if (response.ok) alert("Updated!");
        });
    }
});