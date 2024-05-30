<script setup>
	import navigation from '@/layouts/navigation.vue';
	import { CheckCircleIcon, ExclamationCircleIcon, ArrowUturnLeftIcon, XCircleIcon } from '@heroicons/vue/24/solid'
	import { onMounted, ref } from "vue"
	import { useRouter } from "vue-router"
	const router = useRouter()
	let form = ref({
		id:''
	})
	let error = ref('')
	let success = ref('')

	const props = defineProps({
		id:{
			type:String,
			default:''
		}
	})

	onMounted(async () =>{
		getAccountant()
	})

	const getAccountant = async () => {
		let response = await axios.get(`/api/edit_accountant/${props.id}`)
		form.value = response.data.accountants
	}


	const onEdit = (id) => {
		const formData= new FormData()
		formData.append('accountant_name', form.value.accountant_name)
		formData.append('position', form.value.position)
		formData.append('tin', form.value.tin)
		formData.append('active', form.value.active)
		axios.post(`/api/update_accountant/${form.value.id}`,formData).then(function () {
			success.value='You have successfully updated the data!'
			error.value=''
		}, function (err) {
			error.value = err.response.data.message;
			success.value=''
			
		});

	}
</script>

<template>
    <navigation>
        <div class="container-fluid px-4 py-3">
			<div class="row">
				<div class="col-md-6 col-lg-6 offset-lg-3">
					<div class="alert alert-success !shadow-lg" role="alert"  v-if="success" id="success">
						<div class="flex justify-start space-x-2">
							<CheckCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-11 h-11"/>
							<div class="pt-1">
								<p class="m-0 leading-tight font-bold">Success</p>
								<p class="m-0 leading-none text-base">{{ success }}</p>
							</div>
						</div>
					</div>
					<div class="alert alert-danger !shadow-lg" role="alert" v-if="error" id="error">
						<div class="flex justify-start space-x-2">
							<XCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-11 h-11"/>
							<div class="pt-1">
								<p class="m-0 leading-tight font-bold">Warning</p>
								<p class="m-0 leading-none text-base">{{ error }}</p>
							</div>
						</div>
					</div>
					<div class="card !shadow-lg">
						<div class="px-4 py-4">
							<div class="flex justify-between pb-2 mt-2 mb-2">
								<h4 class="font-bold m-0" >Accountant <small>Update</small></h4>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-label">Accountant Name</label>
										<input type="text" class="form-control border"  v-model="form.accountant_name">
									</div>									
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-label">Position</label>
										<input type="text" class="form-control border" v-model="form.position">
									</div>									
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">TIN</label>
										<input type="text" class="form-control border" v-model="form.tin">
									</div>									
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Status</label>
										
										<select type="text" class="form-control border" v-model="form.active">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
									</div>									
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Upload Photo</label>
											<input type="file" class="form-control" accept="image/*" id="image1" @change="upload_image" disabled >
											
											<div class="mt-2" v-if="form.signature == null">
												<img :src="'/images/default.png'" class="rounded shadow-md border-white border w-30"/>
											</div> 
											<div class="mt-2" v-else>
											<img :src="'/images/'+form.signature"  class="rounded shadow-md border-white border w-full"/> 
											</div>
									</div>									
								</div>
							</div>
							<div class="pt-4 mb-2 flex justify-end">
								<button @click="onEdit(form.id)"  class="btn btn-primary btn-sm btn-block ">Update</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </navigation>
</template>
