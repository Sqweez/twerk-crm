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
import {__hardcoded} from '@/utils/helpers';
import ROLES from '@/common/enums/roles';
import PlanIndex from '@/views/Plan/PlanIndex';
import AlmostExpiredSubscriptions from '@/views/Subscriptions/AlmostExpiredSubscriptions';

const routes = [
    {
        path: '/',
        component: Dashboard,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS, ROLES.ROLE_TRAINER, ROLES.ROLE_ADMIN]
        }
    },
    {
        path: '/plan',
        component: PlanIndex,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS],
        }
    },
    {
        path: '/clients',
        component: ClientsIndex,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS, ROLES.ROLE_ADMIN]
        }
    },
    {
        path: '/clients/:id',
        component: ClientView,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS, ROLES.ROLE_ADMIN]
        }
    },
    {
        path: '/users',
        component: UsersIndex,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS,ROLES.ROLE_ADMIN]
        }
    },
    {
        path: '/users/:id',
        component: UserShow,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS, ROLES.ROLE_ADMIN]
        }
    },
    {
        path: '/subscriptions',
        component: SubscriptionIndex,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS, ROLES.ROLE_ADMIN]
        }
    },
    {
        path: '/subscriptions/create',
        component: SubscriptionCreate,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS, ROLES.ROLE_ADMIN]
        }
    },
    {
        path: '/subscriptions/:id',
        component: SubscriptionEdit,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS, ROLES.ROLE_ADMIN]
        }
    },
    {
        path: '/economy',
        component: StatsPageIndex,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS, ROLES.ROLE_ADMIN]
        }
    },
    {
        path: '/subscriptions/almost/expired',
        component: AlmostExpiredSubscriptions,
        meta: {
            CAN_ENTER: [ROLES.ROLE_BOSS, ROLES.ROLE_ADMIN]
        }
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
