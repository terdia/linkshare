<?php
namespace App\Controllers;

use App\Models\Channel;
use App\Models\SubChannel;
use Legato\Framework\Request;
use Legato\Framework\Validator\Validator;
use App\classes\ValidatorHelper;

class SubChannelController extends BaseController
{

    public function show()
    {
        $channels = Channel::where('archived', 0)->get();
        $subchannels = SubChannel::paginated(7);
        return view('admin.channels.subchannel', compact('channels', 'subchannels'));
    }

    public function save(Request $request)
    {

        $rules = [
            'name' => [
                'required' => true, 'max' => 30, 'string' => true, 'unique' => 'sub_channels'
            ],
            'channel' => ['required' => true, 'numeric' => true]
        ];

        $validator = new Validator($request->all(), $rules);
        $errors = ValidatorHelper::parseErrors($request, $validator);

        if(is_array($errors))
        {
            flash('errors', $errors);
            return redirectTo('/admin/subchannel');
        }

        SubChannel::create([
           'name' => $request->input('name'),
           'slug' => str_slug($request->input('name')),
           'channel_id' => $request->input('channel'),
        ]);

        flash('success', 'Subchannel created');
        return redirectTo('/admin/subchannel');
    }
}