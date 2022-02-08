<?php

namespace LeadsZapp;

defined('ABSPATH') || exit('No direct script access allowed');

class API
{
    protected $contact;
    protected $message;

    private $env;

    private const URL = 'https://hub.leadszapp.com/api/v1/whatsapp/send';

    public function __construct()
    {
        $this->env = new Env();
    }

    public function setContact(Contact $contact)
    {
        $this->contact = $contact->getStructure();
    }

    public function sendMessage(): void
    {
        $this->setMessage();
        $this->send();
    }

    private function send(): bool
    {
        if (!$this->env->getApiKey()) : 
            return false;
        endif;

        $data = [
            'headers'   => [
                'Content-Type'  => 'application/json',
                'X-API-KEY'     => $this->env->getApiKey()
            ],
            'body'       => json_encode((object) [
                'bot'           => $this->env->getBotID(),
                'contact'       => $this->contact,
                'messages'      => [ $this->message ]
            ])
        ];

        $response = wp_remote_post(self::URL, $data);
        return (!is_wp_error($response) && wp_remote_retrieve_response_code( $response ) === 200);
    }

    private function setMessage(): void
    {
        $body = $this->env->getMessageBody();
        $placeholders = [
            'nome_completo' => $this->contact->first_name . ' ' . $this->contact->last_name,
            'nome'          => $this->contact->first_name,
            'sobrenome'     => $this->contact->last_name,
        ];

        $this->message = $this->parseBody($body, $placeholders);
    }

    private function parseBody(string $message, array $placeholders): string
    {
        foreach ($placeholders as $key => $value) : 
            $message = str_replace('{'. $key .'}', $value, $message);
        endforeach;

        return $message;
    }
}