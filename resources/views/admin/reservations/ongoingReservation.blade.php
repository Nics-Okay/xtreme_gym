<div class="rs-section-ongoing">
    <h4 class="rs-list-title">Ongoing Reservations:</h4>
    @if($ongoingReservations->isEmpty())
        <p>No ongoing reservations.</p>
    @else
        @foreach($ongoingReservations as $ongoingReservation)
            <div class="rs-ongoing-list-item">
                <span style="display: inline-flex; align-items: center;">
                    <h4 style="margin: 0;">{{ $ongoingReservation->name }}</h4>
                    <span style="margin: 0 0.5rem;">&bull;</span> <!-- This is the bullet -->
                    <p>
                        {{ \Carbon\Carbon::parse($ongoingReservation->reservation_date)->format('F j, Y') }},
                        {{ $ongoingReservation->start_time ? \Carbon\Carbon::parse($ongoingReservation->start_time)->format('g:i A') : 'Unspecified start time' }}
                        -
                        {{ $ongoingReservation->end_time ? \Carbon\Carbon::parse($ongoingReservation->end_time)->format('g:i A') : 'Unspecified end time' }}
                    </p>
                </span>
                <span><p>Phone: {{ $ongoingReservation->number ?? 'Number not provided.'}}</p></span>
                <span><p>Payment Status: {{ $ongoingReservation->payment_status ?? 'Unpaid' }}</p></span>
                <div class="action-buttons">
                    @if($ongoingReservation->payment_status !== 'paid')
                        <form method="post" action="{{ route('reservation.paid', ['reservation' => $ongoingReservation]) }}" style="display: inline;">
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

                    <a href="{{route('reservation.edit', ['reservation' => $ongoingReservation])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i><p>Edit</p></a>
                    
                    <form method="post" action="{{route('reservation.cancel', ['reservation' => $ongoingReservation])}}">
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