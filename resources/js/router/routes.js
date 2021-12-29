import Dashboard from "@/views/Dashboard/Dashboard";
import Login from "@/views/Login/Login";
import ClientsIndex from "../views/Clients/ClientsIndex";
import UsersIndex from "../views/Users/UsersIndex";
import Settings from "../views/Settings/Settings";

const routes = [
    {
        path: '/',
        component: Dashboard,
    },
    {
        path: '/clients',
        component: ClientsIndex,
    },
    {
        path: '/admins',
        component: UsersIndex,
    },
    {
        path: '/settings',
        component: Settings,
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            CAN_ENTER: {
                IS_GUEST: true
            },
        }
    },
];

export default routes;
