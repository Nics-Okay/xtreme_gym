@extends('layouts.AdminLayout')

@section('title', 'Analytics - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reports.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>GYM ANALYTICS</h2> 
        </div>
        <div class="table-container">
            <div class="section-content">
                <div class="report-box">
                    <p>Report</p>
                    <h3>Content</h3>
                </div>
                <div class="report-box">

                </div>
                <div class="report-box">

                </div>
            </div>

            <div class="section-content">
                <div class="report-box">
                    <p>Report</p>
                    <h3>Content</h3>
                </div>
                <div class="report-box">

                </div>
                <div class="report-box">

                </div>
            </div>
        </div>
    </div>
@endsection