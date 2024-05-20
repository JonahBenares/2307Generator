<script setup>
    import { reactive, ref } from "vue"
    import { useRouter } from "vue-router" //use if link is used inside the page
    import { ExclamationCircleIcon } from '@heroicons/vue/24/solid'
    const router = useRouter() //use if link is used inside the page

    let form = reactive({
        email:'',
        password:'',
    })

    let error = ref('')

 

</script>
<template>
    <div class="adminx-container d-flex justify-content-center align-items-center pt-1 background-grad">
        <div class="page-login">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="alert alert-danger" v-if="error">
                        <div class="flex justify-start space-x-2">
                            <div>
                                <ExclamationCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></ExclamationCircleIcon>
                            </div> 
                        </div>
                    </div>
                    <form>
                        <div class="form-group">
                            <label for="exampleDropdownFormEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control border" id="exampleDropdownFormEmail1" placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label for="exampleDropdownFormPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control border" id="exampleDropdownFormPassword1" placeholder="Password">
                        </div>
                        <a href="/dashboard" class="btn btn-primary btn-block btn-sm btn-rounded">Login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>