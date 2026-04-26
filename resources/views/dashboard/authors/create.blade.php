@extends('layouts.master')

@section('title', __('Create Author'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.authors.index') }}">{{ __('Authors') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.authors.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row p-5">
                        <h3>{{ __('Add New Author') }}</h3>
                        <div class="mb-4 col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                name="name" required placeholder="{{ __('Enter name') }}" autofocus
                                value="{{ old('name') }}" />
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                                name="email" placeholder="{{ __('Enter email') }}"
                                value="{{ old('email') }}" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="image" class="form-label">{{ __('Image') }}</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                                name="image" accept="image/*" />
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="bio" class="form-label">{{ __('BIO') }}</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio"
                                placeholder="{{ __('Enter bio') }}" cols="30" rows="10">
                                {{ old('bio') }}
                            </textarea>
                            @error('bio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="linkedin" class="form-label">{{ __('Linkedin') }}</label>
                            <input class="form-control @error('linkedin') is-invalid @enderror" type="text" id="linkedin"
                                name="linkedin" placeholder="{{ __('Enter linkedin url') }}"
                                value="{{ old('linkedin') }}" />
                            @error('linkedin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="facebook" class="form-label">{{ __('Facebook') }}</label>
                            <input class="form-control @error('facebook') is-invalid @enderror" type="text" id="facebook"
                                name="facebook" placeholder="{{ __('Enter facebook url') }}"
                                value="{{ old('facebook') }}" />
                            @error('facebook')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="twitter" class="form-label">{{ __('Twitter') }}</label>
                            <input class="form-control @error('twitter') is-invalid @enderror" type="text" id="twitter"
                                name="twitter" placeholder="{{ __('Enter twitter url') }}"
                                value="{{ old('twitter') }}" />
                            @error('twitter')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="instagram" class="form-label">{{ __('Instagram') }}</label>
                            <input class="form-control @error('instagram') is-invalid @enderror" type="text" id="instagram"
                                name="instagram" placeholder="{{ __('Enter instagram url') }}"
                                value="{{ old('instagram') }}" />
                            @error('instagram')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="threads" class="form-label">{{ __('Threads') }}</label>
                            <input class="form-control @error('threads') is-invalid @enderror" type="text" id="threads"
                                name="threads" placeholder="{{ __('Enter threads url') }}"
                                value="{{ old('threads') }}" />
                            @error('threads')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Add Author') }}</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            //
        });
    </script>
@endsection
