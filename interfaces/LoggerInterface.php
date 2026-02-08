<?php
interface LoggerInterface{
    public function DebugMessage(string $message): void;
    public function InfoMessage(string $message): void;
    public function ErrorMessage(string $message): void;
}