document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('taskSearch');


    // Event-Listener für das Tippen (Input) und den Button (Click)
    searchInput.addEventListener('input', filterDashboard);

    function filterDashboard() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const columns = document.querySelectorAll('.draggable-column');

        columns.forEach(column => {
            // Wir prüfen, ob der Spaltentitel dem Suchbegriff entspricht
            const columnTitle = column.querySelector('.card-header .fs-5').textContent.toLowerCase();
            const columnMatches = columnTitle.includes(searchTerm);

            const tasks = column.querySelectorAll('.draggable');

            tasks.forEach(task => {
                const taskText = task.textContent.toLowerCase();

                // Zeige Task an, wenn:
                // 1. Suche leer ist (Standard)
                // 2. ODER der Task-Text matcht
                // 3. ODER die Spalte selbst matcht (dann alle Tasks dieser Spalte zeigen)
                if (searchTerm === '' || taskText.includes(searchTerm) || columnMatches) {
                    task.style.display = ''; // Sichtbar machen
                } else {
                    task.style.display = 'none'; // Verstecken
                }
            });

            // Spalten sollen immer sichtbar bleiben, auch wenn keine Tasks matchen, damit man die Tasks drag-droppen kann
        });
    }
});