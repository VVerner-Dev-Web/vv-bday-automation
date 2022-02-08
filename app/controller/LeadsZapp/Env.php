<?php

namespace LeadsZapp;

defined('ABSPATH') || exit('No direct script access allowed');

class Env
{
    private const PREFIX = '_leadszapp-';

    public function setApiKey(string $value)
    {
        $value = sanitize_text_field($value);
        $this->set('api_key', $value);
    }

    public function getApiKey()
    {
        return $this->get('api_key');
    }

    public function setBotID(int $value)
    {
        $this->set('bot_id', $value);
    }

    public function getBotID()
    {
        return $this->get('bot_id');
    }

    public function setMessageBody(string $value)
    {
        $value = sanitize_textarea_field($value);
        $this->set('message_body', $value);
    }

    public function getMessageBody()
    {
        return $this->get('message_body');
    }

    private function get(string $prop)
    {
        return get_option(self::PREFIX . $prop, null);
    }

    private function set(string $prop, $value)
    {
        update_option(self::PREFIX . $prop, $value, false);
    }

}