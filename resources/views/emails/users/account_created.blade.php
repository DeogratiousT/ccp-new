@component('mail::message')
# Dear {{ $user->name }}

Welcome to Discovery Funds. 
Your Account has been created for You.
Your Log in Details are as Follows:

# Email : {{ $user->email }}
# Password : password

@component('mail::button', ['url' => route('login') ])
DISCOVERY FUNDS
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
