<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/ace-diff@^2.0.0/dist/ace-diff.min.css">

    <link href="{{url('/')}}/vendor/khancode/css/loading.css" rel="stylesheet">
    <link href="{{url('/')}}/vendor/khancode/css/switcher.css" rel="stylesheet">

    <style>
      .scroll-to-top{
        z-index:10;
      }     
    </style>

    <style>
        figure.highlight {
            background-color: #fff;
            padding: 20px 40px;
        }
        .form-control::-webkit-input-placeholder { color: #a0a3a77a; }  /* WebKit, Blink, Edge */
        .form-control:-moz-placeholder { color: #a0a3a77a; }  /* Mozilla Firefox 4 to 18 */
        .form-control::-moz-placeholder { color: #a0a3a77a; }  /* Mozilla Firefox 19+ */
        .form-control:-ms-input-placeholder { color: #a0a3a77a; }  /* Internet Explorer 10-11 */
        .form-control::-ms-input-placeholder { color: #a0a3a77a; }  /* Microsoft Edge */
        .btn-delete {
            width: calc(1.5em + .75rem - 2px);
            padding: 0px;
            margin: 0;
            height: calc(1.5em + .75rem - 2px);
        }        
        .form-control , .input-group-text {
            height: calc(1.5em + .75rem - 2px);
            padding: 0.10rem .75rem;
        }
        .icon {
            display: inline-block;
            width: 12px;
            height: 12px;
        }
    </style>

    <style>
        .ui-switcher {            
            background-color: #bdc1c2;
            display: inline-block;
            height: 34px;
            width: 65px;
            border-radius: 6px;
            box-sizing: border-box;
            vertical-align: middle;
            position: relative;
            cursor: pointer;
            transition: border-color 0.25s;
            margin: 0px 4px 0 0;
            box-shadow: inset 1px 1px 1px rgba(0, 0, 0, 0.15);
        }
        .ui-switcher[aria-checked=true]:before {
            content: 'show';         
            left: 3px;
        }
        .ui-switcher:before {
            font-family: sans-serif;
            font-size: 13px;
            font-weight: 400;
            color: #ffffff;
            line-height: 1;
            display: inline-block;
            position: absolute;
            top: 9px;
            height: 12px;
            width: 20px;
            text-align: center;
        }        
        .ui-switcher[aria-checked=true]:after {
            left: 36px;
        }
        .ui-switcher:after {
            background-color: #ffffff;
            content: '\0020';
            display: inline-block;
            position: absolute;
            top: 4px;
            height: 25px;
            width: 25px;
            border-radius: 20%;
            transition: left 0.25s;
        }
        .ui-switcher[aria-checked=false]:before {
            content: 'hide';            
            right: 11px;
        }
        .with-check .ui-switcher[aria-checked=true]:before {            
            content: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAmUlEQVQ4T6WT0RWDMAhFeZs4ipu0mawZpaO4yevBc6hUIWLNd+4NeQDk5sE/PMkZwFvZywKSTxF5iUgH0C4JHGyF97IggFVSqyCFga0CvQSg70Mdwd8QSSr4sGBMcgavAgdvwQCtApvA2uKr1x7Pu++06ItrF5LXPB/CP4M0kKTwYRIDyRAOR9lJTuF0F0hOAJbKopVHOZN9ACS0UgowIx8ZAAAAAElFTkSuQmCC');
            left: 7px;
        }
        .with-check .ui-switcher[aria-checked=false]:before {            
            content : url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAyklEQVQ4T42TaxHCQAyENw5wAhLACVUAUkABOCkSwEkdhNmbpHNckzv689L98toIAKjqGcAFwElEFr5ln6ruAMwA7iLyFBM/TPDuQSrxwf6fCKBoX2UMIYGYkg8BLOnVg2RiAEexGaQQq4w9e9klcxGLLAUwgDAcihlYAR1IvZA1sz/+AAaQjXhTQQVoe2Yo3E7UQiT2ijeQdojRtClOfVKvMVyVpU594kZK9zzySWTlcNqZY9tjCsUds00+A57z1e35xzlzJjee8xf0HYp+cOZQUQAAAABJRU5ErkJggg==');
            right: 7px;
        }
        .with-check .ui-switcher[aria-checked=false]:after {            
            left: 4px;
        }
    </style>

    <style>
        .table th, .table td {
            padding: 0.35rem 0.75rem;
        }
        .pointer {cursor: pointer;}
    </style>

    <style>
        .list-collapse[data-toggle="collapse"]:before {  
            content: "-";
            margin: 10px;
        }

        .list-collapse[data-toggle="collapse"].collapsed:before {
            content: "+";
            margin: 10px;
        }
        footer{
          z-index:10;
        }
    </style>
    
    <style>
        .sidebar-brand-text {
            height: 4.375rem;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 800;
            padding: 0.5rem 0.5rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: .05rem;
            z-index: 1;
        }
        .closed-sidebar .app-header .app-header__logo .sidebar-brand-text {
            display: none
        }
        body{
            overflow-x:hidden
        }
    </style>

    <!-- cmd like css -->
    <style>
        #background {            
            width: 100%;
            height: 100%;
            background-color: black;
            margin: 0px;
            padding: 0px;
        }

        #console {
            margin: 0px;
            padding: 0px;
        }

        #consoletext {
            color: rgb(255, 255, 255);
            font-family: Monospace;
            margin: 10px 0px 0px 10px;
        }

        #textinput {
            resize: none;
            margin: 0px 0px 10px 10px;
            border: none;
            outline: none;
            background-color: rgb(0, 0, 0);
            color: rgb(255, 255, 255);
            font-family: Monospace;
            width: calc(100% - 20px);
            overflow: hidden;
        }
        .codeHint {
            background: #f4f4f4;
            border: 1px solid #ddd;
            border-left: 3px solid #186bc4;
            color: #666;
            page-break-inside: avoid;
            font-family: monospace;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 1.6em;
            max-width: 100%;
            overflow: auto;
            padding: 1em 1.5em;
            display: block;
            word-wrap: break-word;
        }
    </style>
    <link href="{{url('/')}}/vendor/khancode/css/main-architect.css" rel="stylesheet"></head>
    <script>
        function isJson(text) {
            if (/^[\],:{}\s]*$/.test(text.replace(/\\["\\\/bfnrtu]/g, '@').
                replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
                replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                return true;
            }
            return false;
        }
        
        function IsJsonString(str) {
            try {
                jsonObj = JSON.parse(str);
            } catch (e) {
                return false;
            }
            return jsonObj;
        }
        
        function replaceString(data,replace_with,subject) {
            regex = new RegExp(data, "igm");
            return subject.replace(regex, replace_with);
        }      
    </script>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="sidebar-brand-text mx-3">Laravel Rest Builder</div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>    
            <div class="app-header__content">
                <!-- <div class="app-header-left">
                    <div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                    <ul class="header-menu nav">
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-database"> </i>
                                Statistics
                            </a>
                        </li>
                        <li class="btn-group nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-edit"></i>
                                Projects
                            </a>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-cog"></i>
                                Settings
                            </a>
                        </li>
                    </ul>        
                </div> -->
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">                                
                                <div class="widget-content-left ml-3">
                                    <button type="button" class="btn btn-info float-right col-sm-12 btn-sm" onclick="syncRepo()">
                                        <i class="fas fa-refresh fa-sm text-white-50"></i> Sync Repo
                                    </button>
                                </div>                                
                                <div class="widget-content-left ml-3">
                                    <button type="button" class="btn btn-success float-right col-sm-12 btn-sm" onclick="addComposerUpdate()">
                                        <i class="fas fa-refresh fa-sm text-white-50"></i> Composer
                                    </button>
                                </div>
                                <div class="widget-content-left ml-3">
                                    <select class="form-control" name="select_project">                  
                                        @foreach($projects as $project)
                                            @if($project->id == session('project')['id'])
                                            <option value={{$project->id}} selected>{{$project->name}}</option>
                                            @else
                                            <option value={{$project->id}}>{{$project->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">                                    
                                    {{$user->name}}                                                                        
                                </div>
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="https://img.icons8.com/material-rounded/48/000000/user-male-circle.png" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                                <button type="button" tabindex="0" class="dropdown-item">
                                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                                    Logout
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                        <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                    </button>
                                </div> -->
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </div>        
        <!-- <div class="ui-theme-settings">
            <button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
            </button>
            <div class="theme-settings__inner">
                <div class="scrollbar-container">
                    <div class="theme-settings__options-wrapper">
                        <h3 class="themeoptions-heading">Layout Options
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-header">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Header
                                                </div>
                                                <div class="widget-subheading">Makes the header top fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-sidebar">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Sidebar
                                                </div>
                                                <div class="widget-subheading">Makes the sidebar left fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-footer">
                                                    <div class="switch-animate switch-off">
                                                        <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Footer
                                                </div>
                                                <div class="widget-subheading">Makes the app footer bottom fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>
                                Header Options
                            </div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class" data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-header-cs-class" data-class="bg-primary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-header-cs-class" data-class="bg-secondary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-header-cs-class" data-class="bg-success header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-header-cs-class" data-class="bg-info header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-header-cs-class" data-class="bg-warning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-header-cs-class" data-class="bg-danger header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-header-cs-class" data-class="bg-light header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-header-cs-class" data-class="bg-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-header-cs-class" data-class="bg-focus header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-header-cs-class" data-class="bg-alternate header-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-header-cs-class" data-class="bg-vicious-stance header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-header-cs-class" data-class="bg-midnight-bloom header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-header-cs-class" data-class="bg-night-sky header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-header-cs-class" data-class="bg-slick-carbon header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-header-cs-class" data-class="bg-asteroid header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-header-cs-class" data-class="bg-royal header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-header-cs-class" data-class="bg-warm-flame header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-header-cs-class" data-class="bg-night-fade header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-header-cs-class" data-class="bg-sunny-morning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-header-cs-class" data-class="bg-tempting-azure header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-header-cs-class" data-class="bg-amy-crisp header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-header-cs-class" data-class="bg-heavy-rain header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-header-cs-class" data-class="bg-mean-fruit header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-header-cs-class" data-class="bg-malibu-beach header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-header-cs-class" data-class="bg-deep-blue header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-header-cs-class" data-class="bg-ripe-malin header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-header-cs-class" data-class="bg-arielle-smile header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-header-cs-class" data-class="bg-plum-plate header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-header-cs-class" data-class="bg-happy-fisher header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-header-cs-class" data-class="bg-happy-itmeo header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-header-cs-class" data-class="bg-mixed-hopes header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-header-cs-class" data-class="bg-strong-bliss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-header-cs-class" data-class="bg-grow-early header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-header-cs-class" data-class="bg-love-kiss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-header-cs-class" data-class="bg-premium-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-header-cs-class" data-class="bg-happy-green header-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Sidebar Options</div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-sidebar-cs-class" data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-sidebar-cs-class" data-class="bg-primary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-sidebar-cs-class" data-class="bg-secondary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-sidebar-cs-class" data-class="bg-success sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-sidebar-cs-class" data-class="bg-info sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-sidebar-cs-class" data-class="bg-warning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-sidebar-cs-class" data-class="bg-danger sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-sidebar-cs-class" data-class="bg-light sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-sidebar-cs-class" data-class="bg-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-sidebar-cs-class" data-class="bg-focus sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-sidebar-cs-class" data-class="bg-alternate sidebar-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class" data-class="bg-vicious-stance sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class" data-class="bg-midnight-bloom sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-sidebar-cs-class" data-class="bg-night-sky sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class" data-class="bg-slick-carbon sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-sidebar-cs-class" data-class="bg-asteroid sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-sidebar-cs-class" data-class="bg-royal sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-sidebar-cs-class" data-class="bg-warm-flame sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-sidebar-cs-class" data-class="bg-night-fade sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-sidebar-cs-class" data-class="bg-sunny-morning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-sidebar-cs-class" data-class="bg-tempting-azure sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-sidebar-cs-class" data-class="bg-amy-crisp sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-sidebar-cs-class" data-class="bg-heavy-rain sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-sidebar-cs-class" data-class="bg-mean-fruit sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-sidebar-cs-class" data-class="bg-malibu-beach sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-sidebar-cs-class" data-class="bg-deep-blue sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-sidebar-cs-class" data-class="bg-ripe-malin sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-sidebar-cs-class" data-class="bg-arielle-smile sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-sidebar-cs-class" data-class="bg-plum-plate sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-sidebar-cs-class" data-class="bg-happy-fisher sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-sidebar-cs-class" data-class="bg-happy-itmeo sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-sidebar-cs-class" data-class="bg-mixed-hopes sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-sidebar-cs-class" data-class="bg-strong-bliss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-sidebar-cs-class" data-class="bg-grow-early sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-sidebar-cs-class" data-class="bg-love-kiss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-sidebar-cs-class" data-class="bg-premium-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-sidebar-cs-class" data-class="bg-happy-green sidebar-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Main Content Options</div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto active btn btn-focus btn-sm">Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Page Section Tabs
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div role="group" class="mt-2 btn-group">
                                            <button type="button" class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class" data-class="body-tabs-line">
                                                Line
                                            </button>
                                            <button type="button" class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class" data-class="body-tabs-shadow">
                                                Shadow
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>         -->
        <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>    
                    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">                        
                            <ul class="vertical-nav-menu navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                                @include('khancode::menuArchitect')
                                <!-- <li class="app-sidebar__heading">Dashboards</li>
                                <li>
                                    <a href="index.html" class="mm-active">
                                        <i class="metismenu-icon pe-7s-rocket"></i>
                                        Dashboard Example 1
                                    </a>
                                </li> -->
                                                                
                            </ul>
                        </div>
                    </div>
                </div>    
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        
                        @include('khancode::header')

                        @yield('content')
                        
                    </div>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 1
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 2
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="app-footer-right">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                Footer Link 3
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0);" class="nav-link">
                                                <div class="badge badge-success mr-1 ml-0">
                                                    <small>NEW</small>
                                                </div>
                                                Footer Link 4
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
                <!-- <script src="http://maps.google.com/maps/api/js?sensor=true"></script> -->
        </div>
    </div>

    <div class="loading" style="display:show">
        <div class="dl">
        <div class="dl__container">
            <div class="dl__corner--top"></div>
            <div class="dl__corner--bottom"></div>
        </div>
        <div class="dl__square"></div>
        </div>
    </div>

    <script type="text/javascript" src="{{url('/')}}/vendor/khancode/js/main-architect.min.js"></script></body>

<!-- Bootstrap core JavaScript-->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/2.9.0/jquery.serializejson.min.js"></script>    
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>     -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>  
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>  
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://legacy.datatables.net/extras/thirdparty/ColReorderWithResize/ColReorderWithResize.js"></script>
    <!-- Custom scripts for all pages-->
    <!-- <script src="{{url('/')}}/vendor/khancode/js/sb-admin-2.min.js"></script> -->
    <!-- script modul table -->
    <script src="{{url('/')}}/vendor/khancode/js/modul-table.js"></script>
    <script src="{{url('/')}}/vendor/khancode/bootstrap/js/bootstrap.min.js"></script>

    <!-- script diff -->
    <script src="{{url('/')}}/vendor/khancode/js/src/ace.js"></script>
    <script src="{{url('/')}}/vendor/khancode/js/src/ext-language_tools.js"></script>
    <script src="{{url('/')}}/vendor/khancode/js/codeEditorCustom.js"></script>
    <script src="{{url('/')}}/vendor/khancode/js/ace-generator.js"></script>    
    <script src="https://unpkg.com/ace-diff@^2.0.0"></script>
    <script src="{{url('/')}}/vendor/khancode/js/URI.js"></script>
    
    <script>
      function arrayUnique(array) {
          var a = array.concat();
          for(var i=0; i<a.length; ++i) {
              for(var j=i+1; j<a.length; ++j) {
                  if(a[i] === a[j])
                      a.splice(j--, 1);
              }
          }

          return a;
      }

      function array_flip( trans )
      {
          var key, tmp_ar = {};

          for ( key in trans )
          {
              if ( trans.hasOwnProperty( key ) )
              {
                  tmp_ar[trans[key]] = key;
              }
          }

          return tmp_ar;
      }
    </script>

    @yield('script_add_on')

    <!-- set nav active --> 
    <script>
        $( document ).ready(function() {
            $( "[href$='"+window.location.pathname+"']" ).parent().addClass('active');
        })        
        $(document).ajaxStart(function(){
            // Show image container
            $(".loading").show();
        });
        $(document).ajaxComplete(function(data, xhr){
            if(xhr.status == 401) {
                location.reload();
            } 
            // Hide image container
            $(".loading").hide();
        });        
    </script>

    <script>
      $( '[name="select_project"]' ).on('change', function() {
          window.location.replace('{{url('/')}}/setProject/'+this.value+'?previous={{Request::url()}}');          
      });
    </script>
    
    <!-- haeder function -->
    <script>
        function addPackage() {
            formData = new FormData();
            formData.append('package',$("#composer_package").val())
            formData.append('version',$("[name='version']").val())

            dataResult = '';
            $.ajax({
                url: '/addPackage',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {                    
                    dataResult += data;

                    dataResult += '<div id = "background">'
                        dataResult += '<div id = "console">'
                            dataResult += '<p id = "consoletext">'
                                dataResult += dataResult
                            dataResult += '</p>'
                        dataResult += '</div>'
                    dataResult += '</div>'

                    $("#modal_composer .modal-body").html(dataResult);
                    $('#modal_composer').modal({backdrop: 'static', keyboard: false})  

                    getComposerUpdateResult()  
                },
                error: function(data) {
                    $("#modal_composer .modal-body").html(data);
                    $("#modal_composer").modal('show');
                }
            });
        }
        
        function getVersionPackage() {

            $("list_version").html('<div class="loadingio-spinner-pulse-kcbrhx7jx9"><div class="ldio-krr67ftzakf"><div></div><div></div><div></div></div></div>')
            dataResult = '';

            formData = new FormData();
            formData.append('package',$("#composer_package").val())

            $.ajax({
                url: '/getVersionPackage',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {  
                    jumlah_version = 0
                    dataResultOption = '<option value="">dev-master</option>'
                    
                    $.each(data.version, function(i,k){
                        if(k){                                    
                            dataResultOption += '<option value="'+k+'">'+k+'</option>'                                       
                            jumlah_version++
                        }
                    });                    
                    
                    if(jumlah_version>0) {
                        dataResult += '<div class="form-group">'
                            dataResult += '<label for="exampleFormControlSelect1">Package</label>'
                            dataResult += '<select class="form-control" name="version">'
                                dataResult += dataResultOption
                            dataResult += '</select>'
                        dataResult += '</div>'
                        dataResult += '<div class="form-group"><button type="button" class="btn btn-success" onclick="addPackage()">Tambah</button></div>'
                    }else {
                        dataResult += 'version package tidak ditemukan'
                    }

                    $("list_version").html(dataResult);
                },
                error: function(data) {
                    $("#modal_composer .modal-body").html(data);
                }
            });
        }
      
        function addComposerUpdate() {
            html_input = '<p>List Installed Package</p>'

            $.ajax({
                url: '/listPackage',
                type: "GET",
                // contentType: "application/json; charset=utf-8",
                // dataType: "json",
                success: function(data) {
                    html_input += '<table id="example_list_package" class="table table-striped" style="width:100%">'
                        html_input += '<thead>'
                            html_input += '<tr>'
                            html_input += '<th scope="col">#</th>'
                            html_input += '<th scope="col">Name</th>'
                            html_input += '<th scope="col">Version</th>'
                            html_input += '</tr>'
                        html_input += '</thead>'
                        html_input += '<tbody>'

                        $.each(data.list_package.installed,function(i,k){
                            html_input += '<tr>'
                                html_input += '<th scope="row">'+(i+1)+'</th>'
                                html_input += '<td>'+k.name+'</td>'
                                html_input += '<td>'+k.version+'</td>'
                            html_input += '</tr>'
                        })
                            
                        html_input += '</tbody>'
                    html_input += '</table>'

                    html_input += '<hr>'
                    
                    html_input += '<div class="form-group">'
                        html_input += '<label>Add Package</label>'
                        html_input +=  '<div class="input-group mb-3">'
                            html_input +=  '<input type="text" class="form-control" placeholder="package" id="composer_package" name="package">'
                            html_input +=  '<div class="input-group-append">'
                                html_input +=  '<button class="btn btn-info" type="button" onclick="getVersionPackage()">Search</button>'
                            html_input +=  '</div>'
                        html_input +=  '</div>'
                    html_input += '</div>'   
                    
                    html_input += '<list_version></list_version>'

                    $("#modal_composer .modal-body").html(html_input);

                    listcomposer_table = $( "#example_list_package" ).DataTable({
                        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                    });

                    $('#modal_composer').modal({backdrop: 'static', keyboard: false})
                },
                error: function(data) {
                    $("#modal_composer .modal-body").html(data);
                    $("#modal_composer").modal('show');
                }
            });            
        }

        function composerUpdate() {
            dataResult = '';
            $.ajax({
                url: '/composerUpdate',
                type: "GET",
                // contentType: "application/json; charset=utf-8",
                // dataType: "json",
                success: function(data) {
                    dataResult += data;

                    dataResult += '<div id = "background">'
                        dataResult += '<div id = "console">'
                            dataResult += '<p id = "consoletext">'
                                dataResult += dataResult
                            dataResult += '</p>'
                        dataResult += '</div>'
                    dataResult += '</div>'

                    $("#modal_composer .modal-body").html(dataResult);
                    $('#modal_composer').modal({backdrop: 'static', keyboard: false})  

                    getComposerUpdateResult()                   
                },
                error: function(data) {
                    $("#modal_composer .modal-body").html(data);
                    $("#modal_composer").modal('show');
                }
            });
        }

        function getComposerUpdateResult() {
            setTimeout(function(){ 
                $.ajax({
                    url: '/composerUpdateResult',
                    type: "GET",
                    // contentType: "application/json; charset=utf-8",
                    // dataType: "json",
                    success: function(data) {
                        
                        dataResult = '';
                        dataResult += '<div id = "background">'
                            dataResult += '<div id = "console">'
                                dataResult += '<p id = "consoletext">'
                                    dataResult += data.result
                                dataResult += '</p>'
                            dataResult += '</div>'
                        dataResult += '</div>'

                        if( data.status != 'done' ) {                            
                            $("#modal_composer .modal-body").html('Masih di proses <br>'+dataResult);
                            getComposerUpdateResult()
                        }else {
                            $("#modal_composer .modal-body").html('selesai <br>'+dataResult);
                        }
                    },
                    error: function(data) {
                        $("#modal_composer .modal-body").html(data);
                    }
                });
            }, 2000); 
        }
        
        function syncRepo() {
            dataResult = '';
            $.ajax({
                url: '/sync',
                type: "GET",
                // contentType: "application/json; charset=utf-8",
                // dataType: "json",
                success: function(data) {
                    dataResult += 'Branch '+data.branch+'<br><br>';

                    if( data.check_changes ) {
                        dataResult += '<div id = "background">'
                            dataResult += '<div id = "console">'
                                dataResult += '<p id = "consoletext">'
                                    dataResult += data.check_changes
                                dataResult += '</p>'
                            dataResult += '</div>'
                        dataResult += '</div>'
                    }

                    dataResult += data.pull;
                    
                    if( data.pull_hash ) {
                        dataResult += '<div id = "background">'
                            dataResult += '<div id = "console">'
                                dataResult += '<p id = "consoletext">'
                                    dataResult += data.pull_hash
                                dataResult += '</p>'                                
                            dataResult += '</div>'
                        dataResult += '</div>'
                    }

                    dataResult += '<br>'
                    dataResult += 'GIT status'
                    dataResult += '<div id = "background" class="mb-3">'
                        dataResult += '<div id = "console">'
                            dataResult += '<p id = "consoletext">'
                                dataResult += data.git_status
                            dataResult += '</p>'
                        dataResult += '</div>'
                    dataResult += '</div>'

                    if(data.changes[0]) {
                        jumlah_perubahan = 0;
                        $.each( data.changes, function( key, value ) {                            
                            jumlah_perubahan++
                        });
                        dataResult += '<p> File yang berubah ('+jumlah_perubahan+') : <p>'
                        dataResult += '<form id="file_changes">'

                            dataResult += '<table id="example_list_changes" class="table table-striped" style="width:100%">'
                                dataResult += '<thead>'
                                    dataResult += '<tr>'
                                    dataResult += '<th scope="col">#</th>'
                                    dataResult += '<th scope="col">File</th>'
                                    dataResult += '<th scope="col"></th>'
                                    dataResult += '</tr>'
                                dataResult += '</thead>'
                                dataResult += '<tbody>'

                                $.each(data.changes,function(i,k){
                                    dataResult += '<tr>'
                                        dataResult += '<td><input type="checkbox" name="changes[]" value="'+k.file+'" id="file'+i+'"></td>'
                                        dataResult += '<td><label class="form-check-label pointer" for="file'+i+'">'+k.file+'</label></td>'
                                        dataResult += '<td><button type="button" class="btn btn-info float-right btn-sm" onclick="showfilesChanges('+i+')" style="margin-right: 15px;"><i class="fas fa-file fa-sm text-white-50"></i></button></td>'
                                    dataResult += '</tr>'
                                })
                                    
                                dataResult += '</tbody>'
                            dataResult += '</table>'                            

                            dataResult += '<div class="form-group">'
                                dataResult += '<label for="comment">Commit message:</label>'
                                dataResult += '<textarea class="form-control" rows="5" name="message"></textarea>'
                            dataResult += '</div>'
                            dataResult += '<button type="button" class="btn btn-primary" onclick="commitPush()">Commit and Push</button>'
                        dataResult += '</form>'
                    }                    

                    $("#modal_sync .modal-body").html(dataResult);
                    $("#modal_sync").modal('show');
                },
                error: function(data) {
                    $("#modal_sync .modal-body").html(data);
                    $("#modal_sync").modal('show');
                }
            });
        }
        
        function showfilesChanges(id) {

            $.ajax({
                url: '/diffFile/'+id,
                type: "GET",
                success: function(data) {                    
                    dataResult = ''
                    dataResult += '<div class="acediff" style="height:500px"></div>'                    

                    window.oldHtml = $("#modal_sync .modal-body").html();
                    $("#modal_sync .modal-body").html(dataResult);
                    $("[onclick='backSyncRepo()']").removeClass('d-none');

                    differ = new AceDiff({
                        element: '.acediff',
                        left: {
                            content: data.server.out,
                            mode: "ace/mode/php",
                            editable: false
                        },
                        right: {
                            content: data.work_dir.out,
                            mode: "ace/mode/php",
                            editable: false
                        },
                    });                    

                    differ.editors.left.ace.getSession().on('changeScrollTop', function(scroll) {
                        differ.editors.right.ace.getSession().setScrollTop(parseInt(scroll) || 0)
                    });

                    differ.editors.right.ace.getSession().on('changeScrollTop', function(scroll) {
                        // differ.editors.left.ace.getSession().setScrollTop(parseInt(scroll) || 0)
                    });

                    differ.editors.left.ace.resize('true')
                    differ.editors.right.ace.resize('true')
                    differ.editors.left.ace.gotoLine(data.diff, 7, true);
                    differ.editors.right.ace.gotoLine(data.diff, 7, true);
                },
                error: function(data) {
                    $("#modal_sync .modal-body").html(data);
                }
            });
        }

        function backSyncRepo() {
            $("#modal_sync .modal-body").html(window.oldHtml);
            $("[onclick='backSyncRepo()']").addClass('d-none');
        }

        function commitPush() {
            $("#modal_sync").modal('hide');
            
            var form=$("#file_changes");            
            $.ajax({
                type:"POST",
                url:'/push',
                data:form.serialize(),
                success: function(data){
                    $("#modal_sync .modal-body").html(data);
                    $("#modal_sync").modal('show');
                }
            });
        }

        function camelize(str) {
            return str.replace(/(?:^\w|[A-Z]|\b\w|\s+|_\w)/g, function(match, index) {
                if (+match === 0) return ""; // or if (/\s+/.test(match)) for white spaces
                if (match.charAt(0) === '_') return match.charAt(1).toUpperCase();
                return match.toUpperCase();
            });
        }

        function escapeHtml(text) {
            if( typeof text != 'string' ) {
                return text;
            }

            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            
            text = text.replace(/[&<>"']/g, function(m) { return map[m]; });
            return text.replace(/(.{7})..+/, "$1…");
        }
    </script>    

    <!-- Modal -->
    <div class="modal fade" id="modal_composer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">            
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                <!-- <span aria-hidden="true">&times;</span> -->
                <!-- </button> -->
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info mr-auto" onclick="composerUpdate()">
                    <i class="fas fa-refresh fa-sm text-white-50"></i> Composer Update
                </button>
                <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_sync" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">            
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                <!-- <span aria-hidden="true">&times;</span> -->
                <!-- </button> -->
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="button" data-dismiss="modal" onclick="syncRepo()">Re-sync</button>
                <button class="btn btn-info d-none" type="button" onclick="backSyncRepo()">Kembali</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{url('/')}}/KhanCodeLogout">Logout</a>
            </div>
        </div>
        </div>
    </div>
    @yield('modal')
    <script>
        $('.modal').on('hidden.bs.modal', function (e) {
            $(".modal-backdrop").remove();
        })
    </script>
</html>
