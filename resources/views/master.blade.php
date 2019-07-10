@extends('layouts.app')

@section('content')
    <section id="app">
        <navigator></navigator>
        <section class="container">
            <transition name="router" mode="out-in">
                <router-view class=" view-container"></router-view>
            </transition>
        </section>
    </section>
@endsection