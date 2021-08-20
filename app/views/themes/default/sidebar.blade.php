<div id="sidebar">
    <div class="mini-hud">
        @if(!Auth::check())
        <a href="#">Username (#0)</a>
        @else
        <a href="/user/profile/{{ Auth::user()->id }}">{{ Auth::user()->username }} (#{{ Auth::user()->id }})</a>
        @endif
        
        @if(!Auth::check() || Auth::user()->activeCharacter()->count() == 0)
            <img class="user-avatar" src="http://via.placeholder.com/150x150" width="150" alt="Your icon">
        @else
            <a href="/character/profile/{{ Auth::user()->active_character }}"><img class="user-avatar" src="/assets/images/characters/{{ Auth::user()->active_character }}/image_cropped.png" width="150" alt="Your icon"></a>
        @endif
        <select id="character-select">
            @if(Auth::check())
                @if(Auth::user()->characters()->withTrashed()->count())
                
                    @if(Auth::user()->characters()->count())
                        @if(!Auth::user()->activeCharacter()->count())
                            <option>Select a character.</option>
                        @endif
                        
                        @foreach(Auth::user()->characters AS $character)
                            <option value="{{ $character->id }}" @if(Auth::user()->activeCharacter()->count() != 0 && $character->id == Auth::user()->active_character) selected @endif>{{ $character->name }} - Lvl {{ $character->level }}</option>
                        @endforeach
                    @else
                        <option>Select a character.</option>
                    @endif
                    
                    @if(Auth::user()->characters()->onlyTrashed()->count())
                        @foreach(Auth::user()->characters()->onlyTrashed()->get() AS $char)
                            @if(strtotime($char->deleted_at) > strtotime("-72 Hours"))
                            <option value="">{{ $char->name }} - Lvl {{ $char->level }} (Meditating)</option>
                            @endif
                        @endforeach
                    @endif
                @else
                    <option>You don't have any characters.</option>
                @endif
            @else
                <option>Character1- Lvl 0</option>
                <option>Character2- Lvl 0</option>
            @endif
        </select>
    </div>
    <div class="currency-hud">
        @if(!Auth::check())
            <div class="row">
                <div class="coin offset-md-0"><img src="/assets/img/gold_icon.png" width="35" alt="Gold"></div>
                <div class="col amt"><span>Gold Shils:0</span></div>
            </div>
            <div class="row">
                <div class="coin offset-md-0"><img src="/assets/img/silver_icon.png" width="35" alt="Silver"></div>
                <div class="col amt"><span>Silver Shils:0</span></div>
            </div>
        @else
            <div class="row">
                <div class="coin offset-md-0"><img src="/assets/img/gold_icon.png" width="35" alt="Gold"></div>
                <div class="col amt"><span>Gold Shils: {{ number_format(Auth::user()->gold) }}</span></div>
            </div>
            <div class="row">
                <div class="coin offset-md-0"><img src="/assets/img/silver_icon.png" width="35" alt="Silver"></div>
                <div class="col amt"><span>Silver Shils: {{ number_format(Auth::user()->silver) }}</span></div>
            </div>
        @endif
    </div>
    <div class="links-hud">
        
        <ul class="sidebar-nav">
            <h3>Character</h3>
            <li><a href="/create" class="btn primary form-control">Create</a></li>
            <li><a href="" class="btn primary form-control">Quests</a></li>
            <li><a href="" class="btn primary form-control">Bonds</a></li>
            <li><a href="" class="btn primary form-control">Wardrobe</a></li>
            
            <h3>Account</h3>
                        <li><a href="/user/profile/{{ (!Auth::check()) ? ''  : Auth::user()->id }}" class="btn primary form-control">Profile</a></li>
            <li><a href="" class="btn primary form-control">Avatars</a></li>
            <li><a href="" class="btn primary form-control">Achievements</a></li>
            <li><a href="" class="btn primary form-control">Archive</a></li>
            <li><a href="" class="btn primary form-control">Your Home</a></li>
            <li><a href="/craviary" class="btn primary form-control">Craviary</a></li>
            <li><a href="" class="btn primary form-control">Pens</a></li>
            <li><a href="" class="btn primary form-control">Allies</a></li>
            <li><a href="" class="btn danger form-control">Deactivate</a></li>


            <h3>Support</h3>
            <li><a href="" class="btn primary form-control">FAQ</a></li>
            <li><a href="/tos" class="btn primary form-control">Terms of Service</a></li>
            <li><a href="" class="btn danger form-control">Mod Box</a></li>
        </ul>
    </div>
</div>