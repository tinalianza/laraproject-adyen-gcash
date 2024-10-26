@extends('layouts.app')

@section('title', 'Application Confirmation')

@section('content')
<div style="padding: 20px; max-width: 600px; margin: auto; text-align: center;">
    <form id="applicationconfirmation-form" method="POST" action="{{ route('application-pending') }}" enctype="multipart/form-data">
        @csrf
    <h1>Application Confirmation</h1>
    <p>Your application has been received and is currently under review.</p>
    <div style="text-align: left;">
        <h2>Application Details</h2>
        <p id="applicant-name">- Applicant Name:</p>
        <p id="applicant-type">- Applicant Type:</p>
        <p id="contact-number">- Contact Number:</p>
        <p id="email">- Email Address:</p>
        <p id="application-date">- Application Date:</p>
        <p id="vehicle-model">- Vehicle Make/Color:</p>
        <p id="license-plate">- License Plate Number:</p>
    </div>
    <p>We will notify you via email once your application has been processed.</p>
    <div style="text-align: left;">
        <h3>- Instructions -</h3>
        <p>1. <strong>Await Confirmation.</strong> Wait for an email confirmation from the Motorpool Office regarding your application status.<br>
            Approval Notification: Once approved, you will receive an email containing your E-Receipt, Password, and Registration Number.</p>
        <p>2. <strong>Access the Busina Portal.</strong> Use your Email and Password to access the Beeper Portal once registered.</p>
        <p>3. <strong>Sticker Issuance Schedule.</strong> A schedule for sticker issuance and card collection will be emailed to you upon approval.</p>
        <p>4. <strong>Visit Motorpool Office.</strong> Visit the Motorpool Office with necessary documents for sticker issuance upon your scheduled appointment.</p>
    </div>
    <p>Thank you for your patience and cooperation.</p>
    <button type="submit">Submit Application</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const applicationData = JSON.parse(localStorage.getItem('applicationData'));

        if (applicationData) {
            document.getElementById('applicant-name').innerText = `- Applicant Name: ${applicationData.name}`;
            document.getElementById('applicant-type').innerText = `- Applicant Type: ${applicationData.applicant_type}`;
            document.getElementById('contact-number').innerText = `- Contact Number: ${applicationData.contact_no}`;
            document.getElementById('email').innerText = `- Email Address:`;
            document.getElementById('application-date').innerText = `- Application Date: ${applicationData.application_date}`;
            document.getElementById('vehicle-model').innerText = `- Vehicle Make/Color: ${applicationData.vehicle_model}`;
            document.getElementById('license-plate').innerText = `- License Plate Number: ${applicationData.plate_number}`;
        }
    });
</script>
@endsection
