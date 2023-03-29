<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">

        <div class="user-profile">
            <div class="ulogo">
                <a href="/admin">
                    <!-- logo for regular state and mobile devices -->
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="/images/logo-dark.png" alt="">
                        <h3><b>Ozim</b> Admin</h3>
                    </div>
                </a>
            </div>
        </div>

        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="@if(request()->is('*category*') && !request()->is('*forum_category*') && !request()->is('*forum_subcategory*')) active @endif">
                <a href="{{ route('admin.category.index') }}">
                    <i data-feather="pie-chart"></i>
                    <span>Категории</span>
                </a>
            </li>

            <li class="@if(request()->is('*language*')) active @endif">
                <a href="{{ route('admin.language.index') }}">
                    <i data-feather="pie-chart"></i>
                    <span>Языки</span>
                </a>
            </li>

            <li class="treeview @if((request()->is('forum_category*') || request()->is('*forum*')) && !request()->is('category*')) active menu-open @endif">
                <a href="#">
                    <i data-feather="grid"></i>
                    <span>Форум</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(!request()->is('category*') && request()->is('*forum_category*') && !request()->is('*forum'))) active @endif">
                        <a href="{{ route('admin.forum_category.index') }}"><i class="ti-more"></i>Категории</a>
                    </li>
                    <li class="@if(!request()->is('category*') && request()->is('*forum_subcategory*') && !request()->is('*forum'))) active @endif">
                        <a href="{{ route('admin.forum_subcategory.index') }}"><i class="ti-more"></i>Подкатегории</a>
                    </li>
                    <li class="@if(request()->is('*forum*') && !request()->is('*forum_category*') && !request()->is('*forum_subcategory*'))) active @endif">
                        <a href="{{ route('admin.forum.index') }}"><i class="ti-more"></i>Записи</a>
                    </li>
                </ul>
            </li>

            <li class="treeview @if(request()->is('*article*') ||
                request()->is('*diagnosis*') ||
                request()->is('*faq*') ||
                request()->is('*link*') ||
                request()->is('*inclusion*') ||
                request()->is('*rights*') ||
                request()->is('*service_provider*') ||
                request()->is('*skill*') ||
                request()->is('*users*') ||
                request()->is('*for_parent*') ||
                request()->is('*banner*') ||
                request()->is('*questionnaire*') ||
                request()->is('*video*') ||
                request()->is('*partner*')) active menu-open
                @endif"
            >
                <a href="#">
                    <i data-feather="grid"></i>
                    <span>Записи</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(request()->is('*article*')) active @endif">
                        <a href="{{ route('admin.article.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Статьи</span>
                        </a>
                    </li>

                    <li class="@if(request()->is('*diagnosis*')) active @endif">
                        <a href="{{ route('admin.diagnosis.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Диагнозы</span>
                        </a>
                    </li>

                    <li class="@if(request()->is('*faq*')) active @endif">
                        <a href="{{ route('admin.faq.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>FAQ</span>
                        </a>
                    </li>

                    <li class="@if(request()->is('*link*')) active @endif">
                        <a href="{{ route('admin.link.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Ресурсы</span>
                        </a>
                    </li>

                    <li class="@if(request()->is('*inclusion*')) active @endif">
                        <a href="{{ route('admin.inclusion.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Инклюзия</span>
                        </a>
                    </li>

                    <li class="@if(request()->is('*rights*')) active @endif">
                        <a href="{{ route('admin.rights.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Права</span>
                        </a>
                    </li>

                    <li class="@if(request()->is('*service_provider*')) active @endif">
                        <a href="{{ route('admin.service_provider.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Поставщики услуг</span>
                        </a>
                    </li>

                    <li class="@if(request()->is('*skill*')) active @endif">
                        <a href="{{ route('admin.skill.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Навыки</span>
                        </a>
                    </li>

                    <li class="@if(request()->is('*users*')) active @endif">
                        <a href="{{ route('admin.users.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Пользователи</span>
                        </a>
                    </li>

                    <li class="@if(request()->is('*for_parent*')) active @endif">
                        <a href="{{ route('admin.for_parent.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Для мамы</span>
                        </a>
                    </li>

                    <li class="@if(request()->is('*banner*')) active @endif">
                        <a href="{{ route('admin.banner.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Баннер</span>
                        </a>
                    </li>
                    <li class="@if(request()->is('*questionnaire*')) active @endif">
                        <a href="{{ route('admin.questionnaire.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Анкета</span>
                        </a>
                    </li>
                    <li class="@if(request()->is('*video*')) active @endif">
                        <a href="{{ route('admin.video.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Видео</span>
                        </a>
                    </li>
                    <li class="@if(request()->is('*partner*')) active @endif">
                        <a href="{{ route('admin.partner.index') }}">
                            <i class="ti-bookmark-alt"></i>
                            <span>Партнеры(Обмен)</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="header nav-small-cap">Дополнительно</li>

            <li>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <i data-feather="lock"></i>
                    <span>Выход</span>
                </a>
            </li>

        </ul>
    </section>

    {{--<div class="sidebar-footer">--}}

    {{--</div>--}}
</aside>