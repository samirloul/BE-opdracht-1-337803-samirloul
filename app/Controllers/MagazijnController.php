<?php
require_once __DIR__ . '/../Models/Magazijn.php';
// Controller voor magazijnoverzicht
class MagazijnController
{
    public function index()
    {
        $model = new Magazijn();
        $rows  = $model->getOverzicht();
        view('magazijn/overzicht', ['magazijn' => $rows]);
    }
}
