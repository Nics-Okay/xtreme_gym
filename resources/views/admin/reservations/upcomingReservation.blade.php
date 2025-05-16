<div class="rs-section-upcoming">
    <div class="list">
        <h4 class="rs-list-title" style="margin-bottom: 5px;">Upcoming Reservations:</h4>
        @if($upcomingReservations->isEmpty())
            <p>No upcoming reservations.</p>
        @else
            @foreach($upcomingReservations as $upcomingReservation)
                <div class="list-item">
                    <span style="display: inline-flex; align-items: center;">
                        <h4 style="margin: 0;">{{ $upcomingReservation->name }}</h4>
                        <span style="margin: 0 0.5rem;">&bull;</span>
                        <p style="margin: 0;">{{ $upcomingReservation->number_of_people ? $upcomingReservation->number_of_people . ' People' : 'No. of people not set.' }}</p>
                    </span>
                    <p>
                        Date: 
                        {{ \Carbon\Carbon::parse($upcomingReservation->reservation_date)->format('F j, Y') }},
                        {{ $upcomingReservation->start_time ? \Carbon\Carbon::parse($upcomingReservation->start_time)->format('g:i A') : 'Unspecified start time' }}
                        -
                        {{ $upcomingReservation->end_time ? \Carbon\Carbon::parse($upcomingReservation->end_time)->format('g:i A') : 'Unspecified end time' }}
                    </p>
                    <span><p>Phone: {{ $upcomingReservation->number ?? 'Number not provided.'}}</p></span>
                    <span><p>Status: {{ $upcomingReservation->status ?? 'Unconfirmed'}}</p></span>
                    <span><p>Payment Status: {{ $upcomingReservation->payment_status ?? 'Unpaid' }}</p></span>
                    <div class="action-buttons">
                        @if($upcomingReservation->payment_status !== 'paid')
                            <form method="post" action="{{ route('reservation.paid', ['reservation' => $upcomingReservation]) }}" style="display: inline;">
                                @csrf
                                @method('patch')
                                <button type="submit" class="mark-paid-button">
                                    <i class="fa-solid fa-wallet"></i> Pay
                                </button>
                            </form>
                        @else
                            <button type="button" class="mark-paid-button" disabled style="background-color: #aaa; cursor: not-allowed;">
                                <i class="fa-solid fa-check-circle"></i> Paid
                            </button>
                        @endif

                        <a href="{{route('reservation.edit', ['reservation' => $upcomingReservation])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i><p>Edit</p></a>
                        
                        <form method="post" action="{{route('reservation.cancel', ['reservation' => $upcomingReservation])}}">
                            @csrf
                            @method('put')
                            <button type="submit" class="cancel-button">
                                <i class="fa-solid fa-xmark"></i> Cancel
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>