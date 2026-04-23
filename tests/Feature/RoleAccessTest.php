<?php

use App\Models\User;

test('admin can access santri routes', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('santri.index'));

    $response->assertOk();
});

test('guru cannot access santri routes', function () {
    $guru = User::factory()->create(['role' => 'guru']);

    $response = $this->actingAs($guru)->get(route('santri.index'));

    $response->assertForbidden();
});

test('guru can access absensi routes', function () {
    $guru = User::factory()->create(['role' => 'guru']);

    $response = $this->actingAs($guru)->get(route('absensi.index'));

    $response->assertOk();
});

test('admin cannot access absensi routes', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('absensi.index'));

    $response->assertForbidden();
});
