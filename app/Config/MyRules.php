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
        'Erinnerungsdatum'  => 'valid_date',
//    'Erinnerung'        => '',
//    'Notizen'             => 'required',
    ];
    public $taskserstellen_errors = [
        'Bezeichnung'       => ['required' => 'Die Bezeichnung des Tasks ist ein Pflichtfeld.'],
        'TaskartID'         => ['required' => 'Die Auswahl einer Taskart ist ein Pflichtfeld.'],
        'PersonID'          => ['required' => 'Die Auswahl einer Person ist ein Pflichtfeld.'],
        'SpaltenID'         => ['required' => 'Die Auswahl einer Spalte ist ein Pflichtfeld.'],
        'SortID'            => ['required' => 'Die SortID des Tasks ist ein Pflichtfeld.', 'integer' => 'Die SortID muss eine ganze Zahl sein.'],
        //Mit permit_empty wird es nervig, da leer == "0000-00-00 00:00:00" in der Datenbank
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

    // Regeln für das Boards-Formular
    public $boardserstellen = [
        'Bezeichnung' => 'required',
    ];
    public $boardserstellen_errors = [
        'Bezeichnung' => [
            'required'   => 'Bitte geben Sie eine Bezeichnung für den Board ein.',
        ],
    ];

    // Regeln für das Personen-Formular
    public $personenerstellen = [
        'Vorname' => 'required',
        'Nachname' => 'required',
        'EMail' => 'required|valid_email',
        'Passwort' => 'required|min_length[8]',
    ];
    public $personenerstellen_errors = [
        'Vorname' => [
            'required'   => 'Bitte geben Sie einen oder mehrere Vornamen für die Person an.',
        ],
        'Nachname' => [
            'required' => 'Bitte geben Sie einen oder mehrere Nachnamen für die Person ein.',
        ],
        'EMail' => [
            'required' => 'Bitte geben Sie eine E-Mail für die Person ein.',
            'valid_email'  => 'Die E-Mail muss sich in einem gültigen Format befinden.',
        ],
        'Passwort' => [
            'required' => 'Bitte geben Sie ein Passwort für die Person ein.',
            'min_length' => 'Das Passwort darf nicht kürzer als 8 Zeichen sein.',
        ],
    ];

}