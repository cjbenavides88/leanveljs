@extends('layouts.app')

@section('content')
    <section id="app" class="container-fluid h-100">
        <transition name="router" mode="out-in">
            <router-view class="view-container"></router-view>
        </transition>
    </section>
@endsection