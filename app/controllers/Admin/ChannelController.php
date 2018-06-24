<?php
namespace App\Controllers;

use App\classes\ValidatorHelper;
use App\Models\Channel;
use Legato\Framework\Request;
use Legato\Framework\Validator\Validator;

class ChannelController extends BaseController
{

    public function show()
    {
        $channels = Channel::paginated(10);
        return view('admin.channels.channel', compact('channels'));
    }

    public function save(Request $request)
    {
        $rules = [
            'name' => [
                'required' => true, 'max' => 20, 'string' => true, 'unique' => 'channels'
            ]
        ];

        $validator = new Validator($request->all(), $rules);
        $errors = ValidatorHelper::parseErrors($request, $validator);

        if(is_array($errors))
        {
            return view('admin.channels.channel', compact('errors'));
        }

        //save request
        Channel::create([
            'name' => $request->input('name'),
            'slug' => str_slug($request->input('name')),
        ]);

        flash('success', 'Channel Created');
        return redirectTo('/admin/channel');
    }
}