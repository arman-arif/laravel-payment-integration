<aside
    :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
    <x-sidebar.header brandUrl="/dashboard"/>

    <div
        class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
    >
        <!-- Sidebar Menu -->
        <nav x-data="{selected: ''}">
            <x-sidebar.menu-group title="MENU">
                <x-sidebar.menu-item
                    name="Dashboard"
                    :active-pages="['dashboard']"
                    icon="dashboard"
                    :page="$page"
                    href="{{ route('dashboard') }}"
                />

                <x-sidebar.menu-item
                    name="Payments"
                    href="{{ route('payments') }}"
                    :active-pages="['payments']"
                    icon="payments"
                    :page="$page"
                />

                <x-sidebar.menu-item
                    name="Transactions"
                    :active-pages="['transactions']"
                    icon="forms"
                    :page="$page"
                />
            </x-sidebar.menu-group>
        </nav>
    </div>
</aside>
