@extends('layouts.app')
@section('title', 'ParkIt | Find Parking')
@section('content')
    <main>
        <h1 class="text-center">Choose Your Garage Location</h1>
        
        <!-- Search Filters -->
        <div class="search-filters">
            <div class="filters-grid" style="grid-template-columns: repeat(6, 1fr);">
                <div>
                    <select class="filter-select">
                        <option value="">District</option>
                        <option value="1">Dhaka</option>
                        <option value="2">Chittagong</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select">
                        <option value="">Area</option>
                        <option value="adabor">Adabor</option>
                        <option value="badda">Badda</option>
                        <option value="mohakhali">Mohakhali</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select">
                        <option value="">Vehicle</option>
                        <option value="car">Car</option>
                        <option value="bike">Bike</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select">
                        <option value="">Price Range</option>
                        <option value="1">100-200</option>
                        <option value="2">200-300</option>
                        <option value="3">300-400</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select">
                        <option value="">Duration</option>
                        <option value="1">1 Hour</option>
                        <option value="2">2 Hours</option>
                        <option value="3">3+ Hours</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select">
                        <option value="">Guard</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="filters-grid" style="grid-template-columns: repeat(6, 1fr); margin-top: 1rem;">
                <div></div>
                <div></div>
                <div>
                    <select class="filter-select">
                        <option value="">Place Type</option>
                        <option value="residential">Residential</option>
                        <option value="market">Market</option>
                    </select>
                </div>
                <div>
                    <select class="filter-select">
                        <option value="">CC Camera</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div></div>
                <div></div>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 1rem;">
                <button class="search-button">Search</button>
            </div>
        </div>
        
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
                    <!-- Row 1 -->
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="table-image">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </td>
                        <td>150</td>
                        <td>Residential</td>
                        <td>Adabor</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>
                            <button class="details-button">Details</button>
                        </td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr>
                        <td>2</td>
                        <td>
                            <div class="table-image">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </td>
                        <td>250</td>
                        <td>Market</td>
                        <td>Adabor</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>
                            <button class="details-button">Details</button>
                        </td>
                    </tr>
                    
                    <!-- Row 3 -->
                    <tr>
                        <td>3</td>
                        <td>
                            <div class="table-image">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </td>
                        <td>350</td>
                        <td>Residential</td>
                        <td>Adabor</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>
                            <button class="details-button">Details</button>
                        </td>
                    </tr>
                    
                    <!-- Row 4 -->
                    <tr>
                        <td>4</td>
                        <td>
                            <div class="table-image">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </td>
                        <td>100</td>
                        <td>Market</td>
                        <td>Adabor</td>
                        <td>No</td>
                        <td>No</td>
                        <td>
                            <button class="details-button">Details</button>
                        </td>
                    </tr>
                    
                    <!-- Row 5 -->
                    <tr>
                        <td>5</td>
                        <td>
                            <div class="table-image">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </td>
                        <td>150</td>
                        <td>Residential</td>
                        <td>Adabor</td>
                        <td>No</td>
                        <td>Yes</td>
                        <td>
                            <button class="details-button">Details</button>
                        </td>
                    </tr>
                    
                    <!-- Row 6 -->
                    <tr>
                        <td>6</td>
                        <td>
                            <div class="table-image">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </td>
                        <td>170</td>
                        <td>Market</td>
                        <td>Adabor</td>
                        <td>Yes</td>
                        <td>No</td>
                        <td>
                            <button class="details-button">Details</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="call-to-action">
            <h2>Questions about garage booking?</h2>
            <p>Call 01533024242</p>
        </div>
    </main>
@endsection