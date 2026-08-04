<?php

namespace App\Services\Contact;

use App\Models\ContactMessage;

class ContactService
{
    public function store(array $data): ContactMessage
    {
        return ContactMessage::create($data);
    }
}