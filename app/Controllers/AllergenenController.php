<?php
require_once __DIR__ . '/../Models/Allergenen.php';

class AllergenenController
{
    public function index()
    {
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($productId <= 0) { header('Location: '.url()); exit; }

        $model = new Allergenen();
        $rows  = $model->getVoorProduct($productId);

        // Boven info (productnaam/barcode) uit eerste rij indien beschikbaar
        $productNaam = $rows[0]['ProductNaam'] ?? '';
        $barcode     = $rows[0]['Barcode']     ?? '';

        // Als er geen allergenen zijn (alle Allergeen NULL), toon vaste melding + 4s terug
        $geenAllergenen = true;
        foreach ($rows as $r) {
            if (!empty($r['Allergeen'])) { $geenAllergenen = false; break; }
        }

        view('allergenen/overzicht', [
            'items'       => $rows,
            'productNaam' => $productNaam,
            'barcode'     => $barcode,
            'geenAllergenen' => $geenAllergenen
        ]);
    }
}
