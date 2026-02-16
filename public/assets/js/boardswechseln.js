document.addEventListener('DOMContentLoaded', function() {
    const boardDropdown = document.getElementById('BoardID');
    const columnDropdown = document.getElementById('SpaltenID');

    // JS Logic: Nur Spalten anzeigen, die zum gewählten Board gehören
    function filterColumns(onInitialLoad = false) {
        const selectedBoardId = boardDropdown.value;
        const columnDropdownOptions = columnDropdown.querySelectorAll('option');

        // Wenn nicht direkt nach einem Reload (also nur bei Änderungen), um Validation und leere Boards zu berücksichtigen
        if (!onInitialLoad) {
            // Sorgt dafür, dass der Spalten-Dropdown nach einer Änderung beim Board-Dropdown geleert wird
            const placeholder = columnDropdown.querySelector('option[value=""]');
            placeholder.selected = true;
            updateColumnColor();
        }

        // Falls nicht auf true gesetzt, heißt das, dass der Board leer ist
        let containsAnyOptions = false;
        // Filtert, welche Spalten in dem Dropdown zu dem gerade ausgewählten Board gehören und somit angezeigt werden sollen
        columnDropdownOptions.forEach(option => {
            if (option.dataset.boardId === selectedBoardId) {
                option.hidden = false;
                option.disabled = false; // Zur Sicherheit aktivieren
                containsAnyOptions = true;
            } else {
                option.hidden = true;
                option.disabled = true; // Disabled, damit sie nicht versehentlich gesendet werden
            }
        });

        // Spaltenblock ausblenden, wenn Board leer
        const columnBlock = document.getElementById('SpaltenBlock');
        columnBlock.style.display = containsAnyOptions ? "" : "none";

        // Fehlermeldung bei leeren Boards anzeigen
        boardDropdown.classList.toggle('is-invalid', !containsAnyOptions);
        const boardError = document.getElementById('boardNoColumnsError');
        boardError.classList.toggle('d-none', containsAnyOptions);
    }

    // Wenn Spalte geleert worden, grau setzen, ansonsten schwarz
    function updateColumnColor() {
        if (columnDropdown.value === "") {
            columnDropdown.style.color = "#6c757d";
        } else {
            columnDropdown.style.color = "#212529";
        }
    }

    // Lambda-Ausdruck, um Parameter mitgeben zu können.
    // Sobald sich etwas im Board-Dropdown ändert, wird der Spalten-Dropdown (und durch updateColumnColor() innendrin auch dessen Farbe) angepasst
    boardDropdown.addEventListener('change', () => {filterColumns(false);});
    // Passt die Farbe an, wenn sich etwas in dem Spalten-Dropdown ändert.
    columnDropdown.addEventListener("change", updateColumnColor);

    // Initial einmal ausführen
    filterColumns(true);
    updateColumnColor();
});
