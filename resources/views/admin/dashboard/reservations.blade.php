<div class="overview one">
    <div class="list">
        <p class="list-title">Upcoming Reservations:</p>
        <div class="list-content">
            @if($upcomingReservations->isEmpty())
                <p>No upcoming reservations.</p>
            @else
                @foreach($upcomingReservations as $upcomingReservation)
                    <div class="list-item" onclick="window.location.href='{{ route('calendar') }}'">
                        <span style="display: inline-flex; align-items: center;">
                            <h4 style="margin: 0;">{{ $upcomingReservation->name }}</h4>
                            <span style="margin: 0 0.5rem;">&bull;</span> <!-- This is the bullet -->
                            <p style="margin: 0;">{{ $upcomingReservation->number_of_people ?? 'No. of people not set.' }}</p>
                        </span>
                        <p>
                            Date: 
                            {{ \Carbon\Carbon::parse($upcomingReservation->reservation_date)->format('F j, Y') }},
                            {{ $upcomingReservation->start_time ? \Carbon\Carbon::parse($upcomingReservation->start_time)->format('g:i A') : 'Unspecified start time' }}
                            -
                            {{ $upcomingReservation->end_time ? \Carbon\Carbon::parse($upcomingReservation->end_time)->format('g:i A') : 'Unspecified end time' }}
                        </p>
                        <span><p>Phone: {{ $upcomingReservation->number ?? 'Number not provided.'}}</p></span>
                        <span><p>Status: {{ $upcomingReservation->status ?? 'Pending Confirmation'}}</p></span>
                        <span><p>Payment Status: {{ $upcomingReservation->payment_status ?? 'Unpaid' }}</p></span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>