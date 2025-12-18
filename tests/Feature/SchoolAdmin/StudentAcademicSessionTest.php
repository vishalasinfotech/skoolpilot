<?php

namespace Tests\Feature\SchoolAdmin;

use Tests\TestCase;

class StudentAcademicSessionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
