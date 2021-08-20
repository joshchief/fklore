<div class="row topmargin_l">
    <div class="col-12">
        <div class="pms">
            <span class="box_head">Preview Message</span>
        </div>

        <div class="pms-body">
            <div class="row">
                <div class="col-12">
                    <div style="float:left;">
                        <strong>Author</strong>: <a href="https://folkoflore.com/user/profile/{{ Auth::user()->id }}">{{ Auth::user()->username }}</a>
                    </div>
                    <div style="float:right; padding-right: 10px;">
                        {{ date("M d, Y @ h:ia", strtotime($message['created_at'])) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <strong>Message</strong>:
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-10">
                    <p>
                        {{ nl2br($message['message']) }}
                    </p>
                </div>
            </div>
            @if(count($message['attachments']) > 0)
                <div class="row">
                    <div class="col-1">&nbsp;</div>
                    <div class="col-10">
                        <ol style="list-style: none;">
                            @foreach($message['attachments'] as $attachment)
                                <?php
                                switch($attachment['type'])
                                {
                                    case 'currency_silver':
                                        $image = 'https://folkoflore.com/assets/img/silver_icon.png';
                                        $value = $attachment['quantity'];
                                        break;
                                    case 'currency_gold':
                                        $image = 'https://folkoflore.com/assets/img/gold_icon.png';
                                        $value = $attachment['quantity'];
                                        break;
                                    case 'item':
                                        $item = UserItems::find($attachment['object_id'])->item;
                                        $image = 'https://folkoflore.com/assets/images/items/'.$item->image;
                                        $value = $item->name;
                                        break;
                                }
                                ?>
                                <li><img style="height:40px; width:40px;" src="{{ $image }}" alt="attachment" /> <kbd>{{ $value }}</kbd></li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>