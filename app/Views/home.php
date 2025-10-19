<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title> Home - Jamin Magazijn</title>
    <style>
        :root{
            --bg:#fafafa; --fg:#333; --muted:#666; --border:#cfcfcf; --link:#0b57d0;
        }
        *{box-sizing:border-box}
        body{
            font-family: Arial, sans-serif;
            margin: 40px;
            background: var(--bg);
            color: var(--fg);
        }
        h1{font-size:28px;margin:0 0 8px}
        p{margin:0 0 14px;font-size:16px;color:var(--muted)}
        .cards{
            display:flex; gap:16px; flex-wrap:wrap; margin-top:20px;
        }
        .card{
            border:1px solid var(--border);
            border-radius:8px;
            padding:16px 18px;
            background:#fff;
            min-width:280px;
            box-shadow:0 1px 2px rgba(0,0,0,.04);
        }
        .card h2{margin:0 0 8px;font-size:18px}
        .btn{
            display:inline-block;
            margin-top:10px;
            padding:10px 14px;
            border:1px solid var(--border);
            border-radius:6px;
            background:#f5f7fb;
            color:var(--link);
            text-decoration:none;
            font-weight:600;
        }
        .btn:hover{background:#eef2fb}
        footer{margin-top:36px;font-size:13px;color:var(--muted)}
    </style>
</head>
<body>

    <h1> Welkom bij het Jamin Magazijn</h1>
    <p>Kies hieronder het overzicht uit de opdracht. (De detail-schermen open je via de icoontjes in het overzicht.)</p>

    <div class="cards">
        <div class="card">
            <h2> Overzicht Magazijn Jamin</h2>
            <p>Toont alle producten, verpakkings-eenheid en aantallen. Gesorteerd volgens de opdracht.</p>
            <a class="btn" href="<?= url('magazijn/overzicht') ?>">Open overzicht</a>
        </div>

        <div class="card">
            <h2> Allergenen &  Leveringen</h2>
            <p>Deze schermen open je via de icoontjes (❌ / ❓) bij een product in het magazijnoverzicht.</p>
            <!-- Geen directe links hier, omdat detailroutes een id vereisen -->
        </div>
    </div>
</body>
</html>
