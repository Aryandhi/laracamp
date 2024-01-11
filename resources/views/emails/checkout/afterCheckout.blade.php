<x-mail::message>
# Register Camp: {{$checkout->Camp->title}}

Hi, {{$checkout->User->name}}
<br>
Thank you for Register on <b>{{$checkout->Camp->title}}</b>, please see payment instruction by click button below.

<x-mail::button :url="route('dashboard')">
My Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
