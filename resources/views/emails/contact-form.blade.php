<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Form</title>
</head>
<body style="font-family: Arial, sans-serif; color: #011848; line-height: 1.5;">
    <h2 style="margin-bottom: 8px;">New contact message</h2>
    <p style="margin: 0 0 16px; color: #64748b;">Submitted via the LITUS Connect website.</p>
    <p><strong>Name:</strong> {{ $senderName }}</p>
    <p><strong>Email:</strong> {{ $senderEmail }}</p>
    <p><strong>Subject:</strong> {{ $formSubject }}</p>
    <p><strong>Message:</strong></p>
    <p style="white-space: pre-wrap; background: #F7F8FA; padding: 12px; border-radius: 8px;">{{ $messageBody }}</p>
</body>
</html>
