<?php

use App\Mail\MeetingInvitation;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\{Artisan, Mail, Schedule};

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $users = User::all();

    foreach ($users as $user) {
        Mail::to($user->email)->send(new MeetingInvitation());
    }
})->timezone('America/Sao_Paulo')->daily()->at('11:16');
