<?php

namespace App\Http\Controllers;

trait Helper
{
    /**
     * @param int $machineId
     * @param string $workerName
     * @param string $message
     * @return array
     */
    protected function toArray(int $machineId, string $workerName, string $message): array
    {
        return [
            'machine' => $machineId,
            'worker' => $workerName,
            'msg' => $message,
        ];
    }
}
