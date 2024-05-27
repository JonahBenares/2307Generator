<script setup>
	import{ onMounted, ref } from "vue"
	import navigation from '@/layouts/navigation.vue';
	import { CheckCircleIcon, TrashIcon, PlusIcon, XMarkIcon, PencilSquareIcon, ArrowUturnLeftIcon, ExclamationTriangleIcon, CheckIcon  } from '@heroicons/vue/24/solid'
	import { useRouter } from "vue-router"
	import moment from 'moment'

	let details = ref([])
	onMounted(async () => {
		//printDiv()
		getPrintAll()
	})

	const props = defineProps({
		id:{
			type:String,
			default:''
		}
	})

	const getPrintAll = async () => {
		const response = await axios.get(`/api/get_print_all/${props.id}`);
		details.value = response.data

		console.log(response.data)
		
	}
	const printDiv = () => {
		window.print()
	}

	const format_date = (value) => {
		if (value) {
		return moment(String(value)).format('MMDDYYYY')
		}
	}


</script>

<template>
	<navigation>
        <div class="container-fluid">
			<div class="row" id="print_button">
				<div class="col-lg-12">
					<div class="flex justify-center mb-3 space-x-1">
						<a href="#" class="btn btn-sm btn-success" @click="printDiv('printable')"> Print Report</a>
					</div>
				</div>
			</div>
			<div class="" v-for="d in details">
				<page size="Legal" class="page-break">
					<div class="p-2 !relative text-center bg-gren-900">
						<img src="../../../images/form2307.jpg" alt="" class="">
						<div class="date-from">{{ format_date(d.date_from) }}</div>
						<div class="date-to">{{ format_date(d.date_to) }}</div>
						<div :class="'payee-tin'+i" v-for="(tin,i) in (d.tin.split('-'))">{{ tin }}</div>
						<!-- <div class="payee-tin2">032</div>
						<div class="payee-tin3">042</div>
						<div class="payee-tin4">05020</div> -->
						<div class="payee-name">{{ d.payee_name }}</div>
						<div class="payee-address">{{ d.registered_address }}</div>
						<div class="payee-zip">{{ d.zip_code }}</div>
						<div class="payee-foreign">X</div>

						<div class="payor-tin1">022</div>
						<div class="payor-tin2">032</div>
						<div class="payor-tin3">042</div>
						<div class="payor-tin4">05020</div>
						<div class="payor-name">GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC. GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC.</div>
						<div class="payor-address">LACSON STREET, BACOLOD CITY</div>
						<div class="payor-zip">6100</div>
						<!-- <div class="">Ref Number</div> -->
						<div class="income-payments">{{ d.atc_remarks }}</div>
						<div class="atc">{{ d.atc_code }}</div>
						<div class="first-quarter">
							<span v-for="first in d.firstmonth">{{ first }}<br></span>
						</div>
						<div class="first-total">{{ d.totalfirst }}</div>

						<div class="second-quarter">
							<span v-for="second in d.secondmonth">{{ second }}<br></span>
						</div>
						<div class="second-total">{{ d.totalsecond }}</div>

						<div class="third-quarter">
							<span v-for="third in d.thirdmonth">{{ third }}<br></span>
						</div>
						<div class="third-total">{{ d.totalthird }}</div>

						<div class="sub-total" >
							<span v-for="s in d.subtotal">{{ s }}<br></span>
						</div>
						<div class="grand-total">{{  d.grandtotal }}</div>

						<div class="tax-quarter">
							
							<span v-for="t in d.tax">{{ t }}<br></span>
						
							{{ d.totaltax }}<br> <!-- (DIRI LNG BUTANG ANG FINAL TAX) -->
						</div>
						<div class="final-tax"></div><!-- (ND LNG D PAG BUTANG ANG FINAL TAX) -->
						
						<img :src="'/images/'+d.accountant_signature" v-if="d.accountant_signature" alt="" class="esignature">
						<div class="accountant"> {{ d.accountant_name }}</div>
						<div class="accountant_position"> {{ d.accountant_position}}</div>
						<div class="accountant_tin"> {{ d.tin }}</div>
						<div class="ref-number">{{ d.reference_number }}</div>
						

					</div>
				</page>
				
				
			</div>
		</div>
		</navigation>
</template>
