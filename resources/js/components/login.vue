<script setup>
    import { reactive, ref } from "vue"
    import { useRouter } from "vue-router" //use if link is used inside the page
    import { ExclamationCircleIcon, CubeIcon } from '@heroicons/vue/24/solid'
    const router = useRouter() //use if link is used inside the page

    let form = reactive({
        email:'',
        password:'',
    })

    let error = ref('')

    const login = async () =>{
        await axios.post('/api/login_process', form)
            .then(response =>{
                //alert(response.data.message)
               if(response.data.message == 'User login successfully'){
                 localStorage.setItem('token', response.data.data.token)
                 router.push('/dashboard/new/0')
               } else {
                  error.value = response.data.message;
               }
            })
    }

</script>
<template>
    <div class="adminx-container d-flex justify-content-center align-items-center pt-1 background-grad">
        <div class="page-login">
            <div class="alert alert-danger !shadow-lg" v-if="error">
                <div class="flex justify-start space-x-2">
                    <ExclamationCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></ExclamationCircleIcon>
                    <div class="text-base"> {{ error }} </div>
                </div>
            </div>
            <div class="card mb-0 !shadow-lg">
                <div class="card-body">
                    <a class="navbar-brand p-0 w-full text-center mb-3" >
                        <span class=" !text-3xl !font-extrabold italic text-gray-700">2307</span>
                        <span class=" !text-3xl font-extrabold italic text-blue-500">GENERATOR</span>
                    </a>
                    <form @submit.prevent="login">
                        <div class="form-group">
                            <label for="exampleDropdownFormEmail1" class="form-label !text-xs">Email address</label>
                            <input type="email" class="form-control border rounded !text-sm" v-model="form.email" placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label for="exampleDropdownFormPassword1" class="form-label !text-xs">Password</label>
                            <input type="password" class="form-control border rounded !text-sm" v-model="form.password"  placeholder="Password">
                        </div>
                        <input type="submit" value="Login" class="btn btn-primary btn-block btn-sm !text-sm py-2 rounded">
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>