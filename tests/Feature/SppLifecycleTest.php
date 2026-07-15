<?php

namespace Tests\Feature;

use App\Models\Siswa;
use App\Models\SppBill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SppLifecycleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Use the default testing database configuration
        $this->artisan('migrate:fresh');

        // Authenticate as a user with appropriate permissions
        $user = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
    }

    /** @test */
    public function test_it_can_update_a_bill_amount()
    {
        $siswa = Siswa::factory()->create();
        $bill = SppBill::factory()->create([
            'siswa_id' => $siswa->id,
            'jumlah' => 50000,
            'status' => 'belum',
        ]);

        $this->assertEquals(50000, $bill->jumlah);

        $response = $this->putJson(route('spp.update', $bill), ['jumlah' => 75000]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'bill' => ['jumlah' => 75000]
                 ]);

        $this->assertDatabaseHas('spp_bills', [
            'id' => $bill->id,
            'jumlah' => 75000,
        ]);

        $freshBill = SppBill::find($bill->id);
        $this->assertEquals(75000, (float) $freshBill->jumlah);
        echo "\n[SUCCESS] UPDATE: Bill amount correctly persisted. Fresh value: " . $freshBill->jumlah;
    }

    /** @test */
    public function test_it_can_delete_a_bill()
    {
        $siswa = Siswa::factory()->create();
        $bill = SppBill::factory()->create([
            'siswa_id' => $siswa->id,
            'status' => 'belum',
        ]);
        $billId = $bill->id;

        $this->assertDatabaseHas('spp_bills', ['id' => $billId]);

        $response = $this->deleteJson(route('spp.destroy', $bill));

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('spp_bills', ['id' => $billId]);

        $nonExistentBill = SppBill::find($billId);
        $this->assertNull($nonExistentBill);

        echo "\n[SUCCESS] DELETE: Bill correctly removed from database.";
    }

    /** @test */
    public function test_it_can_mark_a_bill_as_paid()
    {
        $siswa = Siswa::factory()->create();
        $bill = SppBill::factory()->create([
            'siswa_id' => $siswa->id,
            'status' => 'belum',
        ]);

        $this->assertEquals('belum', $bill->status);

        $response = $this->postJson(route('spp.mark-paid', $bill));

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'bill' => ['status' => 'lunas']
                 ]);

        $this->assertDatabaseHas('spp_bills', [
            'id' => $bill->id,
            'status' => 'lunas',
        ]);

        $freshBill = SppBill::find($bill->id);
        $this->assertEquals('lunas', $freshBill->status);
        echo "\n[SUCCESS] MARK PAID: Bill status correctly persisted as 'lunas'.";
    }
}
