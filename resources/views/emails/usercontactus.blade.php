@component('mail::message')
<p><strong>ID: </strong>#{{$useremaildata['userid']}}</p>
<p><strong>Name: </strong>{{$useremaildata['name']}}</p>
<p><strong>Email: </strong>{{$useremaildata['email']}}</p>
<p><strong>Message: </strong>{{$useremaildata['message']}}</p>
@endcomponent