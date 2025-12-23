<?php

namespace App\Controllers;
class Home extends BaseController
{
    // Hier werden die einzelnen PHP-Dateien wortwörtlich aneinandergepappt.
    // Man sollte daher die Code-Ausschnitte aus den jeweils vier einzelnen Dateien als ein großes HTML-Dokument betrachten.

    // Der Punkt des Home-Controllers ist es, die Startseite (/) auf die eigentliche Seite (/tasks) weiterzuleiten.
    public function getIndex()
    {
        return redirect()->to(base_url('public/tasks'));
    }


}
