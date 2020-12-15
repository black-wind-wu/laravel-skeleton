@extends('layouts.app')

@once
    @prepend('scripts')
        <script src="{{ asset(mix('/js/user.js')) }}"></script>
    @endprepend
@endonce
