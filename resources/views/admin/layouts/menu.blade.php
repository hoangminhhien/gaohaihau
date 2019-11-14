<ul class="sidebar-menu" data-widget="tree">
    @foreach (config('common.layout.menu') as $menu_item)
        <li
            @if(isset($menu_item['route']))
                {{ PermissionHelper::view($menu_item['route']) }}
            @endif
            class="@if(!empty($menu_item['submenu']) && is_array($menu_item['submenu']))
                treeview
            @endif
            @if(MenuHelper::isMenuActive($menu_item))
                active menu-open
            @endif"
            @if(!empty($menu_item['menu_name']))
                menu_name="{{$menu_item['menu_name']}}"
            @endif
        >
            <a href="{{ MenuHelper::generateUrlFromMenu($menu_item) }}">
                <i class="
                    @if(!empty($menu_item['icon']))
                        {{ $menu_item['icon'] }}
                    @endif
                "></i>
                <span>@if(!empty($menu_item['title'])){{ trans($menu_item['title']) }}@endif</span>
                @if(!empty($menu_item['submenu']) && is_array($menu_item['submenu']))
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                @endif
            </a>
            @if(!empty($menu_item['submenu']) && is_array($menu_item['submenu']))
                <ul class="treeview-menu">
                    @foreach ($menu_item['submenu'] as $submenu_item)
                        <li
                            @if(isset($menu_item['route']))
                                {{ PermissionHelper::view($submenu_item['route']) }}
                            @endif
                            class="
                            @if(MenuHelper::isMenuActive($submenu_item))
                                active
                            @endif"
                            @if(!empty($submenu_item['menu_name']))
                                menu_name="{{$submenu_item['menu_name']}}"
                            @endif
                        >
                            <a href="{{ MenuHelper::generateUrlFromMenu($submenu_item) }}"">
                                <i class="fa fa-circle-o"></i>
                                @if(!empty($submenu_item['title'])){{ trans($submenu_item['title']) }}@endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>