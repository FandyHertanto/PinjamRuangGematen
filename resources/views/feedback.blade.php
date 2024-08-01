@component('mail::message')
    # {{ $data['subject'] }}

    {{ $data['body'] }}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
