<x-mail::message>
Hello Developer 

A new task has been created! Check Out here

<x-mail::button :url="'http://localhost:8000/login'">
Task Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
