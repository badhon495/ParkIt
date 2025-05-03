@extends('layouts.app')
@section('title', 'ParkIt | Find Parking')
@section('content')
    <main>
        <h1 class="text-center">Choose Your Garage Location</h1>
        
        <!-- Search Filters -->
        <form method="GET" action="/find-parking">
        <div class="search-filters">
            <div class="filters-grid" style="grid-template-columns: repeat(6, 1fr);">
                <div>
                    <select class="filter-select" name="division">
                        <option value="">District</option>
                        <option value="Dhaka" {{ (isset($filters['division']) && $filters['division']=='Dhaka') ? 'selected' : '' }}>Dhaka</option>
                        <option value="Chittagong" {{ (isset($filters['division']) && $filters['division']=='Chittagong') ? 'selected' : '' }}>Chittagong</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select" name="area">
                        <option value="">Area</option>
                        <option value="adabor" {{ (isset($filters['area']) && $filters['area']=='adabor') ? 'selected' : '' }}>Adabor</option>
                        <option value="badda" {{ (isset($filters['area']) && $filters['area']=='badda') ? 'selected' : '' }}>Badda</option>
                        <option value="mohakhali" {{ (isset($filters['area']) && $filters['area']=='mohakhali') ? 'selected' : '' }}>Mohakhali</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select" name="vehicle">
                        <option value="">Vehicle</option>
                        <option value="car" {{ (isset($filters['vehicle']) && $filters['vehicle']=='car') ? 'selected' : '' }}>Car</option>
                        <option value="bike" {{ (isset($filters['vehicle']) && $filters['vehicle']=='bike') ? 'selected' : '' }}>Bike</option>
                        <option value="bicycle" {{ (isset($filters['vehicle']) && $filters['vehicle']=='bicycle') ? 'selected' : '' }}>Bicycle</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select" name="price_range">
                        <option value="">Price Range</option>
                        <option value="1" {{ (isset($filters['price_range']) && $filters['price_range']=='1') ? 'selected' : '' }}>100-200</option>
                        <option value="2" {{ (isset($filters['price_range']) && $filters['price_range']=='2') ? 'selected' : '' }}>200-300</option>
                        <option value="3" {{ (isset($filters['price_range']) && $filters['price_range']=='3') ? 'selected' : '' }}>300-400</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select" name="duration">
                        <option value="">Duration</option>
                        <option value="1" {{ (isset($filters['duration']) && $filters['duration']=='1') ? 'selected' : '' }}>1 Hour</option>
                        <option value="2" {{ (isset($filters['duration']) && $filters['duration']=='2') ? 'selected' : '' }}>2 Hours</option>
                        <option value="3" {{ (isset($filters['duration']) && $filters['duration']=='3') ? 'selected' : '' }}>3+ Hours</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select" name="guard">
                        <option value="">Guard</option>
                        <option value="1" {{ (isset($filters['guard']) && $filters['guard']=='1') ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ (isset($filters['guard']) && $filters['guard']=='0') ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>
            <div class="filters-grid" style="grid-template-columns: repeat(6, 1fr); margin-top: 1rem;">
                <div></div>
                <div></div>
                <div>
                    <select class="filter-select" name="place_type">
                        <option value="">Place Type</option>
                        <option value="residential" {{ (isset($filters['place_type']) && $filters['place_type']=='residential') ? 'selected' : '' }}>Residential</option>
                        <option value="market" {{ (isset($filters['place_type']) && $filters['place_type']=='market') ? 'selected' : '' }}>Market</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select" name="cc_camera">
                        <option value="">CC Camera</option>
                        <option value="1" {{ (isset($filters['cc_camera']) && $filters['cc_camera']=='1') ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ (isset($filters['cc_camera']) && $filters['cc_camera']=='0') ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div></div>
                <div></div>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 1rem;">
                <button class="search-button" type="submit">Search</button>
            </div>
        </div>
        </form>
        
        <!-- Page Size -->
        <div class="page-size">
            <span>Page Size:</span>
            <select class="page-size-select">
                <option value="6">6</option>
                <option value="12">12</option>
                <option value="24">24</option>
            </select>
        </div>
        
        <!-- Results Table -->
        <div class="results-table">
            <table>
                <thead>
                    <tr>
                        <th>
                            <div class="sortable">
                                SL
                            </div>
                        </th>
                        <th>
                            <div class="sortable">
                                Image
                            </div>
                        </th>
                        <th>
                            <div class="sortable">
                                Rent
                            </div>
                        </th>
                        <th>
                            Place Type
                        </th>
                        <th>
                            <div class="sortable">
                                Area
                            </div>
                        </th>
                        <th>
                            <div class="sortable">
                                CC Camera
                            </div>
                        </th>
                        <th>
                            <div class="sortable">
                                Guard
                            </div>
                        </th>
                        <th>
                            <div class="sortable">
                                Book
                            </div>
                        </th>
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
                            <td>
                                <a href="/booking-details/{{ $garage->garage_id }}">
                                    <button class="details-button">Details</button>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;">No garages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="call-to-action">
            <h2>Questions about garage booking?</h2>
            <p>Call 01533024242</p>
        </div>
    </main>
@endsection