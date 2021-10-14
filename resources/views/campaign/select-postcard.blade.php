@extends('layouts.app', ['activePage' => 'design', 'titlePage' => __('Select A Postcard')])

@section('content')
    <iframe frameborder="0" src=
    "https://simplepost.designhuddle.com/projects?noheader=1&token={{ $userToken }}#/create"
            style="overflow: hidden; height: 100%; width:100%; position: absolute"
    ></iframe>
@endsection


@push('js')
    <script>
        function bindEvent(element, eventName, eventHandler) {
            if (element.addEventListener) {
                element.addEventListener(eventName, eventHandler, false);
            } else if (element.attachEvent) {
                element.attachEvent('on' + eventName, eventHandler);
            }
        }

        bindEvent(window, 'message', function (e) {
            if (e && e.data && typeof e.data === 'string') {
                try {
                    var data = JSON.parse(e.data);
                    if (data && data.type === 'DSHD_GOTO_PROJECT') {
                        var project_id = data.payload.project_id;
                        window.location.replace('/campaign/design-postcard/' + project_id);
                    }
                } catch {
                }
            }
        })
    </script>
@endpush
