# Preparation

Download and install [Docker Desktop](https://www.docker.com/products/docker-desktop/).

# Services

1. **MySQL** Database.
2. **PhpMyAdmin** application to be able manually inspect database.
3. **MailPit** application to be able to intercept emails sent by main API-application.
4. Main **API-application** with **Swagger UI** documentation to be able to explore available API endpoints.

# Basic Installation

1. Open terminal in your projects directory.
2. Download GIT-repository: `git clone https://github.com/andrei-kochetygov/training-ground-online-shop.git`.
3. Enter project directory: `cd training-ground-online-shop`.
4. Copy `.env.example` file into `.env` file: `cp .env.example .env`.
5. Make sure that variable `FRONTEND_URL` \(in `.env` file\) is directed to URL which you are using for you FE-application.

# Optional Configuration

- You can specify path of your FE-application on which user able to reset password via `FRONTEND_RESET_PASSWORD_PATH` variable which is `/reset-password` by default. This means that user will receive email with link like `${FRONTEND_URL}${FRONTEND_RESET_PASSWORD_PATH}`, which with default configuration will be `http://localhost:3000/reset-password`.

# Start Work

1. Open your terminal in this project directory.
2. Run `docker compose up --detach --build` command.
3. Run `docker compose logs --follow api` command and wait until you will see `Server running on [http://0.0.0.0:8000]` message in console, after it you can exit from logs.
4. Open URL `${APP_URL}` in browser, which by default is `http://localhost:8000`.
5. Select service you wanna interact with by clicking on the related link.

First of all go to Swagger UI and under `Database` section execute `/api/database/refresh` endpoint and provide credentials for the supervisor. You must pass credentials for the supervisor of you database (basically user which can do everything in the system).

# Stop Work

1. Open your terminal in this project directory.
2. Run `docker compose down` command.

# Utilities

On Swagger UI page you can find special endpoints under `Database` section which can be used to:
1. Refresh database by dropping all tables and execute migration again.
2. Seed database with fake data, to be able to perform quickly test you application behavior and improve API endpoints exploration.