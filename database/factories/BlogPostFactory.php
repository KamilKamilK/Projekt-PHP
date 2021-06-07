<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' =>$this->faker->sentence(10),
            'content'=>$this->faker->paragraph(5,true)
        ];
    }

    public function newTitle()
    {


        return $this->state([

               'title' => 'New title',
               'content' => 'Content of the blog post',
                'user_id'=> 1
           ]);
    }
    }
