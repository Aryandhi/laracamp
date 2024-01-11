<x-mail::message>
# Introduction

Hi, {{$user->name}}
<br>
Welcome to Siger Talent - Siber Camp, your account has been created succesfully.
Now you begin explore cyber career!

<x-mail::button :url="route('login')">
Login here
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
