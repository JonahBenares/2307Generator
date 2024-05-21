<script setup>
	import navigation from '@/layouts/navigation.vue';
	import { CheckCircleIcon, ExclamationCircleIcon, ArrowUturnLeftIcon, XCircleIcon } from '@heroicons/vue/24/solid'
	import axios from 'axios';
	import {onMounted, ref} from "vue";
	import { useRouter } from "vue-router";
	const router = useRouter();

	let form=ref({
		accountant_name:'',
		position:'',
		tin:'',
		active:'1'
	})
	let error = ref('')
	let success = ref('')

	const onSave = () => {

		const formData= new FormData()
		formData.append('accountant_name', form.value.accountant_name)
		formData.append('position', form.value.position)
		formData.append('tin', form.value.tin)
		formData.append('active', form.value.active)

		axios.post("/api/add_accountant",formData).then(function () {
			success.value='You have successfully added new data!'
			form.value.accountant_name=''
			form.value.position=''
			form.value.tin=''
			form.value.active='1'
			error.value=''
		
		}, function (err) {
			success.value=''
			error.value = err.response.data.message;
		
		});

	}

</script>

<template>
    <navigation>
        <div class="container-fluid px-4 py-3">
			<div class="row">
				<div class="col-md-6 col-lg-6 offset-lg-3">
					<div class="alert alert-success" role="alert" v-if="success" id="success">
						<div class="flex justify-start space-x-2">
							<CheckCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-11 h-11"/>
							<div class="pt-1">
								<p class="m-0 leading-tight font-bold">Success</p>
								<p class="m-0 leading-none text-base">{{ success }}</p>
							</div>
						</div>
					</div>
					<div class="alert alert-danger" role="alert" v-if="error" id="error">
						<div class="flex justify-start space-x-2">
							<XCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-11 h-11"/>
							<div class="pt-1">
								<p class="m-0 leading-tight font-bold">Warning</p>
								<p class="m-0 leading-none text-base">{{ error }}</p>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="px-4 py-4">
							<div class="flex justify-between pb-2 mt-2 mb-2">
								<h4 class="font-bold m-0" >Accountant <small>Add New</small></h4>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-label">Accountant Name</label>
										<input type="text" class="form-control border" v-model="form.accountant_name">
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
							<div class="pt-4 mb-2 flex justify-end">
								<button  @click="onSave()" class="btn btn-sm btn-primary btn-block ">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>
    </navigation>
</template>
