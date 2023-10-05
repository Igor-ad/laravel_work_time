<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel Work Time
### REST API queries implementation

- commands of application init:
- - cd /path_to_application
- - ./vendor/bin/sail up -d
- - composer update
- - ./vendor/bin/sail artisan migrate
- - ./vendor/bin/sail artisan db:seed


-  \app\Enums\PathEnum this file contains all system paths.


#### Examples of requests and responses

#### machine list request

> GET http://localhost:80/api/machines/?api_token=**********

> HTTP/1.1 200 OK
Host: localhost:80
Date: Mon, 02 Oct 2023 10:17:58 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 10:17:58 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

> {
"machines": {
"count": 5,
"data": [
{
"id": 23
},
{
"id": 44
},
{
"id": 56
},
{
"id": 78
},
{
"id": 102
}
]
}
}

========

#### worker list request

> GET http://localhost:80/api/workers/?api_token=**********

>HTTP/1.1 200 OK
Host: localhost:80
Date: Mon, 02 Oct 2023 10:31:44 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 10:31:44 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

> {
"workers": {
"count": 9,
"data": [
{
"name": "Андрей"
},
{
"name": "Сергей"
},
{
"name": "Михаил"
},
{
"name": "Стас"
},
{
"name": "Артем"
},
{
"name": "Татьяна"
},
{
"name": "Евгений"
},
{
"name": "Катя"
},
{
"name": "Борис"
}
]
}
}

========

#### set machine usage (worker Андрей, machine ID 102)

> PUT http://localhost:80/api/start/?machine=102&worker=Андрей&api_token=**********

#### the machine is in use

>HTTP/1.1 501 Not Implemented
Host: localhost:80
Date: Mon, 02 Oct 2023 10:34:51 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 10:34:51 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

> {
"error": {
"machine": 102,
"worker": "Андрей",
"msg": "error, the machine ID 102 is currently in use"
}
}

#### the machine not found in the system

> {
"error": {
"machine": 24,
"worker": "Андрей",
"msg": "machine ID 24 not found in the system"
}
}

#### worker not found in the system

> {
"error": {
"machine": 23,
"worker": "Андрейs",
"msg": "worker Андрейs not found in the system"
}
}

#### starting to use the machine

>HTTP/1.1 201 Created
Host: localhost:80
Date: Mon, 02 Oct 2023 10:36:02 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 10:36:02 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

> {
"message": {
"machine": 102,
"worker": "Андрей",
"msg": "the cycle started successfully"
}
}

======== 

##### set the end of use of the machine (worker Андрей, machine ID 102)

> PUT http://localhost:80/api/end/?machine=102&worker=Андрей&api_token=**********

#### the machine is not in use

>HTTP/1.1 501 Not Implemented
Host: localhost:80
Date: Mon, 02 Oct 2023 11:01:53 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 14:01:53 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

> {
"error": {
"machine": 102,
"worker": "Андрей",
"msg": "error, machine 102 is not using now"
}
}

**the machine not found in the system** [`see this`](#the-machine-not-found-in-the-system) 

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

#### end of machine use

>HTTP/1.1 201 OK
Host: localhost:80
Date: Mon, 02 Oct 2023 14:02:56 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 14:02:56 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

> {
"message": {
"machine": 102,
"worker": "Андрей",
"msg": "the cycle completed successfully"
}
}

========

##### request for up-to-date information on the worker Андрей

> GET http://localhost:80/api/worker_now/?worker=Андрей&api_token=**********

> HTTP/1.1 200 OK
Host: localhost:80
Date: Mon, 02 Oct 2023 10:49:26 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 14:49:26 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

> {
"Андрей uses machine(s)": [
{
"id": 102
}
]
}

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

========

##### request for up-to-date information on the machine 102

> GET http://localhost:80/api/machine_now/?machine=102&api_token=**********

> HTTP/1.1 200 OK
Host: localhost:80
Date: Mon, 02 Oct 2023 10:52:17 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 14:52:17 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 57
Access-Control-Allow-Origin: *

> {
"Андрей uses machine(s)": [
{
"id": 23
},
{
"id": 102
}
]
}

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

#### validation error

> HTTP/1.0 422 Unprocessable Content
Host: localhost:80
Date: Mon, 02 Oct 2023 09:59:47 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 09:59:47 GMT
Content-Type: application/json
Access-Control-Allow-Origin: *

> {
"errors": {
"machine": [
"The machine field is required."
]
}
}

========

##### request of the machine usage history

> GET http://localhost:80/api/machine_history/?machine=102&api_token=**********

> HTTP/1.1 200 OK
Host: localhost:80
Date: Mon, 02 Oct 2023 10:53:10 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 14:53:10 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

> {
"history machine usage with ID 102": {
"count": 5,
"data": [
{
"worker": "Андрей",
"start": "2023-09-29 08:01:36",
"end": "2023-09-29 08:01:36",
"complete": 0
},
{
"worker": "Андрей",
"start": "2023-09-29 07:53:33",
"end": "2023-09-29 07:54:51",
"complete": 1
},
{
"worker": "Андрей",
"start": "2023-09-29 07:45:11",
"end": "2023-09-29 07:48:34",
"complete": 1
},
{
"worker": "Андрей",
"start": "2023-09-29 07:42:53",
"end": "2023-09-29 07:44:48",
"complete": 1
},
{
"worker": "Андрей",
"start": "2023-09-29 07:29:43",
"end": "2023-09-29 07:42:36",
"complete": 1
}
]
}
}

**the machine not found in the system** [`see this`](#the-machine-not-found-in-the-system)

========

##### request of the worker job history with pagination

> GET http://localhost:80/api/worker_history/?worker=Андрей&page=3&per_page=5&api_token=**********

> HTTP/1.1 200 OK
Host: localhost:80
Date: Mon, 02 Oct 2023 10:54:10 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 14:54:10 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

> {
"history job worker Андрей": {
"data": [
{
"machine": 23,
"start": "2023-09-29 10:08:46",
"end": "2023-09-29 10:08:56",
"complete": 1
},
{
"machine": 23,
"start": "2023-09-29 10:08:15",
"end": "2023-09-29 10:08:26",
"complete": 1
},
{
"machine": 23,
"start": "2023-09-29 10:42:47",
"end": "2023-09-29 10:42:59",
"complete": 1
}
],
"meta": {
"from": 11,
"to": 13,
"current_page": 3,
"last_page": 3,
"per_page": 5,
"total": 13,
"link": {
"path": "http:\/\/localhost\/api\/worker_history\/",
"first_page_url": "http:\/\/localhost\/api\/worker_history\/?page=1",
"prev_page_url": "http:\/\/localhost\/api\/worker_history\/?page=2",
"next_page_url": null,
"last_page_url": "http:\/\/localhost\/api\/worker_history\/?page=3"
}
}
}
}

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

====================================!






## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
