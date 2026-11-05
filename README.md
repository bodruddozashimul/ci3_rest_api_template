# CodeIgniter 3 REST API Template

A ready-to-use **CodeIgniter 3.1.6** REST API starter with **JWT (HS256)** authentication.

## Features
- REST controller (`REST_Controller`) with JSON responses
- JWT login endpoint + `Authorization: Bearer <token>` middleware (`BD_Controller::auth()`)
- Sample protected GET/POST endpoints
- Ready SQL dump with a default user table

## Requirements
- PHP 7.x (developed on 7.4)
- MySQL / MariaDB
- Apache with `mod_rewrite` (or equivalent Nginx rewrite)

## Setup
1. Clone the repo into your web root (e.g. `htdocs/ci3_rest_api_template`).
2. Create a database `api_template` and import `api_template.sql`.
3. Edit DB credentials in `application/config/database.php`.
4. **Change the JWT secret** (`$config['thekey']`) and `encryption_key` in `application/config/config.php`.
5. `base_url` is auto-detected; override it in `config.php` if needed.

## Default login
| Username | Password |
|----------|----------|
| `app`    | `app`    |

> Change or remove this user before any real deployment.

## Endpoints
| Method | URL | Auth | Params |
|--------|-----|------|--------|
| POST | `/auth/login` | No | `username`, `password` |
| GET  | `/test/sample_get_data` | Bearer | `data` |
| POST | `/test/sample_post_data` | Bearer | `data` |

### Example
```bash
# 1. Get token
curl -X POST http://localhost/ci3_rest_api_template/auth/login \
  -d "username=app" -d "password=app"

# 2. Call a protected endpoint
curl "http://localhost/ci3_rest_api_template/test/sample_get_data?data=hello" \
  -H "Authorization: Bearer <token>"
```

## Add your own endpoint
Create `application/controllers/Foo.php`:
```php
class Foo extends BD_Controller {
    function __construct() { parent::__construct(); $this->auth(); }

    public function list_get() {
        $this->response(['status' => TRUE, 'data' => []], REST_Controller::HTTP_OK);
    }
}
```
Available at `GET /foo/list`. Methods are named `<action>_<httpmethod>`.

## Configuration
| Setting | File |
|---------|------|
| Database | `application/config/database.php` |
| JWT secret / expiry (`thekey`, `jwt_expire`, default 2h) | `application/config/config.php` |
| REST options (keys, limits, logging) | `application/config/rest.php` |
| Routes | `application/config/routes.php` |

## Project structure
```
application/
  controllers/   Auth.php, Test.php, Key.php
  core/          BD_Controller.php (JWT middleware)
  libraries/     REST_Controller, JWT, Format
  models/        Users.php
api_template.sql DB schema + default user
```

## Security notes (before production)
- Set `ENVIRONMENT` to `production` (via `CI_ENV`).
- Replace the default JWT secret and `encryption_key`.
- Passwords use MD5 for demo purposes. Switch to `password_hash()` / `password_verify()`.
- Use HTTPS.

## License
CodeIgniter is MIT licensed. Add your own license for this template if needed.
