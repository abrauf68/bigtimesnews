<div class="card mb-6">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('AI Blog Automation') }}</h5>
        <form action="{{ route('dashboard.setting.ai_blog.run_now') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning">
                <i class="ti ti-bolt me-1"></i> {{ __('Run Now') }}
            </button>
        </form>
    </div>
    <div class="card-body pt-4">
        <form id="formAiBlogSettings" method="POST"
            action="{{ route('dashboard.setting.ai_blog.update', $aiBlogSetting->id ?? 0) }}">
            @csrf
            @method('PUT')

            <div class="row p-5">
                <h3>{{ __('Automation') }}</h3>

                <div class="mb-4 col-md-4">
                    <label for="is_enabled" class="form-label">{{ __('Automation Status') }}</label><span class="text-danger">*</span>
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="radio" name="is_enabled" value="1" id="aiEnabled1"
                            {{ old('is_enabled', $aiBlogSetting->is_enabled ? '1' : '0') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="aiEnabled1"> {{ __('Enabled') }} </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_enabled" value="0" id="aiEnabled2"
                            {{ old('is_enabled', $aiBlogSetting->is_enabled ? '1' : '0') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="aiEnabled2"> {{ __('Disabled') }} </label>
                    </div>
                    @error('is_enabled')
                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-4">
                    <label for="daily_post_limit" class="form-label">{{ __('Blogs Per Day') }}</label><span class="text-danger">*</span>
                    <input class="form-control @error('daily_post_limit') is-invalid @enderror" type="number" min="1" max="20"
                        id="daily_post_limit" name="daily_post_limit"
                        value="{{ old('daily_post_limit', $aiBlogSetting->daily_post_limit ?? 3) }}" required />
                    <small class="fw-medium text-primary">{{ __('How many new blog posts to auto-generate daily') }}</small>
                    @error('daily_post_limit')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-4">
                    <label for="run_time" class="form-label">{{ __('Daily Run Time') }}</label><span class="text-danger">*</span>
                    <input class="form-control @error('run_time') is-invalid @enderror" type="time"
                        id="run_time" name="run_time"
                        value="{{ old('run_time', isset($aiBlogSetting->run_time) ? \Carbon\Carbon::parse($aiBlogSetting->run_time)->format('H:i') : '03:00') }}" required />
                    <small class="fw-medium text-primary">{{ __('Server time. Requires the cron scheduler to be set up (see below).') }}</small>
                    @error('run_time')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-6">
                    <label for="auto_publish" class="form-label">{{ __('Publish Behaviour') }}</label><span class="text-danger">*</span>
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="radio" name="auto_publish" value="0" id="aiPublish1"
                            {{ old('auto_publish', $aiBlogSetting->auto_publish ? '1' : '0') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="aiPublish1"> {{ __('Save as Draft (recommended, review before publishing)') }} </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="auto_publish" value="1" id="aiPublish2"
                            {{ old('auto_publish', $aiBlogSetting->auto_publish ? '1' : '0') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="aiPublish2"> {{ __('Auto Publish Immediately') }} </label>
                    </div>
                    @error('auto_publish')
                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-6">
                    <label for="notify_admin" class="form-label">{{ __('Email Notification') }}</label><span class="text-danger">*</span>
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="radio" name="notify_admin" value="1" id="aiNotify1"
                            {{ old('notify_admin', $aiBlogSetting->notify_admin ? '1' : '0') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="aiNotify1"> {{ __('Email me when a batch is ready') }} </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="notify_admin" value="0" id="aiNotify2"
                            {{ old('notify_admin', $aiBlogSetting->notify_admin ? '1' : '0') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="aiNotify2"> {{ __("Don't email me") }} </label>
                    </div>
                    @error('notify_admin')
                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-6">
                    <label for="admin_email" class="form-label">{{ __('Notify Email (optional)') }}</label>
                    <input class="form-control @error('admin_email') is-invalid @enderror" type="email"
                        id="admin_email" name="admin_email"
                        value="{{ old('admin_email', $aiBlogSetting->admin_email ?? '') }}"
                        placeholder="{{ __('Leave blank to use Company Settings email') }}" />
                    @error('admin_email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-6">
                    <label for="posted_by_user_id" class="form-label">{{ __('Post As (User)') }}</label><span class="text-danger">*</span>
                    <select id="posted_by_user_id" name="posted_by_user_id" class="select2 form-select @error('posted_by_user_id') is-invalid @enderror">
                        <option value="">{{ __('Select User') }}</option>
                        @foreach ($aiUsers as $user)
                            <option value="{{ $user->id }}" {{ old('posted_by_user_id', $aiBlogSetting->posted_by_user_id ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <small class="fw-medium text-primary">{{ __('Generated posts are attributed to this account') }}</small>
                    @error('posted_by_user_id')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <h3>{{ __('Trend Source') }}</h3>

                <div class="mb-4 col-md-4">
                    <label for="trends_provider" class="form-label">{{ __('Trends Provider') }}</label><span class="text-danger">*</span>
                    <select id="trends_provider" name="trends_provider" class="form-select @error('trends_provider') is-invalid @enderror">
                        <option value="google_trends" {{ old('trends_provider', $aiBlogSetting->trends_provider ?? 'google_trends') == 'google_trends' ? 'selected' : '' }}>
                            {{ __('Google Trends (Free, no key needed)') }}
                        </option>
                        <option value="serpapi" {{ old('trends_provider', $aiBlogSetting->trends_provider ?? '') == 'serpapi' ? 'selected' : '' }}>
                            {{ __('SerpApi (paid, optional)') }}
                        </option>
                    </select>
                    @error('trends_provider')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-4">
                    <label for="trend_country" class="form-label">{{ __('Trend Country') }}</label>
                    <select id="trend_country" name="trend_country" class="form-select @error('trend_country') is-invalid @enderror">
                        <option value="" {{ old('trend_country', $aiBlogSetting->trend_country ?? '') == '' ? 'selected' : '' }}>
                            {{ __('Global (blend of major markets)') }}
                        </option>
                        <option value="US" {{ old('trend_country', $aiBlogSetting->trend_country ?? '') == 'US' ? 'selected' : '' }}>{{ __('United States') }}</option>
                        <option value="GB" {{ old('trend_country', $aiBlogSetting->trend_country ?? '') == 'GB' ? 'selected' : '' }}>{{ __('United Kingdom') }}</option>
                        <option value="CA" {{ old('trend_country', $aiBlogSetting->trend_country ?? '') == 'CA' ? 'selected' : '' }}>{{ __('Canada') }}</option>
                        <option value="AU" {{ old('trend_country', $aiBlogSetting->trend_country ?? '') == 'AU' ? 'selected' : '' }}>{{ __('Australia') }}</option>
                        <option value="IN" {{ old('trend_country', $aiBlogSetting->trend_country ?? '') == 'IN' ? 'selected' : '' }}>{{ __('India') }}</option>
                        <option value="PK" {{ old('trend_country', $aiBlogSetting->trend_country ?? '') == 'PK' ? 'selected' : '' }}>{{ __('Pakistan') }}</option>
                        <option value="AE" {{ old('trend_country', $aiBlogSetting->trend_country ?? '') == 'AE' ? 'selected' : '' }}>{{ __('United Arab Emirates') }}</option>
                    </select>
                    <small class="fw-medium text-primary">{{ __('Your target is US, but "Global" also works well for worldwide reach') }}</small>
                    @error('trend_country')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-4">
                    <label for="trends_api_key" class="form-label">{{ __('Trends API Key') }}</label>
                    <input class="form-control @error('trends_api_key') is-invalid @enderror" type="text"
                        id="trends_api_key" name="trends_api_key"
                        value="{{ old('trends_api_key', $aiBlogSetting->trends_api_key ?? '') }}"
                        placeholder="{{ __('Only required if using SerpApi') }}" />
                    @error('trends_api_key')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <h3>{{ __('AI Writer (Claude)') }}</h3>

                <div class="mb-4 col-md-12">
                    <label for="claude_api_key" class="form-label">{{ __('Claude API Key') }}</label>
                    <input class="form-control @error('claude_api_key') is-invalid @enderror" type="text"
                        id="claude_api_key" name="claude_api_key"
                        value="{{ old('claude_api_key', $aiBlogSetting->claude_api_key ?? '') }}"
                        placeholder="sk-ant-..." />
                    <small class="fw-medium text-primary">{{ __('From console.anthropic.com — used for both writing and QA models below') }}</small>
                    @error('claude_api_key')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-6">
                    <label for="claude_writer_model" class="form-label">{{ __('Writer Model (drafts the article)') }}</label><span class="text-danger">*</span>
                    <input class="form-control @error('claude_writer_model') is-invalid @enderror" type="text"
                        id="claude_writer_model" name="claude_writer_model"
                        value="{{ old('claude_writer_model', $aiBlogSetting->claude_writer_model ?? 'claude-sonnet-5') }}" required />
                    @error('claude_writer_model')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-6">
                    <label for="claude_qa_model" class="form-label">{{ __('Humanize / QA Model') }}</label><span class="text-danger">*</span>
                    <input class="form-control @error('claude_qa_model') is-invalid @enderror" type="text"
                        id="claude_qa_model" name="claude_qa_model"
                        value="{{ old('claude_qa_model', $aiBlogSetting->claude_qa_model ?? 'claude-haiku-4-5-20251001') }}" required />
                    <small class="fw-medium text-primary">{{ __('Cheaper model that rewrites/rechecks the draft before saving') }}</small>
                    @error('claude_qa_model')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <h3>{{ __('Images') }}</h3>

                <div class="mb-4 col-md-12">
                    <label for="unsplash_access_key" class="form-label">{{ __('Unsplash Access Key') }}</label>
                    <input class="form-control @error('unsplash_access_key') is-invalid @enderror" type="text"
                        id="unsplash_access_key" name="unsplash_access_key"
                        value="{{ old('unsplash_access_key', $aiBlogSetting->unsplash_access_key ?? '') }}"
                        placeholder="{{ __('From unsplash.com/developers (free tier)') }}" />
                    @error('unsplash_access_key')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <h3>{{ __('Post Defaults') }}</h3>

                <div class="mb-4 col-md-6">
                    <label for="default_category_id" class="form-label">{{ __('Default Category') }}</label>
                    <select id="default_category_id" name="default_category_id" class="select2 form-select @error('default_category_id') is-invalid @enderror">
                        <option value="">{{ __('Auto (first active category)') }}</option>
                        @foreach ($aiCategories as $category)
                            <option value="{{ $category->id }}" {{ old('default_category_id', $aiBlogSetting->default_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('default_category_id')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4 col-md-6">
                    <label for="default_author_id" class="form-label">{{ __('Default Author') }}</label>
                    <select id="default_author_id" name="default_author_id" class="select2 form-select @error('default_author_id') is-invalid @enderror">
                        <option value="">{{ __('Auto (first active author)') }}</option>
                        @foreach ($aiAuthors as $author)
                            <option value="{{ $author->id }}" {{ old('default_author_id', $aiBlogSetting->default_author_id ?? '') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('default_author_id')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            @canany(['create setting', 'update setting'])
                <div class="mt-2 px-5">
                    <button type="submit" class="btn btn-primary me-3">{{ __('Save changes') }}</button>
                </div>
            @endcan
        </form>
    </div>

    <div class="card-body border-top pt-4">
        <h5>{{ __('Recent Automation Activity') }}</h5>
        @if ($aiRecentTopics->isEmpty())
            <p class="text-muted">{{ __('No automation runs yet. Save your settings, enable automation, then click "Run Now" to test it.') }}</p>
        @else
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('Topic') }}</th>
                            <th>{{ __('Country') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Post') }}</th>
                            <th>{{ __('Fetched At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aiRecentTopics as $topic)
                            <tr>
                                <td>{{ \Illuminate\Support\Str::limit($topic->topic, 50) }}</td>
                                <td>{{ $topic->country ?? '-' }}</td>
                                <td>
                                    @php
                                        $badge = ['pending' => 'secondary', 'generating' => 'info', 'completed' => 'success', 'failed' => 'danger'][$topic->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-label-{{ $badge }}" title="{{ $topic->status === 'failed' ? $topic->error_message : '' }}">{{ ucfirst($topic->status) }}</span>
                                </td>
                                <td>
                                    @if ($topic->post)
                                        <a href="{{ route('dashboard.posts.edit', $topic->post->id) }}">{{ __('View / Edit') }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $topic->fetched_at ? $topic->fetched_at->format('d M Y H:i') : '-' }}</td>
                                <td>
                                    @if ($topic->status === 'failed')
                                        @canany(['create setting', 'update setting'])
                                            <form action="{{ route('dashboard.setting.ai_blog.regenerate', $topic->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Regenerate this post now?') }}');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-icon btn-label-primary" title="{{ __('Regenerate') }}">
                                                    <i class="ti ti-refresh"></i> {{ __('Regenerate') }}
                                                </button>
                                            </form>
                                        @endcanany
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
