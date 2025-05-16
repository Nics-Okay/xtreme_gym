@extends('layouts.AdminLayout')

@section('title', 'Tournament Results - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/results.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Tournament Results List</h2>
            <div class="page-button">
                <a href="{{ route('result.create') }}"><ion-icon name="add-sharp"></ion-icon>Add Tournament Result</a>
            </div>
        </div>
        <div class="page-content">
<div class="table-container">
                <table class="table-content">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Tournament</th>
                            <th rowspan="2">Game Category</th>
                            <th rowspan="2">Date</th>
                            <th colspan="2">Winner</th>
                            <th colspan="2">Defeated</th>
                            <th rowspan="2">Actions</th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Score</th>
                            <th>Name</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($results->isEmpty())
                            <tr>
                                <td colspan="9" style="text-align: center;">No stuedent records available.</td>
                            </tr>
                        @else
                            @foreach($results as $result)
                                <tr>
                                    <td>{{ ($results->currentPage() - 1) * $results->perPage() + $loop->iteration }}</td>
                                    <td>{{ $result->tournament->name ?? 'Tournament not found' }}</td>
                                    <td>{{ $result->remarks ?? 'Not found' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($result->game_date)->format('F j, Y') }}</td>
                                    <td>{{ $result->winner_name ?? 'Not found' }}</td>
                                    <td>{{ $result->winner_score ?? 'Not found' }}</td>
                                    <td>{{ $result->defeated_name ?? 'Not found' }}</td>
                                    <td>{{ $result->defeated_score ?? 'Not found' }}</td>
                                    <td>
                                        <div class="action-button">
                                            <a href="{{route('result.edit', ['result' => $result])}}" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <form method="post" action="{{route('result.destroy', ['result' => $result])}}">
                                                @csrf 
                                                @method('delete')
                                                <button type="submit" class="delete-button" style="background: none; border: none; cursor: pointer;">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $results->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection