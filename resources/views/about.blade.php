@extends('layouts.indexLayout')

@section('title', 'About Us - Xtreme Gym World')

@section('main-content')
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            line-height: 25px;
            gap: 40px;
            height: 60%;
            width: 50%;
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

        @media (max-width: 639px) {
            .content {
                height: 75%;
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
            <h2>ABOUT US</h2>
            <p>Xtreme Gym World Baliuag offers top-tier equipment, expert trainers, and a supportive fitness community perfect for anyone chasing real results.</p>
            <p>We provide flexible membership options and full access to modern, well-maintained machines to suit all fitness levels and budgets.</p>
        </div>
    </div>
@endsection