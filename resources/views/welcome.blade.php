@extends('layouts.app')
@section('title', 'ParkIt | Your Parking Solution')
@section('content')
    <main>
        <div class="hero">
            <div class="hero-content">
                <h1>Your Parking Solution</h1>
                <p>Whenever you're near schools, shopping malls, hospitals & restaurants you're damn sure to have a hard time finding the right parking spot for you. If you think you can just park by the road side, you'll be facing legal problems & fines of 5000 from the authority. Why waste your team & money. Start hourly parking with ParkIt & happy parking.</p>
                <a href="/find-parking" class="btn">Find Parking</a>
            </div>
            <div class="hero-image">
                <div class="hero-image-placeholder">
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V19a2 2 0 002 2h14a2 2 0 002-2v-2.5M16 3.13a4 4 0 010 7.75M12 7v6m0 0l-3-3m3 3l3-3" /></svg>
                </div>
            </div>
        </div>
        <h2 class="section-heading">Experience the Best Service Without Breaking the Bank</h2>
        <div class="card-grid" style="margin-bottom:2.5rem;">
            @foreach($featuredGarages as $garage)
                <div class="card card-with-border" style="align-items:center;">
                    <div class="card-image">
                        @php
                            $images = $garage->images ? json_decode($garage->images, true) : [];
                            $firstImage = !empty($images) ? $images[0] : null;
                        @endphp
                        @if($firstImage)
                            <img src="{{ asset('storage/' . $firstImage) }}" alt="Garage Image" style="width:100px;height:70px;object-fit:cover;border-radius:6px;">
                        @else
                            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V19a2 2 0 002 2h14a2 2 0 002-2v-2.5M16 3.13a4 4 0 010 7.75M12 7v6m0 0l-3-3m3 3l3-3" /></svg>
                        @endif
                    </div>
                    <div class="card-content" style="text-align:center;">
                        <div class="card-title" style="font-weight:700;">{{ $garage->area }}</div>
                        <div><b>Place Type:</b> {{ ucfirst($garage->parking_type) }}</div>
                        <div><b>CC Camera:</b> {{ $garage->camera ? 'Available' : 'Not Available' }}</div>
                        <div><b>Guard:</b> {{ $garage->guard ? 'Available' : 'Not Available' }}</div>
                        <div><b>Rent:</b> {{ $garage->rent }}tk (Per Hour)</div>
                    </div>
                    <a href="/booking-details/{{ $garage->garage_id }}" style="margin-top:1rem;display:inline-block;">
                        <button class="search-button">Book</button>
                    </a>
                </div>
            @endforeach
        </div>
        <h2 class="section-heading">Why Us?</h2>
        <div class="card-grid">
            <div class="card card-with-border">
                <div class="feature-icon">
                    <svg xmlns='http://www.w3.org/2000/svg' class='w-7 h-7' fill='none' viewBox='0 0 24 24' stroke='currentColor'><circle cx='12' cy='12' r='10' stroke-width='2'/><path d='M8 12h8M8 16h8M8 8h8' stroke-width='2'/></svg>
                </div>
                <div class="feature-title">First Garage Rental in Bd</div>
                <div class="feature-text">first dedicated garage rental platform. Find the perfect space for your vehicle, workshop, or storage needs. Experience the convenience of organized garage rentals for the first time in BD.</div>
            </div>
            <div class="card card-with-border">
                <div class="feature-icon">
                    <svg xmlns='http://www.w3.org/2000/svg' class='w-7 h-7' fill='none' viewBox='0 0 24 24' stroke='currentColor'><circle cx='12' cy='12' r='10' stroke-width='2'/><path d='M8 12h8M8 16h8M8 8h8' stroke-width='2'/></svg>
                </div>
                <div class="feature-title">Safety Deposit</div>
                <div class="feature-text">Many garage rentals on our platform will involve a standard safety deposit. This refundable amount provides security for the duration of the rental period. Check FAQ to know more about the deposit.</div>
            </div>
            <div class="card card-with-border">
                <div class="feature-icon">
                    <svg xmlns='http://www.w3.org/2000/svg' class='w-7 h-7' fill='none' viewBox='0 0 24 24' stroke='currentColor'><rect x='4' y='4' width='16' height='16' rx='2' stroke-width='2'/><path d='M8 16h8' stroke-width='2'/></svg>
                </div>
                <div class="feature-title">Low Cost</div>
                <div class="feature-text">As the first service of its kind in BD, we offer competitive pricing for your convenience. Experience the value of secure storage and workspace at an affordable price point.</div>
            </div>
        </div>
        <h2 class="section-heading">Reviews from Our Customer</h2>
        <div class="card-grid">
            <div class="card card-with-border">
                <div class="testimonial-text">"Finally, a solution for garage space in Dhaka! I found a secure spot for my car at a low cost, and the safety deposit process was straightforward. Highly recommend!"</div>
                <div class="testimonial-author">
                    <div class="testimonial-avatar"></div>
                    <div>
                        <div class="testimonial-name">Sakib Sadman</div>
                        <div class="testimonial-role">Customer</div>
                    </div>
                </div>
            </div>
            <div class="card card-with-border">
                <div class="testimonial-text">"I was hesitant to rent a garage, but this platform made it easy. The rates are affordable, and knowing my belongings are safe with the deposit system gives me peace of mind."</div>
                <div class="testimonial-author">
                    <div class="testimonial-avatar"></div>
                    <div>
                        <div class="testimonial-name">Noyon Rahman</div>
                        <div class="testimonial-role">Customer</div>
                    </div>
                </div>
            </div>
            <div class="card card-with-border">
                <div class="testimonial-text">"As a first-time user of a garage rental service in Bangladesh, I'm impressed. I got a great deal, and the whole process, including the safety deposit, was very professional."</div>
                <div class="testimonial-author">
                    <div class="testimonial-avatar"></div>
                    <div>
                        <div class="testimonial-name">Lamia Khan</div>
                        <div class="testimonial-role">Customer</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
