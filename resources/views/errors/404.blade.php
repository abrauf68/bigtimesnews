@extends('layouts.errors.master')

@section('title', 'Error 404')

@section('css')
@endsection

@section('content')
    <div class="section py-6 lg:py-8 xl:py-10">
        <div class="container max-w-xl">
            <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                <h2 class="display-5 sm:display-3 lg:display-2 xl:display-1 text-primary">404</h2>
                <h1 class="h3 sm:h1 m-0">Page not found</h1>
                <p class="fs-6 md:fs-5">
                    Sorry, the page you seems looking for, <br>
                    has been moved, redirected or removed permanently.
                </p>
                <a href="{{ route('frontend.home') }}" class="animate-btn btn btn-md btn-primary text-none gap-0">
                    <span>Go back home</span>
                    <i class="icon icon-narrow unicon-arrow-left fw-bold"></i>
                </a>
                <p>Why Not try to search again? <a class="uc-link" href="#uc-search-modal" data-uc-toggle>Search
                        now</a></p>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
