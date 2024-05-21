<script setup>
import navigation from '@/layouts/navigation.vue';
import { PencilSquareIcon, Bars3Icon, PlusIcon, MagnifyingGlassIcon, ArrowUpTrayIcon, ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/solid'
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRouter } from "vue-router";

    const router = useRouter() 
	let payees = ref([])
	let searchPayee=ref([]);

	onMounted(async () => {
		getPayee()
	})

	const getPayee = async (page = 1) => {
		const response = await axios.get(`/api/get_all_payee?page=${page}&filter=${searchPayee.value}`);
		payees.value = response.data
    }

	const search = async () => {
        let response = await fetch('/api/search_payee?filter='+searchPayee.value);
        payees.value = await response.json();
	}

	
	const onEdit = (id) =>{
		router.push('/supplier/edit/'+id)
	}


</script>

<template>
    <navigation>
		<div class="container-fluid px-4 py-3">
			<div class="row">
				<div class="col-md-12 col-lg-12 ">
					<div class="card">
						<!-- <h5 class="font-bold " >Supplier</h5> -->
						<div class="px-4 py-4">
							<div class="flex justify-between pb-2 mt-2 mb-2">
								<h4 class="font-bold m-0" >Payees</h4>
								<div class="flex justify-between space-x-1">
									<div class="input-group border rounded w-80">
										<div class="input-group-prepend">
											<div class="input-group-icon pt-1 pl-2 pr-2">
												<MagnifyingGlassIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></MagnifyingGlassIcon>
											</div>
										</div>
										<input type="text" class="form-control border-0 rounded-none" id="search" placeholder="Type to search..." @keyup="search()" v-model="searchPayee" >
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
									<a href="/supplier/new" class="btn btn-sm btn-primary ">
										<div class="flex justify-center space-x-2" >
											<PlusIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></PlusIcon>
											<span>Add New</span>
										</div>
									</a>
								</div>
							</div>
							<table class="table table-actions table-hover rounded ">
								<thead>
									<tr>
										<th class="p-2 px-3 text-base" width="40%">Payee's Name</th>
										<th class="p-2 px-3 text-base" width="30%">Registered Address</th>
										<th class="p-2 px-3 text-base" width="20%">TIN</th>
										<th class="p-2 px-3 text-base" width="10%">ZIP Code</th>
										<th class="p-2 px-3 text-base" width="1" align="center">
											<Bars3Icon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></Bars3Icon>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="p in payees.data">
										<td class="p-1 px-3">{{ p.payee_name }}</td>
										<td class="p-1 px-3">{{ p.registered_address }}</td>
										<td class="p-1 px-3">{{ p.tin }}</td>
										<td class="p-1 px-3">{{ p.zip_code }}</td>
										<td class="p-1 px-3">
											<a @click="onEdit(p.id)"  class="btn btn-xs btn-info btn-rounded  text-white">
												<PencilSquareIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3"></PencilSquareIcon>
											</a>
										</td>
									</tr>
									
								</tbody>
							</table>
							<div class="flex justify-end p-2 border-t">
								<nav aria-label="Page navigation example">
									<TailwindPagination
										:data="payees"
										:limit="1"
										@pagination-change-page="getPayee"
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
