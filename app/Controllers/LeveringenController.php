<?php
require_once __DIR__ . '/../Models/Leveringen.php';
require_once __DIR__ . '/../Models/Database.php';

class LeveringenController
{
    public function index()
    {
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($productId <= 0) { header('Location: ' . url()); exit; }

        $pdo   = Database::getConnection();
        $model = new Leveringen();

        // Alle leveringsregels (gesorteerd op datum oplopend via SP)
        $rows = $model->getVoorProduct($productId);

        // 1) Voorraadstatus bepalen op basis van Magazijn.AantalAanwezig (NULL = geen voorraad)
        $stmt = $pdo->prepare("SELECT AantalAanwezig FROM Magazijn WHERE ProductId = :pid LIMIT 1");
        $stmt->execute([':pid' => $productId]);
        $voorraadRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $geenVoorraad = !$voorraadRow || $voorraadRow['AantalAanwezig'] === null;

        // 2) Eerstvolgende leverdatum bepalen (MIN niet-NULL DatumEerstVolgendeLevering)
        $stmt2 = $pdo->prepare("
            SELECT MIN(DatumEerstVolgendeLevering) AS Eerstvolgende
            FROM ProductPerLeverancier
            WHERE ProductId = :pid AND DatumEerstVolgendeLevering IS NOT NULL
        ");
        $stmt2->execute([':pid' => $productId]);
        $next = $stmt2->fetch(PDO::FETCH_ASSOC);
        $eerstvolgende = $next['Eerstvolgende'] ?? null; // bv. '2024-10-30'

        // Leveranciers + productinfo verzamelen uit $rows (bovenin tonen)
        $leveranciers = [];
        $productNaam = '';
        $barcode = '';
        foreach ($rows as $r) {
            $productNaam = $r['ProductNaam'] ?? $productNaam;
            $barcode     = $r['Barcode'] ?? $barcode;
            $key = $r['LeverancierNummer'] ?? ($r['LeverancierNaam'] ?? uniqid('L'));
            $leveranciers[$key] = [
                'Naam'               => $r['LeverancierNaam'] ?? '',
                'ContactPersoon'     => $r['ContactPersoon'] ?? '',
                'LeverancierNummer'  => $r['LeverancierNummer'] ?? '',
                'Mobiel'             => $r['Mobiel'] ?? '',
            ];
        }

        view('leveringen/overzicht', [
            'rows'          => $rows,
            'productNaam'   => $productNaam,
            'barcode'       => $barcode,
            'leveranciers'  => array_values($leveranciers),
            'geenVoorraad'  => $geenVoorraad,
            'eerstvolgende' => $eerstvolgende,
        ]);
    }
}
