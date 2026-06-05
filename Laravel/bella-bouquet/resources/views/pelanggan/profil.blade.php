@extends('layouts.pelanggan')

@section('title', 'Profil')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Profil Pelanggan</h1>
        <p>Informasi akun pelanggan yang sedang login.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="profile-card">
            <div>
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>

            <div class="profile-info">
                <div class="profile-row">
                    <span>Nama</span>
                    <strong>{{ $user->name }}</strong>
                </div>

                <div class="profile-row">
                    <span>Email</span>
                    <strong>{{ $user->email }}</strong>
                </div>

                <div class="profile-row">
                    <span>Role</span>
                    <strong>{{ $user->role }}</strong>
                </div>

                <div class="profile-row">
                    <span>Status Akun</span>
                    <strong>Aktif</strong>
                </div>

                <p style="color:#64748b; line-height:1.7;">
                    Nanti halaman ini bisa dikembangkan agar pelanggan dapat mengubah nomor HP,
                    alamat, foto profil, dan password.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection