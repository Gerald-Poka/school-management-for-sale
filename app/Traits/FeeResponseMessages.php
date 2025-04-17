<?php

namespace App\Traits;

trait FeeResponseMessages
{
    protected function getSuccessMessage(string $type, string $action): string
    {
        return ucfirst($type) . " fee structure {$action} successfully.";
    }

    protected function getErrorMessage(string $type, string $action): string
    {
        return "Unable to {$action} {$type} fee structure. Please try again.";
    }
}