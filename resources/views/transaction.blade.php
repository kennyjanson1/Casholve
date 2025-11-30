@extends('layouts.app')

@section('title', 'Account - Moneta')

@section('content')
    <x-transactions.create :categories="$categories" />
@endsection