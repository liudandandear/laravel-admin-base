<div class="sidebar-menu toggle-others fixed">
    <div class="sidebar-menu-inner">
        <header class="logo-env">
            <!-- logo -->
            <div class="logo">
                <a href="/" class="logo-expanded">
                    <h3 style="color: #ffffd5">电竞网址导航</h3>
                </a>
                <a href="/" class="logo-collapsed">
                    <h3 style="color: #ffffd5">导航</h3>
                </a>
            </div>
            <div class="mobile-menu-toggle visible-xs">
                <a href="#" data-toggle="user-info-menu">
                    <em class="linecons-cog"></em>
                </a>
                <a href="#" data-toggle="mobile-menu">
                    <em class="fa-bars"></em>
                </a>
            </div>
        </header>
        <ul id="main-menu" class="main-menu">
            @foreach ($categories as $categorie)
                <li>
                    @if ($categorie->children_count == 0 && $categorie->parent_id == 0)
                        <a href="#{{ $categorie->title }}" class="smooth">
                            <em class="fa fa-fw {{ $categorie->icon }}"></em>
                            <span class="title">{{ $categorie->title }}</span>
                        </a>
                    @elseif ($categorie->children_count != 0 && $categorie->parent_id == 0)
                        <a>
                            <em class="fa fa-fw {{ $categorie->icon }}"></em>
                            <span class="title">{{ $categorie->title }}</span>
                        </a>
                        <ul>
                            @foreach ($categorie->children as $child)
                                <li>
                                    <a href="#{{ $child->title }}" class="smooth">
                                        <span class="title">{{ $child->title }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>