document.addEventListener('DOMContentLoaded', function () {

    function setupDragula(containerSelector, options, onDropCallback) {
        const containers = Array.from($(containerSelector));
        if (containers.length === 0) return;

        const drake = dragula(containers, options);

        // Wenn in dem drag-State (Maus gedrückt), dann füge die dragging-Klasse zu dem Body Element hinzu.
        // In main.css sorgt das für cursor: grabbing, und überschreibt alle anderen cursor-Zustände.
        // Speziell Body, um alle Elemente abzudecken und Edge Cases zu verhindern, da es das äußerste Element ist.
        drake.on('drag', () => document.body.classList.add('dragging'));
        // Analog, aber anstatt die dragging-Klasse hinzuzufügen, wird sie entfernt.
        drake.on('dragend', () => document.body.classList.remove('dragging'));

        drake.on('drop', onDropCallback);

        // Stoppt Drag, wenn die Maus das Fenster verlässt und man dann den Klick loslässt
        window.addEventListener('mouseout', function(e) {
            if (!e.relatedTarget && drake.dragging) {
                drake.cancel();
            }
        });

        // Wenn das Browserfenster den Fokus verliert, Drag abbrechen, bspw. durch Windows-Taste oder Alt & Tab
        window.addEventListener('blur', () => {
            if (drake.dragging) {
                drake.cancel();
            }
        });
    }

    // Drag & Drop für Tasks
    setupDragula('.draggable-container', {
        // Task-Cards sind draggable Elemente
        accepts: function (el, target, source, sibling) {
            return el.classList.contains('draggable');
        },
        // Man kann Tasks-Cards nur am Header packen, und auch da nicht am Text
        moves: function (el, source, handle) {
            return handle.closest('.task-handle') !== null && handle.closest('.task-title') == null;
        }
    }, function (el, target, source, sibling) {
        // Beim Drop wird das HTML-Element der Task-Card direkt automatisch von der Ursprungsspalte entfernt und in die Zielspalte eingebettet, alles client-side.

        // Für jedes draggable Element in der Zielspalte, also Task-Card, wird ein neuer Eintrag zu einem Array hinzugefügt.
        // Zweck: SortID innerhalb der Spalte für jede Task-Card erneut ermitteln und zuweisen,
        // sodass der Server die Stelle der gedroppten Task-Card speichert, sodass es auch nach Reloads an der richtigen Stelle in der Spalte bleibt.
        const order = [];
        $(target).children('.draggable').each(function(index, child){
            // Übergibt die TaskID, die in dem HTML-Attribut data-task-id client-side gespeichert ist,
            // und ermittelt die SortID, von oben nach unten aufsteigend. (index ist zu Beginn 0)
            order.push({
                TaskID: $(child).data('task-id'),
                SortID: index + 1
            });
        });

        // Packt die zu aktualisierenden Daten durch den Drop in einen JSON-String, und schickt dieses an den Server
        $.ajax({
            // In dashboard.php festgelegt, ruft eine Controller-Methode von Tasks auf
            url: updateTaskPositionUrl,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                // $(el).data() lädt die Werte, die in data-task-id bzw. data-spalten-id in den HTML-Elementen gespeichert waren.
                TaskID: $(el).data('task-id'), // Upzudatender Task
                SpaltenID: $(target).data('spalten-id'), // Zielspalte des upzudatenden Tasks
                Order: order, // Aktualisiert die SortID für alle Tasks innerhalb der Zielspalte neu
            }),
            success: function(response){
                console.log('Task successfully drag-and-dropped!');
            },
            error: function(xhr, status, error){
                console.error('AJAX error:', error);
            }
        });
    });

    // Drag & Drop für Spalten
    setupDragula('.columns-container', {
        direction: 'horizontal',
        // Man kann Spalten-Cards nur am Header packen, und auch da nicht am Text
        moves: function (el, source, handle) {
            // Nur Header der Task draggable
            return handle.closest('.column-handle') !== null && handle.closest('.spalten-title') == null;
        }
    }, function (el, target, source, sibling) {
        const order = [];
        // Durch alle Spalten iterieren und neue Reihenfolge bauen
        $(target).children('.draggable-column').each(function(index, child){
            order.push({
                SpaltenID: $(child).data('col-id'),
                SortID: index + 1
            });
        });

        // AJAX an den Server senden
        $.ajax({
            url: updateColumnPositionUrl,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                Order: order
            }),
            success: function(response){
                console.log('Spalten neu sortiert!');
            },
            error: function(xhr, status, error){
                console.error('AJAX error:', error);
            }
        });
    });
});
