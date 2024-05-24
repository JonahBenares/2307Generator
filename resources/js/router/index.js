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
        path:'/dashboard/:id',
        props:true,
        name: 'dashboard',
        component: dashboard,
        meta:{
            requiresAuth:true
        }

    },
   
    {
        path:'/supplier',
        component: supplierIndex,
        meta:{
            requiresAuth:true
        }

    },
    {
        path:'/supplier/new',
        component: supplierNew,
        meta:{
            requiresAuth:true
        }

    },
    {
        path:'/supplier/edit/:id',
        component: supplierEdit,
        props:true,
        meta:{
            requiresAuth:true
        }

    },
    {
        path:'/atc',
        component: atcIndex,
        meta:{
            requiresAuth:true
        }

    },
    {
        path:'/atc/new',
        component: atcNew,
        meta:{
            requiresAuth:true
        }

    },
    {
        path:'/atc/edit/:id',
        component: atcEdit,
        props:true,
        meta:{
            requiresAuth:true
        }

    },

    {
        path:'/accountant',
        component: accountantIndex,
        meta:{
            requiresAuth:true
        }

    },
    {
        path:'/accountant/new',
        component: accountantNew,
        meta:{
            requiresAuth:true
        }
    },
    {
        path:'/accountant/edit/:id',
        component: accountantEdit,
        props:true,
        meta:{
            requiresAuth:true
        }

    },

    {
        path:'/report',
        component: reportIndex,

    },

    {
        path:'/print/:id',
        component: reportPrint,
        props:true,
        meta:{
            requiresAuth:true
        }

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
