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

{
    "message": "the cycle started successfully",
    "data": {
        "machine": 102,
        "worker": "Андрей"
    }
}
```

#### the machine is in use

```
{
    "errors": {
        "machine": "the machine ID 56 is currently in use"
    }
}
```

#### the machine not found in the system

```
{
    "errors": { 
        "machine": [
            "The selected machine is invalid."
        ]
    }
}
```

#### worker not found in the system

```
{
    "errors": {
        "worker": [
            "The selected worker is invalid."
        ]
    }
}
```

#### starting to use the machine

```
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
{
    "errors": {
        "machine": "the machine ID 78 is not currently in use"
    }
}
```

**the machine not found in the system** [`see this`](#the-machine-not-found-in-the-system)

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

#### end of machine use

```
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
    "errors": {
        "machine": "machine ID 56 has not been used yet"
    }
}
```

**the machine not found in the system** [`see this`](#the-machine-not-found-in-the-system)

========

##### request of the worker job history with pagination

```
GET http://localhost:80/api/worker_history/?worker=Андрей&page=3&per_page=5&api_token=**********

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
    "errors": {
        "worker": "worker Борис has no history yet"
    }
}
```

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

====================================!
