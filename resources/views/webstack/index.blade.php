<link rel="stylesheet" href="{{ admin_asset("webstack/app.css") }}">
<script src="{{ admin_asset("webstack/app.js") }}"></script>

    <!-- skin-white -->
    <div class="page-container">

        <div class="main-content">
            <nav class="navbar user-info-navbar" role="navigation">
                <ul class="user-info-menu left-links list-inline list-unstyled">
                    <li class="dropdown hover-line language-switcher" style="min-height: 75px;">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            平台导航
                        </a>
                    </li>
                </ul>
            </nav>
            @if($newRecoveryCode)
            <p class="bg-warning">警告：您已通过一次性恢复代码进入，请您妥善保管好新的恢复代码：{{$newRecoveryCode}}</p>
            @endif

            @include('common::webstack.layouts.content')

        </div>
    </div>
