<script setup>
	import navigation from '@/layouts/navigation.vue';
	import { PencilSquareIcon, Bars3Icon, TrashIcon, MagnifyingGlassIcon, PrinterIcon, ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/solid'
	import axios from "axios";
	import {onMounted, ref} from "vue";
	import { useRouter } from "vue-router";
	const router = useRouter()
	let rows = ref([])
	let payees = ref([])
	let form = ref({
		date_from:'',
		date_to:'',
		date_encoded:'',
		payee:'',
	})
	let error = ref('')

	onMounted(async () => {
		getPayees()
	})

	const getPayees = async () => {
		const response = await axios.get(`/api/get_payees`);
		payees.value = response.data
	}

	const onSearch = () => {
    
		const formData= new FormData()
		formData.append('date_form', form.value.date_form)
		formData.append('date_to', form.value.date_to)
		formData.append('date_encoded', form.value.date_encoded)
		formData.append('payee', form.value.payee)

			axios.post("/api/search_generation/",formData).then(function (response) {
				rows.value = response.data
			}, function (err) {
				error.value = err.response.data.message;
				
			});
	}

	const onEdit = (head_id, detail_id) => {

		axios.get("/api/edit_generation/"+head_id+"/"+detail_id).then(function (response) {
				router.push('/dashboard/'+head_id+'/'+detail_id)
			}, function (err) {
				error.value = err.response.data.message;
				
			});
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
								<h4 class="font-bold m-0 capitalize" >Report</h4>
								<div class="flex justify-between space-x-1">
									<button class="btn btn-sm btn-success">
										<div class="flex justify-center space-x-2">
											<ArrowTopRightOnSquareIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-5"></ArrowTopRightOnSquareIcon>
											<span>Export</span>
										</div>
									</button>
								</div>
							</div>
							<div class="flex justify-between space-x-2 mb-2 rounded border p-3 ">
								<div class="w-2/12">
									<label class="mb-0 text-sm">Period From</label>
									<input type="date" class="form-control border rounded-none" v-model="form.date_from">
								</div>
								<div class="w-2/12">
									<label class="mb-0 text-sm">Period To</label>
									<input type="date" class="form-control border rounded-none" v-model="form.date_to">
								</div>
								<div class="w-2/12">
									<label class="mb-0 text-sm">Date Encoded</label>
									<input type="date" class="form-control border rounded-none" v-model="form.date_encoded">
								</div>
								<div class="w-5/12">
									<label class="mb-0 text-sm">Payee</label>
									<select class="form-control border"  v-model="form.payee" >
											<option value="">Select Payee</option>
											<option v-for="p in payees" :value="p.id">{{ p.payee_name }}</option>
										</select>
								</div>
								<div class="w-1/12">
									<br>
									<a @click="onSearch()" class="btn btn-sm btn-primary w-full text-white">
										<div class="flex justify-center space-x-1" >
											<MagnifyingGlassIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></MagnifyingGlassIcon>
											<span>Search</span>
										</div>
									</a>
								</div>
							</div>
							<table class="table table-bor table-hover rounded ">
								<thead>
									<tr>
										<th class="p-2 px-3 text-base" width="35%">Payee's Name</th>
										<th class="p-2 px-3 text-base" width="10%">Date Encoded</th>
										<th class="p-2 px-3 text-base" width="15%">Period</th>
										<th class="p-2 px-3 text-base text-center" width="1%" align="center">
											<center>
												<Bars3Icon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></Bars3Icon>
											</center>
										</th>
									</tr>
								</thead>
								<tbody v-if="rows.length>0">
									<tr v-for="r in rows">
										<td class="p-1 px-3">{{ r.payee_name }}</td>
										<td class="p-1 px-3">{{ r.date_encoded }}</td>
										<td class="p-1 px-3">{{ r.date_period }}</td>
										<td class="p-1 px-3">
											<div class="flex justify-center space-x-1">
												<a @click="onEdit(r.generation_head_id, r.id)" class="btn btn-xs btn-info btn-rounded text-white" target='_blank' >
													<PencilSquareIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3"></PencilSquareIcon>
												</a>
												<a :href="'/print/'+r.id" class="btn btn-xs btn-success btn-rounded text-white" target='_blank' >
													<PrinterIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3"></PrinterIcon>
												</a>
												<a href="" class="btn btn-xs btn-danger btn-rounded text-white"  >
													<TrashIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3"></TrashIcon>
												</a>
											</div>
										</td>
									</tr>
								</tbody>
								<tbody v-else>
									<tr>
										<td colspan="4" class="text-center">No available data.</td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
    </navigation>
</template>
