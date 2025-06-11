document.addEventListener('DOMContentLoaded', () => {
    // Load navbar
    fetch('/src/components/navbar.html')
        .then(response => response.text())
        .then(html => {
            document.getElementById('navbar-container').innerHTML = html;
        })
        .catch(error => console.error('Error fetching navbar:', error));

    // Fetch initial recommendations
    fetch('./getDestination.php')
        .then(response => {
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
                    window.location.href = `../Destinasi/destination.php?name=${(destination.name || '').replace(/ /g, '_')}`;
                });
                exploreWrapper.appendChild(card);
            });
        })
        .catch(error => {
            console.error('Error fetching destinations:', error);
            const exploreWrapper = document.getElementById('explore-wrapper');
            exploreWrapper.innerHTML = `<p>Error generate rekomendasi destinasi: ${error.message}</p>`;
        });

    // Search functionality
    const cariBtn = document.querySelector('.cari-btn');
    cariBtn.addEventListener('click', () => {
        const jenis = document.getElementById('jenis').value;
        const lokasi = document.getElementById('lokasi').value;

        if (!jenis || !lokasi || jenis === '' || lokasi === '') {
            alert('Silakan pilih Jenis Destinasi dan Lokasi!');
            return;
        }

        window.location.href = `../HasilPencarian/hasilpencarian.html?jenis=${encodeURIComponent(jenis)}&lokasi=${encodeURIComponent(lokasi)}`;
    });
});