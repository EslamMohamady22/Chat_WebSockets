@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

           {{-- <chat :user="{{ Auth::user() }}" :id="{{ $id }}" :chat_id="{{ $chat_id->chat_id }}" /> --}}
            <chat :user="{{ Auth::user() }}" :id="{{ $id }}"  />

        </div>
    </div>
</div>
@endsection
