@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Purchase Agreements</h1>
    @foreach($agreements as $agreement)
        <!-- Display agreement details here -->
    @endforeach
</div>
@endsection
