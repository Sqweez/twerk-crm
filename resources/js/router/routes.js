import Dashboard from "@/views/Dashboard/Dashboard";
import Login from "@/views/Login/Login";
import ClientsIndex from "../views/Clients/ClientsIndex";
import UsersIndex from "../views/Users/UsersIndex";
import SubscriptionIndex from '@/views/Subscriptions/SubscriptionIndex';
import SubscriptionCreate from '@/views/Subscriptions/SubscriptionCreate';
import SubscriptionEdit from '@/views/Subscriptions/SubscriptionEdit';
import ClientView from '@/views/Clients/ClientView';

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
        path: '/clients/:id',
        component: ClientView,
    },
    {
        path: '/users',
        component: UsersIndex,
    },
    {
        path: '/subscriptions',
        component: SubscriptionIndex,
    },
    {
        path: '/subscriptions/create',
        component: SubscriptionCreate,
    },
    {
        path: '/subscriptions/:id',
        component: SubscriptionEdit,
    },
    /*{
        path: '/settings',
        component: Settings,
    },*/
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
