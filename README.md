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
GET /api/machines

{
    "message": "Machines",
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
GET /api/workers

{
    "message": "Workers",
    "count": 9,
    "data": [
        {
            "id": 1,
            "name": "Андрей"
        },
        {
            "id": 2,
            "name": "Сергей"
        },
        {
            "id": 3,
            "name": "Михаил"
        },
        {
            "id": 4,
            "name": "Стас"
        },
        {
            "id": 5,
            "name": "Артем"
        },
        {
            "id": 6,
            "name": "Татьяна"
        },
        {
            "id": 7,
            "name": "Евгений"
        },
        {
            "id": 8,
            "name": "Катя"
        },
        {
            "id": 9,
            "name": "Борис"
        }
    ]
}
```

========

#### set machine usage (worker Андрей, machine ID 102)

```
POST /api/start?machine=102&worker=Андрей

```

#### starting to use the machine

```
{
    "message": "The cycle started successfully",
    "count": 2,
    "data": {
        "machine": 102,
        "worker": "Андрей"
    }
}
```

#### the machine is in use

```
{
    "errors": "Cycle start fail, the machine ID 56 is currently in use",
    "code": 501
}
```

#### the machine not found in the system

```
{
    "errors": "The selected machine is invalid.",
    "code": 501
}
```

#### the worker not found in the system

```
{
    "errors": "The selected worker is invalid.",
    "code": 501
}
```


========

##### set the end of use of the machine (worker Андрей, machine ID 102)

```
PUT /api/end?machine=102&worker=Андрей
```

#### end of machine use

```
{
    "message": "The cycle completed successfully",
    "data": {
        "machine": 102,
        "worker": "Андрей"	
    }
}
```

#### the machine is not in use

```
{
    "errors": "Cycle end fail, machine ID 102 is not using now",
    "code": 501
}
```

**the machine not found in the system** [`see this`](#the-machine-not-found-in-the-system)

**worker not found in the system** [`see this`](#the-worker-not-found-in-the-system)

========

##### request for up-to-date information on the worker Андрей

```
GET /api/worker_now?worker=Андрей

{
    "message": "Андрей uses machine(s)",
    "count": 1,
    "data": {
        "worker": {
            "id": 1,
            "name": "Андрей",
            "machines_now": [
                {
                    "id": 23,
                    "worker_id": 1
                },
                {
                    "id": 56,
                    "worker_id": 1
                }
            ]
        }
    }
}
```

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

========

##### request for up-to-date information on the machine 102

```
GET /api/machine_now?machine=102

{
    "message": "machine ID 102 is used by",
    "count": 1,
    "data": {
        "machine": {
            "id": 102,
            "worker_id": 1,
            "worker": {
                "id": 1,
                "name": "Андрей"
            }
        }
    }
}
```

```
{
    "errors": "Machine ID 102 is not currently in use",
    "code": 501
}
```

**worker not found in the system** [`see this`](#worker-not-found-in-the-system)

#### validation error

```
{
    "errors": "The machine field is required.",
    "code": 501
}

{
	"errors": {
		"worker": [
			"The worker field is required."
		]
	}
}

```

========

##### request of the machine usage history

```
GET /api/machine_history?machine=102

{
    "message": "Usage history of machine ID 56",
    "count": 3,
    "data": [
        {
            "id": 136,
            "complete": "Complete",
            "start": "2025-05-10 11:32:27",
            "end": "2025-05-10 11:36:14",
            "workers": [
                {
                    "id": 9,
                    "name": "Борис",
                    "cycle_worker": {
                        "cycle_id": 136,
                        "worker_id": 9
                    }
                }
            ]
        },
        {
            "id": 137,
            "complete": "Complete",
            "start": "2025-05-10 14:57:48",
            "end": "2025-05-10 14:59:20",
            "workers": [
                {
                    "id": 9,
                    "name": "Борис",
                    "cycle_worker": {
                        "cycle_id": 137,
                        "worker_id": 9
                    }
                }
            ]
        },
        {
            "id": 145,
            "complete": "Complete",
            "start": "2025-05-15 08:43:24",
            "end": "2025-05-15 08:45:00",
            "workers": [
                {
                    "id": 10,
                    "name": "Alex",
                    "cycle_worker": {
                        "cycle_id": 145,
                        "worker_id": 10
                    }
                }
            ]
        }
    ]
}
```

#### the machine has not been used yet

```
{
    "errors": "Machine ID 56 has not been used yet",
    "code": 501
}
```

**the machine not found in the system** [`see this`](#the-machine-not-found-in-the-system)

========

##### request of the worker job history with pagination

```
GET /api/worker_history?worker=Андрей&page=3&per_page=2

{
    "message": "History job of worker Андрей",
    "meta": {
        "from": 5,
        "to": 7,
        "current_page": 3,
        "last_page": 36,
        "per_page": 2,
        "total": 72
    },
    "link": {
        "path": "http://localhost/api/worker_history",
        "first_page_url": "http://localhost/api/worker_history?page=1",
        "prev_page_url": "http://localhost/api/worker_history?page=2",
        "next_page_url": "http://localhost/api/worker_history?page=4",
        "last_page_url": "http://localhost/api/worker_history?page=36"
    },
    "data": [
        {
            "id": 47,
            "complete": "Complete",
            "start": "2025-05-10 14:26:47",
            "end": "2025-05-10 16:13:20",
            "machines": [
                {
                    "id": 102,
                    "worker_id": 1,
                    "cycle_machine": {
                        "cycle_id": 47,
                        "machine_id": 102
                    }
                }
            ]
        },
        {
            "id": 50,
            "complete": "Complete",
            "start": "2025-05-12 06:37:00",
            "end": "2025-05-12 06:44:23",
            "machines": [
                {
                    "id": 102,
                    "worker_id": 1,
                    "cycle_machine": {
                        "cycle_id": 50,
                        "machine_id": 102
                    }
                }
            ]
        }
    ]
}
```

#### the worker has no work history

```
{
    "errors": "Worker Сергей has no history yet",
    "code": 501
}
```

**worker not found in the system** [`see this`](#the-worker-not-found-in-the-system)

====================================!
