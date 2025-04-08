@extends('layouts.AdminLayout')

@section('title', 'Rates')

@section('header-title', 'Membership Plans')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/admin/rates.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/universalCRUD.css') }}">
@endsection

@section('main-content')
    <div class="crud-container">
        <div class="crud-section header">
            <h3 class="table-header-info">Available Plans</h3>
            <div class="table-header-button">
                <a href="{{ route('rate.create') }}"><ion-icon name="add-outline"></ion-icon>Create New Rate</a>
            </div>
        </div>
        <div class="rate-section rates">
            @foreach($rates as $rate)
                <div class="rate-content" style="background-color: {{ $rate->color ?? '#ffffff' }};">
                    <h2>{{$rate->name}}</h2>
                    <div class="rate-price">
                        <p>₱{{$rate->price}}</p>
                    </div>
                    <div class="rate-validity">
                        <p>Valid for {{$rate->validity_value}} {{$rate->validity_unit}}(s).</p>
                    </div>
                    <div class="rate-perks">
                        <h3>Perks</h3>
                        <p>{{$rate->perks ?? 'No description provided.'}}</p>
                    </div>
                    <div class="rate-description">
                        <h3>Description</h3>
                        <p><p>{{$rate->description ?? 'No description provided.'}}</p></p>
                    </div>
                    <div class="rate-availed">
                        <p>{{$rate->times_availed ? 'Availed by ' . $rate->times_availed . ' member(s).' : 'Haven\'t been availed yet.'}}</p>
                    </div>

                    <div class="action-buttons rate">
                        <a href="{{route('rate.edit', ['rate' => $rate])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form method="post" action="{{route('rate.destroy', ['rate' => $rate])}}">
                            @csrf 
                            @method('delete')
                            <button type="submit" class="delete-button">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
