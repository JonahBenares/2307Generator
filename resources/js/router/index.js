import { createRouter, createWebHistory } from "vue-router";


import loginForm from  '../components/login.vue'
import dashboard from '../components/dashboard.vue'


import supplierIndex from '../components/supplier/index.vue'
import supplierNew from '../components/supplier/new.vue'
import supplierEdit from '../components/supplier/edit.vue'


import atcIndex from '../components/atc/index.vue'
import atcNew from '../components/atc/new.vue'
import atcEdit from '../components/atc/edit.vue'

import accountantIndex from '../components/accountant/index.vue'
import accountantNew from '../components/accountant/new.vue'
import accountantEdit from '../components/accountant/edit.vue'

import reportIndex from '../components/report/index.vue'
import reportPrint from '../components/report/Print.vue'


import notFound from '../components/notFound.vue'

const routes = [
    {
        path:'/',
        name:'login',
        component: loginForm,
    },
    {
        path:'/dashboard',
        name: 'dashboard',
        component: dashboard,

    },
   
    {
        path:'/supplier',
        component: supplierIndex,

    },
    {
        path:'/supplier/new',
        component: supplierNew,

    },
    {
        path:'/supplier/edit/',
        component: supplierEdit,
        props:true,

    },
    {
        path:'/atc',
        component: atcIndex,

    },
    {
        path:'/atc/new',
        component: atcNew,

    },
    {
        path:'/atc/edit/',
        component: atcEdit,
        props:true,

    },

    {
        path:'/accountant',
        component: accountantIndex,

    },
    {
        path:'/accountant/new',
        component: accountantNew,

    },
    {
        path:'/accountant/edit/',
        component: accountantEdit,
        props:true,

    },

    {
        path:'/report',
        component: reportIndex,

    },

    {
        path:'/print',
        component: reportPrint,

    },
    
    {
        path:'/:pathMatch(.*)*',
        name:'notFound',
        component: notFound,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to,from) => {
    if(to.meta.requiresAuth && !localStorage.getItem('token') ){
        return { name: 'login'}
    } 
})



// router.beforeEach((to, from, next) => {
//     const requiresAuth = to.matched.some(x => x.meta.requiresAuth);
  
//     if (to.meta.requiresAuth && !localStorage.getItem('token')) {
//         return { name: 'login'}
//     } else if (to.meta.requiresAuth && localStorage.getItem('token')) {
//       next();
//     } else {
//       next();
//     }
//   });

export default router
