@extends('themes.default.layout')

@section('content')
    <div class="row">
        <div class="col-12 text-center">
            <h2 style="display: inline-block;">{{ $user->username }} (#{{ $user->id }}) </h2> <h3 style="display: inline-block;">Level 1 </h3>
            <br />
            
            @if(Auth::user()->roles()['admin'] || Auth::user()->roles()['moderator'])
            <h4><a href="/user/warn/{{ $user->id }}" class="badge badge-warning">Warn User</a></h4>
            
            @endif
        </div>
    </div>    
        
    <div class="row">
        <div class="col-12">
            <div class="prof_custom_text">
                {{ $user->about }}
            </div>
        </div>
    </div>
    
    <div class="row">
            <div class="col-6">
                <div class="col-10">
                    <div class="prof_info">
                        <br>
                    Joined: {{ date("n/j/Y", strtotime($user->created_at)) }}<br />
                    Last visit: {{ date("n/j/Y", $user->last_active) }}
                    </div>
                </div>
                
                <div class="col-10">
                    <div class="prof_achiev">
                        <br>
                        <strong>Achievements:</strong> <a href="#">0</a><br />
                        <strong>Craviary:</strong> <a href="#">0</a><br />
                        <strong>Trades:</strong> <a href="#">0</a><br />
                        <strong>Auctions:</strong> <a href="#">0</a>
                    </div>
                </div>
                
                <div class="col-10">
                    <div class="prof_allies">
                        <span class="box_head">Allies</span>
                        <div class="row topmargin_xs">
                            @if(!$user->allies()->count())
                                This user hasn't made any allies yet :(
                            @else
                                @foreach($user->allies AS $ally)
                                <div class="col-6 topmargin_xs">
                                    <a href="/user/profile/{{ $ally->ally_id }}">{{ $ally->user->username }} (#{{ $ally->ally_id }})</a> 
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <br><br>
                @if($user->id != Auth::user()->id)
                <div class="col-13">
                    <div class="prof_buttons">
                        <a href="{{ route('messages.compose.withid', ['id'=>$user->id] ) }}" class="prof_button">Send Message</a>
                        @if(!Auth::user()->allies()->where('ally_id', '=', $user->id)->count() && !Auth::user()->alliesPending()->where('ally_id', '=', $user->id)->count())
                            <a href="/user/alliance/{{ $user->id }}" class="prof_button"> Request Alliance</a>
                            
                        @elseif(Auth::user()->alliesPending()->where('ally_id', '=', $user->id)->count())
                            <a href="javascript:void(0);" class="prof_button"> Alliance Pending...</a>
                        @else
                            <a href="/user/alliance-end/{{ $user->id }}" class="prof_button" onclick="if (! confirm('Are you sure you want to end this alliance?')) { return false; }"> End Alliance</a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <div class="col-6">
                <div class="col-12">
                    <div class="prof_badges">
                        <span class="box_head">Badges</span>
                        <br>
                        <div class="row topmargin_s">
                         This user hasn't earned any badges yet :(
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="prof_avatars">
                        <span class="box_head">Avatars</span>
                        <?php
                        //Columns must be a factor of 12 (1,2,3,4,6,12)
                        $numOfCols = 3;
                        $rowCount = 0;
                        $bootstrapColWidth = 12 / $numOfCols;
                        foreach ($user->characters()->get() as $character){
                        if($rowCount % $numOfCols == 0) { ?> <div class="row topmargin_s"> <?php }
                            $rowCount++; ?>
                            <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                                <a href="/character/profile/{{ $character->id }}"><img src="/assets/images/characters/{{ $character->id }}/image_cropped.png" alt="Your icon"></a>
                            </div>
                            <?php
                            if($rowCount % $numOfCols == 0) { ?> </div> <?php } } ?>
                    </div>
                </div>
            </div>
        </div>
@stop