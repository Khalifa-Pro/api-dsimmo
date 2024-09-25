<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Validation de Demande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: rgba(255, 204, 128, 0.9); 
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .email-header h1 {
            color: #674005;
            font-family: 'Helvetica', sans-serif;
            font-size: 36px;
            margin: 0;
            letter-spacing: 2px;
        }

        .email-header p {
            color: #2a1b05;
            font-size: 14px;
            margin: 5px 0 0;
        }

        .email-body {
            padding: 20px 0;
        }

        .email-body p {
            color: #34495e;
            font-size: 16px;
            line-height: 1.6;
        }

        .email-body strong {
            color: #2c3e50;
        }

        .email-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #f4f4f4;
            margin-top: 20px;
        }

        .email-footer p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .email-button {
            display: inline-block;
            background-color: #3498db;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 10px;
        }

        .email-button:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>DSIMMO</h1>
            <p>DIADHIOU SERVICE IMMOBILIER</p>
        </div>

        <div class="email-body">
            <p>Bonjour <strong>{{ $detailsContrat->client_prenom }} {{ $detailsContrat->client_nom }}</strong>,</p>
            <p>Nous sommes heureux de vous informer que votre demande a été bien pris en compte.</p>
            
            <p>Voici un récapitulatif des informations relatives à votre demande :</p>
            <ul>
                <li><strong>Numéro de contrat :</strong> #{{ $detailsContrat->numero_contrat }}</li>
                <li><strong>Bien loué :</strong> Appartement, {{ $detailsContrat->superficie }} m², {{ $detailsContrat->nombre_de_pieces }} pièces</li>
                <li><strong>Loyer :</strong> {{ $detailsContrat->montant }} CFA / mois</li>
                <li><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($detailsContrat->date_debut)->format('d F Y') }}</li>
            </ul>

            <p>Vous pouvez télécharger votre contrat (format PDF).</p>
            
            <p>Si vous avez des questions, n'hésitez pas à nous contacter (whatsApp ou Appel). Nous vous remercions pour votre confiance.</p>
        </div>

        <div class="email-footer">
            <p>Cordialement,</p>
            <p><strong>L'équipe DSIMMO (DIADHIOU SERVICE IMMOBILIER)</strong></p>
            <p>Email : support@dsimmo.com | Téléphone : +221 78 149 84 76</p>
        </div>
    </div>
</body>
</html>
