<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tag;
use App\Models\Contact;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
              'firstname' => $this->faker->name, 
              'lastname' => $this->faker->sentence,
              'email' => "nrg123@dev.io",
              'phone'=>'+7 777 77 77'
        ];
    }

    public function create_contacts_with_tags(int $count)
    {
         Contact::factory()->hasAttached(Tag::firstOrCreate(['text'=>'nrg-software','color'=>'#e64747']))->count($count)->create();
    }
}
