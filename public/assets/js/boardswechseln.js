document.addEventListener('DOMContentLoaded', function() {
    const boardSelect = document.getElementById('BoardUpdate');
    const columnSelect = document.getElementById('SpaltenID');

    // JS Logic: Nur Spalten anzeigen, die zum gewählten Board gehören
    function filterColumns() {
        const selectedBoardId = boardSelect.value;
        const options = columnSelect.querySelectorAll('option');
        let firstVisible = null;
        let currentSelectedVisible = false;

        options.forEach(option => {
            if (option.dataset.boardId === selectedBoardId) {
                option.hidden = false;
                option.disabled = false; // Zur Sicherheit aktivieren
                if (!firstVisible) firstVisible = option;
                if (option.selected) currentSelectedVisible = true;
            } else {
                option.hidden = true;
                option.disabled = true; // Disabled, damit sie nicht versehentlich gesendet werden
                option.selected = false;
            }
        });

        // Wenn die aktuell gewählte Spalte jetzt unsichtbar ist, wähle die erste verfügbare des neuen Boards
        if (!currentSelectedVisible && firstVisible) {
            firstVisible.selected = true;
        }
    }

    if(boardSelect && columnSelect) {
        boardSelect.addEventListener('change', filterColumns);
        // Initial einmal ausführen
        filterColumns();
    }
});
