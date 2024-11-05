@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Purchase Agreements</h1>

    @foreach($purchaseAgreements as $agreement)
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-xl font-semibold mb-2">Agreement #{{ $agreement->id }}</h2>
            <p>Buyer: {{ $agreement->buyer_name }}</p>
            <p>Property: {{ $agreement->property->address }}</p>
            <p>Status: {{ $agreement->status }}</p>
            <a href="{{ route('purchase-agreements.show', $agreement) }}" class="text-blue-500 hover:underline">View Details</a>
        </div>
    @endforeach

    {{ $purchaseAgreements->links() }}
</div>
@endsection
