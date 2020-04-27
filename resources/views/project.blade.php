@extends('khancode::base'.config('laravelrestbuilder.theme'))

@section('title', 'Project')

@section('content')
<style>
.tree-block {
    background: rgba(86,61,124,.15);
    padding: 10px;
    border-radius: 5px;
    overflow: scroll;
    /* height: 100%; */
}
.tree-detail {
    padding: 0px;
    border-radius: 5px;
    /* height: 100%; */
}
.select-method {
    border-radius: .35rem 0 0 .35rem;
    height: calc(1.5em + .75rem - 2px);
    width: 100%;
    border: 1px solid #d1d3e2;
    color: #6e707e;
    padding: 0.10rem .75rem;
}
.input-group>.prepend-method {
    flex: 0 0 15%;
}
.input-group .input-group-text {
    width: 100%;
}
.dokumentasi button {
    height: calc(1.5em + .75rem - 2px);
}
.input-url {
    border-radius:  0 .35rem .35rem 0 !important;
}
.tab-content {
    padding:10px;
    background: white;
}
.nav-link {
    padding: 0.2rem 0.7rem 0.2rem 0.7rem;
}
.tab-auto .fa-times {    
    margin-right: -5px;    
    cursor:pointer;
}
#tab-top .nav-item .nav-link {
    border-color: #dddfeb #dddfeb #fff;
}
#top-tab-plus {
    cursor:pointer;
    margin-left: 5px;
}
.atas a {
    white-space: nowrap;
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
}
/* .atas i {
    display: block;
    margin-top: 100px;
    margin-left: 56px;
} */
#addTabChrome {
    font-weight: bold;
    font-size: large;
    margin-top: -6px;
    cursor:pointer
}
</style>
<style>
.icon-get {
    margin-left:20px !important;
}
.icon-get:before {
    content:'GET';
    color: #3ac23a;
    font-weight: bold;
    margin-left: -25px;
    font-size:x-small;
}
.icon-post {
    margin-left:20px !important;
}
.icon-post:before {
    content:'POST';
    color: orange;
    font-weight: bold;
    margin-left: -25px;
    font-size:x-small;
}
.icon-put {
    margin-left:20px !important;
}
.icon-put:before {
    content:'PUT';
    color: purple;
    font-weight: bold;
    margin-left: -25px;
    font-size:x-small;
}
.icon-delete {
    margin-left:20px !important;
}
.icon-delete:before {
    content:'DEL';
    color: red;
    font-weight: bold;
    margin-left: -25px;
    font-size:x-small;
}
.changed {
    flex-grow: 0;
    flex-shrink: 0;
    position: relative;    
    border-radius: 50%;
    background-image: none !important;
    background: #d94f4f;
    width: 12px !important;
    height: 12px !important;
}
.desc-textarea {
    border-top: 0px;
    border-left: 0px;
    border-right: 0px;
    border-radius: 0px;
}
.addtab {
    width: 50px !important;
}
table .fa-close {
    margin-top: 8px;
    cursor: pointer;
}
.ace_editor {
    min-height:520px;
}
</style>


@endsection

@section('script_add_on')    
    <script>
        baseUrl = "{{url('/')}}"
    </script>
@endsection

    