<!DOCTYPE html>
<html lang="en">
<body style="font-family: Arial, Helvetica, sans-serif; color:#111827; line-height:1.6;">
    <h2 style="margin:0 0 12px;">New contact form message</h2>
    <table cellpadding="6" cellspacing="0" style="border-collapse:collapse;">
        <tr><td><strong>Name</strong></td><td>{{ $data['name'] }}</td></tr>
        <tr><td><strong>Email</strong></td><td>{{ $data['email'] }}</td></tr>
        <tr><td><strong>Topic</strong></td><td>{{ $data['topic'] }}</td></tr>
        <tr><td><strong>Subject</strong></td><td>{{ $data['subject'] }}</td></tr>
        <tr><td><strong>IP</strong></td><td>{{ $ip }}</td></tr>
    </table>
    <hr style="border:none;border-top:1px solid #e5e7eb;margin:16px 0;">
    <p style="white-space:pre-wrap;">{{ $data['message'] }}</p>
    <p style="color:#6b7280;font-size:12px;">Reply to this email to respond directly to the sender.</p>
</body>
</html>
