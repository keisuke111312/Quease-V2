
<h1>New Appointment Request</h1>
                
<p>Dear {{ $recipient->fname }} {{ $recipient->lname }},</p>

<p>A new appointment request has been made by {{ $appointment->creator->fname }} {{ $appointment->creator->lname }}.</p>

<p><strong>Details:</strong></p>
<ul>
    <li><strong>Purpose:</strong> {{ $appointment->title }}</li>
    <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->start)->format('F j, Y') }}</li>
    <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->start)->format('h:i A') }} - 
        {{ \Carbon\Carbon::parse($appointment->end)->format('h:i A') }}</li>
    {{-- <li><strong>Problem:</strong> {{ $appointment->problem }}</li> --}}
</ul>

<p>Please review the request at your earliest convenience.</p>

<p>Thank you!</p>
