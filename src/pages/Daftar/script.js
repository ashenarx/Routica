function showDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.style.display = 'flex';
    modal.classList.add('active');
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.style.display = 'none';
    modal.classList.remove('active');
}

function createItineraryItem(imageSrc, title, date, location) {
    return `
        <div class="itinerary-item">
            <div class="itinerary-item__image-container">
                <img class="itinerary-item__image" src="${imageSrc}">
                <div class="itinerary-item__edit">
                    <img class="itinerary-item__icon" src="../../assets/icons/Ellipse 3.svg">
                    <img class="itinerary-item__icon-pencil" src="../../assets/icons/pencil.svg">
                </div>
                <div class="itinerary-item__delete">
                    <img class="itinerary-item__icon" src="../../assets/icons/Ellipse 3.svg">
                    <img class="itinerary-item__icon-trash" src="../../assets/icons/trash.svg" onclick="showDeleteModal()">
                </div>
            </div>
            <div class="itinerary-item__details">
                <label class="itinerary-item__title">${title}</label>
                <div class="itinerary-item__date">
                    <img class="itinerary-item__date-icon" src="../../assets/icons/cal-blue.svg">
                    <p>${date}</p>
                </div>
                <div class="itinerary-item__location">
                    <img class="itinerary-item__location-icon" src="../../assets/icons/location-marker-blue.svg">
                    <p>${location}</p>
                </div>
            </div>
        </div>
    `;
}

document.addEventListener('DOMContentLoaded', () => {
    const itineraryList = document.querySelector('.itinerary-list');
    const itineraries = [
        {
            imageSrc: '../../assets/images/Kampung Warna-Warni.png',
            title: 'Liburan ke Malang',
            date: '30 April 2025 - 1 Mei 2025',
            location: '3 Tempat'
        },
        {
            imageSrc: '../../assets/images/Kampung Warna-Warni.png',
            title: 'Liburan ke Malang',
            date: '30 April 2025 - 1 Mei 2025',
            location: '3 Tempat'
        }
    ];

    itineraries.forEach(itinerary => {
        itineraryList.innerHTML += createItineraryItem(itinerary.imageSrc, itinerary.title, itinerary.date, itinerary.location);
    });
});