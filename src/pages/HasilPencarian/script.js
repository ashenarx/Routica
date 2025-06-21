    function goBack() {
        window.location.href = '../Pencarian/pencarian.html';
    }
        
    document.addEventListener('DOMContentLoaded', () => {
        fetch('/src/components/navbar.html')
            .then(response => response.text())
            .then(html => {
                document.getElementById('navbar-container').innerHTML = html;
            })
            .catch(error => console.error('Error fetching navbar:', error));

        const urlParams = new URLSearchParams(window.location.search);
        const jenis = urlParams.get('jenis');
        const lokasi = urlParams.get('lokasi');

        if (!jenis || !lokasi) {
            document.getElementById('explore-wrapper').innerHTML = '<p>Tidak ada parameter filtrasi!</p>';
            return;
        }

        fetch(`../Pencarian/getDestination.php?jenis=${encodeURIComponent(jenis)}&lokasi=${encodeURIComponent(lokasi)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                const exploreWrapper = document.getElementById('explore-wrapper');
                exploreWrapper.innerHTML = '';
                if (!data || data.length === 0) {
                    exploreWrapper.innerHTML = '<p>Tidak ada destinasi yang sesuai dengan filtrasi.</p>';
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
                console.error('Error fetching filtered destinations:', error);
                document.getElementById('explore-wrapper').innerHTML = `<p>Error loading destinations: ${error.message}</p>`;
            });
    });
