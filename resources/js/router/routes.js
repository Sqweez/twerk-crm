import Dashboard from "@/views/Dashboard/Dashboard";
import Login from "@/views/Login/Login";
import ClientsIndex from "../views/Clients/ClientsIndex";
import UsersIndex from "../views/Users/UsersIndex";

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
