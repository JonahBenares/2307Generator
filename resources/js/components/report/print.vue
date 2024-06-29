<script setup>
	import{ onMounted, ref } from "vue"
	import navigation from '@/layouts/navigation.vue';
	import { CheckCircleIcon, TrashIcon, PlusIcon, XMarkIcon, PencilSquareIcon, ArrowUturnLeftIcon, ExclamationTriangleIcon, CheckIcon  } from '@heroicons/vue/24/solid'
	import { useRouter } from "vue-router"
	import moment from 'moment'

	let details = ref([])
	let subtotal_ewt=ref([]);
	onMounted(async () => {
		//printDiv()
		getPrintDetails()
	})

	const props = defineProps({
		id:{
			type:String,
			default:''
		}
	})

	const getPrintDetails = async () => {
		const response = await axios.get(`/api/get_print_details/${props.id}`);
		details.value = response.data
		//alert(response.data)
		
	}
	const printDiv = () => {
		const formItems= new FormData()
			var first_month_total = document.getElementById('firstmonthtotal').value;
			var original_first_month_total = document.getElementById('original_firstmonthtotal').value;
			var second_month_total = document.getElementById('secondmonthtotal').value;
			var original_second_month_total = document.getElementById('original_secondmonthtotal').value;
			var third_month_total = document.getElementById('thirdmonthtotal').value;
			var original_third_month_total = document.getElementById('original_thirdmonthtotal').value;
			var overall_total_amount = document.getElementById('overalltotalamount').value;
			var original_overall_total_amount = document.getElementById('original_overalltotalamount').value;
			var overall_ewt = document.getElementById('overallewt').value;
			var original_overall_ewt = document.getElementById('original_overallewt').value;

			if(first_month_total == undefined && original_first_month_total == undefined){
				var firstmonth_total = 0;
				var original_firstmonth_total = 0;
			}else{
				var firstmonth_total = first_month_total;
				var original_firstmonth_total = original_first_month_total;
			}

			if(second_month_total == undefined && original_second_month_total == undefined){
				var secondmonth_total = 0;
				var original_secondmonth_total = 0;
			}else{
				var secondmonth_total = second_month_total;
				var original_secondmonth_total = original_second_month_total;
			}


			if(third_month_total == undefined && original_third_month_total == undefined){
				var thirdmonth_total = 0;
				var original_thirdmonth_total = 0;
			}else{
				var thirdmonth_total = third_month_total;
				var original_thirdmonth_total = original_third_month_total;
			}

			formItems.append('generations_id',props.id)
			formItems.append('first_month_total', firstmonth_total)
			formItems.append('original_first_month_total', original_firstmonth_total)
			formItems.append('second_month_total', secondmonth_total)
			formItems.append('original_second_month_total', original_secondmonth_total)
			formItems.append('third_month_total', thirdmonth_total)
			formItems.append('original_third_month_total', original_thirdmonth_total)
			formItems.append('overall_total_amount', overall_total_amount ?? 0)
			formItems.append('original_overall_total_amount', original_overall_total_amount ?? 0)
			formItems.append('overall_ewt', overall_ewt ?? 0)
			formItems.append('original_overall_ewt', original_overall_ewt ?? 0)

			var countrow = document.getElementsByClassName("subtotalamount");
			for(var t=0;t<countrow.length;t++){
				var row = t+1;
				var subtotal_amount = document.getElementsByClassName("subtotalamount")[t].value;
				var ewt_amount = document.getElementsByClassName("ewtamount")[t].value;
					const subtotalewt = {
						row:row,
						subtotal_amount:subtotal_amount,
						ewt_amount:ewt_amount,
					}
						subtotal_ewt.value.push(subtotalewt)
			}
			formItems.append('sub_total_ewt', JSON.stringify(subtotal_ewt.value))
			axios.post("/api/update_generation_total/",formItems);
			window.print()
			getPrintDetails()
	}

	const format_date = (value) => {
		if (value) {
		return moment(String(value)).format('MMDDYYYY')
		}
	}

	const CalculateGrandTotal = (row) => {
	var count_row = document.getElementsByClassName("subtotalamount");
	const sub_t = document.getElementById("sub_total"+row).value;
	const percent = document.getElementById('percentage').value
	var grandtotal=0;
			for(var t=0;t<count_row.length;t++){
				grandtotal += parseFloat(document.getElementsByClassName("subtotalamount")[t].value);
			}
			document.getElementById('overalltotalamount').value = parseFloat(grandtotal).toFixed(2);
			document.getElementById('print_overalltotalamount').value = parseFloat(grandtotal).toFixed(2);
			document.getElementById("ewt_amount"+row).value = parseFloat(sub_t * percent).toFixed(2);
			document.getElementById("ewt_amount1"+row).innerText = parseFloat(sub_t * percent).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
			document.getElementById("sub_total1"+row).innerText = parseFloat(sub_t).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
			CalculateTotalEwt();

	}

	const CalculateTotalEwt = (row) => {
	var count_row = document.getElementsByClassName("ewtamount");
	var ewttotal=0;
			for(var e=0;e<count_row.length;e++){
				ewttotal += parseFloat(document.getElementsByClassName("ewtamount")[e].value);
			}
			document.getElementById('overallewt').value = parseFloat(ewttotal).toFixed(2);
			document.getElementById('print_overallewt').innerText = parseFloat(ewttotal).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
			document.getElementById("ewt_amount1"+row).innerText = parseFloat(document.getElementById("ewt_amount"+row).value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
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
						<img src="../../../images/bg-white.jpg" alt="" class="bg-white2307">
						<img src="../../../images/form2307.jpg" alt="" class="img2307">
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
						<div :class="'payor-tin'+i" v-for="(comp_tin,i) in (d.company_tin.split('-'))">{{ comp_tin }}</div>
						<!-- <div class="payor-tin1">022</div>
						<div class="payor-tin2">032</div>
						<div class="payor-tin3">042</div>
						<div class="payor-tin4">05020</div> -->
						<div class="payor-name">{{ d.company_name }}</div>
						<div class="payor-address">{{ d.company_address}}</div>
						<div class="payor-zip">{{ d.company_zip }}</div>
						<!-- <div class="">Ref Number</div> -->
						<div class="income-payments">{{ d.atc_remarks }}</div>
						<div class="atc" >
							<span v-for="l in d.loop">{{ d.atc_code }}<br></span>
							</div>
						<div class="first-quarter">
							<span v-for="first in d.firstmonth"> {{ parseFloat(first.tax_base_amount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }} <br></span>
						</div>
						<div class="first-total" v-if="d.firstmonth !=0">
							<!-- {{ parseFloat(d.subtotal_first).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }} -->
							<input type="number" id="firstmonthtotal" class="w-full text-right bg-transparent p-0" v-model="d.first_month_total" v-if="d.first_month_total != 0">
							<input type="number" id="firstmonthtotal" class="w-full text-right bg-transparent p-0" v-model="d.subtotal_first" v-else>
						</div>
						<div class="first-total" id="firstmonthtotal" v-else>-</div>
						<input type="hidden" id="original_firstmonthtotal" class="w-full text-right bg-transparent p-0" v-model="d.original_subtotal_first">
						<div class="first-total1" v-if="d.firstmonth !=0"> {{ (d.first_month_total != 0) ? parseFloat(d.first_month_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') : parseFloat(d.subtotal_first).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')}}</div>
						<div class="first-total1" v-else>-</div>
						

						<div class="second-quarter">
							<span v-for="second in d.secondmonth">{{ parseFloat(second.tax_base_amount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}<br></span>
						</div>
						<div class="second-total"  v-if="d.secondmonth !=0">
							<!-- {{ parseFloat(d.subtotal_second).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }} -->
							<input type="number" id="secondmonthtotal" class="w-full text-right bg-transparent p-0" v-model="d.second_month_total" v-if="d.second_month_total != 0">
							<input type="number" id="secondmonthtotal" class="w-full text-right bg-transparent p-0" v-model="d.subtotal_second" v-else>
						</div>
						<div class="second-total" id="secondmonthtotal" v-else>-</div>
						<input type="hidden" id="original_secondmonthtotal" class="w-full text-right bg-transparent p-0" v-model="d.original_subtotal_second">
						<div class="second-total1"  v-if="d.secondmonth !=0">{{ (d.second_month_total != 0) ? parseFloat(d.second_month_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') : parseFloat(d.subtotal_second).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}</div>
						<div class="second-total1" v-else>-</div>

						<div class="third-quarter">
							<span v-for="third in d.thirdmonth">{{ parseFloat(third.tax_base_amount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}<br></span>
						</div>
						<div class="third-total" v-if="d.thirdmonth !=0">
							<!-- {{ parseFloat(d.subtotal_third).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }} -->
							<input type="number" id="thirdmonthtotal" class="w-full text-right bg-transparent p-0" v-model="d.third_month_total" v-if="d.third_month_total != 0">
							<input type="number" id="thirdmonthtotal" class="w-full text-right bg-transparent p-0" v-model="d.subtotal_third" v-else>
						</div>
						<div class="third-total" id="thirdmonthtotal" v-else>-</div>
						<input type="hidden" id="original_thirdmonthtotal" class="w-full text-right bg-transparent p-0" v-model="d.original_subtotal_third">
						<div class="third-total1" v-if="d.thirdmonth !=0">{{ (d.third_month_total != 0) ? parseFloat(d.third_month_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') : parseFloat(d.subtotal_third).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}</div>
						<div class="third-total1" v-else>-</div>

						<div class="sub-total" v-if="d.count_row == 0">
							<span v-for="(s, row) in d.subtotal">
								<input v-if="s != 0" type="number" :id="'sub_total'+ row" class="w-full text-right bg-transparent p-0 subtotalamount" :value="parseFloat(s).toFixed(2)" @change="CalculateGrandTotal(row)">
							<br></span>
						</div>
						<div class="sub-total" v-else>
							<span v-for="(s, row) in d.gen_total.sub_to">
								<input v-if="s != 0" type="number" :id="'sub_total'+ row" class="w-full text-right bg-transparent p-0 subtotalamount" :value="s.sub_total" @change="CalculateGrandTotal(row)">
								<br></span>
						</div>
						
						<div class="sub-total1" v-if="d.count_row == 0">
							<span v-for="(s, row) in d.subtotal" >
								<span v-if="s != 0" :id="'sub_total1'+ row">{{ parseFloat(s).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}</span>
							<br></span>
						</div>
						<div class="sub-total1" v-else>
							<span v-for="(s, row) in d.gen_total.sub_to">
								<span v-if="s != 0" :id="'sub_total1'+ row">{{ parseFloat(s.sub_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}</span>
							<br></span>
						</div>
						
						<div class="grand-total" v-if="d.grandtotal !=0">
							<!-- {{ parseFloat(d.grandtotal).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }} -->
							<input type="number" id="overalltotalamount" class="w-full text-right bg-transparent p-0" v-model="d.overall_total_amount" v-if="d.overall_total_amount != 0">
							<input type="number" id="overalltotalamount" class="w-full text-right bg-transparent p-0" v-model="d.grandtotal" v-else>
						</div>
						<input type="hidden" id="original_overalltotalamount" class="w-full text-right bg-transparent p-0" v-model="d.original_grandtotal">
						<div class="grand-total1" v-if="d.grandtotal !=0" id="print_overalltotalamount">
							{{ (d.overall_total_amount != 0) ? parseFloat(d.overall_total_amount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') :  parseFloat(d.grandtotal).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}
						</div>

						<div class="tax-quarter" v-if="d.count_row == 0">
							<span v-for="(t, row) in d.tax">
								<!-- <span v-if="t != 0">{{ parseFloat(t).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}</span> -->
								<input v-if="t != 0" type="number" :id="'ewt_amount'+ row" class="w-full text-right bg-transparent p-0 ewtamount" :value="parseFloat(t).toFixed(2)" @change="CalculateTotalEwt(row)">
							<br></span>
						</div>
						<div class="tax-quarter" v-else>
							<span v-for="(t, row) in d.gen_total.sub_to">
								<!-- <span v-if="t != 0">{{ parseFloat(t).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}</span> -->
								<input v-if="t != 0" type="number" :id="'ewt_amount'+ row" class="w-full text-right bg-transparent p-0 ewtamount" :value="parseFloat(t.ewt_total).toFixed(2)" @change="CalculateTotalEwt(row)">
							<br></span>
						</div>
						<div class="tax-quarter1" v-if="d.count_row == 0">
							<span v-for="(t, row) in d.tax">
								<span v-if="t != 0" :id="'ewt_amount1'+ row">{{ parseFloat(t).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}</span>
							<br></span>
						</div>
						<div class="tax-quarter1" v-else>
							<span v-for="(t, row) in d.gen_total.sub_to">
								<span v-if="t != 0" :id="'ewt_amount1'+ row">{{ parseFloat(t.ewt_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}</span>
							<br></span>
						</div>

						<div class="finaltax"  id="print_overallewt">{{ (d.overall_ewt != 0) ? parseFloat(d.overall_ewt).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') : parseFloat(d.totaltax).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }}</div> <!-- para ni sa printing nga class naka-->
						<div class="final-tax ">
							<!-- {{ parseFloat(d.totaltax).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') }} -->
							<input type="number" id="overallewt" class="w-full text-right bg-transparent p-0" v-model="d.overall_ewt" v-if="d.overall_ewt != 0">
							<input type="number" id="overallewt" class="w-full text-right bg-transparent p-0" v-model="d.totaltax" v-else>
							<input type="hidden" id="original_overallewt" class="w-full text-right bg-transparent p-0" v-model="d.original_totaltax">
						</div><!-- para ni ya sa view nga class-->
						
						<div class="esig-container">
							<img :src="'/images/'+d.accountant_signature" alt="" class="esignature">
						</div>

						<div class="accountant"> {{ d.accountant_name }}</div>
						<div class="accountant_position"> {{ d.accountant_position }}</div>
						<div class="accountant_tin"> {{ d.accountant_tin }}</div>
						<div class="ref-number">{{ d.reference_number }}</div>
						<input type="hidden" id="percentage" class="w-full text-right bg-transparent p-0" v-model="d.atc_percentage">
					</div>
				</page>
				
				
			</div>
		</div>
		</navigation>
</template>
