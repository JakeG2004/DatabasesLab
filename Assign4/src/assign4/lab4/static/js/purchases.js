document.addEventListener('click', function (event) {
    const isUpdate = event.target.classList.contains('update-btn');
    const isDelete = event.target.classList.contains('delete-btn');

    if (!isUpdate && !isDelete) return;

    const row = event.target.closest('tr');
    const data_url = event.target.dataset.url;
    const csrftoken = document.querySelector('[name=csrfmiddlewaretoken]').value;

    // --- DELETE ---
    if (isDelete) {
        if (!confirm("Delete this purchase record?")) return;

        fetch(data_url, {
            method: 'POST',
            headers: { 'X-CSRFToken': csrftoken }
        }).then(response => {
            if (response.ok) row.remove();
        });
    }

    // --- UPDATE ---
    if (isUpdate) {
        const month = row.querySelector('.month').value;
        const year = row.querySelector('.year').value;
        const quantity = row.querySelector('.quantity').value;

        fetch(data_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRFToken': csrftoken
            },
            body: JSON.stringify({
                'month': month,
                'year': year,
                'quantity': quantity
            })
        }).then(response => {
            if (response.ok) {
                alert("Purchase updated!");
            } else {
                alert("Update failed.");
            }
        });
    }
});