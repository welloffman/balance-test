<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание пользователя';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        if(strlen($password) < 6 || strlen($password) > 12) {
            $this->error("Длина пароля должна быть от 6 до 12 символов");
            return false;
        }
        
        $user = User::where('email', $email)->first();
        if($user) {
            $this->error("Email $email уже используется");
            return false;
        }

        $user = new User();
        $user->password = \Hash::make($password);
        $user->email = $email;
        $user->save();

        $this->info("Пользователь с Email $email успешно создан");
    }
}
