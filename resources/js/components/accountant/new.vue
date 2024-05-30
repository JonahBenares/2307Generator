<script setup>
	import navigation from '@/layouts/navigation.vue';
	import { CheckCircleIcon, ExclamationCircleIcon, ArrowUturnLeftIcon, XCircleIcon } from '@heroicons/vue/24/solid'
	import axios from 'axios';
	import {onMounted, ref, watch} from "vue";
	import { useRouter } from "vue-router";
	const router = useRouter();

	let form=ref({
		accountant_name:'',
		position:'',
		tin:'',
		signature:'',
		active:'1'
	})
	let error = ref('')
	let success = ref('')
	let imageFile1=ref("");
    let imageUrl1=ref("");
    let error_image=ref('')

	const upload_image = (event) => {
        let file = event.target.files[0];
        if(event.target.files.length===0){
            imageFile1.value='';
            imageUrl1.value='';
            return;
        }else if(file['size'] < 1000000){
            imageFile1.value = event.target.files[0];
            error_image.value=''
        }else{
            error_image.value='File size can not be bigger than 1 MB'
            imageUrl1.value='';
        }
    }
    watch(imageFile1, (imageFile1) => {
        if(!(imageFile1 instanceof File)){
            return;
        }
        let fileReader1 = new FileReader();
        fileReader1.readAsDataURL(imageFile1)
        fileReader1.addEventListener("load", () => {
            imageUrl1.value=fileReader1.result
        })

     
    })


	const onSave = () => {

		const formData= new FormData()
		formData.append('accountant_name', form.value.accountant_name)
		formData.append('position', form.value.position)
		formData.append('tin', form.value.tin)
		formData.append('active', form.value.active)
		formData.append('signature', imageFile1.value)

		axios.post("/api/add_accountant",formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function (response) {
			success.value='You have successfully added new data!'
			form.value.accountant_name=''
			form.value.position=''
			form.value.tin=''
			form.value.active='1'
			form.value.signature=''
			imageUrl1.value=''
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
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Upload Signature</label>
											<p class="text-danger" v-if='error_image'>{{ error_image }}</p>
											<input type="file" class="form-control" accept="image/*" id="image1" @change="upload_image">
											
											<div class="mt-2" v-if="imageUrl1 == ''">
												<img :src="'/images/'+form.signature"  v-if="form.signature != ''" class="rounded shadow-md border-white border w-full"/>
												<img :src="'/images/default.png'"  v-else class="rounded shadow-md border-white border w-30"/>
											</div> 
											<div class="mt-2" v-else>
											<img :src="imageUrl1"  class="rounded shadow-md border-white border w-full"/> 
										</div>
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
