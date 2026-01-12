# WGHTD_BE - Backend API

Backend Laravel per l'applicazione di tracciamento del peso corporeo.

## 📋 Requisiti

- PHP >= 8.1
- Composer
- MySQL o MariaDB
- Laravel 11

## 🚀 Installazione

### 1. Clona il repository

```bash
git clone <repository-url>
cd wghtd_be
```

### 2. Installa le dipendenze

```bash
composer install
```

### 3. Configura l'ambiente

```bash
# Copia il file .env di esempio
cp .env.example .env

# Genera la chiave applicazione
php artisan key:generate
```

### 4. Configura il database

Modifica il file `.env` con le tue credenziali:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wghtd
DB_USERNAME=root
DB_PASSWORD=tua_password
```

### 5. Crea il database

```sql
CREATE DATABASE wghtd;
```

### 6. Esegui le migrations

```bash
php artisan migrate
```

### 7. Avvia il server

```bash
php artisan serve
```

Il server sarà disponibile su `http://127.0.0.1:8000`

## 📡 API Endpoints

### Autenticazione

#### Registrazione
```http
POST /api/register
Content-Type: application/json

{
  "name": "Mario Rossi",
  "email": "mario@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Risposta:**
```json
{
  "message": "Registrazione completata con successo",
  "user": {
    "id": 1,
    "name": "Mario Rossi",
    "email": "mario@example.com"
  },
  "access_token": "1|xyz...",
  "token_type": "Bearer"
}
```

#### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "mario@example.com",
  "password": "password123"
}
```

**Risposta:**
```json
{
  "message": "Login effettuato con successo",
  "user": { ... },
  "access_token": "2|abc...",
  "token_type": "Bearer"
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

#### Utente Corrente
```http
GET /api/me
Authorization: Bearer {token}
```

### Misurazioni

Tutte le route richiedono autenticazione (`Authorization: Bearer {token}`)

#### Lista Misurazioni
```http
GET /api/misurazioni
```

**Risposta:**
```json
[
  {
    "id": 1,
    "user_id": 1,
    "peso": "75.50",
    "data": "2025-01-12",
    "ora": "08:30:00",
    "strumento_id": 1,
    "stomaco_vuoto": true,
    "strumento": {
      "id": 1,
      "nome": "Bilancia Digitale"
    }
  }
]
```

#### Crea Misurazione
```http
POST /api/misurazioni
Content-Type: application/json

{
  "peso": 75.5,
  "data": "2025-01-12",
  "ora": "08:30:00",
  "strumento_id": 1,
  "stomaco_vuoto": true
}
```

#### Visualizza Misurazione
```http
GET /api/misurazioni/{id}
```

#### Aggiorna Misurazione
```http
PUT /api/misurazioni/{id}
Content-Type: application/json

{
  "peso": 76.0
}
```

#### Elimina Misurazione
```http
DELETE /api/misurazioni/{id}
```

### Strumenti (Bilance)

#### Lista Strumenti
```http
GET /api/strumenti
```

**Risposta:**
```json
[
  {
    "id": 1,
    "nome": "Bilancia Digitale",
    "marca": "Xiaomi",
    "descrizione": "Bilancia smart bluetooth",
    "created_by": 1,
    "creatore": {
      "id": 1,
      "name": "Mario Rossi"
    }
  }
]
```

#### Crea Strumento
```http
POST /api/strumenti
Content-Type: application/json

{
  "nome": "Bilancia Digitale",
  "marca": "Xiaomi",
  "descrizione": "Bilancia smart bluetooth"
}
```

#### Visualizza Strumento
```http
GET /api/strumenti/{id}
```

#### Aggiorna Strumento
```http
PUT /api/strumenti/{id}
Content-Type: application/json

{
  "nome": "Bilancia Smart",
  "marca": "Xiaomi Mi"
}
```

**Nota:** Solo il creatore può modificare uno strumento.

#### Elimina Strumento
```http
DELETE /api/strumenti/{id}
```

**Nota:** Solo il creatore può eliminare uno strumento.

## 🗄️ Struttura Database

### Tabella `users`
- `id` - ID univoco
- `name` - Nome utente
- `email` - Email (univoca)
- `password` - Password hashata
- `created_at`, `updated_at`

### Tabella `strumenti`
- `id` - ID univoco
- `nome` - Nome strumento
- `marca` - Marca (opzionale)
- `descrizione` - Descrizione (opzionale)
- `created_by` - ID utente creatore
- `created_at`, `updated_at`

### Tabella `misurazioni`
- `id` - ID univoco
- `user_id` - ID utente
- `peso` - Peso in kg (decimal 5,2)
- `data` - Data misurazione
- `ora` - Ora misurazione
- `strumento_id` - ID strumento (opzionale)
- `stomaco_vuoto` - Boolean
- `created_at`, `updated_at`

## 🔒 Sicurezza

- Le password sono hashate con bcrypt
- Autenticazione tramite Laravel Sanctum (token Bearer)
- Le route API sono protette da middleware `auth:sanctum`
- Ogni utente vede solo le proprie misurazioni
- Gli strumenti sono condivisi ma modificabili solo dal creatore
- Le route web sono bloccate (API only)

## 🧪 Testing

```bash
# Esegui i test
php artisan test
```

## 📝 Note

- L'accesso web è disabilitato - solo API
- Gli strumenti sono condivisi tra tutti gli utenti
- Le misurazioni sono private per ogni utente
- Non è richiesta verifica email per la registrazione

## 🛠️ Comandi Utili

```bash
# Cancella cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Visualizza tutte le route
php artisan route:list

# Rollback migrations
php artisan migrate:rollback

# Fresh migrations (attenzione: cancella tutti i dati)
php artisan migrate:fresh
```

## 📄 Licenza

Progetto personale - Tutti i diritti riservati