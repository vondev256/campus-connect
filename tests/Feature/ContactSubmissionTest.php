<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('valid contact submissions are stored', function () {
    $response = $this->post(route('contact.store'), [
        'full_name' => 'Taylor Example',
        'cartoon_email' => 'taylor@example.com',
        'message' => 'My favorite cartoon is Example Show.',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('contacts', [
        'full_name' => 'Taylor Example',
        'cartoon_email' => 'taylor@example.com',
        'message' => 'My favorite cartoon is Example Show.',
    ]);
});

test('empty contact submissions are rejected without storing a record', function () {
    $response = $this->post(route('contact.store'), []);

    $response->assertSessionHasErrors(['full_name', 'cartoon_email', 'message']);
    $this->assertDatabaseCount('contacts', 0);
});
