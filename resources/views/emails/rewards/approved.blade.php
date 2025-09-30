@extends('emails._partials.layout')

@section('content')
<tr>
    <td>
        <h2 style="color:#2d3748;">✅ Great news, {{ $user->f_name ?? $user->user_name }}!</h2>
        <p style="color:#4a5568;">
            Your reward <strong>{{ $reward->reward->title ?? 'Reward' }}</strong> has been approved.
        </p>
        <p style="color:#4a5568;">
            You can now enjoy the full benefits of your achievement.
        </p>
    </td>
</tr>
@endsection