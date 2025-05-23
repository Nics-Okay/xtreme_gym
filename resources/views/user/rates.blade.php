@extends('layouts.UserDesign')

@section('title', 'Membership - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/rates.css') }}">
@endsection

@section('main-content')
    <!-- Design -->
    <style>
        .main-section {
            display: flex;
            justify-content: center;
            height: 100%;
            width: 100%;
        }
    </style>

    <!-- Structure -->
    <div class="user-content-container">
        <div class="user-content-header">
            <div class="custom-header">
                <a href="{{ route('user.home')}}"><i class="fa-solid fa-arrow-left"></i></a>
                <h3 class="custom-header-title">Membership Plans</h3> 
            </div>
        </div>
        <div class="user-main-content">
            <div class="main-section">
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
                                        <p>Gym Membership for {{$rate->validity_value}} {{$rate->validity_unit}}(s).</p>
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
                                            Purchase
                                        </button>
                                    </div>
                                    <div class="plan-availed">
                                        <p>{{$rate->times_availed ? 'Availed by ' . $rate->times_availed . ' member(s).' : 'Be the first to enjoy this plan!'}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="note-container">
                        <p><b>Note:</b> Daily membership is also available for ₱{{ $walkIn->price ?? '(Price N/A)'}}. For more information message us <a href="{{ route('page.contact') }}">here</a>.</p>
                    </div>
                </div>
            </div>
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

    <!-- Structure -->
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