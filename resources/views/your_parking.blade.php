@extends('layouts.app')
@section('title', 'Your Garages | ParkIt')
@section('content')
    <main>
        <script>console.log('Session user_id: {{ session('user_id') }}');</script>
        <h1 class="text-center">Your Listed Garages</h1>
        <div style="background:#fff;padding:2.5rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:1200px;width:100%;margin:0 auto 2rem auto;">
            @if(isset($searchError) && $searchError)
                <div style="color:#b94a48;background:#f2dede;border:1px solid #eed3d7;padding:0.7rem 1.2rem;border-radius:4px;margin-bottom:1rem;text-align:center;">
                    {{ $searchError }}
                </div>
            @endif
            <form method="GET" action="" style="margin-bottom:2rem;display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;align-items:center;">
                <select name="search_field" style="padding:0.5rem;">
                    <option value="garage_id" {{ request('search_field') == 'garage_id' ? 'selected' : '' }}>Garage ID</option>
                    <option value="area" {{ request('search_field') == 'area' ? 'selected' : '' }}>Area</option>
                    <option value="division" {{ request('search_field') == 'division' ? 'selected' : '' }}>Division</option>
                </select>
                <input type="text" name="search_value" placeholder="Enter search value" value="{{ request('search_value') }}" style="padding:0.5rem;">
                <button type="submit" class="search-button">Search</button>
                <a href="{{ url()->current() }}" style="padding:0.5rem 1rem;background:#eee;border-radius:4px;text-decoration:none;">Reset</a>
            </form>
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
                            <th>Slots</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($garages as $i => $garage)
                            <tr>
                                <td>{{ $garage->garage_id }}</td>
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
                                <td>
                                    @php
                                        $slots = isset($garage->slots) ? json_decode($garage->slots, true) : [];
                                        if (is_array($slots) && count($slots)) {
                                            $slotLabels = collect($slots)->map(function($s) {
                                                $start = str_pad($s, 2, '0', STR_PAD_LEFT) . ':00';
                                                $end = str_pad(($s+1)%24, 2, '0', STR_PAD_LEFT) . ':00';
                                                return $start . ' - ' . $end;
                                            });
                                            echo implode(', ', $slotLabels->toArray());
                                        } else {
                                            echo '-';
                                        }
                                    @endphp
                                </td>
                                <td>
                                    <a href="/edit-parking/{{ $garage->garage_id }}" class="details-button" style="margin-left:8px;">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align:center;">
                                    @if(request('search_field') && request('search_value') && empty($searchError))
                                        No results found for your search.
                                    @else
                                        You have not listed any garages yet.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="call-to-action" style="margin-top: 3rem; text-align: center;">
            <h2>Want to add a new garage?</h2>
        </div>
        <div style="display: flex; justify-content: center; margin-top: 1rem;">
            <a href="/register-parking" class="search-button">Register Parking</a>
        </div>
    </main>
@endsection
