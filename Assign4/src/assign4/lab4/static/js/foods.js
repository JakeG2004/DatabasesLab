document.addEventListener('click', function (event) {
    const isUpdate = event.target.classList.contains('update-btn');
    const isDelete = event.target.classList.contains('delete-btn');
    if (!isUpdate && !isDelete) return;

    const row = event.target.closest('tr');
    const url = event.target.dataset.url;
    const token = document.querySelector('[name=csrfmiddlewaretoken]').value;

    if (isDelete && confirm("Delete food?")) {
        fetch(url, { method: 'POST', headers: { 'X-CSRFToken': token }})
        .then(res => { if(res.ok) row.remove(); });
    }

    if (isUpdate) {
        const body = {
            name: row.querySelector('.name').value,
            brand: row.querySelector('.brand').value,
            typeoffood: row.querySelector('.typeoffood').value,
            price: row.querySelector('.price').value,
            itemweight: row.querySelector('.itemweight').value,
            classoffood: row.querySelector('.classoffood').value,

        };
        fetch(url, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRFToken': token 
            },
            body: JSON.stringify(body)
        }).then(res => { if(res.ok) alert("Food updated!"); });
    }
});