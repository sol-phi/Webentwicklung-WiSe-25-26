document.addEventListener("DOMContentLoaded", function () {

    const checkbox = document.getElementById("Erinnerung");
    const container = document.getElementById("erinnerungsdatum-container");
    const input = document.getElementById("Erinnerungsdatum");

    function toggleErinnerungsdatum() {
        // Kontrolliert, ob die Erinnerungsdatum Form Elemente sichtbar sind oder nicht
        container.style.display = (checkbox.checked) ? "flex" : "none";
        // Wenn mit unvollständigem Datum versteckt, Default-Wert (aktuelles Datum) eingefüllt
        if (!checkbox.checked && !input.value) {
            input.value = new Date().toISOString().slice(0,16); // Default = jetzt
        }
    }

    function applyVisualState() {
        // Wenn das Datum entweder leer ist oder nicht vollständig, dann setze Textfarbe durch CSS-Klasse auf Grau.
        // Wenn die Bedingung nicht erfüllt ist, wird die Klasse entfernt, was es wieder schwarz macht.
        input.classList.toggle("input-empty", input.value === "" || !input.validity.valid);
    }

    // Event Listener
    checkbox.addEventListener("change", toggleErinnerungsdatum);
    //Die Checkbox muss den visual state immer wieder updaten, um bei unchecked -> checked sich an das automatische Einfüllen von dem Default Value anzupassen
    checkbox.addEventListener("change", applyVisualState);
    input.addEventListener("input", applyVisualState);

    // Beim Reload direkt einmalig anwenden
    toggleErinnerungsdatum();
    applyVisualState();

});