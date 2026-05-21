@extends('layouts.mainsuperadmin')

@section('content')
<div style="max-width: 600px;">
    <div class="card">
    <h2 style="margin-bottom: 20px;">Profil Saya</h2>
    
    <div style="padding: 30px; text-align: center;">
        <div style="background: #4e73df; color: #fff; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; font-weight: bold; margin: 0 auto 20px;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        
        <h3 style="margin: 10px 0;">{{ $user->name }}</h3>
        <p style="color: #666; margin-bottom: 20px;">Status: <strong>{{ strtoupper($user->role) }}</strong></p>
        
        <div style="text-align: left; border-top: 1px solid #eee; padding-top: 20px;">
            <label style="font-weight: bold; display: block; font-size: 13px; color: #888;">EMAIL</label>
            <p style="margin: 5px 0 15px; font-weight: 500;">{{ $user->email }}</p>
            
            <label style="font-weight: bold; display: block; font-size: 13px; color: #888;">TANGGAL BERGABUNG</label>
            <p style="margin: 5px 0 0; font-weight: 500;">{{ $user->created_at->format('d M Y') }}</p>
        </div>
    </div>
    </div>
</div>
@endsection
