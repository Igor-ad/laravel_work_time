<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Laravel Work Time
### REST API queries implementation

- commands of application init:

```
> cd /path_to_application
> ./vendor/bin/sail up -d
> composer update
> ./vendor/bin/sail artisan migrate
> ./vendor/bin/sail artisan db:seed
```

#### Examples of requests and responses

#### machine list request
```
GET http://localhost:80/api/machines/?api_token=**********

HTTP/1.1 200 OK
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

{
    "message": "machines",
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
```
========

#### worker list request
```
GET http://localhost:80/api/workers/?api_token=**********

HTTP/1.1 200 OK
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

{
    "message": "workers",
    "count": 10,
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
```
========

#### set machine usage (worker Андрей, machine ID 102)
```
POST http://localhost:80/api/start/?machine=102&worker=Андрей&api_token=**********
```

#### the machine is in use

```
HTTP/1.1 501 Not Implemented
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

{
    "error": "machine ID 44 is currently in use"
}
```

#### the machine not found in the system

```
{
    "status": 422,
    "errors": {
        "worker": [
            "The selected worker is invalid."
        ]
    }
}
```

#### worker not found in the system

```
{
    "status": 422,
    "errors": {
        "machine": [
            "The selected machine is invalid."
        ]
    }
}
```

#### starting to use the machine

```
HTTP/1.1 201 Created
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

{
    "message": "the cycle started successfully",
    "data": {
        "machine": 44,
        "worker": "Андрей"
    }
}
```

========

##### set the end of use of the machine (worker Андрей, machine ID 102)

```
PUT http://localhost:80/api/end/?machine=102&worker=Андрей&api_token=**********
```

#### the machine is not in use

```
HTTP/1.1 501 Not Implemented
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

{
    "error": "machine ID 44 is not using now"
}
```

**the machine not found in the system** [`see this`](#the-machine-not-found-in-the-system)

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

#### end of machine use

```
HTTP/1.1 200 OK
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

{
    "message": "the cycle completed successfully",
    "data": {
        "machine": 44,
        "worker": "Андрей"	
    }
}
```

========

##### request for up-to-date information on the worker Андрей

```
GET http://localhost:80/api/worker_now/?worker=Андрей&api_token=**********

HTTP/1.1 200 OK
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

{
    "message": "Андрей uses machine(s)",
    "data": [
        {
            "id": 44
        },
        {
            "id": 102
        }
    ]
}
```

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

========

##### request for up-to-date information on the machine 102

```
GET http://localhost:80/api/machine_now/?machine=102&api_token=**********

HTTP/1.1 200 OK
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

{
    "message": "machine 102 is used by",
    "data": [
        {
            "name": "Андрей"
        }
    ]
}
```

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

#### validation error

```
HTTP/1.0 422 Unprocessable Content
Host: localhost:80
Date: Mon, 02 Oct 2023 09:59:47 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 09:59:47 GMT
Content-Type: application/json
Access-Control-Allow-Origin: *

{
	"errors": {
		"machine": [
			"The machine field is required."
		]
	}
}
```

========

##### request of the machine usage history

```
GET http://localhost:80/api/machine_history/?machine=102&api_token=**********

HTTP/1.1 200 OK
Host: localhost:80
Date: Mon, 16 Oct 2023 10:53:10 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 14:53:10 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

{
    "message": "history machine usage with ID 102",
    "count": 5,
    "data": [
        {
            "worker": "Андрей",
            "start": "2023-10-09 18:48:42",
            "end": "2023-10-09 18:49:18",
            "complete": 1
        },
        {
            "worker": "Андрей",
            "start": "2023-10-09 16:40:26",
            "end": "2023-10-09 18:47:55",
            "complete": 1
        },
        {
            "worker": "Андрей",
            "start": "2023-10-09 16:40:18",
            "end": "2023-10-09 16:40:21",
            "complete": 1
        },
        {
            "worker": "Андрей",
            "start": "2023-10-09 16:26:07",
            "end": "2023-10-09 16:26:10",
            "complete": 1
        },
        {
            "worker": "Андрей",
            "start": "2023-10-09 16:21:58",
            "end": "2023-10-09 16:22:02",
            "complete": 1
        }
    ]
}
```

#### the machine has not been used yet

```
{
    "error": "machine ID 56 has not been used yet"
}
```

**the machine not found in the system** [`see this`](#the-machine-not-found-in-the-system)

========

##### request of the worker job history with pagination

```
GET http://localhost:80/api/worker_history/?worker=Андрей&page=3&per_page=5&api_token=**********

HTTP/1.1 200 OK
Host: localhost:80
Date: Mon, 16 Oct 2023 10:54:10 GMT
Connection: close
X-Powered-By: PHP/8.2.10
Cache-Control: no-cache, private
Date: Mon, 02 Oct 2023 14:54:10 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

{
    "message": "history job worker Андрей",
    "data": [
        {
            "machine": 102,
            "start": "2023-10-09 16:26:07",
            "end": "2023-10-09 16:26:10",
            "complete": 1
        },
        {
            "machine": 102,
            "start": "2023-10-09 16:21:58",
            "end": "2023-10-09 16:22:02",
            "complete": 1
        },
        {
            "machine": 102,
            "start": "2023-10-09 13:28:49",
            "end": "2023-10-09 16:21:53",
            "complete": 1
        }
    ],
    "meta": {
        "from": 4,
        "to": 7,
        "current_page": 2,
        "last_page": 23,
        "per_page": 3,
        "total": 68,
        "link": {
            "path": "http:\/\/192.168.4.145\/api\/worker_history",
            "first_page_url": "http:\/\/192.168.4.145\/api\/worker_history?page=1",
            "prev_page_url": "http:\/\/192.168.4.145\/api\/worker_history?page=1",
            "next_page_url": "http:\/\/192.168.4.145\/api\/worker_history?page=3",
            "last_page_url": "http:\/\/192.168.4.145\/api\/worker_history?page=23"
        }
    }
}
```

#### the worker has no work history

```
{
    "error": "worker Борис has no history yet"
}
```

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

====================================!
