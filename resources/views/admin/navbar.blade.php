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