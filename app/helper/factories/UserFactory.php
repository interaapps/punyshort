<?php
namespace app\helper\factories;


use app\model\User;
use de\interaapps\ulole\core\testing\factory\AssemblyLine;
use de\interaapps\ulole\core\testing\factory\Factory;
use de\interaapps\ulole\core\testing\factory\Faker;

// app\factories\UserFactory::run(5)

class UserFactory extends Factory
{
    public $model = User::class;

    protected function production(AssemblyLine $assemblyLine)
    {
        $assemblyLine->insert(function(User $user, Faker $faker){
            $user->name = $faker->fullName();
            $user->gender = "FEMALE";
            $user->password = password_hash($faker->password(), PASSWORD_BCRYPT);
        });
    }
}