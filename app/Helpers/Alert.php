<?php

namespace App\Helpers;


class Alert {
    public static function success($message): void
    {
        session()->flash('success', $message);
    }
    public static function error($message): void
    {
        session()->flash('error', $message);
    }
    public static function warning($message): void
    {
        session()->flash('warning', $message);
    }
    public static function info($message): void
    {
        session()->flash('info', $message);
    }
}

