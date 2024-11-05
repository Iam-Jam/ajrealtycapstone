
@extends('layouts.app')

@section('content')
    <h1>Edit Form</h1>

    <form action="{{ route('forms.update', $form->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Form fields for editing -->
        <!-- ... -->

        <button type="submit">Update Form</button>
    </form>
@endsection
