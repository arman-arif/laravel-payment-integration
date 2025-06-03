<aside
    :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
    <x-sidebar.header />

    <div
        class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
    >
        <!-- Sidebar Menu -->
        <nav x-data="{selected: $persist('Dashboard')}">
            <x-sidebar.menu-group title="MENU">
                <x-sidebar.menu-item
                    name="Dashboard"
                    :has-dropdown="true"
                    :active-pages="['dashboard']"
                    :prevent-click="true"
                    icon="dashboard"
                >
                    <x-sidebar.menu-dropdown-item href="#" active-page="ecommerce">
                        eCommerce
                    </x-sidebar.menu-dropdown-item>
                </x-sidebar.menu-item>

                <x-sidebar.menu-item
                    name="Calendar"
                    href="#"
                    :active-pages="['calendar']"
                    icon="calendar"
                />

                <x-sidebar.menu-item
                    name="User Profile"
                    href="#"
                    :active-pages="['profile']"
                    icon="profile"
                />

                <x-sidebar.menu-item
                    name="Forms"
                    :has-dropdown="true"
                    :active-pages="['formElements', 'formLayout', 'proFormElements', 'proFormLayout']"
                    :prevent-click="true"
                    icon="forms"
                >
                    <x-sidebar.menu-dropdown-item href="#" active-page="formElements">
                        Form Elements
                    </x-sidebar.menu-dropdown-item>
                </x-sidebar.menu-item>

                <x-sidebar.menu-item
                    name="Tables"
                    :has-dropdown="true"
                    :active-pages="['basicTables', 'dataTables']"
                    :prevent-click="true"
                    icon="tables"
                >
                    <x-sidebar.menu-dropdown-item href="#" active-page="basicTables">
                        Basic Tables
                    </x-sidebar.menu-dropdown-item>
                </x-sidebar.menu-item>

                <x-sidebar.menu-item
                    name="Pages"
                    :has-dropdown="true"
                    :active-pages="['fileManager', 'pricingTables', 'blank', 'page404', 'page500', 'page503', 'success', 'faq', 'comingSoon', 'maintenance']"
                    :prevent-click="true"
                    icon="pages"
                >
                    <x-sidebar.menu-dropdown-item href="#" active-page="blank">
                        Blank Page
                    </x-sidebar.menu-dropdown-item>
                    <x-sidebar.menu-dropdown-item href="#" active-page="page404">
                        404 Error
                    </x-sidebar.menu-dropdown-item>
                </x-sidebar.menu-item>
            </x-sidebar.menu-group>

            <x-sidebar.menu-group title="OTHERS">
                <x-sidebar.menu-item
                    name="Charts"
                    :has-dropdown="true"
                    :active-pages="['lineChart', 'barChart', 'pieChart']"
                    :prevent-click="true"
                    icon="charts"
                >
                    <x-sidebar.menu-dropdown-item href="#" active-page="lineChart">
                        Line Chart
                    </x-sidebar.menu-dropdown-item>
                    <x-sidebar.menu-dropdown-item href="#" active-page="barChart">
                        Bar Chart
                    </x-sidebar.menu-dropdown-item>
                </x-sidebar.menu-item>

                <x-sidebar.menu-item
                    name="UI Elements"
                    :has-dropdown="true"
                    :active-pages="['alerts', 'avatars', 'badge', 'buttons', 'buttonsGroup', 'cards', 'carousel', 'dropdowns', 'images', 'list', 'modals', 'videos']"
                    :prevent-click="true"
                    icon="ui-elements"
                >
                    <x-sidebar.menu-dropdown-item href="#" active-page="alerts">
                        Alerts
                    </x-sidebar.menu-dropdown-item>
                    <x-sidebar.menu-dropdown-item href="#" active-page="avatars">
                        Avatars
                    </x-sidebar.menu-dropdown-item>
                    <x-sidebar.menu-dropdown-item href="#" active-page="badge">
                        Badges
                    </x-sidebar.menu-dropdown-item>
                    <x-sidebar.menu-dropdown-item href="#" active-page="buttons">
                        Buttons
                    </x-sidebar.menu-dropdown-item>
                    <x-sidebar.menu-dropdown-item href="#" active-page="images">
                        Images
                    </x-sidebar.menu-dropdown-item>
                    <x-sidebar.menu-dropdown-item href="#" active-page="videos">
                        Videos
                    </x-sidebar.menu-dropdown-item>
                </x-sidebar.menu-item>

                <x-sidebar.menu-item
                    name="Authentication"
                    :has-dropdown="true"
                    :active-pages="['signin', 'signup']"
                    :prevent-click="true"
                    icon="authentication"
                >
                    <x-sidebar.menu-dropdown-item href="#" active-page="signin">
                        Sign In
                    </x-sidebar.menu-dropdown-item>
                    <x-sidebar.menu-dropdown-item href="#" active-page="signup">
                        Sign Up
                    </x-sidebar.menu-dropdown-item>
                </x-sidebar.menu-item>
            </x-sidebar.menu-group>
        </nav>

        <x-sidebar.promo-box />
    </div>
</aside>
