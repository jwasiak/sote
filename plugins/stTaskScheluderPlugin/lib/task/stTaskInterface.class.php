<?php

interface stTaskInterface
{
    public function getId(): string;
    public function getName(): string;
    public function getTimeInterval(): int;
    public function getExecuteAt(): string;
    public function getStatus(): int;
    public function isReadyToExecute(): bool;
    public function getProgress(): int;
    public function getLastProgress(): int;
    public function getTask(): Task;
    public function doCount(): int;
    public function count(): int;
    public function doExecute(int $offset): int;
    public function execute(int $offset): int;
    public function getLogger(): stTaskLoggerInterface;
    public function refreshActiveStatus(): void;
}