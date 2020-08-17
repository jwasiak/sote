<?php

interface stTaskLoggerInterface
{
    public function log(int $type, string $message, array $messageParams = null): stTaskLoggerInterface;
    public function info(string $message, array $messageParams = null): stTaskLoggerInterface;
    public function error(string $message, array $messageParams = null): stTaskLoggerInterface;
    public function warning(string $message, array $messageParams = null): stTaskLoggerInterface;
    public function exception(Throwable $e): stTaskLoggerInterface;
}