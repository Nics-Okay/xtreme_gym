@extends('layouts.UserLayout')

@section('title', 'Membership Plans')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/user/rates.css') }}">
@endsection

@section('main-content')
    <div class="user-content-container">
        <div class="user-content-header">
            <p>AVAILABE MEMBERSHIP PLANS</p>
        </div>
        @if(session('success'))
            <script>
                window.onload = function() {
                    let message = "{{ session('success') }}";
                    let alertBox = document.createElement('div');
                    alertBox.textContent = message;
                    
                    // Styling
                    alertBox.style.position = 'fixed';
                    alertBox.style.bottom = '30px'; /* Position near bottom */
                    alertBox.style.right = '-300px'; /* Start off-screen */
                    alertBox.style.backgroundColor = '#4CAF50';
                    alertBox.style.color = 'white';
                    alertBox.style.padding = '15px 20px';
                    alertBox.style.borderRadius = '8px';
                    alertBox.style.boxShadow = '0 4px 10px rgba(0,0,0,0.2)';
                    alertBox.style.zIndex = '1000';
                    alertBox.style.fontSize = '14px';
                    alertBox.style.fontWeight = 'bold';
                    alertBox.style.textAlign = 'center';
                    alertBox.style.minWidth = '220px';
                    alertBox.style.maxWidth = '300px';
                    alertBox.style.transition = 'right 0.5s ease-out, opacity 0.5s ease-in-out';

                    document.body.appendChild(alertBox);

                    // Slide in animation
                    setTimeout(() => {
                        alertBox.style.right = '10px';
                    }, 100);

                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        alertBox.style.opacity = '0';
                        setTimeout(() => alertBox.remove(), 500);
                    }, 3000);
                };
            </script>
        @endif
        <div class="membership-plans">
            @foreach($rates as $rate)
                <div class="plans-container" style="background-color: {{ $rate->color ?? '#ffffff' }};">
                    <div class="gradient-overlay">
                        <div class="plans">
                            <h2 style="color: {{ $rate->color ?? '#000000' }}; filter: brightness(70%);">{{$rate->name}}</h2>
                            <div class="plan-price">
                                <p style="color: {{ $rate->color ?? '#000000' }}; filter: brightness(40%);">₱{{$rate->price}}</p>
                            </div>
                            <div class="plan-validity">
                                <p>Xtreme membership for {{$rate->validity_value}} {{$rate->validity_unit}}(s).</p>
                            </div>
                            <div class="plan-perks-description">
                                <h3>{{$rate->name}} plan perks</h3>
                                @if ($rate->perks)
                                    @php
                                        $perks = nl2br(e($rate->perks));
                                    @endphp
                                    
                                    <p style="color: {{ $rate->color ?? '#000000' }}; filter: brightness(50%);">{!! $perks !!}</p>
                                @else
                                    <p style="color: {{ $rate->color ?? '#000000' }}; filter: brightness(50%);">No perks details provided.</p>
                                @endif
                                <br>
                                <h3>Description</h3>
                                <p style="color: {{ $rate->color ?? '#000000' }}; filter:brightness(50%);">{{$rate->description ?? 'No description provided.'}}</p>
                            </div>
                            <div class="plan-buttons">
                                <button type="button" onclick="showModal('{{ route('membership.avail', ['rate' => $rate]) }}')">
                                    Avail Now! 
                                </button>
                            </div>
                            <div class="plan-availed">
                                <p>{{$rate->times_availed ? 'Availed by ' . $rate->times_availed . ' member(s).' : 'Be the first to enjoy this plan!'}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
        <div class="note-container">
            <p><b>Note:</b> Daily membership is also available for 299. For more information message us <a href="#">here</a>.</p>
        </div>
    </div>
    <div id="confirmationModal" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <p>Are you sure you want to avail this membership plan?</p>
            <div class="modal-buttons">
                <button onclick="closeModal()">Cancel</button>
                <form id="confirmForm" method="GET" action="">
                    <button type="submit">Confirm</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js-container')
    <script>
        function showModal(availUrl) {
            document.getElementById('confirmationModal').style.display = 'flex';
            document.getElementById('confirmForm').action = availUrl;
        }

        function closeModal() {
            document.getElementById('confirmationModal').style.display = 'none';
        }
    </script>
@endsection