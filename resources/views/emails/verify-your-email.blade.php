@component('mail::message')
    # Verify your email

    By clicking on this button your email will be verified!

    @component('mail::button', ['url' => $url])
        Verify
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
