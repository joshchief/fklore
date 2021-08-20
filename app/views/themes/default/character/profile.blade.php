@extends('themes.default.layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="primary header_prof text-center">
                <div class="col-2" style="float: left;">
                    Owner<br />
                    <a href="/user/profile/{{ $character->user_id }}" style="color: #19374b;">{{ strtoupper($character->owner->username) }}</a>
                </div>
                
                <div class="col-3" style="float: left;">
                    Name<br />
                    {{ strtoupper($character->name) }}
                </div>
                
                <div class="col-3" style="float: left;">
                    Birthday<br />
                    {{ strtoupper(date("M d", strtotime($character->created_at))) }} Y{{ (date("Y", strtotime($character->created_at)) - date("Y") + 1) }}
                </div>
                
                <div class="col-2" style="float: left;">
                    Folk<br />
                    {{ strtoupper($character->species->name) }}
                </div>
                
                <div class="col-2" style="float: left;">
                    Alignment<br />
                    {{ strtoupper($character->grabElement->name) }}
                </div>
            </div>
        </div>
    </div>   
    
    <div class="row">
        <div class="col-12 text-center">
            <img src="/assets/images/characters/{{ $character->id }}/image.png" height="500px" style="margin-left: -180px;" />
            
            <div style="position: absolute; top: -35px; right: 10px;">
                <img src="/assets/images/elements/banners/{{ $character->grabElement->name }}.png" />
            </div>
            
            <div style="position: absolute; z-index: 10; top: 120px; right: 80px;">
                <div class="row">
                    <div class="col-12 text-center">
                        <span class="blue_title" style="font-size: 16px;">LEVEL &nbsp;{{ $character->level }}</span>
                    </div>
                </div>
                
                <div class="row topmargin_l">
                    <div class="col-12 text-center blue_title">
                        MAG &nbsp;{{ $character->magic }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 text-center blue_title">
                        STR &nbsp;{{ $character->strength }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 text-center blue_title">
                        DEF &nbsp;{{ $character->defense }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 text-center blue_title">
                        DEX &nbsp;{{ $character->dexterity }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 text-center blue_title">
                        VIT &nbsp;{{ $character->vitality }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 text-center blue_title">
                        AGI &nbsp;{{ $character->agility }}
                    </div>
                </div>
                
                <div class="row topmargin_l">
                    <div class="col-12 text-center blue_title">
                        HP {{ $character->hp }}/{{ $character->hp_max }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 text-center blue_title">
                        MP {{ $character->mp }}/{{ $character->mp_max }}
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="row" style="margin-top: 0px;">
        <div class="offset-1 col-4 text-center">
            <span class="blue_title">Wardrobe</span>
        </div>
    </div>
    
    <div class="row">
        <div class="offset-1 col-4 char_prof_box">
        </div>

         <div class="offset-1 col-4">
             @if(!$character->deleted_at || $character->deleted_at && strtotime($character->deleted_at) > strtotime("-72 Hours"))
            <div class="row topmargin_s">
                <div class="col-4">
                    <a href="" class="btn-char-prof">Ally</a>
                </div>
                
                <div class="col-4">
                    <a href="" class="btn-char-prof">Contact</a>
                </div>
            </div>
            
            <div class="row topmargin_l">
                <div class="col-10  text-center">
                    <a href="" class="char-auction" disabled>In Auction</a>

                    &nbsp;&nbsp;<a href="" class="char-report">REPORT AVATAR</a>
                </div>
            </div>
            @endif
            
            @if($character->user_id == Auth::user()->id)
            <div class="row topmargin_l">
                <div class="col-12">
                    @if(!$character->deleted_at)
                        &nbsp;&nbsp;<a href="/character/delete/{{ $character->id }}" class="btn danger white-font" onclick="if (! confirm('Are you sure you want to delete this avatar?')) { return false; }">Delete</a>
                    @else
                        @if(strtotime($character->deleted_at) > strtotime("-72 Hours"))
                            &nbsp;<span class="char-auction">Meditating</span>

                            &nbsp;&nbsp;<a href="/character/delete/{{ $character->id }}" class="char-report">CANCEL DELETION</a>
                        @else
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="char-auction">Queued for Deletion</span>
                        @endif
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <div class="row topmargin_l">
        <div class="offset-1 col-10 char_prof_box">
 
            
        </div>
    </div>
@stop