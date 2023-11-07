<?php

namespace App\Domain\User;

interface Document
{
    public function getValue(): string;
}