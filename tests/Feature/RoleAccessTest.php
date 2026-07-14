<?php

use App\Models\Siswa;
use App\Models\SppBill;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Hash;

test('admin can access siswa routes', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $response = $this->actingAs($admin)->get(route('siswa.index'));
    $response->assertOk();
});

test('guru cannot access siswa routes', function () {
    $guru = User::factory()->create(['role' => 'guru']);
    $response = $this->actingAs($guru)->get(route('siswa.index'));
    $response->assertForbidden();
});

test('guru can access absensi routes', function () {
    $guru = User::factory()->create(['role' => 'guru']);
    $response = $this->actingAs($guru)->get(route('absensi.index'));
    $response->assertOk();
});

test('admin can access absensi routes', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $response = $this->actingAs($admin)->get(route('absensi.index'));
    $response->assertOk();
});

test('admin can update siswa password', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $siswa = Siswa::factory()->create();
    $user = User::factory()->create(['role' => 'siswa', 'siswa_id' => $siswa->id]);

    $response = $this->actingAs($admin)->post(route('siswa.password.update', $siswa), [
        'password' => 'new-password',
    ]);

    $response->assertRedirect();
    $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
});

test('guru cannot update siswa password', function () {
    $guru = User::factory()->create(['role' => 'guru']);
    $siswa = Siswa::factory()->create();

    $response = $this->actingAs($guru)->post(route('siswa.password.update', $siswa), [
        'password' => 'new-password',
    ]);

    $response->assertForbidden();
});

test('admin cannot checkout siswa spp bill', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $siswa = Siswa::factory()->create();
    $sppBill = SppBill::factory()->create(['siswa_id' => $siswa->id]);

    $response = $this->actingAs($admin)->post(route('spp.checkout', $sppBill));

    $response->assertStatus(403);
});

test('guru cannot checkout siswa spp bill', function () {
    $guru = User::factory()->create(['role' => 'guru']);
    $siswa = Siswa::factory()->create();
    $sppBill = SppBill::factory()->create(['siswa_id' => $siswa->id]);

    $response = $this->actingAs($guru)->post(route('spp.checkout', $sppBill));

    $response->assertStatus(403);
});

test('guest cannot checkout siswa spp bill', function () {
    $siswa = Siswa::factory()->create();
    $sppBill = SppBill::factory()->create(['siswa_id' => $siswa->id]);

    $response = $this->post(route('spp.checkout', $sppBill));

    $response->assertRedirect(route('login'));
});

test('siswa cannot checkout another siswa spp bill', function () {
    $siswa1 = Siswa::factory()->create();
    $user1 = User::factory()->create(['role' => 'siswa', 'siswa_id' => $siswa1->id]);

    $siswa2 = Siswa::factory()->create();
    $sppBill2 = SppBill::factory()->create(['siswa_id' => $siswa2->id]);

    $response = $this->actingAs($user1)->post(route('spp.checkout', $sppBill2));

    $response->assertStatus(403);
});

test('siswa can access checkout for own spp bill', function () {
    $siswa = Siswa::factory()->create();
    $user = User::factory()->create(['role' => 'siswa', 'siswa_id' => $siswa->id]);
    $sppBill = SppBill::factory()->create(['siswa_id' => $siswa->id]);

    // Mock PaymentService
    $mock = Mockery::mock(PaymentService::class);
    $mock->shouldReceive('getSnapToken')
        ->once()
        ->andReturn('fake-snap-token');

    $this->instance(PaymentService::class, $mock);

    $response = $this->actingAs($user)->post(route('spp.checkout', $sppBill));

    $response->assertOk();
    $response->assertJson([
        'snap_token' => 'fake-snap-token',
    ]);
});
