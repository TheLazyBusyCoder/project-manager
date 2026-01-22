<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Project Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Navbar */
        nav {
            background: #222;
            padding: 0 15px;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav > ul > li {
            display: inline-block;
            position: relative;
        }

        nav a {
            display: block;
            padding: 12px 15px;
            color: #fff;
            text-decoration: none;
            white-space: nowrap;
        }

        nav a:hover {
            background: #444;
        }

        /* Dropdowns */
        nav ul ul {
            display: none;
            position: absolute;
            background: #333;
            min-width: 180px;
            top: 100%;
            left: 0;
        }

        nav ul ul li {
            position: relative;
        }

        nav ul li:hover > ul {
            display: block;
        }

        /* Nested dropdowns (right side) */
        nav ul ul ul {
            top: 0;
            left: 100%;
        }

    </style>
</head>
<body>

<nav>
    <ul>

        <!-- Dashboard -->
        <li>
            <a href="/admin/dashboard">Dashboard</a>
        </li>

        <!-- User Management -->
        <li>
            <a href="#">User Management</a>
            <ul>

                <!-- Project Managers -->
                <li>
                    <a href="#">Project Managers</a>
                    <ul>
                        <li>
                            <a href="#">Create</a>
                            <ul>
                                <li><a href="/admin/project-managers/create">New PM</a></li>
                            </ul>
                        </li>
                        <li><a href="/admin/project-managers">List</a></li>
                    </ul>
                </li>

                <!-- Developers -->
                <li>
                    <a href="#">Developers</a>
                    <ul>
                        <li><a href="/admin/developers">View All</a></li>
                    </ul>
                </li>

                <!-- Testers -->
                <li>
                    <a href="#">Testers</a>
                    <ul>
                        <li><a href="/admin/testers">View All</a></li>
                    </ul>
                </li>

            </ul>
        </li>

        <!-- System Control -->
        <li>
            <a href="#">System</a>
            <ul>
                <li>
                    <a href="#">Audit</a>
                    <ul>
                        <li><a href="/admin/activity-logs">Activity Logs</a></li>
                        <li><a href="/admin/login-logs">Login Logs</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <!-- Reports -->
        <li>
            <a href="#">Reports</a>
            <ul>

                <li>
                    <a href="#">Project Reports</a>
                    <ul>
                        <li><a href="/admin/reports/project-progress">Progress</a></li>
                        <li><a href="/admin/reports/project-health">Health</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#">User Reports</a>
                    <ul>
                        <li><a href="/admin/reports/pm-performance">PM Performance</a></li>
                        <li><a href="/admin/reports/dev-performance">Developer Performance</a></li>
                    </ul>
                </li>

            </ul>
        </li>

        <!-- Settings -->
        <li>
            <a href="#">Settings</a>
            <ul>
                <li><a href="/admin/settings/general">General</a></li>
                <li><a href="/admin/settings/notifications">Notifications</a></li>
            </ul>
        </li>

        <!-- Logout -->
        <li>
            <a href="/logout">Logout</a>
        </li>

    </ul>
</nav>

</body>
</html>
