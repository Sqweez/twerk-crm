import Dashboard from "@/views/Dashboard/Dashboard";
import Login from "@/views/Login/Login";
import ClientsIndex from "../views/Clients/ClientsIndex";
import UsersIndex from "../views/Users/UsersIndex";
import SubscriptionIndex from '@/views/Subscriptions/SubscriptionIndex';
import SubscriptionCreate from '@/views/Subscriptions/SubscriptionCreate';
import SubscriptionEdit from '@/views/Subscriptions/SubscriptionEdit';
import ClientView from '@/views/Clients/ClientView';
import StatsPageIndex from '@/views/Stats/StatsPageIndex';
import UserShow from '@/views/Users/UserShow';

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
        path: '/users/:id',
        component: UserShow,
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
    {
        path: '/economy',
        component: StatsPageIndex
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
