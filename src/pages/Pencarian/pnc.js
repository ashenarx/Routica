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
                        <img src="../../assets/icons/plus-sm.svg" alt="Plus" class="plus-icon" data-name="${destination.name}" data-kota="${destination.kota}" data-provinsi="${destination.provinsi}" data-image="${destination.main_image || 'placeholder.jpg'}">
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

            // Add event listener for plus icon
            document.querySelectorAll('.plus-icon').forEach(icon => {
                icon.addEventListener('click', (e) => {
                    e.stopPropagation(); // Prevent card click event
                    const name = icon.getAttribute('data-name');
                    const kota = icon.getAttribute('data-kota');
                    const provinsi = icon.getAttribute('data-provinsi');
                    const image = icon.getAttribute('data-image');
                    addToItinerary({ name, kota, provinsi, image });
                });
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

    // Function to add to itinerary
    function addToItinerary(destination) {
        let itinerary = JSON.parse(localStorage.getItem('itinerary') || '[]');
        if (!itinerary.some(item => item.name === destination.name)) {
            itinerary.push(destination);
            localStorage.setItem('itinerary', JSON.stringify(itinerary));
            alert(`${destination.name} ditambahkan ke itinerary!`);
        } else {
            alert(`${destination.name} sudah ada di itinerary!`);
        }
    }
});