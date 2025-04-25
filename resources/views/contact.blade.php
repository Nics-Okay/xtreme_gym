@extends('layouts.indexLayout')

@section('title', 'Contact Us - Xtreme Gym World')

@section('main-content')
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            overflow-y: auto;
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            line-height: 25px;
            gap: 40px;
            height: 70%;
            width: 65%;
            padding: 20px 25px;
            border-radius: 25px;
            background-image: url('{{ asset('images/about-us.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat; 
        }

        .content h2 {
            font-size: 50px;
            color: white;
        }

        .content p {
            color: white;
        }

        .content h3 {
            color: white;
            margin-bottom: -40px;
        }

        @media (max-width: 639px) {
            .content {
                height: 85%;
                width: 90%;
                border-radius: 15px;
            }

            .content h2 {
            font-size: 30px;
            color: white;
            }
        }
    </style>
    <div class="container">
        <div class="content">
            <h2>CONTACT US</h2>

            <h3>Visit Us:</h3>
            <p>
                Rodriguez Compound, DRT Highway, Tangos, Baliuag, Bulacan
                (Inside Mimi’s Café & Project Steak, in front of Puregold)<br>
            </p>

            <h3>Call or Text:</h3>
            <p>
                Smart: 0969-575-5842 / 0986-378-918<br>
                PLDT Landline: (044) 792-3166<br>
            </p>

                <h3>Follow Us:</h3>
            <p>
                Facebook: Xtreme Gym Baliuag Bulacan Branch<br>
                Instagram: @xtremebaliuag<br>
            </p>
        </div>
    </div>
@endsection