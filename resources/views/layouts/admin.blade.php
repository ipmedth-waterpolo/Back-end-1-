<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <!-- Include a CSS file -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Verwijder standaard opmaak van lijsten */
        ul, ol {
            list-style: none;  /* Verwijdert de standaard puntjes of nummers */
            padding: 0;         /* Verwijdert de standaard inspringing van lijsten */
            margin: 0;          /* Verwijdert de standaard marge van lijsten */
        }

        /* Verwijder onderlijning van links */
        a {
            text-decoration: none; /* Verwijdert de onderlijning van links */
            color: inherit;        /* Zorgt ervoor dat de kleur van links dezelfde is als de tekstkleur */
        }

        /* Styling voor de links in het Dashboard */
        ul {
            list-style: none; /* Verwijdert de standaard puntjes */
            padding: 0;
        }

        ul li {
            margin-bottom: 15px; /* Ruimte tussen de items */
        }

        ul li a {
            text-decoration: none; /* Verwijdert onderlijning */
            color: #000000; /* Standaard blauwe kleur voor links */
            font-size: 18px; /* Vergroot de tekst voor een beter overzicht */
            font-weight: bold; /* Maak de tekst vetgedrukt voor nadruk */
            display: inline-block; /* Zorgt ervoor dat de gehele link klikbaar is */
            padding: 10px 15px; /* Voeg padding toe voor een meer 'button'-achtige uitstraling */
            border-radius: 5px; /* Afronden van de hoeken */
            background-color: #007bff; /* Lichtblauwe achtergrondkleur */
            transition: background-color 0.3s, color 0.3s; /* Voegt een soepele overgang toe bij hover */
        }

        ul li a:hover {
            background-color: #007bff; /* Donkerblauwe achtergrondkleur bij hover */
            color: white; /* Witte tekstkleur bij hover */
        }

        .header {
            background-color: #007BFF;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .nav ul {
            display: flex;
            justify-content: center;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .nav ul li {
            margin: 0 10px;
        }

        .nav ul li a, .nav ul li form button {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .nav ul li form button {
            background: none;
            border: none;
            cursor: pointer;
        }

        .main {
            padding: 1rem;
        }

        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        /* Buttons */
        button, .btn {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            cursor: pointer;
            margin: 5px 0;
            display: inline-block;
        }

        .btn-delete {
            background-color: #ff0000;
        }

        button:hover, .btn:hover {
            background-color: #0056b3;
        }

        /* Forms */
        form {
            margin: 10px 0;
        }

        form label {
            display: block;
            margin: 5px 0;
        }

        form input, form textarea, form select {
            width: 80%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .nav ul {
                flex-direction: column;
            }

            table th, table td {
                font-size: 14px;
            }

            button, .btn {
                font-size: 14px;
                padding: 8px 16px;
            }
        }

        /* Algemeen ontwerp voor de admin-interface */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        h1, h2 {
            color: #333;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        .error-messages {
            color: red;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .form label {
            display: block;
            margin-bottom: 8px;
        }

        .form input, .form select {
            width: 90%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .form button:hover {
            background-color: #218838;
        }

        /* Algemeen ontwerp voor de admin-interface */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        h1, h2 {
            color: #333;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .table-container {
            max-height: 500px; /* Zet de maximale hoogte van de tabel */
            overflow-y: auto;  /* Laat de tabel verticaal scrollen wanneer nodig */
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        .error-messages {
            color: red;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .checkbox-container {
            position: relative; /* Zorg ervoor dat je de container positioneert */
            align-items: center; /* Align the checkbox and label vertically */
            z-index: 10; /* Zet een hoge waarde zodat het boven andere elementen staat */
            background-color: white; /* Optioneel: geef een achtergrondkleur om overlappen te benadrukken */
            padding: 10px; /* Voeg wat ruimte rond de inhoud toe */
            border: 1px solid #ccc; /* Optionele styling voor duidelijkheid */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtiele schaduw voor visuele nadruk */
            margin: 1rem
        }

        /* Verbetering van de checkbox zelf */
        .checkbox-container input[type="checkbox"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #007bff;
            border-radius: 4px;
            outline: none;
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s;
            text-align: center;
        }

        /* Toestand voor aangeklikte checkbox */
        .checkbox-container input[type="checkbox"]:checked {
            background-color: #007bff;
            border-color: #0056b3;
            position: relative;
        }

        /* Visuele checkmark */
        .checkbox-container input[type="checkbox"]:checked::after {
            content: '✔';
            color: white;
            font-size: 14px;
            position: absolute;
            left: 4px;
            top: 0;
        }

        /* Label-styling */
        .checkbox-container label {
            margin-left: 10px;
            font-size: 16px;
            cursor: pointer;
            line-height: 1;
        }

        .form-control-checkbox {
            text-align: center;
            margin: 0;
        }

        /* Responsief gedrag voor mobiele apparaten */
        @media (max-width: 768px) {
            .checkbox-container {
                margin-bottom: 15px;
            }
            .checkbox-container input[type="checkbox"] {
                width: 25px;
                height: 25px;
            }
            .checkbox-container label {
                font-size: 18px;
            }
        }



    </style>
</head>
<body>
    <main class="main">
        @yield('content') <!-- Placeholder for additional content -->
    </main>
    <footer class="footer">
        <p>&copy; 2025 Waterpolo Admin Panel</p>
    </footer>
</body>
</html>
