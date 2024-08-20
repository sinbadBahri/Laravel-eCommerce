@if (! $footerCollection == null)
    
<div class="footer">
    <div class="container">
        <div class="row">
            @foreach ($footerCollection as $footerItems)
            
            <div class="col-md-3">
                <div class="footer-description">
                    <ul>
                        <li><i class="fa fa-truck"></i>{{$footerItems[0]->footerName()}}</li>
                        @foreach($footerItems as $item)
                        <li><a href="{{ $item->value }}">{{ $item->key }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif