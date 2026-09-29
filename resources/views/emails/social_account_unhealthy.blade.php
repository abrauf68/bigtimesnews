<!DOCTYPE html>
<html lang="en">
<body style="font-family: Arial, Helvetica, sans-serif; color:#111827; line-height:1.6;">
    <h2 style="margin:0 0 12px;">{{ $account->platformEnum()->label() }} needs reconnecting</h2>
    <p>Automatic posting to {{ $account->platformEnum()->label() }} has stopped working because the connected account's access token was rejected.</p>
    <p><strong>Reason:</strong> {{ $account->health_message }}</p>
    <p>Please reconnect this account from the admin panel so future posts keep publishing to this platform.</p>
    <p><a href="{{ route('dashboard.social.index') }}">Open Social Publishing settings</a></p>
</body>
</html>
