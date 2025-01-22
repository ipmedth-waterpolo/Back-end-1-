Uitstekend! Ik zal de README-updates verwerken om de specifieke configuratie-instellingen van je `.env` bestand te reflecteren, zoals de database-instellingen, sessie-instellingen en API-sleutels. Hier is de aangepaste **README** met deze details:

---

# Waterpolo Planner Backend

Dit project bevat de backend voor de **Waterpolo Planner**, een webapplicatie die is ontworpen om waterpolotrainers te helpen bij het snel en efficiënt plannen van trainingen. De backend is gebouwd met **Laravel** en biedt een robuuste API voor de frontend van de applicatie om mee te communiceren.

## Inhoudsopgave

1. [Installatie](#installatie)
2. [Gebruik](#gebruik)
3. [API Endpoints](#api-endpoints)
4. [Technische Specificaties](#technische-specificaties)
5. [Bijdragen](#bijdragen)
6. [Licentie](#licentie)

---

## Installatie

Volg de onderstaande stappen om de backend op je lokale machine in te stellen.

### 1. Clone het project

Clone het repository naar je lokale machine:

```bash
git clone https://github.com/ipmedth-waterpolo/Back-end-1.git
```

### 2. Installeer de afhankelijkheden

Navigeer naar de projectmap en installeer de PHP-afhankelijkheden via Composer:

```bash
cd Back-end-1
composer install
```

### 3. Kopieer de voorbeeld `.env` bestand

Maak een kopie van het voorbeeld `.env` bestand en pas de instellingen aan je lokale omgeving aan:

```bash
cp .env.example .env
```

### 4. Genereer de applicatiesleutel

Genereer een nieuwe applicatiesleutel voor je Laravel-applicatie:

```bash
php artisan key:generate
```

### 5. Database configureren

Stel de juiste databaseverbinding in je `.env` bestand in. In jouw geval wordt een **SQLite** database gebruikt:

```dotenv
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=F:/ProgrameerTalen/Laravel/WaterPoloPlannerDB/database/database.sqlite
DB_USERNAME=root
DB_PASSWORD=password
```

Zorg ervoor dat het pad naar je `database.sqlite` bestand correct is ingesteld.

### 6. Voer de database migraties uit

Voer de migraties uit om de benodigde tabellen te maken:

```bash
php artisan migrate:refresh --seed
```

### 7. Start de server

Start de lokale ontwikkelingsserver:

```bash
php artisan serve
```

De backend draait nu op `http://127.0.0.1:8000`.

---

## Gebruik

De backend biedt verschillende API-endpoints waarmee de frontend kan communiceren. Zie de sectie [API Endpoints](#api-endpoints) voor meer informatie over de beschikbare endpoints.

### Voorbeeld API-aanroepen

- **GET /api/exercises**: Haal een lijst op van alle oefeningen.
- **POST /api/trainings**: Maak een nieuwe training aan.
- **GET /api/trainings/{id}**: Haal de details van een specifieke training op.

check de routes/API.php voor alle routes
---

## Technische Specificaties

- **Framework**: Laravel 8.x
- **Database**: SQLite
- **API**: RESTful API
- **Authenticatie**: JWT (JSON Web Tokens) voor beveiligde API-aanroepen
- **Pakketten**:
  - `laravel/sanctum` voor authenticatie
  - `guzzlehttp/guzzle` voor externe API-aanroepen
  - `fideloper/proxy` voor het ondersteunen van het gebruik van een reverse proxy in productie

### Omgevingsinstellingen

De volgende instellingen zijn geconfigureerd in je `.env` bestand:

```dotenv
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:TrJeEvZwrX5Q44HUMLEZNI/YSKnW2qnprGUSGtBaHPY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=F:/ProgrameerTalen/Laravel/WaterPoloPlannerDB/database/database.sqlite
DB_USERNAME=root
DB_PASSWORD=password

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_STORE=database
CACHE_PREFIX=

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

API_KEY=Safe_Key
```

Zorg ervoor dat je **`API_KEY`** correct is ingesteld en gebruik deze voor beveiligde API-aanroepen.

---

## Bijdragen

Dit is gemaakt door studenten aan de Hogeschool Leiden
Mark van Muijen 
Billie Bakker 
Annick Vink 
Lars Wajer 
