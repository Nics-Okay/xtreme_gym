<div class="logs member">
    <form id="member_attendee" action="{{ route('attendee.store') }}" method="post">
        @csrf
        <h2 class="grid-title">XTREME ENTRY CHECKPOINT</h2>
        <input type="text" id="identification" name="identification" required placeholder="Enter name or ID">
        <button type="submit">Submit</button>
    </form>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>