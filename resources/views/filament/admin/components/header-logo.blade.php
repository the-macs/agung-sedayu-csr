@if(setting('show_logo', false))
    <img src="{{ setting('site_logo') }}" alt="{{ setting('site_name') }}" class="{{setting('custom_css')}}">
@endif
@if(setting('show_app_name', false))
    <span class="text-xl font-bold text-gray-800 dark:text-gray-400 align-middle ms-2">{{ setting('site_name') }}</span>
@endif
