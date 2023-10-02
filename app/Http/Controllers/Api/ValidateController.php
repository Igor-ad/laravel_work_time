<?php

namespace App\Http\Controllers\Api;

trait ValidateController
{
    private readonly string|null $worker;
    private readonly int|null $machine;

    /**
     * @return void
     */
    protected function validateInput(): void
    {
        $validData = $this->request->validated();

        $this->worker = $validData['worker'] ?? null;
        $this->machine = $validData['machine'] ?? null;
    }
}
