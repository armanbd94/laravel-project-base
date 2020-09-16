<div class="form-group {{$col ?? ''}} {{$required ?? ''}}" >
    <label for="{{$name}}">{{$labelName}}</label>
    <textarea name="{{$name}}" id="{{$name}}" class="form-control {{$class ?? ''}}" value="{{ $value ?? '' }}"
     placeholder="{{$placeholder ?? ''}}"></textarea>
</div>