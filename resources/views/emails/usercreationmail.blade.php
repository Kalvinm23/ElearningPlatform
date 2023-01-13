@component('mail::message')
<p>Hello {{$emailuser->first_name}} {{$emailuser->last_name}},</p>
<p>Welcome to Premier Training.</p>
<p>Thank you for enrolling on:</p>
<p>Course: {{$emailcourse->name}}<br>
    Professional Body: <?php echo \App\Http\Controllers\ProfessionalBodiesController::showname($emailcourse->professional_body_id);?></p>
<p>Your login details are:</p>
<p>Email: {{$emailuser->email}}<br>
    Password: {{$emailpassword}}</p>
<p>If you require any assistance please contact info@premiertraining.co.uk</p>
<p>Many thanks,</p>
<p>Premier Training</p>
@endcomponent