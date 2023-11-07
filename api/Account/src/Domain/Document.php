<?php

namespace Account\Domain;

interface Document
{
    public function getValue(): string;
}