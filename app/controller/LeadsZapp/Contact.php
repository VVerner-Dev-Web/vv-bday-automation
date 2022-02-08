<?php

namespace LeadsZapp;

defined('ABSPATH') || exit('No direct script access allowed');

use stdClass;

class Contact
{
    protected $first_name;
    protected $last_name;
    protected $mobile_phone;

    public function __construct(string $fullName, string $phone)
    {
        $this->parseName($fullName);
        $this->parsePhone($phone);
    }

    public function getStructure(): stdClass
    {
        return (object) [
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'mobile_phone'  => $this->mobile_phone
        ];
    }

    private function parseName(string $value): void
    {
        $name = explode(' ', $value);
        $this->first_name = array_shift($name);
        $this->last_name  = implode(' ', $name);
    }

    private function parsePhone(string $value): void
    {
        $phone  = '55';
        $phone .= preg_replace('/\D/', '', $value);

        $this->mobile_phone = $phone;
    }
}