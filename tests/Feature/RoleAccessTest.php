<?php

use App\Models\User;

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
