@extends('layouts.master')

@section('title', __('Edit Post'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.posts.index') }}">{{ __('Posts') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.posts.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row p-5">
                        <h3>{{ __('Edit Post') }}</h3>
                        <div class="mb-4 col-md-6">
                            <label for="title" class="form-label">{{ __('Title') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" id="title"
                                name="title" required placeholder="{{ __('Enter title') }}" autofocus
                                value="{{ old('title', $post->title) }}" />
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="slug" class="form-label">{{ __('Slug') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('slug') is-invalid @enderror" type="text" id="slug"
                                name="slug" required placeholder="{{ __('Enter slug') }}"
                                value="{{ old('slug', $post->slug) }}" />
                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label class="form-label" for="category_id">{{ __('Category') }}</label><span
                                class="text-danger">*</span>
                            <select id="category_id" name="category_id"
                                class="select2 form-select @error('category_id') is-invalid @enderror" required>
                                <option value="" selected disabled>{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label class="form-label" for="author_id">{{ __('Author') }}</label><span
                                class="text-danger">*</span>
                            <select id="author_id" name="author_id"
                                class="select2 form-select @error('author_id') is-invalid @enderror" required>
                                <option value="" selected disabled>{{ __('Select Author') }}</option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}"
                                        {{ old('author_id', $post->author_id) == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="meta_image" class="form-label">{{ __('Meta Image') }}</label>
                            <input class="form-control @error('meta_image') is-invalid @enderror" type="file"
                                id="meta_image" name="meta_image" accept="image/*" />
                            @error('meta_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if($post->meta_image)
                                <img src="{{ asset($post->meta_image) }}" alt="meta image" class="mt-2" width="120">
                            @endif
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="main_image" class="form-label">{{ __('Main Image') }}</label>
                            <input class="form-control @error('main_image') is-invalid @enderror" type="file"
                                id="main_image" name="main_image" accept="image/*" />
                            @error('main_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if($post->main_image)
                                <img src="{{ asset($post->main_image) }}" alt="main image" class="mt-2" width="120">
                            @endif
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="content" class="form-label">{{ __('Content') }}</label><span
                                class="text-danger">*</span>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content"
                                placeholder="{{ __('Enter content') }}" cols="30" rows="10">{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="tags" class="form-label">Tags</label>
                            <input id="tags" name="tags" class="form-control @error('tags') is-invalid @enderror"
                                placeholder="Select tags" value="{{ old('tags', $post->tags) }}" />
                            @error('tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <h5>SEO Details</h5>
                        <hr>
                        <div class="mb-4 col-md-12">
                            <label for="meta_title" class="form-label">{{ __('Meta Title') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('meta_title') is-invalid @enderror" type="text"
                                id="meta_title" name="meta_title" required placeholder="{{ __('Enter meta title') }}"
                                value="{{ old('meta_title', $post->meta_title) }}" />
                            @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="meta_description" class="form-label">{{ __('Meta Description') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('meta_description') is-invalid @enderror" type="text"
                                id="meta_description" name="meta_description" required
                                placeholder="{{ __('Enter meta description') }}"
                                value="{{ old('meta_description', $post->meta_description) }}" />
                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="meta_keywords" class="form-label">{{ __('Meta Keywords') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('meta_keywords') is-invalid @enderror" type="text"
                                id="meta_keywords" name="meta_keywords" required
                                placeholder="{{ __('Enter meta keywords') }}" value="{{ old('meta_keywords', $post->meta_keywords) }}" />
                            @error('meta_keywords')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Edit Post') }}</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
@endsection

@section('script')
    <!-- Vendors JS -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script>
        const tagsEl = document.querySelector('#tags');
        const whitelist = @json($uniqueTags);
        // Inline
        let tags = new Tagify(tagsEl, {
            whitelist: whitelist,
            maxTags: 10,
            dropdown: {
                maxItems: 20,
                classname: 'tags-inline',
                enabled: 0,
                closeOnSelect: false
            }
        });
        $(document).ready(function() {
            tinymce.init({
                selector: '#content',
                height: 500,

                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',

                toolbar: `undo redo | formatselect | bold italic underline |
              alignleft aligncenter alignright |
              bullist numlist | link image media | code fullscreen`,

                menubar: true,
                branding: false,

                automatic_uploads: true,

                images_upload_url: '/posts/upload-image',

                images_upload_handler: function(blobInfo) {

                    return new Promise((resolve, reject) => {

                        let formData = new FormData();
                        formData.append('file', blobInfo.blob());

                        fetch('/posts/upload-image', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(result => {

                                if (!result.location) {
                                    reject('No image URL returned');
                                    return;
                                }

                                resolve(result.location); // 👈 important
                            })
                            .catch(error => {
                                reject('Upload failed: ' + error);
                            });

                    });
                }
            });

            // Generate slug from title
            $('#title').on('keyup change', function() {
                let title = $(this).val();
                let slug = title.toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#slug').val(slug);
            });

            // Handle form submission manually to validate TinyMCE
            $('form').on('submit', function(e) {
                tinymce.triggerSave(); // sync content to <textarea>
                const $description = $('#content');
                const descriptionContent = $description.val().trim();

                // Remove previous validation state
                $description.removeClass('is-invalid');
                $description.next('.invalid-feedback').remove();

                if (!descriptionContent) {
                    e.preventDefault();

                    // Add Bootstrap invalid class
                    $description.addClass('is-invalid');

                    // Append validation message
                    $description.after(`
                        <div class="invalid-feedback">
                            {{ __('The content field is required.') }}
                        </div>
                    `);

                    // Optional: focus editor
                    tinymce.get('content').focus();
                }
            });

        });
    </script>
@endsection
