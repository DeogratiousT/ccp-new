@component('mail::message')
# Dear {{ $user->name }}

Your Password Has been Successfully Updated.

@component('mail::button', ['url' => route('login') ])
DISCOVERY FUNDS
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
