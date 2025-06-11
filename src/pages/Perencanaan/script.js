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
    
itinerariesSection.style.display = "none";
chevronItinerary.style.transform = "rotate(-90deg)"; 

toggleChevron.addEventListener("click", () => {
    const isVisible = itinerariesSection.style.display !== "flex";

    if (isVisible) {
        itinerariesSection.style.display = "flex";
        chevronItinerary.style.transform = "rotate(0deg)";
    } else {
        itinerariesSection.style.display = "none";
        chevronItinerary.style.transform = "rotate(-90deg)";
    }
});