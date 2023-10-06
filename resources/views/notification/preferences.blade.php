<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{-- {{ __('Dashboard.finance.dashboard')}} --}}
           {{ __("Preferences") }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Notification preferences') }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Update your notification preferences.") }}
                        </p>
                    </header>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('notification.preferences.update') }}" class="mt-6 space-y-6">
                            @csrf
                                <!-- Frequency Selection -->
                                <div class="form-group">
                                    <x-input-label for="frequency"/>Notification Frequency
                                    <select id="frequency" name="frequency" class="form-control" required>
                                        <option value="daily" {{ $notificationPreferences->frequency === 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ $notificationPreferences->frequency === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="bi-weekly" {{ $notificationPreferences->frequency === 'bi-weekly' ? 'selected' : '' }}>Bi-weekly</option>
                                        <option value="monthly" {{ $notificationPreferences->frequency === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    </select>
                                </div>
    
                                <div>
                                    <x-input-label for="advance_notice_days"/>Advance Notice (in days)
                                    <x-text-input id="advance_notice_days" name="advance_notice_days" class="form-control" required min="0" value="{{ $notificationPreferences->advance_notice_days }}"/>
                                </div>
    
                                <!-- Active/Inactive -->
                                <div class="form-check">
                                    <x-input-label class="form-check-label" for="is_active"/>Receive Notifications
                                    <input type="checkbox" id="is_active" name="is_active" class="form-check-input" {{ $notificationPreferences->is_active ? 'checked' : '' }}>
                                </div>
    
                                <!-- Notification Time -->
                                <div class="form-group">
                                    <x-input-label for="notification_time"/>Notification Time
                                    <input type="time" id="notification_time" name="notification_time" class="form-control" required value="{{ $notificationPreferences->notification_time }}">
                                </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>