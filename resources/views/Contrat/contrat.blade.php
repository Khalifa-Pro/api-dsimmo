<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrat de Location</title>
    <link rel="stylesheet" href="contrat.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .contract-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 28px;
            margin-bottom: 5px;
            color: ;
        }

        header h1 {
            font-size: 25px;
            margin-bottom: 5px;
            color: #444;
        }

        header p {
            font-size: 18px;
            color: #777;
        }

        header strong {
            color: #333;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #444;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        p, ul {
            font-size: 16px;
            margin-bottom: 15px;
        }

        ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        strong {
            color: #333;
        }

        .signature {
            margin-top: 30px;
        }

        .signature p {
            font-size: 16px;
            display: inline-block;
            width: 48%;
        }

        .signature p::after {
            content: '';
            display: block;
            margin-top: 10px;
            border-top: 1px solid #333;
            width: 90%;
        }

        .signatures {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="contract-container">
        <header>
            <h1>DSIMMO (DIADHIOU - SERVICE - IMMOBILIER)</h1>
            <h1>Contrat de Location</h1>
            <p>Numéro de contrat : <strong>#{{ $detailsContrat->numero_contrat }}</strong></p>
            <p>Entre le bailleur et le locataire</p>
        </header>

        <section class="parties">
            <h2>Identité des parties</h2>
            <p><strong>Bailleur :</strong> {{ $detailsContrat->proprietaire_prenom }} {{ $detailsContrat->proprietaire_nom }}</p>
            <p><strong>Locataire :</strong> {{ $detailsContrat->client_prenom }} {{ $detailsContrat->client_nom }}</p>
        </section>

        <section class="property-details">
            <h2>Description du bien loué</h2>
            <p><strong>Adresse :</strong> {{ $detailsContrat->adresse_appartement }}</p>
            <p><strong>Superficie :</strong> {{ $detailsContrat->superficie }} m²</p>
            <p><strong>Nombre de pièces :</strong> {{ $detailsContrat->nombre_de_pieces }}</p>
        </section>

        <section class="rental-details">
            <h2>Détails de la location</h2>
            <p><strong>Durée :</strong> {{ $detailsContrat->date_debut }} à {{ $detailsContrat->date_fin }}</p>
            <p><strong>Loyer :</strong> {{ $detailsContrat->montant }} CFA / mois</p>
            <p><strong>Caution :</strong> {{ $detailsContrat->montant * 3 }} CFA</p>
        </section>

        <section class="signatures">
            <h2>Signatures</h2>
            <p>Bailleur : ______________________________________</p>
            <p>Locataire : ______________________________________</p>
        </section>
    </div>
</body>
</html>
