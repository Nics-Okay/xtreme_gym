@extends('layouts.AdminLayout')

@section('title', 'Rates')

@section('header-title', 'Membership Plans')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/admin/universalCRUD.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>AVAILABLE PLANS</h2>
            <div class="page-button">
                <a href="{{ route('rate.create') }}"><ion-icon name="add-outline"></ion-icon>Create New Plan</a>
            </div>
        </div>
        <div class="page-content">
            <div class="table-container">
                <table class="table-content">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Validity</th>
                            <th>Description</th>
                            <th>Perks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rates as $rate)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$rate->name}}</td>
                                <td>₱{{$rate->price}}</td>
                                <td>{{$rate->validity_value}} {{$rate->validity_unit}}(s)</td>
                                <td>{{$rate->description ?? 'No description provided.'}}</td>
                                <td>{{$rate->perks ?? 'Not available'}}</td>
                                <td>
                                    <div class="action-button">
                                    <a href="{{route('rate.edit', ['rate' => $rate])}}" class="edit-button official"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form method="post" action="{{route('rate.destroy', ['rate' => $rate])}}">
                                        @csrf 
                                        @method('delete')
                                        <button type="submit" class="delete-button official">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
