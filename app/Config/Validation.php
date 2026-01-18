<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    // Regeln für das Formular zum Erstellen einer neuen Spalte
    public $spaltenErstellenRules = [
        'Bezeichnung' => 'required',
        'Beschreibung' => 'required',
        'SortID' => 'required|integer',
        'BoardID' => 'required',
    ];

    // Dazugehörige Fehlermeldungen
    public $spaltenErstellenRules_errors = [
        'Bezeichnung' => ['required' => 'Die Bezeichnung der Spalte ist ein Pflichtfeld.'],
        'Beschreibung' => ['required' => 'Die Beschreibung der Spalte ist ein Pflichtfeld.'],
        'SortID' => ['required' => 'Die SortID der Spalte ist ein Pflichtfeld.', 'integer' => 'Die SortID muss eine ganze Zahl sein.'],
        'BoardID' => ['required' => 'Die Auswahl eines Boards ist ein Pflichtfeld.'],
    ];

    // Regeln für das Formular zum Erstellen eines neuen Tasks. Die ersten 5 sollten bei jedem Task dabei sein.
    // Erinnerungen und Notizen sind optional.
    // Erinnerungsdatum darf zwar leer sein (dann keine Erinnerung), aber darf kein halbes Datum enthalten.
    public $taskErstellenRules = [
    'Bezeichnung'       => 'required',
    'TaskartID'         => 'required',
    'PersonID'          => 'required',
    'SpaltenID'         => 'required',
    'SortID'            => 'required|integer',
    'Erinnerungsdatum'  => 'permit_empty|valid_date',
//    'Erinnerung'        => '',
//    'Notizen'             => 'required',
    ];

    // Dazugehörige Fehlermeldungen
    public $taskErstellenRules_errors = [
    'Bezeichnung'       => ['required' => 'Die Bezeichnung des Tasks ist ein Pflichtfeld.'],
    'TaskartID'         => ['required' => 'Die Auswahl einer Taskart ist ein Pflichtfeld.'],
    'PersonID'          => ['required' => 'Die Auswahl einer Person ist ein Pflichtfeld.'],
    'SpaltenID'         => ['required' => 'Die Auswahl einer Spalte ist ein Pflichtfeld.'],
    'SortID'            => ['required' => 'Die SortID des Tasks ist ein Pflichtfeld.', 'integer' => 'Die SortID muss eine ganze Zahl sein.'],
    'Erinnerungsdatum'  => ['valid_date' => 'Das Erinnerungsdatum muss ein gültiges Datum sein.'],
//    'Erinnerung'        => ['' => ''],
//    'Notizen'           => ['required' => 'Die Notizen zum Task sind ein Pflichtfeld.'],
    ];

}
