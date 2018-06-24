<select class="form-control" name="channel" id="channel">
    @if(isset($channels) && count($channels))
        @foreach($channels as $channel)
            <option value="{{ $channel->id }}">{{ $channel->name }}</option>
        @endforeach
    @else
        <option value="">No channels available</option>
    @endif
</select>