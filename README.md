# LARGO_System1 — Hotel System (Main CRUD Application)

Full CRUD web app for managing hotel rooms. Runs on **port 80** inside the
Docker environment (see the `YourLastName_DockerCodebase` repo for
docker-compose.yml and infra config).

## Files
- `index.html` — landing page (redirects to read.php)
- `read.php` — list all rooms (R)
- `create.php` — add a new room (C) — staff dropdown loaded from the microservice API
- `update.php` — edit a room (U) — staff dropdown loaded from the microservice API
- `delete.php` — remove a room (D)
- `db_config.php` — MySQL connection (PDO)
- `fetch_api.php` — optional server-side proxy to the microservice API
- `script.js` — fetches `http://<host>:81/api.php` and fills the staff dropdown
- `style.css` — styling

## Integration with System 2
The Create and Update forms populate an "Assigned Staff" dropdown by calling
the Employee Microservice's API (System 2) at `http://localhost:81/api.php`.
