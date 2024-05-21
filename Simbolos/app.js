function deleteImage(id) {
    if (!confirm('¿Estás seguro de que quieres eliminar esta imagen?')) return;

    fetch('delete_image.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        loadImages();  // Recargar lista de imágenes después de eliminar
    })
    .catch(error => console.error('Error:', error));
}

function loadImages() {
    fetch('load_images.php')
        .then(response => response.json())
        .then(images => {
            const imageTableBody = document.querySelector('#imageTable tbody');
            imageTableBody.innerHTML = '';

            images.forEach(image => {
                const row = document.createElement('tr');

                const categoryCell = document.createElement('td');
                categoryCell.textContent = image.category;
                row.appendChild(categoryCell);

                const imageCell = document.createElement('td');
                const imgElement = document.createElement('img');
                imgElement.src = image.image_path;
                imgElement.alt = image.category;
                imageCell.appendChild(imgElement);
                row.appendChild(imageCell);

                const dateCell = document.createElement('td');
                dateCell.textContent = new Date(image.created_at).toLocaleString();
                row.appendChild(dateCell);

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Eliminar';
                deleteButton.onclick = function() {
                    deleteImage(image.id);
                };
                row.appendChild(deleteButton);

                imageTableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error:', error));
}

window.onload = loadImages;
