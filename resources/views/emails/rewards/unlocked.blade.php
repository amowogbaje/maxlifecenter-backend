@extends('emails._partials.layout')

@section('content')
<tr>
    <td>
        <h2 style="color:#2d3748;">🎉 Congratulations {{ $user->f_name ?? $user->user_name }}!</h2>
        <p style="color:#4a5568;">
            You’ve unlocked a new reward: <strong>{{ $reward->reward->title ?? 'Reward' }}</strong>.
        </p>
        <p style="color:#4a5568;">
            Requirement completed: {{ $reward->reward->required_points }} points / {{ $reward->reward->required_purchases }} purchases.
        </p>
    </td>
</tr>
<tr>
    <td style="padding-top: 20px; text-align: center;">
        <a href="{{ route('rewards')}}" style="display:inline-block; margin-top:20px; background:#d69e2e; color:white; padding:10px 16px; border-radius:5px; text-decoration:none;">
             Claim Reward
         </a>
    </td>
</tr>
</table>
@endsection