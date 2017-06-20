<?php 
	global $config;
    require 'data/user.php';
    require 'head.php';
?>
<body class="nav-md">

    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="/" class="site_title">
                            <i class="fa fa-dollar"></i> <span>Trends Config</span>
                        </a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li><a>
                                        <i class="fa fa-picture-o"></i> Лендинги 
                                        <span class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul class="nav child_menu">
                                        <li>
                                            <a href="/">Лендиги</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a>
                                        <i class="fa fa-picture-o"></i> Допродажи 
                                        <span class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul class="nav child_menu">
                                        <li>
                                            <a href="/upsells">Допродажи</a>
                                        </li>
                                        <li>
                                            <a href="/images">Изображения</a>
                                        </li>
                                        <li>
                                            <a href="/image-upload">Загрузить изображения</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
  <!--                   <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div> -->
                    <!-- /menu footer buttons -->

                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">

                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <?= $login ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                    <form action="/logout" method="post">
                                        <button style="
                                           background-color: inherit; 
                                           border: none; 
                                           display: block; 
                                           width: 100%;
                                           padding: 12px 20px;
                                           color: #5A738E;
                                           clear: both;
                                           font-weight: 400;
                                           line-height: 1.42857143;
                                           white-space: nowrap;
                                           text-align: left;">
                                                <i class="fa fa-sign-out pull-right"></i>
                                                Выход
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->