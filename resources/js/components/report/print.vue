<script setup>
	import{ onMounted, ref } from "vue"
	import navigation from '@/layouts/navigation.vue';
	import { CheckCircleIcon, TrashIcon, PlusIcon, XMarkIcon, PencilSquareIcon, ArrowUturnLeftIcon, ExclamationTriangleIcon, CheckIcon  } from '@heroicons/vue/24/solid'
	import { useRouter } from "vue-router"
	onMounted(async () => {
		//printDiv()
	})
	
	
	
	const printDiv = () => {
		window.print()
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
			<div class="">
				<page size="Legal" class="page-break">
					<div class="p-2 !relative text-center bg-gren-900">
						<img src="../../../images/form2307.jpg" alt="" class="">
						<div class="date-from">09122024</div>
						<div class="date-to">02232024</div>
						<div class="payee-tin1">022</div>
						<div class="payee-tin2">032</div>
						<div class="payee-tin3">042</div>
						<div class="payee-tin4">05020</div>
						<div class="payee-name">GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC. GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC.</div>
						<div class="payee-address">LACSON STREET, BACOLOD CITY</div>
						<div class="payee-zip">6100</div>
						<div class="payee-foreign">X</div>

						<div class="payor-tin1">022</div>
						<div class="payor-tin2">032</div>
						<div class="payor-tin3">042</div>
						<div class="payor-tin4">05020</div>
						<div class="payor-name">GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC. GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC.</div>
						<div class="payor-address">LACSON STREET, BACOLOD CITY</div>
						<div class="payor-zip">6100</div>
						<!-- <div class="">Ref Number</div> -->
						<div class="income-payments">Income payment made by top withholding agents to their local/resident supplier of goods other than those covered by other rates of withholding tax Income payment made by top withholding agents to their local/resident supplier of goods other than those covered by other rates of withholding tax</div>
						<div class="atc">WC158</div>
						<div class="first-quarter">
							1001<br>
							1009<br>
						</div>
						<div class="first-total">--</div>

						<div class="second-quarter">--</div>
						<div class="second-total">--</div>

						<div class="third-quarter">--</div>
						<div class="third-total">--</div>

						<div class="sub-total">--</div>
						<div class="grand-total">--</div>

						<div class="tax-quarter">
							1001<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							99999<br> <!-- (DIRI LNG BUTANG ANG FINAL TAX) -->
						</div>
						<div class="final-tax"></div><!-- (ND LNG D PAG BUTANG ANG FINAL TAX) -->
						
						<img src="../../../images/sign_Lacambra.png" alt="" class="esignature">

						<div class="ref-number">PO PHRS23-1639-1026-CNPR  / 01-20-24</div>
						

					</div>
				</page>
				<page size="Legal" class="page-break">
					<div class="p-2 !relative text-center bg-gren-900">
						<img src="../../../images/form2307.jpg" alt="" class="">
						<div class="date-from">09122024</div>
						<div class="date-to">02232024</div>
						<div class="payee-tin1">022</div>
						<div class="payee-tin2">032</div>
						<div class="payee-tin3">042</div>
						<div class="payee-tin4">05020</div>
						<div class="payee-name">GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC. GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC.</div>
						<div class="payee-address">LACSON STREET, BACOLOD CITY</div>
						<div class="payee-zip">6100</div>
						<div class="payee-foreign">X</div>

						<div class="payor-tin1">022</div>
						<div class="payor-tin2">032</div>
						<div class="payor-tin3">042</div>
						<div class="payor-tin4">05020</div>
						<div class="payor-name">GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC. GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC.</div>
						<div class="payor-address">LACSON STREET, BACOLOD CITY</div>
						<div class="payor-zip">6100</div>
						<!-- <div class="">Ref Number</div> -->
						<div class="income-payments">Income payment made by top withholding agents to their local/resident supplier of goods other than those covered by other rates of withholding tax Income payment made by top withholding agents to their local/resident supplier of goods other than those covered by other rates of withholding tax</div>
						<div class="atc">WC158</div>
						<div class="first-quarter">
							1001<br>
							1009<br>
						</div>
						<div class="first-total">--</div>

						<div class="second-quarter">--</div>
						<div class="second-total">--</div>

						<div class="third-quarter">--</div>
						<div class="third-total">--</div>

						<div class="sub-total">--</div>
						<div class="grand-total">--</div>

						<div class="tax-quarter">
							1001<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							99999<br> <!-- (DIRI LNG BUTANG ANG FINAL TAX) -->
						</div>
						<div class="final-tax"></div><!-- (ND LNG D PAG BUTANG ANG FINAL TAX) -->
						
						<img src="../../../images/sign_Lacambra.png" alt="" class="esignature">

						<div class="ref-number">PO PHRS23-1639-1026-CNPR  / 01-20-24</div>
						

					</div>
				</page>
				<page size="Legal" class="page-break">
					<div class="p-2 !relative text-center bg-gren-900">
						<img src="../../../images/form2307.jpg" alt="" class="">
						<div class="date-from">09122024</div>
						<div class="date-to">02232024</div>
						<div class="payee-tin1">022</div>
						<div class="payee-tin2">032</div>
						<div class="payee-tin3">042</div>
						<div class="payee-tin4">05020</div>
						<div class="payee-name">GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC. GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC.</div>
						<div class="payee-address">LACSON STREET, BACOLOD CITY</div>
						<div class="payee-zip">6100</div>
						<div class="payee-foreign">X</div>

						<div class="payor-tin1">022</div>
						<div class="payor-tin2">032</div>
						<div class="payor-tin3">042</div>
						<div class="payor-tin4">05020</div>
						<div class="payor-name">GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC. GREENLANE  HARDWARE & CONSTRUCTION SUPPLY INC.</div>
						<div class="payor-address">LACSON STREET, BACOLOD CITY</div>
						<div class="payor-zip">6100</div>
						<!-- <div class="">Ref Number</div> -->
						<div class="income-payments">Income payment made by top withholding agents to their local/resident supplier of goods other than those covered by other rates of withholding tax Income payment made by top withholding agents to their local/resident supplier of goods other than those covered by other rates of withholding tax</div>
						<div class="atc">WC158</div>
						<div class="first-quarter">
							1001<br>
							1009<br>
						</div>
						<div class="first-total">--</div>

						<div class="second-quarter">--</div>
						<div class="second-total">--</div>

						<div class="third-quarter">--</div>
						<div class="third-total">--</div>

						<div class="sub-total">--</div>
						<div class="grand-total">--</div>

						<div class="tax-quarter">
							1001<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							99999<br> <!-- (DIRI LNG BUTANG ANG FINAL TAX) -->
						</div>
						<div class="final-tax"></div><!-- (ND LNG D PAG BUTANG ANG FINAL TAX) -->
						
						<img src="../../../images/sign_Lacambra.png" alt="" class="esignature">

						<div class="ref-number">PO PHRS23-1639-1026-CNPR  / 01-20-24</div>
						

					</div>
				</page>
			</div>
		</div>
		</navigation>
</template>
