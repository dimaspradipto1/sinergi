<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BackupTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::first() ?? User::factory()->create();
    }

    public function test_backup_page_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('backup.index'));

        $response->assertStatus(200);
        $response->assertSee('Backup Database & Storage', false);
        $response->assertSee('Ekspor & Impor Database', false);
        $response->assertSee('Backup & Impor Storage Public', false);
    }

    public function test_backup_database_download(): void
    {
        $response = $this->actingAs($this->user)->get(route('backup.database.download'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/sql');
        $this->assertStringContainsString('SINERGI PLD Database Backup', $response->getContent());
    }

    public function test_backup_storage_download(): void
    {
        // Pastikan ada file dummy di storage/app/public
        $storagePublic = storage_path('app/public');
        if (!File::exists($storagePublic)) {
            File::makeDirectory($storagePublic, 0755, true);
        }
        File::put($storagePublic . DIRECTORY_SEPARATOR . 'test-dummy.txt', 'Test content');

        $response = $this->actingAs($this->user)->get(route('backup.storage.download'));

        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-disposition'), '.zip'));

        // Cleanup
        if (File::exists($storagePublic . DIRECTORY_SEPARATOR . 'test-dummy.txt')) {
            File::delete($storagePublic . DIRECTORY_SEPARATOR . 'test-dummy.txt');
        }
    }

    public function test_backup_database_restore(): void
    {
        $sqlContent = "-- Test Restore\nSELECT 1;\n";
        $file = UploadedFile::fake()->createWithContent('backup.sql', $sqlContent);

        $response = $this->actingAs($this->user)->post(route('backup.database.restore'), [
            'sql_file' => $file,
        ]);

        $response->assertRedirect(route('backup.index'));
        $response->assertSessionHasNoErrors();
    }
}
