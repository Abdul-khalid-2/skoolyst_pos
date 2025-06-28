@props(['tenant' => null])

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ $tenant ? 'Edit Tenant' : 'Create New Tenant' }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $tenant ? route('tenants.update', $tenant->id) : route('tenants.store') }}">
                        @csrf
                        @if($tenant) @method('PUT') @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Tenant Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                        value="{{ old('name', $tenant->name ?? '') }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                        value="{{ old('email', $tenant->email ?? '') }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="domain">Domain *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="domain" name="domain" 
                                            value="{{ old('domain', $tenant->domains->first()->domain ?? '') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">.{{ config('tenancy.central_domains')[0] }}</span>
                                        </div>
                                    </div>
                                    @error('domain')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="database_name">Database Name *</label>
                                    <input type="text" class="form-control" id="database_name" name="database_name" 
                                        value="{{ old('database_name', $tenant->database_name ?? '') }}" required>
                                    @error('database_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="timezone">Timezone *</label>
                                    <select class="form-control" id="timezone" name="timezone" required>
                                        @foreach(timezone_identifiers_list() as $tz)
                                            <option value="{{ $tz }}" {{ old('timezone', $tenant->timezone ?? 'UTC') == $tz ? 'selected' : '' }}>
                                                {{ $tz }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('timezone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="currency">Currency *</label>
                                    <select class="form-control" id="currency" name="currency" required>
                                        <option value="Rs" {{ old('currency', $tenant->currency ?? 'Rs') == 'Rs' ? 'selected' : '' }}>Rs (Rupees)</option>
                                        <option value="USD" {{ old('currency', $tenant->currency ?? 'Rs') == 'USD' ? 'selected' : '' }}>$ (US Dollar)</option>
                                        <option value="EUR" {{ old('currency', $tenant->currency ?? 'Rs') == 'EUR' ? 'selected' : '' }}>€ (Euro)</option>
                                    </select>
                                    @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="locale">Locale *</label>
                                    <select class="form-control" id="locale" name="locale" required>
                                        <option value="en_US" {{ old('locale', $tenant->locale ?? 'en_US') == 'en_US' ? 'selected' : '' }}>English (US)</option>
                                        <option value="en_GB" {{ old('locale', $tenant->locale ?? 'en_US') == 'en_GB' ? 'selected' : '' }}>English (UK)</option>
                                        <option value="fr_FR" {{ old('locale', $tenant->locale ?? 'en_US') == 'fr_FR' ? 'selected' : '' }}>French</option>
                                        <!-- Add more locales as needed -->
                                    </select>
                                    @error('locale')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="is_active" 
                                            name="is_active" value="1" {{ old('is_active', $tenant->is_active ?? true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Active Tenant</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="trial_ends_at">Trial Ends At</label>
                                    <input type="date" class="form-control" id="trial_ends_at" name="trial_ends_at" 
                                        value="{{ old('trial_ends_at', optional($tenant->trial_ends_at)->format('Y-m-d')) }}">
                                    @error('trial_ends_at')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('tenants.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>