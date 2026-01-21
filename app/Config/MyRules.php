<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MyRules extends BaseConfig
{
    public $taskserstellen = [
        'Bezeichnung'       => 'required',
        'TaskartID'         => 'required',
        'PersonID'          => 'required',
        'SpaltenID'         => 'required',
        'SortID'            => 'required|integer',
        'Erinnerungsdatum'  => 'permit_empty|valid_date',
//    'Erinnerung'        => '',
//    'Notizen'             => 'required',
    ];

    public $taskserstellen_errors = [
        'Bezeichnung'       => ['required' => 'Die Bezeichnung des Tasks ist ein Pflichtfeld.'],
        'TaskartID'         => ['required' => 'Die Auswahl einer Taskart ist ein Pflichtfeld.'],
        'PersonID'          => ['required' => 'Die Auswahl einer Person ist ein Pflichtfeld.'],
        'SpaltenID'         => ['required' => 'Die Auswahl einer Spalte ist ein Pflichtfeld.'],
        'SortID'            => ['required' => 'Die SortID des Tasks ist ein Pflichtfeld.', 'integer' => 'Die SortID muss eine ganze Zahl sein.'],
        'Erinnerungsdatum'  => ['valid_date' => 'Das Erinnerungsdatum muss ein gültiges Datum sein.'],
//    'Erinnerung'        => ['' => ''],
//    'Notizen'           => ['required' => 'Die Notizen zum Task sind ein Pflichtfeld.'],
    ];

    // Regeln für das Spalten-Formular
    public $spaltenerstellen = [
        'Bezeichnung' => 'required',
        'Beschreibung' => 'required',
        'SortID' => 'required|integer',
        'Board' => 'required',
    ];

    public $spaltenerstellen_errors = [
        'Bezeichnung' => [
            'required'   => 'Bitte geben Sie eine Bezeichnung für die Spalte ein.',
        ],
        'Beschreibung' => [
            'required' => 'Bitte geben Sie eine Beschreibung für die Spalte ein.',
        ],
        'SortID' => [
            'required' => 'Bitte geben Sie eine SortID ein.',
            'integer'  => 'Die SortID muss eine ganze Zahl sein.',
        ],
        'Board' => [
            'required' => 'Die Auswahl eines Boards ist ein Pflichtfeld.',
        ],
    ];

}