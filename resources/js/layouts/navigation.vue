<script setup >
import { ref } from 'vue';
import { useRouter } from "vue-router";
import { HomeIcon , Cog8ToothIcon } from '@heroicons/vue/24/solid';
import { PlusCircleIcon, BuildingStorefrontIcon, DocumentTextIcon, ClipboardDocumentListIcon, UserCircleIcon  } from '@heroicons/vue/24/outline';


const router = useRouter();

const dropdown = ref(false);

const logout = () => {
	localStorage.removeItem('token')
	router.push('/')
}

</script>

<template>
    <div class="adminx-container">
      	<nav id="print_nav" class="navbar navbar-expand justify-content-between fixed-top  ">
			<a class="navbar-brand mb-0 h1 d-none d-md-block w-60" >
				<span class="!font-extrabold italic text-gray-700">2307</span>
				<span class="font-extrabold italic text-blue-500">GENERATOR</span>
				<span class="font-extrabold italic text-blue-500"> 
					
				</span>
			</a>
			<div class=" w-60 flex justify-center space-x-5">
				<a href="/dashboard" class="!no-underline flex align-center space-x-1 px-2 py-1">
					<PlusCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></PlusCircleIcon>
					<span class="text-sm font-bold mt-1">New</span>
				</a>
				<a href="/supplier" class="!no-underline flex align-center space-x-1 px-2 py-1">
					<BuildingStorefrontIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></BuildingStorefrontIcon>
					<span class="text-sm font-bold mt-1">Supplier</span>
				</a>
				<a href="/atc" class="!no-underline flex align-center space-x-1 px-2 py-1">
					<ClipboardDocumentListIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></ClipboardDocumentListIcon>
					<span class="text-sm font-bold mt-1">ATC</span>
				</a>
				<a href="/accountant" class="!no-underline flex align-center space-x-1 px-2 py-1">
					<UserCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></UserCircleIcon>
					<span class="text-sm font-bold mt-1">Accountants</span>
				</a>
				<a href="/report" class="!no-underline flex align-center space-x-1 px-2 py-1">
					<DocumentTextIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></DocumentTextIcon>
					<span class="text-sm font-bold mt-1">Reports</span>
				</a>
			</div>
			<ul class="navbar-nav d-flex justify-content-end mr-2  w-64">
				<li class="nav-item dropdown d-flex align-items-center mr-2 ">
					<a class="nav-link nav-link-notifications" @click="dropdown = !dropdown" href="#"  aria-expanded="false">
						<Cog8ToothIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></Cog8ToothIcon>
					</a>
					<Transition
						enter-active-class="transition ease-out duration-200"
						enter-from-class="opacity-0 scale-95"
						enter-to-class="opacity-100 scale-100"
						leave-active-class="transition ease-in duration-75"
						leave-from-class="opacity-100 scale-100"
						leave-to-class="opacity-0 scale-95"
					>
					<div class="dropdown-menu dropdown-menu-right" v-show="dropdown">
						<a class="dropdown-item" href="/change_password/">Change password</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item text-danger" href="#"  >Sign out</a>
					</div>
					</Transition>
				</li>
			</ul>
      	</nav>
		
      	
		<div class="adminx-content p-0 ">
			<div class="adminx-main-content h-full !overflow-x-hidden">
				<slot/>
			</div>
		</div>
    </div>
</template>
