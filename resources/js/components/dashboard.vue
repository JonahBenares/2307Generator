<script setup>
	import navigation from '@/layouts/navigation.vue';
	import { CheckCircleIcon, ExclamationCircleIcon, TrashIcon, PlusIcon, XMarkIcon, XCircleIcon,  MagnifyingGlassIcon, InboxArrowDownIcon, EyeIcon, PrinterIcon} from '@heroicons/vue/24/solid'
import { CanceledError } from 'axios';
	import {onMounted, ref} from "vue";
	import { useRouter } from "vue-router";
	const router = useRouter()
	
	let payees = ref([])
	let atc = ref([])
	let head = ref([])
	let details = ref([])
	let accountant = ref([])
	let rows = ref([])
	let error = ref('')
	let success = ref('')
	let form = ref({
		generation_head_id:props.id,
		detail_id:'',
		date_from:'',
		date_to:'',
		payee_id:'',
		payee_name:'',
		registered_address:'',
		tin:'',
		zip_code:'',
		tax_payer:'',
		atc_id:'',
		atc_code:'',
		remarks:'',
		percentage:'',
		amount:'',
		old_amount:'',
		include_sign:'',
		reference_number:'',
		accountant_id:'',
		accountant_name:'',
		accountant_position:'',
		accountant_tin:'',
		accountant_sign:'',

	})
	onMounted(async () => {
		getDropdown()
		getDrafts()
		getAccountant()
		getAmount()
	})

	
	const props = defineProps({
		id:{
			type:String,
			default:''
		},
		detail_id:{
			type:String,
			default:''
		}
	})

	const getDropdown = async () => {
		const response = await axios.get(`/api/get_dropdown`);
		payees.value = response.data.payees
		atc.value = response.data.atc
    }

	const getAmount = async () => {
		const response = await axios.get(`/api/get_amount/${props.detail_id}`);
		rows.value = response.data
    }

	
	const getDrafts = async () => {
		
			const response = await axios.get(`/api/get_drafts/${props.id}/${props.detail_id}`);
			head.value = response.data.head
			details.value = response.data.details

			if(props.detail_id != 0){
				form.value = response.data.edit_details
			} else{
				form.value.generation_head_id = response.data.head_id
			}
			
    }

	const getAccountant = async () => {

		const response = await axios.get(`/api/get_accountant_details`).then(function (response) {
			form.value.accountant_id = response.data[0]['id']
			form.value.accountant_name = response.data[0]['accountant_name']
			form.value.accountant_position = response.data[0]['position']
			form.value.accountant_tin = response.data[0]['tin']
			form.value.accountant_sign = response.data[0]['signature']
		});
		
		
	}

	const get_atc_details = (event) => {
		axios.get(`/api/get_atc_details/`+event.target.value).then(function (response) {
			form.value.atc_code = response.data[0]['atc_code']
			form.value.atc_remarks = response.data[0]['remarks']
			form.value.atc_percentage = response.data[0]['percentage']
		});
		
	}

	const get_payee_details = (event) => {
		
		axios.get(`/api/get_payee_details/`+event.target.value).then(function (response) {
			form.value.payee_name = response.data[0]['payee_name']
			form.value.registered_address = response.data[0]['registered_address']
			form.value.tin = response.data[0]['tin']
			form.value.zip_code = response.data[0]['zip_code']
			form.value.tax_type = response.data[0]['tax_type']
		});
		
	}

	const addRow= () =>{
       
       rows.value.push(
           {
			id:"",
			quarter_month:"",
            amount:"",
            old_amount:0,
           }
       );
   }
   const removeRow= (row, id) =>{
   
		if(confirm("Do you really want to delete this row?")){
			rows.value.splice(row,1)
		}
        
        // if(id){
        // 	axios.get(`/api/delete_certification/${id}`);
        // }
	}

	const onSave = () => {
    
		const formData= new FormData()
		//formData.append('id', form.value.id)
		formData.append('generation_head_id', form.value.generation_head_id)
		formData.append('date_from', form.value.date_from)
		formData.append('date_to', form.value.date_to)
		formData.append('payee_id', form.value.payee_id)
		formData.append('payee_name', form.value.payee_name)
		formData.append('registered_address', form.value.registered_address)
		formData.append('tin', form.value.tin)
		formData.append('zip_code', form.value.zip_code)
		formData.append('tax_type', form.value.tax_type)
		formData.append('atc_id', form.value.atc_id)
		formData.append('atc_code', form.value.atc_code)
		formData.append('atc_remarks', form.value.atc_remarks)
		formData.append('atc_percentage', form.value.atc_percentage)
		// formData.append('amount', form.value.amount)
		formData.append('reference_number', form.value.reference_number)
		formData.append('accountant_id', form.value.accountant_id)
		formData.append('accountant_name', form.value.accountant_name)
		formData.append('accountant_position', form.value.accountant_position)
		formData.append('accountant_tin', form.value.accountant_tin)
		formData.append('accountant_sign', form.value.accountant_sign)
		formData.append('amount', JSON.stringify(rows.value))
		let include_sign=document.getElementById('include_sign');
			if(include_sign.checked){
				var sign=1
			}else{
				var sign=0
			}
			formData.append('include_sign',sign)

		axios.post("/api/add_generation",formData).then(function (response) {
		
			success.value='You have successfully added a new 2307!'
			form.value=ref([])
			rows=ref([])
			error.value=''
			form.value.id = response.data
			getDrafts()
			getAccountant()
			// router.push('/dashboard/'+response.data+'/0')
			
		}, function (err) {
			error.value = err.response.data.message;
		});
	}

	const onEdit = () => {
    
		const formData= new FormData()
		formData.append('generation_head_id', form.value.generation_head_id)
		formData.append('detail_id', form.value.detail_id)
		formData.append('date_from', form.value.date_from)
		formData.append('date_to', form.value.date_to)
		formData.append('payee_id', form.value.payee_id)
		formData.append('payee_name', form.value.payee_name)
		formData.append('registered_address', form.value.registered_address)
		formData.append('tin', form.value.tin)
		formData.append('zip_code', form.value.zip_code)
		formData.append('tax_type', form.value.tax_type)
		formData.append('atc_id', form.value.atc_id)
		formData.append('atc_code', form.value.atc_code)
		formData.append('atc_remarks', form.value.atc_remarks)
		formData.append('atc_percentage', form.value.atc_percentage)
		formData.append('reference_number', form.value.reference_number)
		formData.append('accountant_id', form.value.accountant_id)
		formData.append('accountant_name', form.value.accountant_name)
		formData.append('accountant_position', form.value.accountant_position)
		formData.append('accountant_tin', form.value.accountant_tin)
		formData.append('accountant_sign', form.value.accountant_sign)
		formData.append('amount', JSON.stringify(rows.value))
		let include_sign=document.getElementById('include_sign');
			if(include_sign.checked){
				var sign=1
			}else{
				var sign=0
			}
			formData.append('include_sign',sign)

			axios.post("/api/edit_generation/",formData).then(function (response) {
			
				success.value='You have successfully updated the 2307 file!'
				form.value=ref([])
				rows=ref([])
				error.value=''
				form.value.generation_head_id = response.data
				
				// router.push('/dashboard/'+response.data+'/0')
				// getDrafts()
				// getAccountant()
				
			}, function (err) {
				error.value = err.response.data.message;
				
			});

	}


	const saveSet = (generation_head_id) => {

		// axios.get("/api/save_set/"+props.id).then(function (response) {
			axios.get("/api/save_set/"+generation_head_id).then(function (response) {
			// alert("List of 2307 have been successfully saved!");
			// router.push('/print_all/'+props.id)
			router.push('/print_all/'+generation_head_id)
			//window.location.href ='/dashboard/new'
		});
	}

	const cancelGeneration = (id) => {
		if(confirm("Are you sure you want to cancel this 2307 file?")){
			axios.post('/api/cancel_generation/'+id).then(function (response) {
						update.value='You have successfully cancelled the 2307 file!'
						getDrafts();
					});
		}
	}
</script>

<template>
    <navigation>
		<div class="container-fluid px-4 py-3">
			<div class="row">
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
				<div class="col-lg-6">
					<div class="card !shadow-lg">
						<div class="px-4 pt-4">
							<div class="row">
								<div class="col-lg-12">
									<div class="flex justify-between space-x-1">
										<div class="form-group w-full">
											<label for="" class="mb-0 text-sm">Date From</label>
											<input type="date" class="form-control border" v-model="form.date_from">
										</div>
										<div class="form-group w-full">
											<label for="" class="mb-0 text-sm">Date To</label>
											<input type="date" class="form-control border" v-model="form.date_to">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="" class="mb-0 text-sm">Payee's Name</label>
									
										<select class="form-control border"  v-model="form.payee_id"  @change="get_payee_details($event)">
											<option value="">Select Payee</option>
											<option v-for="p in payees" :value="p.id">{{ p.payee_name }}</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="" class="mb-0 text-sm">Payee's TIN</label>
										<input type="text" class="form-control border !bg-gray-50"  v-model="form.tin" disabled>
										
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="" class="mb-0 text-sm">Payee's Registered Address</label>
										<input type="text"  class="form-control border !bg-gray-50" v-model="form.registered_address" disabled>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="" class="mb-0 text-sm">ATC</label>
										<select class="form-control border"  v-model="form.atc_id" @change="get_atc_details($event)">
											<option value="">Select ATC Code</option>
											<option v-for="a in atc" :value="a.id ">{{ a.atc_code + ' (' + a.percentage + ')' }}</option>
										</select>
									</div>
									<div class="form-group">
										<label for="" class="mb-0 text-sm">Remarks</label>
										<textarea  cols="30" rows="5" class="form-control border !bg-gray-50" v-model="form.atc_remarks" disabled></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									
									<div class="form-group mt-2">
										<button @click="addRow()" class="btn btn-sm btn-warning text-white">Add Amount</button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="flex justify-between space-x-1">
										<label for="" class="pl-2 mb-0 text-sm w-[50%] ">Quarter of the Month</label>
										<label for="" class=" mb-0 text-sm w-[50%] ">Amount</label>
									</div>
								</div>
							</div>
						
							<div class="row" v-for="(r, a) in rows">
								<div class="col-lg-12">
									<div class="form-group mb-1">
										<div class="flex justify-between space-x-1">
											<select class="form-control border" v-model="r.quarter_month">
												<option value=""></option>
												<option value="1">First Month</option>
												<option value="2">Second Month</option>
												<option value="3">Third Month</option>
											</select>
											<input type="hidden" class="form-control border" v-model="r.id">
											<input type="number" class="form-control border" maxlength="15" v-model="r.amount">
											<input type="hidden" class="form-control border" maxlength="15" v-model="r.old_amount">
											<button class="btn btn-xs btn-danger"  @click="removeRow(a, r.id)"  >
												<XMarkIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"></XMarkIcon>
											</button>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group flex space-x-2">
										<input type="checkbox" id="include_sign" v-model="form.include_sign"  true-value="1" false-value="0">
										<label for="" class="mb-0 text-sm">Include Corporate Accountant's Signature</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-0">
										<label for="" class="mb-0 text-sm">Reference Number</label>
										<input type="text" class="form-control border" v-model="form.reference_number">
									</div>
								</div>
							</div>
							<input type="hidden" v-model="form.atc_percentage">
							<input type="hidden" v-model="form.atc_code">
							<input type="hidden" v-model="form.payee_name">
							<input type="hidden" v-model="form.zip_code">
							<input type="hidden" v-model="form.tax_type">
							<input type="hidden" v-model="form.accountant_id">
							<input type="hidden" v-model="form.accountant_name">
							<input type="hidden" v-model="form.accountant_tin">
							<input type="hidden" v-model="form.accountant_position">
							<input type="hidden" v-model="form.accountant_sign">
							<input type="hidden" v-model="form.generation_head_id">
							<input type="hidden" v-model="form.detail_id">
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card h-full !shadow-lg">
						<div class="mx-4 mt-4 p-3 h-full rounded overflow-y-hidden hover:overflow-y-scroll bg-gray-200 shadow-inner">
							<div class="card w-full mb-2 !shadow hover:bg-yellow-100"  v-for="d in details">
								
								<div class="row" >
									<div class="col-lg-10  cursor-pointer">
										<a :href="'/dashboard/'+ props.id + '/' + d.id " class="!no-underline text-gray-700 hover:text-gray-700 ">
											<div class="truncate overflow-ellipsis text-base font-bold leading-tight">Payee's Name: {{ d.payee_name }}</div>
											<div class="text-xs leading-tight">{{ d.date_from }} - {{ d.date_to }}</div>
										</a>
									</div>
									<div class="col-lg-2">
										<div class="flex justify-end space-x-2">
											<a :href="'/print/'+ d.id" class="mt-1" target="_blank">
												<PrinterIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></PrinterIcon>
											</a> 
											<a href=" " @click="cancelGeneration(d.id)" class="mt-1 !text-red-500" >
												<XCircleIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" ></XCircleIcon>
											</a>
										</div>
									</div>
								</div>
								<!-- <div class="row" v-else>
									<div class="col-lg-12  cursor-pointer text-center text-sm">No available data.</div>
									
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="card !shadow-lg">
						<div class="px-4 pb-4" v-if="props.detail_id == 0">
							<button @click="onSave()"   class="btn btn-primary btn-sm btn-block ">Add New</button>
						</div>
						<div class="flex justify-between space-x-1  pb-4 px-4" v-else>
							<span class="w-full"><a :href="'/dashboard/'+ props.id + '/0'" class="btn btn-danger btn-sm btn-block ">Cancel Update</a></span>
							<span class="w-full"><a @click="onEdit(props.detail_id)"   class="btn btn-primary btn-sm btn-block ">Save Changes</a></span>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card !shadow-lg">
						<div class="px-4 pb-4">
							<a @click = "saveSet(form.generation_head_id)" class="btn btn-sm btn-success btn-block text-white">Save Set and Print All</a>
						</div>
					</div>
				</div>
			</div>
		</div>
    </navigation>
</template>
