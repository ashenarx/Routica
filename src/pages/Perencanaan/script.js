const toggleBtn = document.getElementById("toggleNote");
const notesSection = document.getElementById("notesSection");
const chevronIcon = document.getElementById("chevronIcon");
    
notesSection.style.display = "none";
chevronIcon.style.transform = "rotate(-90deg)"; 

toggleBtn.addEventListener("click", () => {
    const isVisible = notesSection.style.display !== "flex";

    if (isVisible) {
        notesSection.style.display = "flex";
        chevronIcon.style.transform = "rotate(0deg)";
    } else {
        notesSection.style.display = "none";
        chevronIcon.style.transform = "rotate(-90deg)";
    }
});

const toggleChevron = document.getElementById("toggleItinerary");
const itinerariesSection = document.getElementById("itinerariesSection");
const chevronItinerary = document.getElementById("chevronItinerary");
const destinationsList = document.getElementById("destinationsList");
const saveItineraryBtn = document.getElementById("saveItineraryBtn");
const clearFormBtn = document.getElementById("clearFormBtn");
const planTitle = document.getElementById("planTitle");
const planDate = document.getElementById("planDate");
const planLocation = document.getElementById("planLocation");
const notesInput = document.getElementById("notesInput");

itinerariesSection.style.display = "none";
chevronItinerary.style.transform = "rotate(-90deg)"; 

toggleChevron.addEventListener("click", () => {
    const isVisible = itinerariesSection.style.display !== "flex";

    if (isVisible) {
        itinerariesSection.style.display = "flex";
        chevronItinerary.style.transform = "rotate(0deg)";
        loadDestinations();
    } else {
        itinerariesSection.style.display = "none";
        chevronItinerary.style.transform = "rotate(-90deg)";
    }
});

function loadDestinations() {
    const itineraries = JSON.parse(localStorage.getItem('itineraries') || '[]');
    destinationsList.innerHTML = '';
    if (itineraries.length === 0 || !itineraries[0].destinations || itineraries[0].destinations.length === 0) {
        destinationsList.innerHTML = '<p>Tidak ada destinasi yang ditambahkan.</p>';
        return;
    }

    itineraries[0].destinations.forEach(destination => {
        const div = document.createElement('div');
        div.className = 'destination-item';
        div.innerHTML = `
            <img src="${destination.image}" alt="${destination.name}">
            <div class="destination-info">
                <h3>${destination.name}</h3>
                <p>Ditambahkan: ${new Date(destination.addedAt).toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'short' })}</p>
            </div>
        `;
        destinationsList.appendChild(div);
    });
}

saveItineraryBtn.addEventListener('click', () => {
    const title = planTitle.value;
    const date = planDate.value;
    const location = planLocation.value;
    const notes = notesInput.value;

    if (!title || !date || !location) {
        alert('Lengkapi judul, tanggal, dan lokasi!');
        return;
    }

    let itineraries = JSON.parse(localStorage.getItem('itineraries') || '[]');
    if (itineraries.length === 0) {
        itineraries.push({ title, date, location, notes, destinations: [] });
    } else {
        itineraries[0].title = title;
        itineraries[0].date = date;
        itineraries[0].location = location;
        itineraries[0].notes = notes;
    }
    localStorage.setItem('itineraries', JSON.stringify(itineraries));
    alert('Itinerary disimpan!');
    loadDestinations();
});

clearFormBtn.addEventListener('click', () => {
    planTitle.value = '';
    planDate.value = '';
    planLocation.value = '';
    notesInput.value = '';
});