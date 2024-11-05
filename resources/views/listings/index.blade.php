@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-16">
    <h1 class="text-2xl font-bold mb-6">Listing Agreements</h1>

    @foreach($listingAgreements as $agreement)
        <div class="mb-4 p-4 border rounded">
            <h2 class="text-xl">{{ $agreement->seller_name }}</h2>
            <p>{{ $agreement->property_address }}</p>
            <a href="{{ route('listings.show', $agreement) }}" class="text-blue-500">View Details</a>
        </div>
    @endforeach

    {{ $listingAgreements->links() }}
</div>
@endsection
