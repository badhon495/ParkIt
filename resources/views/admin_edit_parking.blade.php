@extends('layouts.app')
@section('title', 'Edit Garage | ParkIt')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:3.5rem 4rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:900px;width:100%;">
        <h2 style="text-align:center;font-size:2.5rem;font-weight:700;color:#444;margin-bottom:2rem;">Edit Garage Details</h2>
        @if(session('success'))
            <div class="alert alert-success" style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 1rem 2rem; border-radius: 6px; text-align: center; min-width: 300px; margin-bottom:1rem;">
                {{ session('success') }}
            </div>
        @endif
        @include('edit_parking', [
            'garage' => $garage,
            'user' => [
                'name' => $owner->name ?? '',
                'phone' => $owner->phone ?? '',
                'email' => $owner->email ?? ''
            ],
            'formAction' => url('/admin/edit-parking/' . $garage->garage_id),
            'isAdmin' => true
        ])
    </div>
</main>
@endsection
