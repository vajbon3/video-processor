<?php
namespace Vanilla\public_html;

use Vanilla\core\Request;
use Vanilla\core\App;
use Vanilla\enums\MediaEnum;
use Vanilla\models\Media;
use Vanilla\models\MediaDao;
use Vanilla\utils\Bag;
use Vanilla\utils\Envy;
use Vanilla\utils\File;
use Vanilla\utils\VideoProcessor;

require_once __DIR__ . '/../vendor/autoload.php';

// load environment variables from .env.example
(new Envy(__DIR__ . '/../.env'))->load();

// initialize app with passed config
App::init([
    'database' => [
        'hostname' => getenv('HOSTNAME'),
        'name' => getenv('NAME'),
        'user' => getenv('USER'),
        'password' => getenv('PASS')
    ],
]);

// routes
App::$router->get('/', function(Request $request) {
    return Bag::render('home.php',[
        'media' => MediaDao::all(),
        'photos' => MediaDao::allPhotos(),
        'videos' => MediaDao::allVideos(),
    ]);
});

App::$router->post('/upload', function(Request $request) {
    $media = $request->files()['media'];

    // validation
    if(!empty($media->error)) {
        die(print($media->error));
    }

    // if video
    if($media->type === MediaEnum::video) {
        // compress, get new file name ( random ) and move
        $new_name = VideoProcessor::compress($media);

        // generate thumbnail
        $thumbnail = VideoProcessor::generateThumbnail($media);
    }

    // if photo
    if($media->type === MediaEnum::photo) {
        // generate random name and move to public
        $new_name = File::generateRandomName() . '.' . $media->extension;
        move_uploaded_file($media->temp_path, App::$project_root . '/public/storage/photos/' . $new_name);
    }

    // get duration
    $duration = $media->type === MediaEnum::video
        ? VideoProcessor::getVideoLength($media) : null;

    // persist
    $media_object = new Media(null, $new_name, $media->name, $duration, $media->type, $thumbnail ?? null);
    $media_object->save();

    header('Location: ' . $_SERVER['HTTP_REFERER']);
});