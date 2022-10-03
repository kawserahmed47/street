<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public $view = ['pubic', 'friends', 'private'];
    public $media = [
        'https://vod-progressive.akamaized.net/exp=1664671942~acl=%2Fvimeo-prod-skyfire-std-us%2F01%2F2209%2F28%2F711046076%2F3295729053.mp4~hmac=40b3d90f83de38ab6cc999f436ccfd7e1a00d826fa776023b600e3e5b1392ed3/vimeo-prod-skyfire-std-us/01/2209/28/711046076/3295729053.mp4?filename=file.mp4',
        'https://player.vimeo.com/progressive_redirect/playback/749766982/rendition/540p/file.mp4?loc=external&oauth2_token_id=57447761&signature=48791a3ff7e72f293a80610e1f2cc601c49fc0146b259e3b608c1794d8d1f46b',
        'https://player.vimeo.com/progressive_redirect/playback/677299276/rendition/540p?loc=external&oauth2_token_id=57447761&signature=d9a2e9c44ddfe29bcd241309267dbe1ffac33ad3589d1276d152d6ef28688e45',
        'https://player.vimeo.com/progressive_redirect/playback/742877549/rendition/540p/file.mp4?loc=external&oauth2_token_id=57447761&signature=7a4b5f6c16bf784204e0a7f818390fe0b0eacfa619a994a40ed0f29065af10df',
        'https://player.vimeo.com/external/513280663.sd.mp4?s=e33fae98a61e50425a02985e8fdfe4af0a91bac8&profile_id=165&oauth2_token_id=57447761',
        'https://player.vimeo.com/external/637211366.sd.mp4?s=4374c53f0b09f0f59c65119979725e573d7c703f&profile_id=165&oauth2_token_id=57447761'
    ];

    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'media_url' => $this->media[rand(1,5)],
            'title' =>  $this->faker->title,
            'description' => $this->faker->text,
            'content' => $this->faker->text,
            'view_type' => $this->view[rand(1,2)],
            'status' => true
        ];
    }
}
