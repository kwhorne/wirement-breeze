@props(['title','description'])
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 wirement-breeze-grid-section" {{ $attributes }}>

    <div>
        <h3 @class(['text-lg font-medium wirement-breeze-grid-title'])>{{$title}}</h3>

        <p @class(['mt-1 text-sm text-gray-500 wirement-breeze-grid-description'])>
            {{$description}}
        </p>
    </div>

    <div>
        {{ $slot }}
    </div>

</div>
