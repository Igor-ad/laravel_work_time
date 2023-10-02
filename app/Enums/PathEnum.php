<?php

namespace App\Enums;

enum PathEnum: string
{
    case getWorkers = '/workers/';
    case getMachines = '/machines/';
    case setStart = '/start/';
    case setEnd = '/end/';
    case getWorkerNow = '/worker_now/';
    case getMachineNow = '/machine_now/';
    case getWorkerHistory = '/worker_history/';
    case getMachineHistory = '/machine_history/';
}
