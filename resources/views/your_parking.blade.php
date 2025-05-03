@extends('layouts.app')
@section('title', 'Your Garages | ParkIt')
@section('content')
    <main>
        <h1 class="text-center">Your Listed Garages</h1>
        <div class="results-table">
            <table>
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Image</th>
                        <th>Rent</th>
                        <th>Place Type</th>
                        <th>Area</th>
                        <th>CC Camera</th>
                        <th>Guard</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($garages as $i => $garage)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                @php
                                    $images = $garage->images ? json_decode($garage->images, true) : [];
                                    $firstImage = !empty($images) ? $images[0] : null;
                                @endphp
                                @if($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="Garage Image" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                @else
                                    <span style="color:#888;">No Image</span>
                                @endif
                            </td>
                            <td>{{ $garage->rent ?? '-' }}</td>
                            <td>{{ ucfirst($garage->parking_type) }}</td>
                            <td>{{ ucfirst($garage->area) }}</td>
                            <td>{{ $garage->camera ? 'Yes' : 'No' }}</td>
                            <td>{{ $garage->guard ? 'Yes' : 'No' }}</td>
                            <td>{{ $garage->start_time }}</td>
                            <td>{{ $garage->end_time }}</td>
                            <td>
                                <a href="/edit-parking/{{ $garage->garage_id }}" class="details-button" style="margin-left:8px;">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align:center;">You have not listed any garages yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="call-to-action" style="margin-top: 3rem; text-align: center;">
            <h2>Want to add a new garage?</h2>
        </div>
        <div style="display: flex; justify-content: center; margin-top: 1rem;">
            <a href="/register-parking" class="search-button">Register Parking</a>
        </div>
    </main>
@endsection
