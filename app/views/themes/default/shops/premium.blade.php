@extends('themes.default.layout')
    
@section('content')
    <div class="row align-center">
        <div class="col-md-12">
            <h1><span style="color: #355b7d;"><b>Premium Shop</span></b></h1>
        </div>
        
        <div class="col-md-12">
            <img src="/assets/images/shops/premium_shopfront.png" />
        </div>
        
        <div class="col-md-11 topmargin_l" style="margin-left: 30px;">
            Welcome to the premium shop
        </div>
        
            <div class="col-md-12 topmargin_l">
                <h3>Purchase Gold Shils</h3>
            </div>
            
            <div class="col-md-6 offset-md-3 topmargin_l">
                <form method="store" action="/payments">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><img src="/assets/img/gold_icon.png" /></span>
                        </div>
                        <input type="text" name="shilQty" class="form-control" placeholder="Qty" aria-label="Qty" aria-describedby="basic-addon1" value="1">
                    </div>
                    
                    <input type="submit" class="btn primary white-font form-control" value="Purchase" />
                </form>
            </div>
    </div>
@stop