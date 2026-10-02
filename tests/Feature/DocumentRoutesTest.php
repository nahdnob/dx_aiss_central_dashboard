<?php

namespace Tests\Feature;

use Tests\TestCase;

class DocumentRoutesTest extends TestCase
{
    public function test_documents_landing_page_loads_successfully(): void
    {
        $response = $this->get('/documents');
        $response->assertStatus(200);
    }

    public function test_dasg_index_loads_successfully(): void
    {
        $response = $this->get('/dasgs');
        $response->assertStatus(200);
    }

    public function test_risk_assessment_index_loads_successfully(): void
    {
        $response = $this->get('/risk-assessments');
        $response->assertStatus(200);
    }

    public function test_sop_index_loads_successfully(): void
    {
        $response = $this->get('/sops');
        $response->assertStatus(200);
    }

    public function test_machines_index_loads_successfully(): void
    {
        $response = $this->get('/machines');
        $response->assertStatus(200);
    }

    public function test_system_managers_redirects_to_login_if_unauthenticated(): void
    {
        $response = $this->get('/system-managers');
        $response->assertStatus(302);
    }
}
