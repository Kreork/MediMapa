function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

document.querySelectorAll('#doctorTable tbody tr').forEach(function(row) {
    row.addEventListener('click', function() {
        let name = row.cells[0].textContent;
        let specialty = row.cells[1].textContent;
        let postalCode = row.cells[2].textContent;
        let address = row.cells[3].textContent;
        let phone = row.cells[4].textContent;

        document.getElementById('doctorName').innerText = name;
        document.getElementById('doctorDetails').innerText = `Especialidad: ${specialty}\nCódigo Postal: ${postalCode}\nDirección: ${address}\nTeléfono: ${phone}`;

        document.getElementById('popup').style.display = 'block';
    });
});
