document.addEventListener('DOMContentLoaded', () => {
    console.log('Fetching data...');
    fetch('./get_destination.php') // Path relatif
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data);
            const exploreWrapper = document.getElementById('explore-wrapper');
            exploreWrapper.innerHTML = '';
            if (!data || data.length === 0) {
                exploreWrapper.innerHTML = '<p>Tidak ada data destinasi.</p>';
                return;
            }
            data.forEach(destination => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <img src="${destination.main_image || 'placeholder.jpg'}" alt="${destination.name}">
                    <div class="plus">
                        <img src="../../assets/icons/plus-sm.svg" alt="Plus">
                    </div>
                    <div class="card-content">
                        <h3>${destination.name || 'Nama Tidak Tersedia'}</h3>
                        <div class="location-info">
                            <img src="../../assets/icons/location-marker.svg" alt="Location" />
                            <span>${destination.kota || ''}, ${destination.provinsi || ''}</span>
                        </div>
                    </div>
                `;
                card.addEventListener('click', () => {
                    window.location.href = `destination.php?name=${(destination.name || '').replace(/ /g, '_')}`;
                });
                exploreWrapper.appendChild(card);
            });
        })
        .catch(error => {
            console.error('Error fetching destinations:', error);
            const exploreWrapper = document.getElementById('explore-wrapper');
            exploreWrapper.innerHTML = `<p>Error loading destinations: ${error.message}</p>`;
        });
});