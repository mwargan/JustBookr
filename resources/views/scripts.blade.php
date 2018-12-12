{{-- Global configuration object --}}
@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = config('app.locale'),
    'locales' => config('app.locales'),
    'apiUrl' => config('app.url'),
    'translations' => json_decode(file_get_contents(resource_path("lang/{$locale}.json")), true),
    'githubAuth' => config('services.github.client_id'),
    'stripe_key' => config('services.stripe.key'),
    'facebook_app_id' => config('services.facebook.client_id'),
];
@endphp
<script>window.config = @json($config);</script>

{{-- Polyfill some features via polyfill.io --}}
@php
$polyfills = [
    'Promise',
    'Object.assign',
    'Object.values',
    'Array.prototype.find',
    'Array.prototype.findIndex',
    'Array.prototype.includes',
    'Array.prototype.filter',
    'Array.prototype.map',
    'String.prototype.includes',
    'String.prototype.startsWith',
    'String.prototype.endsWith',
    '~html5-elements',
];
@endphp
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}" async></script>

{{-- Load the application scripts --}}
@if (config('app.env') === 'local')
  <script src="{{ mix('js/app.js') }}" defer></script>
@else
  <script src="{{ mix('js/manifest.js') }}" defer></script>
  <script src="{{ mix('js/vendor.js') }}" defer></script>
  <script src="{{ mix('js/app.js') }}" defer></script>
{{--   <script async>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js').then(function(registration) {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
            });
        });
    }
  </script> --}}
@endif
<script src="https://js.stripe.com/v3/"></script>
