<x-mail::message>
# Your transaction has been confirmed

Hi {{$checkout->user->name}}, thanks Your transaction has been confirmed, now you can enjoy the benefit of <b>{{$checkout->Camp->title}}</b> camp.

<x-mail::button :url="route('user.dashboard')">
My Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
