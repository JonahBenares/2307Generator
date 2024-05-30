<script setup>
import navigation from '@/layouts/navigation.vue';
import { PencilSquareIcon, Bars3Icon, PlusIcon, MagnifyingGlassIcon, ArrowUpTrayIcon, ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/solid'
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRouter } from "vue-router";

	const router = useRouter() 
	let accountants = ref([])
	let searchAccountant=ref([]);

	onMounted(async () => {
		getAccountant()
	})

	const getAccountant = async (page = 1) => {
		const response = await axios.get(`/api/get_all_accountant?page=${page}&filter=${searchAccountant.value}`);
		accountants.value = response.data
    }

	const search = async () => {
        let response = await fetch('/api/search_accountant?filter='+searchAccountant.value);
        accountants.value = await response.json();
	}

	
	const onEdit = (id) =>{
		router.push('/accountant/edit/'+id)
	}


</script>

<template>
    <navigation>
		<div class="container-fluid px-4 py-3">
			<div class="row">
				<div class="col-md-12 col-lg-12 ">
					<div class="card !shadow-lg">
						<!-- <h5 class="font-bold " >Supplier</h5> -->
						<div class="px-4 py-4">
							<div class="flex justify-between pb-2 mt-2 mb-2">
								<h4 class="font-bold m-0 capitalize" >Accountant</h4>
								<div class="flex justify-between space-x-1">
									<div class="input-group border rounded w-80">
										<div class="input-group-prepend">
											<div class="input-group-icon pt-1 pl-2 pr-2">
												<MagnifyingGlassIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></MagnifyingGlassIcon>
											</div>
										</div>
										<input type="text" class="form-control border-0 rounded-none" id="search" placeholder="Type to search..." @keyup="search()" v-model="searchAccountant">
									</div>
									<span class="border-l ml-2  mr-1"></span>
									<button class="btn btn-sm btn-success">
										<div class="flex justify-center space-x-2">
											<ArrowTopRightOnSquareIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-5"></ArrowTopRightOnSquareIcon>
											<span>Export</span>
										</div>
									</button>
									<button class="btn btn-sm btn-success">
										<div class="flex justify-center space-x-2">
											<ArrowUpTrayIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-5"></ArrowUpTrayIcon>
											<span>Upload</span>
										</div>
									</button>
									<a href="/accountant/new" class="btn btn-sm btn-primary ">
										<div class="flex justify-center space-x-2" >
											<PlusIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></PlusIcon>
											<span>Add New</span>
										</div>
									</a>
								</div>
							</div>
							<table class="table table-bor table-hover rounded ">
								<thead>
									<tr>
										<th class="p-2 px-3 text-base" width="40%">Accountant Name</th>
										<th class="p-2 px-3 text-base" width="25%">Position</th>
										<th class="p-2 px-3 text-base" width="15%">TIN</th>
										<th class="p-2 px-3 text-base" width="5%" align="center">Status</th>
										<th class="p-2 px-3 text-base" width="1%" align="center">
											<Bars3Icon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></Bars3Icon>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="a in accountants.data">
										<td class="p-1 px-3">{{ a.accountant_name }}</td>
										<td class="p-1 px-3">{{ a.position }}</td>
										<td class="p-1 px-3">{{ a.tin }}</td>
										<td class="p-1 px-3" align="center" v-if="a.active == 1"><button class="btn btn-xs !text-xs btn-success !py-0">Active</button></td>
										<td class="p-1 px-3" align="center" v-else><button class="btn btn-xs btn-danger !text-xs !py-0 ">Inactive</button></td>
										<td class="p-1 px-3">
											<a @click="onEdit(a.id)"  class="btn btn-xs btn-info btn-rounded  text-white">
												<PencilSquareIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3"></PencilSquareIcon>
											</a>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="flex justify-end p-2 border-t">
								<nav aria-label="Page navigation example">
									<TailwindPagination
										:data="accountants"
										:limit="1"
										@pagination-change-page="getAccountant"
									/>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </navigation>
</template>
